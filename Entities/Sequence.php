<?php
namespace App\Entities;


use App\Entities\Entity;

 class Sequence extends Entity {
    private string $id;
    private bool $isAssigned;
    private float $durationEstimated;
    private Type $type;
    private Project $project;


    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getIsAssigned() : bool {
        return $this->isAssigned;
    }

    public function getDurationEstimated() : float {
        return $this->durationEstimated;
    }

    public function getType() : Type {
        return $this->type;
    }

    public function getProject() : Project {
        return $this->project;
    }


    // Setters

    public function setId($id) {
        $this->id = $id;
    }

    public function setIsAssigned($isAssigned) {
        $this->isAssigned = $isAssigned;
    }

    public function setDurationEstimated($durationEstimated) {
        $this->durationEstimated = $durationEstimated;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setProject($project) {
        $this->project = $project;
    }
 }
    