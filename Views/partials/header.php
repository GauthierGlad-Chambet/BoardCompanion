<?php
require_once("Views/partials/head.php");
?>

<body>
    <header>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="index.php?controller=form&action=newProject">Nouveau projet</a>
            <a href="index.php?controller=statistics&action=dashboard">Tableau de bord</a>
            <a href="index.php?controller=calendar&action=index">Planning</a>
            <a href="index.php?controller=folder&action=index">Arborescence</a>
            <a href="index.php?controller=user&action=index">Compte</a>
            <a name="logout" href="index.php?controller=user&action=logout">Se déconnecter</a>
        </nav>
    </header>