<?php

namespace GauthierGladchambet\BoardCompanion\Entities;

use GauthierGladchambet\BoardCompanion\Entities\MotherEntity;

class FinalReport extends MotherEntity
{
    private string $id;
    private float $totalDuration;
    private float $cleaningDuration;
    private int $nbShots;
    private string $commentary;
    private int $fk_appreciation;
    private int $fk_project;


    // Getters

    public function getId(): string
    {
        return $this->id;
    }

    public function getTotalDuration(): float
    {
        return $this->totalDuration;
    }

    public function getCleaningDuration(): float
    {
        return $this->cleaningDuration;
    }

    public function getNbShots(): int
    {
        return $this->nbShots;
    }

    public function getCommentary(): string
    {
        return $this->commentary;
    }

    public function getAppreciation(): int
    {
        return $this->fk_appreciation;
    }

    public function getProject(): int
    {
        return $this->fk_project;
    }


    // Setters

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTotalDuration($totalDuration)
    {
        $this->totalDuration = $totalDuration;
    }

    public function setCleaningDuration($cleaningDuration)
    {
        $this->cleaningDuration = $cleaningDuration;
    }

    public function setNbShots($nbShots)
    {
        $this->nbShots = $nbShots;
    }

    public function setCommentary($commentary)
    {
        $this->commentary = $commentary;
    }

    public function setAppreciation($appreciation)
    {
        $this->fk_appreciation = $appreciation;
    }

    public function setProject($project)
    {
        $this->fk_project = $project;
    }
}
