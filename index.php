<?php
// Every pages uses session
session_start();

// Autoloader de composer
require 'vendor/autoload.php';

// Détermine le controleur à appeler et son action en fonction de l'url
if(empty($_SESSION)){
    $controller = $_GET["controller"] ?? "user";
    $action = $_GET["action"] ?? "login";
} else {
    $controller = $_GET["controller"] ?? "main";
$action = $_GET["action"] ?? "home";
}


// Flag sur la présence de la page
$bool404 = false;

// Création du nom de la classe
// On spécifie le nom complet de la classe avec le namespace
// Construire le nom de la classe attendu par l'autoloader
// Namespace utilisé dans les contrôleurs : App\Controllers
$strCtrlName = 'GauthierGladchambet\\BoardCompanion\\Controllers\\' . ucfirst($controller) . 'Controller';

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