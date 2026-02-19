<?php

namespace GauthierGladchambet\BoardCompanion\Models;

use PDO;
use GauthierGladchambet\BoardCompanion\Models\MotherModel;

class TypeModel extends MotherModel {

    function findLabelById(int $fk_type): array {
        $query = "
            SELECT label
            FROM type
            WHERE id = :fk_type
        ";

        $prepare = $this->_db->prepare($query);
        $prepare->bindValue(':fk_type', $fk_type, PDO::PARAM_INT);
        $prepare->execute();

        return $prepare->fetch(PDO::FETCH_ASSOC);
    }
}