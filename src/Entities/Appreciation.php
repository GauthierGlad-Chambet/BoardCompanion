<?php

namespace GauthierGladchambet\BoardCompanion\Entities;

use GauthierGladchambet\BoardCompanion\Entities\MotherEntity;

class Appreciation extends MotherEntity
{
    private string $id;
    private string $label;

    // Getters

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }


    // Setters

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }
}
