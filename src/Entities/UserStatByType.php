<?php

namespace GauthierGladchambet\BoardCompanion\Entities;

use GauthierGladchambet\BoardCompanion\Entities\MotherEntity;

class UserStatByType extends MotherEntity
{
    private string $id;
    private float $avgPagesDays = 1;
    private int $fk_type;
    private int $fk_user;


    // Getters

    public function getId(): string
    {
        return $this->id;
    }

    public function getAvgPagesDays(): float
    {
        return $this->avgPagesDays;
    }

    public function getType(): int
    {
        return $this->fk_type;
    }

    public function getUser(): int
    {
        return $this->fk_user;
    }


    // Setters

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setAvgPagesDays($avgPagesDays)
    {
        $this->avgPagesDays = $avgPagesDays;
    }

    public function setType($type)
    {
        $this->fk_type = $type;
    }

    public function setUser($user)
    {
        $this->fk_user = $user;
    }
}
