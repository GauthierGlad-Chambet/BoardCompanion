<?php

namespace GauthierGladchambet\BoardCompanion\Entities;

use GauthierGladchambet\BoardCompanion\Entities\MotherEntity;

class User extends MotherEntity
{
    function __construct() {
        $this->_strPrefix = "_user";
    }

    private int $id;
    private string $pseudo;
    private string $email;
    private string $pwd ='';
    private float $avg_pages_per_day = 1;
    private float $avg_cleaning_duration = 0.2; // en jours, par page assignée
    private int $avg_shots_per_page = 0; 
    private float $fk_appreciation = 2;
    private string $appreciation_label = "";


    // Getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPwd(): string
    {
        return $this->pwd;
    }

    public function getAvg_pages_per_day(): float
    {
        return $this->avg_pages_per_day;
    }

    public function getAvg_cleaning_duration(): float
    {
        return $this->avg_cleaning_duration;
    }

    public function getAvg_shots_per_page(): float
    {
        return $this->avg_shots_per_page;
    }

    public function getFk_appreciation(): float
    {
        return $this->fk_appreciation;
    }

    public function getAppreciation_label(): string
    {
        if ($this->appreciation_label == '') {
            return "Non renseigné";
        }
        return $this->appreciation_label;
    }


    // Setters

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
    }

    public function setAvg_pages_per_day($avg_pages_per_day)
    {
        $this->avg_pages_per_day = $avg_pages_per_day;
    }

    public function setAvg_cleaning_duration($avg_cleaning_duration)
    {
        $this->avg_cleaning_duration = $avg_cleaning_duration;
    }

    public function setAvg_shots_per_page($avg_shots_per_page)
    {
        $this->avg_shots_per_page = $avg_shots_per_page;
    }

    public function setFk_appreciation($fk_appreciation)
    {
        $this->fk_appreciation = $fk_appreciation;
    }

    public function setAppreciation_label($appreciation_label)
    {
        if ($appreciation_label == null) {
            $appreciation_label = "Non renseigné";
        }
        $this->appreciation_label = $appreciation_label;
    }
}
