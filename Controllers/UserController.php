<?php

namespace App\Controllers;

use App\Entities\User;
use App\Models\UserModel;

class UserController extends MotherController
{
    // Show signUp/signIn page
    public function login()
    {
        //Si le $_POST n'est pas vide
        if(count($_POST) > 0){

            // si on a cliqué sur le bouton s'inscrire
            if(isset($_POST['submit_signUp'])) {

            // Récupération des données du formulaire
                $email                  =trim($_POST['email']??'');
                $pseudo                 =trim($_POST['pseudo']??'');//trim remove invisibles characters like spaces, before and after the text
                $password               =$_POST['password']??'';
                $passwordConfirmation   =$_POST['passwordConfirmation']??'';

            // Création de l'objet User et assignation des valeurs
                $user = new User();
                $user->setEmail($email);    
                $user->setPseudo($pseudo);

                if($password !== $passwordConfirmation){
                    die("Les mots de passe ne correspondent pas.");
                } else {
                    // Hash the password before storing it
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $user->setPwd($hashedPassword);
                }

                // Enregistrement de l'utilisateur dans la base de données
                try {
                    $UserModel = new UserModel();
                    $UserModel->add($user);
                    echo "Utilisateur ajouté avec succès.";
                } catch (\Exception $e) {
                    echo "Erreur lors de l'ajout de l'utilisateur : " . htmlspecialchars($e->getMessage());
                    exit;
                }

                // Si on a cliqué sur le bouton se connecter
            } else if (isset($_POST['submit_signIn'])) {

                // Récupération des données du formulaire
                $email = trim($_POST['email']??'');
                $password = $_POST['password']??'';

                // Récupération de l'utilisateur par email
                $UserModel = new UserModel();
                $user = $UserModel->findByMail($email);

                // Vérification des identifiants
                if ($user && password_verify($password, $UserModel->getPasswordHash($email)['pwd'])) {
                    $_SESSION['user'] = $user;
                    header("Location: index.php?controller=main&action=home");
                    exit;
                } else {
                    echo "Identifiants incorrects.";
                }
            }
        }

        $this->_display("user/signIn");
    }

    function logout() {
        // Détruit la session utilisateur
        session_destroy();
        header("Location: index.php?controller=user&action=login");
    }
}
