<?php

namespace GauthierGladchambet\BoardCompanion\Entities;


use GauthierGladchambet\BoardCompanion\Entities\MotherEntity;
use GauthierGladchambet\BoardCompanion\Models\TypeModel;

class Sequence extends MotherEntity
{
    function __construct() {
            $this->_strPrefix = "_sequence";
        }

    private string $id;
    private int $number;
    private string $title;
    private string $script;
    private int $lines_count;
    private bool $is_assigned;
    private float $duration_estimated = 0;
    private float $duration_real;
    private int $fk_type;
    private int $fk_project;


    // Getters

    public function getId(): string
    {
        return $this->id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getScript(): string
    {
        return $this->script;
    }

    public function getLines_count(): int
    {
        return $this->lines_count;
    }

    public function getIs_assigned(): bool
    {
        return $this->is_assigned;
    }

    public function getDuration_estimated(): float
    {
        return $this->duration_estimated;
    }

    public function getDuration_real(): float
    {
        return $this->duration_real;
    }

    public function getFk_type(): int
    {
        return $this->fk_type;
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

    public function setNumber($number)
    {
        $this->number = $number;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setScript($script)
    {
        $this->script = $script;
    }

    public function setLines_count($lines_count)
    {
        $this->lines_count = $lines_count;
    }

    public function setIs_assigned($is_assigned)
    {
        $this->is_assigned = $is_assigned;
    }

    public function setDuration_estimated($duration_estimated)
    {
        $this->duration_estimated = $duration_estimated;
    }

    public function setDuration_real($duration_real)
    {
        $this->duration_real = $duration_real;
    }

    public function setFk_type($fk_type)
    {
        $this->fk_type = $fk_type;
    }

    public function setFk_project($fk_project)
    {
        $this->fk_project = $fk_project;
    }


    // Autres méthodes

    public function getTypeLabel(): string
    {
        $typeModel = new TypeModel();
        $typeLabel = $typeModel->findLabelById($this->fk_type);
        return $typeLabel['label'] ?? 'Inconnu';
    }

}
