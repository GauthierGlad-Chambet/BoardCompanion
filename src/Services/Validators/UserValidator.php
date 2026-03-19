<?php

namespace GauthierGladchambet\BoardCompanion\Services\Validators;

use GauthierGladchambet\BoardCompanion\Models\UserModel;

class UserValidator {

    public function validerEmail($email) {
            if (empty($email)) {
                return "Le champ 'Email' est obligatoire.";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "Adresse mail invalide";
            }
            return null;
        }

    public function emailExists($email) {
        $userModel = new UserModel();
        if ($userModel->findByMail($email)) {
            return "Ce compte existe déjà.";
        }
        return null;
    }

    public function verifIdentifiants($user, $email, $password, $passwordHash) {
        if ($user->getEmail() != $email || !password_verify($password, $passwordHash['pwd'])) {
            return "Identifiants incorrects.";
        }
        return null;
    }

    public function validerPseudo($pseudo) {
        if (empty($pseudo)) {
            return "Le champ 'Pseudo' est obligatoire.";
        }
        return null;
    }

    public function validerMdp($password) {
        if (empty($password)) {
            return "Le champ 'Mot de passe' est obligatoire.";
        }
        return null;
    }

    public function verifierMdp($password,$passwordHash) {
        if (empty($password)) {
            return "Le champ 'Mot de passe' est obligatoire.";
        } else if (!password_verify($password, $passwordHash['pwd'])) {
            return "Mot de passe incorrect.";
        }
        return null;
    }

    public function differenceMdp($oldPassword,$newPassword) {
        if (empty($newPassword)) {
            return "Le champ 'Nouveau mot de passe' est obligatoire.";
        } else if ($oldPassword == $newPassword) {
            return "Le nouveau mot de passe doit être différent du mot de passe actuel.";
        }
        return null;
    }

    public function regexMdp($newPassword) {
        if (!preg_match("/(?=\S{8,})(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S/", $newPassword)) {
            return "Le mot de passe doit comporter au moins 8 caractères dont une majuscule et un caractère spécial.";
        }
        return null;
    }

    public function matcherMdp($newPassword,$newPasswordConfirmation) {
        if (empty($newPasswordConfirmation)) {
            return "Le champ 'Confirmez le nouveau mot de passe' est obligatoire.";
        } else if ($newPassword !== $newPasswordConfirmation) {
            return "Les mots de passe ne correspondent pas.";
        }
        return null;
    }

    public function accepterCGU($checkbox) {
        if ($checkbox == "off") {
            return "L'acceptation des termes et conditions est obligatoire pour créer un compte.";
        }
        return null;
    }

}
