<?php

namespace GauthierGladchambet\BoardCompanion\Entities;


use GauthierGladchambet\BoardCompanion\Entities\MotherEntity;

class Sequence extends MotherEntity
{
    private string $id;
    private string $script;
    private bool $isAssigned;
    private float $durationEstimated;
    private string $type;
    private int $fk_project;


    // Getters

    public function getId(): string
    {
        return $this->id;
    }

    public function getScript(): string
    {
        return $this->script;
    }

    public function getIsAssigned(): bool
    {
        return $this->isAssigned;
    }

    public function getDurationEstimated(): float
    {
        return $this->durationEstimated;
    }

    public function getType(): string
    {
        return $this->type;
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

    public function setScript($script)
    {
        $this->script = $script;
    }

    public function setIsAssigned($isAssigned)
    {
        $this->isAssigned = $isAssigned;
    }

    public function setDurationEstimated($durationEstimated)
    {
        $this->durationEstimated = $durationEstimated;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setProject($fk_project)
    {
        $this->fk_project = $fk_project;
    }
}
