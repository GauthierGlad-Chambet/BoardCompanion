<?php
require_once("Views/partials/head.php");
?>

<body>
    <header>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="index.php?controller=form&action=newProject">Nouveau projet</a>
            <a href="index.php?action=">Tableau de bord</a>
            <a href="index.php?action=">Planning</a>
            <a href="index.php?action=">Arborescence</a>
            <a href="index.php?action=">Compte</a>
            <a name="logout" href="index.php?controller=user&action=logout">Se déconnecter</a>
        </nav>
    </header>