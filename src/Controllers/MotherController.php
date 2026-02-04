<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

/**
 * Classe mère des controllers
 */
abstract class MotherController
{

    protected array $_arrData = [];

    /**
     * Fonction d'affichage
     * @param string $strTemplate nom de la vue à afficher
     * @return void Affichage de la vue
     */
    protected function _display(string $strTemplate, bool $header = true, array $data = [])
    {
        foreach ($this->_arrData as $key => $value) {
            $$key = $value;
        }
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        
        // Chemins relatifs depuis le dossier Controllers vers le dossier Views
        if ($header) {
            require __DIR__ . '/../../Views/partials/header.php';
        }
        include __DIR__ . '/../../Views/' . $strTemplate . '.php';
        require __DIR__ . '/../../Views/partials/footer.php';
    }

    protected function _notFound()
    {
        header("Location:index.php?controller=errors&action=error_404");
        exit();
    }
}
