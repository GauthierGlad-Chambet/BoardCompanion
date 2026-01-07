<?php

namespace App\Entities;


use App\Entities\Entity;

class User extends MainEntity
{
    private string $id;
    private string $pseudo;
    private string $email;
    private string $pwd;
    private float $avgPageDay;
    private float $avgCleaningDuration;


    // Getters

    public function getId(): string
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

    public function getAvgPageDay(): float
    {
        return $this->avgPageDay;
    }

    public function getAvgCleaningDuration(): float
    {
        return $this->avgCleaningDuration;
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

    public function setAvgPageDay($avgPageDay)
    {
        $this->avgPageDay = $avgPageDay;
    }

    public function setAvgCleaningDuration($avgCleaningDuration)
    {
        $this->avgCleaningDuration = $avgCleaningDuration;
    }
}
