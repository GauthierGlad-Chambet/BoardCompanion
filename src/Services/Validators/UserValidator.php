<?php

namespace GauthierGladchambet\BoardCompanion\Services\Validators;

use GauthierGladchambet\BoardCompanion\Models\UserModel;

class UserValidator {

    // Vérifie si le champ mail n'est pas vide
    public function validerEmail($email) {
            if (empty($email)) {
                return "Le champ 'Email' est obligatoire.";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 50) {
                return "Adresse mail invalide.";
            }
            return null;
        }

    // Vérifie si l'email existe déjà en bdd
    public function emailExists($email) {
        if (empty($email)) {
            return "Le champ 'Email' est obligatoire.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 50) {
            return "Adresse email invalide.";
        } else {
            $userModel = new UserModel();
            if ($userModel->findByMail($email)) {
                return "Ce compte existe déjà.";
            }
        }
        return null;
    }

    // Verifie si les identifiants entrés correspondent à ceux de l'utilsateur en bdd
    public function verifIdentifiants($user, $email, $password, $passwordHash) {
        if ($user->getEmail() != $email || !password_verify($password, $passwordHash['pwd'])) {
            return "Identifiants incorrects.";
        }
        return null;
    }

    // Vérifie si le champs pseudo n'est pas vide et s'il fait 16 caractères ou moins
    public function validerPseudo($pseudo) {
        if (empty($pseudo)) {
            return "Le champ 'Pseudo' est obligatoire.";
        } else if (strlen($pseudo) > 16) {
            return "La taille du pseudo doit être inférieure à 16 caractères.";
        }
        return null;
    }

    // Vérifie si le champ mdp n'est pas vide
    public function validerMdp($password) {
        if (empty($password)) {
            return "Le champ 'Mot de passe' est obligatoire.";
        }
        return null;
    }

    // Vérifie si le champs mdp n'est pas vide et s'il correspond à celui en bdd
    public function verifierMdp($password,$passwordHash) {
        if (empty($password)) {
            return "Le champ 'Mot de passe' est obligatoire.";
        } else if (!password_verify($password, $passwordHash['pwd'])) {
            return "Mot de passe incorrect.";
        }
        return null;
    }

    // Vérifie si le champ mdp n'est pas vide et si le nouveau mdp est différent de l'ancien
    public function differenceMdp($oldPassword,$newPassword) {
        if (empty($newPassword)) {
            return "Le champ 'Nouveau mot de passe' est obligatoire.";
        } else if ($oldPassword == $newPassword) {
            return "Le nouveau mot de passe doit être différent du mot de passe actuel.";
        }
        return null;
    }

    // Vérifie que le mot de passe correspond bien à la règle demandée
    public function regexMdp($newPassword) {
        if (!preg_match("/(?=\S{8,})(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S/", $newPassword)) {
            return "Le mot de passe doit comporter au moins 8 caractères dont une majuscule et un caractère spécial.";
        } else if (strlen($newPassword) > 255) {
            return "Le mot de passe ne peut pas excéder 255 caractères.";
        }
        return null;
    }

    // Vérifie si la confirmation de mot de passe correspond au mot de passe
    public function matcherMdp($newPassword,$newPasswordConfirmation) {
        if (empty($newPasswordConfirmation)) {
            return "Le champ 'Confirmez le nouveau mot de passe' est obligatoire.";
        } else if ($newPassword !== $newPasswordConfirmation) {
            return "Les mots de passe ne correspondent pas.";
        }
        return null;
    }

    // Vérifie que l'utilisateur a bien coché la case d'acceptation des cgu avant de créer son compte
    public function accepterCGU($checkbox) {
        if ($checkbox == "off") {
            return "L'acceptation des termes et conditions est obligatoire pour créer un compte.";
        }
        return null;
    }

}
