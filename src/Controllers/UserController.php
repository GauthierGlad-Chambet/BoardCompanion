<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Controllers\MotherController;
use GauthierGladchambet\BoardCompanion\Entities\User;
use GauthierGladchambet\BoardCompanion\Models\UserModel;
use GauthierGladchambet\BoardCompanion\Models\UserStatByTypeModel;
use GauthierGladchambet\BoardCompanion\Services\Validators\UserValidator;

class UserController extends MotherController
{
    private UserValidator $validator;

    function __construct() {
    
        //Appelle ce qui est dans le constructeur de la class parente (siil y en a un)
        // parent::__construct();

        //instantiation du validateur
        $this->validator = new UserValidator;
    }

    // Show signUp/signIn page
    public function login() {
        //Si le $_POST n'est pas vide
        if(count($_POST) > 0){

            // si on a cliqué sur le bouton s'inscrire
            if(isset($_POST['submit_signUp'])) {

                // Récupération des données du formulaire
                $pseudo                 = trim(filter_input(INPUT_POST,"pseudo", FILTER_SANITIZE_SPECIAL_CHARS)??'');//trim remove invisibles characters like spaces, before and after the text
                $email                  = trim(filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL)??'');
                $password               = $_POST['password']??'';
                $passwordConfirmation   = $_POST['passwordConfirmation']??'';
                $accepteCGU             = $_POST['accepteCGU']??'off';

                // Validateurs des différents champs
                // Array_filter permet de collecter uniquement les erreurs non nulles
                $errors = array_filter([
                    'pseudo'            => $this->validator->validerPseudo($pseudo),
                    'email'             => $this->validator->validerEmail($email),
                    'emailExists'       => $this->validator->emailExists($email),
                    'incorrectPassword' => $this->validator->validerMdp($password),
                    'matching'          => $this->validator->matcherMdp($password, $passwordConfirmation),
                    'regex'             => $this->validator->regexMdp($password),
                    'accepteCGU'        => $this->validator->accepterCGU($accepteCGU)      
                ]);

                // S'il y a des erreurs, on les met en session et on redirige
                if (!empty($errors)) {
                    $_SESSION['error'] = $errors;
                    header("Location: index.php?controller=user&action=login");
                    exit;
                }

                // Création de l'objet User et assignation des valeurs
                $user = new User();
                $user->setEmail($email);    
                $user->setPseudo($pseudo);
                
                // Hash the password before storing it
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $user->setPwd($hashedPassword);
            

                // Enregistrement de l'utilisateur dans la base de données
                try {
                    $userModel = new UserModel();
                    $userModel->addUser($user);

                    $userStatByTypeModel = new UserStatByTypeModel();
                    for ($i = 1; $i <= 3; $i++) {
                        $userStatByTypeModel->addUserStatByType($userModel->findByMail($user->getEmail())['id'], $i, 1);
                    }

                    $_SESSION['success']['utilisateurAjoute'] = "Utilisateur ajouté avec succès !";
                    header("Location: index.php?controller=user&action=login");
                    exit;

                
                } catch (\Exception $e) {
                    echo "Erreur lors de l'ajout de l'utilisateur : " . htmlspecialchars($e->getMessage());
                    exit;
                }

                    

            // Si on a cliqué sur le bouton se connecter
            } else if (isset($_POST['submit_signIn'])) {

                // Récupération des données du formulaire
                $email    = trim(filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL)??'');
                $password = $_POST['password']??'';

                // Récupération de l'utilisateur par email
                $userModel = new UserModel();


                // Vérifier d'abord que l'email est valide
                $emailError = $this->validator->validerEmail($email);
                if ($emailError) {
                    $_SESSION['error'] = ['email' => $emailError];
                    header("Location: index.php?controller=user&action=login");
                    exit;
                }

                // Vérifier que l'utilisateur existe
                $userDatas = $userModel->findByMail($email);
                if (!$userDatas) {
                    $_SESSION['error'] = ['verifIdentifiants' => "Identifiants incorrects."];
                    header("Location: index.php?controller=user&action=login");
                    exit;
                }

                $user = new User();
                $user->hydrate($userDatas);

                $passwordHash = $userModel->getPasswordHash($email);


                $errors = array_filter([
                    'verifIdentifiants' => $this->validator->verifIdentifiants($user, $email, $password, $passwordHash)
                ]);

                // S'il y a des erreurs, on les met en session et on redirige
                if (!empty($errors)) {
                    $_SESSION['error'] = $errors;
                    header("Location: index.php?controller=user&action=login");
                    exit;
                }

                $_SESSION['user'] = $userDatas;
                header("Location: index.php");
                exit;
            }
        }

        $this->_display("user/signIn", false);
    }

    public function logout() {
        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }
        // Détruit la session utilisateur
        session_destroy();
        header("Location: index.php?controller=user&action=login");
        exit;
    }

    public function showAccount() {
        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $userModel = new UserModel();
        $userData = $userModel->findById($_SESSION['user']['id']);

        $user = new User();
        $user->hydrate($userData);

        $this->_arrData['user'] = $user;

        // Récupération des stats par type
        $userStatByTypeModel = new UserStatByTypeModel();
        $this->_arrData['statAction']  = $userStatByTypeModel->findByUserIdAndType($_SESSION['user']['id'], 1)['avg_pages_per_day'] ?? 1;
        $this->_arrData['statComedie'] = $userStatByTypeModel->findByUserIdAndType($_SESSION['user']['id'], 2)['avg_pages_per_day'] ?? 1;
        $this->_arrData['statMixte']   = $userStatByTypeModel->findByUserIdAndType($_SESSION['user']['id'], 3)['avg_pages_per_day'] ?? 1;

        $this->_display("user/account");
    }

    public function updateAccount() {

        $pseudo = trim(filter_input(INPUT_POST,"pseudo", FILTER_SANITIZE_SPECIAL_CHARS)??'');
        $oldPassword = $_POST['oldPassword']??'';
        $newPassword = $_POST['newPassword'];
        $newPasswordConfirmation = $_POST['newPasswordConfirmation']??'';

        $userModel = new UserModel();
        $passwordHash = $userModel->getPasswordHash($_SESSION['user']['email']);

    // var_dump($newPassword);die;

    // COndition pour savoir si on modifie juste le pseudo ou tout le compte
    if(!$newPassword) {
        // Array_filter permet de collecter uniquement les erreurs non nulles
        // Validateurs des différents champs
            $errors = array_filter([
                'pseudo'            => $this->validator->validerPseudo($pseudo),
                'incorrectPassword' => $this->validator->verifierMdp($oldPassword, $passwordHash)
            ]);

            // S'il y a des erreurs, on les met en session et on redirige
            if (!empty($errors)) {
                $_SESSION['error'] = $errors;
                header("Location: index.php?controller=user&action=showAccount");
                exit;
            }

            $user = new User();
            $user->setId($_SESSION['user']['id']);
            $user->setPseudo($pseudo);

            $userModel->updateAccount($user);

            $_SESSION['success']['CompteMAJ'] = "Compte mis à jour avec succès !";
            header("Location: index.php?controller=user&action=showAccount");
            exit;


        } else {
            $errors = array_filter([
                'pseudo'            => $this->validator->validerPseudo($pseudo),
                'incorrectPassword' => $this->validator->verifierMdp($oldPassword, $passwordHash),
                'differenceMdp'     => $this->validator->differenceMdp($oldPassword, $newPassword),
                'regex'             => $this->validator->regexMdp($newPassword),
                'matching'          => $this->validator->matcherMdp($newPassword, $newPasswordConfirmation),
            ]);

            // S'il y a des erreurs, on les met en session et on redirige
            if (!empty($errors)) {
                $_SESSION['error'] = $errors;
                header("Location: index.php?controller=user&action=showAccount");
                exit;
            }
    
            $user = new User();
            $user->setId($_SESSION['user']['id']);
            $user->setPseudo($pseudo);
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $user->setPwd($hashedPassword);
    
            $userModel->updateAccount($user);
    
            $_SESSION['success']['CompteMAJ'] = "Compte mis à jour avec succès !";
            header("Location: index.php?controller=user&action=showAccount");
            exit;
        }


    }

    public function deleteAccount() {

        //Check si l'utilisateur est connecté, sinon renvoie à la page login
        if (empty($_SESSION)) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $confirmPassword = $_POST['confirmPassword']??'';

        $userModel = new UserModel();
        $passwordHash = $userModel->getPasswordHash($_SESSION['user']['email']);

        $errors = array_filter([
            'incorrectPassword' => $this->validator->verifierMdp($confirmPassword, $passwordHash),
        ]);

        if (!empty($errors)) {
            $_SESSION['error'] = $errors;
            header("Location: index.php?controller=user&action=showAccount");
            exit;
        }

            
        $userModel = new UserModel();
        $userModel->deleteUserById($_SESSION['user']['id']);
        
        session_destroy();
        $_SESSION['success']['CompteSupprime'] = "Compte supprimé avec succès !";
        header("Location: index.php?controller=user&action=login");
        exit;
    }
}
