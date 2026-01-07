<?php

namespace App\Entities;

use App\Entities\Entity;

class FinalReport extends MainEntity
{
    private string $id;
    private float $totalDuration;
    private float $cleaningDuration;
    private int $nbShots;
    private string $commentary;
    private Appreciation $appreciation;
    private Project $project;


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

    public function getAppreciation(): Appreciation
    {
        return $this->appreciation;
    }

    public function getProject(): Project
    {
        return $this->project;
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
        $this->appreciation = $appreciation;
    }

    public function setProject($project)
    {
        $this->project = $project;
    }
}
