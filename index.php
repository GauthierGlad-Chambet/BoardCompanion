<?php
// Every pages uses session
session_start();

//A ANALYSER POUR COMPRENDRE

// Déclaration de l'autoloader (manuel)
spl_autoload_register(function ($class) {

    // Pour chaque use, cette fonction sera appelée
    // ex. : use Blog\Controllers\ArticlesCtrl;
    // $class = "Blog\Controllers\ArticlesCtrl"

    // Objectif, transformer $class => chemin réel du fichier .php
    // ex. "./Controllers/ArticlesCtrl.php"

    $strFilename = str_replace('App\\', './', $class); //< "Controllers\ArticlesCtrl"
    $strFilename = str_replace('\\', '/', $strFilename) . '.php'; //< "Controllers/ArticlesCtrl"

    // On vérifie si le fichier existe avant de faire le require_once
    if (file_exists($strFilename)) {
        require_once $strFilename;
    }
});

// Détermine le controleur à appeler et son action en fonction de l'url
$controller = $_GET["controller"] ?? "user";
$action = $_GET["action"] ?? "signIn";

// Flag sur la présence de la page
$bool404 = false;

// Création du nom de la classe
// On spécifie le nom complet de la classe avec le namespace
// Construire le nom de la classe attendu par l'autoloader
// Namespace utilisé dans les contrôleurs : App\Controllers
$strCtrlName = 'App\\Controllers\\' . ucfirst($controller) . 'Controller';

// Test sur l'existence de la classe
if (class_exists($strCtrlName)) {

    // Instanciation de l'objet de la classe
    // Remplacer le nom par Blog\Controllers\Articles
    $objCtrl = new $strCtrlName();

    // Test sur la présence de la méthode dans l'objet instancié
    if (method_exists($objCtrl, $action)) {

        // Appel à la méthode
        $objCtrl->$action();
    } else {
        $bool404 = true;
    }
} else {
    $bool404 = true;
}

// si un des éléments non trouvé => redirection vers page 404
if ($bool404) {
    header("Location:index.php?controller=errors&action=error_404");
    exit();
}



// $controllerPath = "controller/" . $controller . "Controller.php";

// // Si le controleur existe, on l'appelle
// if (file_exists($controllerPath)) {
//     require_once($controllerPath);
//     $controllerName = $controller . "Controller";

//     // Si la méthode qui correspond à l'action existe, on l'appelle
//     if (class_exists($controllerName)) {
//         $newController = new $controllerName();
//         if (method_exists($newController, $action)) {
//             $newController->$action();
//         }
//     }
// }
