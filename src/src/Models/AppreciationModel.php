<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use GauthierGladchambet\BoardCompanion\Models\MotherModel;

class AppreciationModel extends MotherModel {

    function findAllAppreciations(): array {
        $query = "
            SELECT id, label
            FROM appreciation
            ORDER BY id
    ";

        $prepare = $this->_db->prepare($query);
        $prepare->execute();

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }

    function findLabelById(int $fk_appreciation): array {
        $query = "
            SELECT label
            FROM appreciation
            WHERE id = :fk_appreciation
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':fk_appreciation', $fk_appreciation, PDO::PARAM_INT);
        $prepare->execute();

        return $prepare->fetch(PDO::FETCH_ASSOC);
    }
}