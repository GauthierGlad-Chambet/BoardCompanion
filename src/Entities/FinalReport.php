<?php

namespace GauthierGladchambet\BoardCompanion\Entities;

use GauthierGladchambet\BoardCompanion\Entities\MotherEntity;
use GauthierGladchambet\BoardCompanion\Models\AppreciationModel;

class FinalReport extends MotherEntity
{

    function __construct() {
        $this->_strPrefix = "_finalReport";
    }

    private string $id;
    private float $total_duration;
    private float $cleaning_duration;
    private int $nb_shots;
    private string $commentary;
    private int $fk_appreciation;
    private int $fk_project;


    // Getters

    public function getId(): string
    {
        return $this->id;
    }

    public function getTotal_duration(): float
    {
        return $this->total_duration;
    }

    public function getCleaning_duration(): float
    {
        return $this->cleaning_duration;
    }

    public function getNb_shots(): int
    {
        return $this->nb_shots;
    }

    public function getCommentary(): string
    {
        return $this->commentary;
    }

    public function getFk_appreciation(): int
    {
        return $this->fk_appreciation;
    }

    public function getFk_project(): int
    {
        return $this->fk_project;
    }


    // Setters

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTotal_duration($total_duration)
    {
        $this->total_duration = $total_duration;
    }

    public function setCleaning_duration($cleaning_duration)
    {
        $this->cleaning_duration = $cleaning_duration;
    }

    public function setNb_shots($nb_shots)
    {
        $this->nb_shots = $nb_shots;
    }

    public function setCommentary($commentary)
    {
        $this->commentary = $commentary;
    }

    public function setFk_appreciation($appreciation)
    {
        $this->fk_appreciation = $appreciation;
    }

    public function setFk_project($project)
    {
        $this->fk_project = $project;
    }

    // Autres méthodes

    public function getAppreciationLabel(): string
    {
        $appreciationModel = new AppreciationModel();
        $appreciationLabel = $appreciationModel->findLabelById($this->fk_appreciation);
        return $appreciationLabel['label'] ?? 'Inconnu';
    }
}
