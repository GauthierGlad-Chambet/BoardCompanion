<?php

namespace GauthierGladchambet\BoardCompanion\Tests;

use GauthierGladchambet\BoardCompanion\Models\UserModel;
use GauthierGladchambet\BoardCompanion\Entities\User;

class UserIntegrationTest extends IntegrationTestCase
{
    // Test 1 : créer un utilisateur et vérifier qu'il est bien en BDD
    public function testCreerUtilisateur(): void {
        $user = new User();
        $user->setPseudo("TestUser");
        $user->setEmail("integration@test.com");
        $user->setPwd(password_hash("Motdepasse1!", PASSWORD_DEFAULT));
        $user->setAvg_shots_per_page(0);
        $user->setFk_appreciation(2);

        $userModel = new UserModel();
        $userModel->addUser($user);

        // Vérifier en BDD que l'utilisateur existe bien
        $prepare = $this->db->prepare("SELECT * FROM user WHERE email = ?");
        $prepare->execute(["integration@test.com"]);
        $result = $prepare->fetch();

        $this->assertNotFalse($result);
        $this->assertEquals("TestUser", $result['pseudo']);
        $this->assertEquals("integration@test.com", $result['email']);
    }

    // Test 2 : vérifier qu'on ne peut pas créer 2 utilisateurs avec le même email
    public function testEmailUniqueEnBdd(): void {
        $this->db->exec("INSERT INTO user (pseudo, email, pwd, avg_shots_per_page, fk_appreciation) 
                         VALUES ('User1', 'doublon@test.com', 'hash', 0, 2)");

        $this->expectException(\PDOException::class);

        $this->db->exec("INSERT INTO user (pseudo, email, pwd, avg_shots_per_page, fk_appreciation) 
                         VALUES ('User2', 'doublon@test.com', 'hash', 0, 2)");
    }

    // Test 3 : retrouver un utilisateur par son email
    public function testFindByMail(): void {
        $this->db->exec("INSERT INTO user (pseudo, email, pwd, avg_shots_per_page, fk_appreciation) 
                         VALUES ('TestFind', 'find@test.com', 'hash', 0, 2)");

        $userModel = new UserModel();
        $result = $userModel->findByMail("find@test.com");

        $this->assertNotFalse($result);
        $this->assertEquals("TestFind", $result['pseudo']);
    }
}