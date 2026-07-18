<?php

namespace GauthierGladchambet\BoardCompanion\Tests;

use PHPUnit\Framework\TestCase;
use GauthierGladchambet\BoardCompanion\Services\Validators\UserValidator;
use GauthierGladchambet\BoardCompanion\Models\UserModel;

class UserValidatorTest extends TestCase
{
    private UserValidator $validator;

    // setUp() s'exécute avant chaque test
    protected function setUp(): void
    {
        $this->validator = new UserValidator();
    }

    ///////// TESTS FONCTION VALIDEREMAIL ///////////

    // Cas valide
    public function testEmailValide(): void {
        $this->assertNull($this->validator->validerEmail("test@gmail.com"));
    }

    // Cas vide
    public function testEmailVide(): void {
        $result = $this->validator->validerEmail("");
        $this->assertEquals("Le champ 'Email' est obligatoire.", $result);
    }

    // Cas Format de mail invalide 1 (pas d'arobase)
    public function testEmailSansArobase(): void {
        $result = $this->validator->validerEmail("testgmail.com");
        $this->assertEquals("Adresse mail invalide.", $result);
    }

    // Cas Format de mail invalide 2 (pas de domaine)
    public function testEmailSansDomaine(): void {
        $result = $this->validator->validerEmail("test@");
        $this->assertEquals("Adresse mail invalide.", $result);
    }

    // Cas Format de mail invalide 3 (espace)
    public function testEmailAvecEspaces(): void {
        $result = $this->validator->validerEmail("test @gmail.com");
        $this->assertEquals("Adresse mail invalide.", $result);
    }

    // Cas email trop long
    public function testEmailTropLong(): void {
        // 51 caractères
        $result = $this->validator->validerEmail("maildeplusde50caracterestroplongvraimentroplong@example.com");
        $this->assertEquals("Adresse mail invalide.", $result);
    }

    // Cas email limite maximum de longeur
    public function testEmailExactement50Caracteres(): void {
        //str_pad permet de compléter une chaîne jusqu'à une longueur donnée.
        $email = str_pad("@gmail.com", 50, "a", STR_PAD_LEFT);
        $this->assertNull($this->validator->validerEmail($email));
    }

    ///////// TESTS FONCTION EMAILEXISTS ///////////

    // Cas email déjà en bdd
    public function testEmailExistsDejaExistant(): void {
        // On crée un faux UserModel qui simule un email déjà en BDD
        $userModelMock = $this->createMock(UserModel::class);
        // ajout de ->expects($this->once()) pour supprimer les warning de phpUnit
        $userModelMock->expects($this->once())->method('findByMail')->willReturn(['id' => 1, 'email' => 'test@gmail.com']);

        $result = $this->validator->emailExists("test@gmail.com", $userModelMock);
        $this->assertEquals("Ce compte existe déjà.", $result);
    }

    // Cas email absent de la bdd
    public function testEmailExistsNouvelEmail(): void {
        // On crée un faux UserModel qui simule un email absent de la BDD
        $userModelMock = $this->createMock(UserModel::class);
        // ajout de ->expects($this->once()) pour supprimer les warning de phpUnit
        $userModelMock->expects($this->once())->method('findByMail')->willReturn(null);

        $result = $this->validator->emailExists("nouveau@gmail.com", $userModelMock);
        $this->assertNull($result);
    }


    
}