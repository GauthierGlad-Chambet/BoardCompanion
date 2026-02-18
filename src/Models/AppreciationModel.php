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
}