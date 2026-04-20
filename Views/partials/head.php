<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <!-- ajout de viewport-fit=cover pour permettre les safeareas, permet au contenu de s'étendre dans la zone de sécurité-->
  <meta name="”theme-color”" content="#7CEE00" />
  <!-- Indique le thème de couleur du site, qui apparait sur les navigateurs compatibles-->
  <title>
    <?= $strTitle ?>
  </title>
  <meta
    name="description"
    content="<?= $strMetaDesc ?>" />

  <!-- Pour afficher un aperçu personnalisé quand partage le lien du site sur les plateformes comme Messenger ou Whatsapp -->
  <meta
    property="og:title"
    content="<?= $strTitle ?>" />
  <meta property="og:description" content="<?= $strMetaDesc ?>" />
  <meta
    property="og:image"
    content="https://www.boardcompanion.fr/Views/assets/icons/Boardy/boardy-pen.png" />
  <meta
    property="og:url"
    content="https://www.boardcompanion.fr" />
  <meta property="og:type" content="website" />

  <link
    rel="icon"
    type="image/png"
    href="Views/assets/icons/favicon-board-companion.png" />

  <!-- Appel de la police Julius Sans One -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
  <!-- Appel de la police Just Me Again Down Here -->
  <link href="https://fonts.googleapis.com/css2?family=Just+Me+Again+Down+Here&display=swap" rel="stylesheet">
  <!-- Appel de la police Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

  <link href="Views/assets/css/style.css" rel="stylesheet" type="text/css" />
</head>