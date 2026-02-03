<?php

namespace App\Entities;


use App\Entities\Entity;

class Type extends MotherEntity
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
