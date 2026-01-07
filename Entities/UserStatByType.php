<?php
namespace App\Entities;


use App\Entities\Entity;

 class UserStatByType extends Entity {
    private string $id;
    private float $avgPagesDays;
    private Type $type;
    private User $user;


    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getAvgPagesDays() : float {
        return $this->avgPagesDays;
    }

    public function getType() : Type {
        return $this->type;
    }

    public function getUser() : user {
        return $this->user;
    }


    // Setters

    public function setId($id) {
        $this->id = $id;
    }

    public function setAvgPagesDays($avgPagesDays) {
        $this->avgPagesDays = $avgPagesDays;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setUser($user) {
        $this->user = $user;
    }
 }