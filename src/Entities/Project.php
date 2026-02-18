<?php

namespace GauthierGladchambet\BoardCompanion\Entities;

use DateTime;
use GauthierGladchambet\BoardCompanion\Entities\MotherEntity;

class Project extends MotherEntity
{
    function __construct() {
        $this->_strPrefix = "_project";
    }

    private string $id;
    private string $name;
    private string $studio;
    private string $episode_nb;
    private string $episode_title;
    private int $nb_predec;
    private bool $is_alone;
    private bool $is_cleaning;
    private string $script_path;
    private ?string $template_path = null;
    private string $date_beginning;
    private string $date_end;
    private int $nb_total_pages;
    private int $nb_assigned_pages;
    private float $estimated_total_duration;
    private ?float $estimated_cleaning_duration = 0;
    private float $recommended_pages_per_day;
    private int $fk_user;
    private int $fk_final_report;
    private string $appreciation_label = "";


    // Getters

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStudio(): string
    {
        return $this->studio;
    }

    public function getEpisode_nb(): string
    {
        return $this->episode_nb;
    }

    public function getEpisode_title(): string
    {
        return $this->episode_title;
    }

    public function getDate_beginning(): string
    {
        return $this->date_beginning;

    }

    public function getDate_end(): string
    {
       return $this->date_end;
    }

    public function getNb_predecs(): int
    {
        return $this->nb_predec;
    }

    public function getIs_cleaning(): bool
    {
        return $this->is_cleaning;
    }

    public function getIs_alone(): bool
    {
        return $this->is_alone;
    }

    public function getScript_path(): string
    {
        return $this->script_path;
    }

    public function getTemplate_path(): ?string
    {
        return $this->template_path;
    }

    public function getNb_total_pages(): float
    {
        return $this->nb_total_pages;
    }

    public function getNb_assigned_pages(): float
    {
        return $this->nb_assigned_pages;
    }

    public function getEstimated_total_duration(): float
    {
        return $this->estimated_total_duration;
    }

    public function getEstimated_cleaning_duration(): ?float
    {
        return $this->estimated_cleaning_duration;
    }

    public function getRecommended_pages_per_day(): float
    {
        return $this->recommended_pages_per_day;
    }

    public function getFk_user(): int
    {
        return $this->fk_user;
    }

    public function getFk_final_report(): int
    {
        return $this->fk_final_report;
    }

    public function getAppreciation_label(): string
    {
        if($this->appreciation_label == '') {
            $this->appreciation_label = "Non renseigné";
        }
        return $this->appreciation_label;
    }

    // Setters

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setStudio($studio)
    {
        $this->studio = $studio;
    }

    public function setEpisode_nb($episode_nb)
    {
        $this->episode_nb = $episode_nb;
    }

    public function setEpisode_title($episode_title)
    {
        $this->episode_title = $episode_title;
    }

    public function setDate_beginning($date_beginning)
    {
        $this->date_beginning = $date_beginning;
    }

    public function setDate_end($date_end)
    {
        $this->date_end = $date_end;
    }

    public function setNb_predecs($nb_predec)
    {
        $this->nb_predec = $nb_predec;
    }

    public function setIs_cleaning($is_cleaning)
    {
        $this->is_cleaning = $is_cleaning;
    }

    public function setIs_alone($is_alone)
    {
        $this->is_alone = $is_alone;
    }

    public function setScript_path($script_path)
    {
        $this->script_path = $script_path;
    }

    public function setTemplate_path($template_path)
    {
        $this->template_path = $template_path;
    }

    public function setNb_total_pages($nb_total_pages)
    {
        $this->nb_total_pages = $nb_total_pages;
    }

    public function setNb_assigned_pages($nb_assigned_pages)
    {
        $this->nb_assigned_pages = $nb_assigned_pages;
    }

    public function setEstimated_total_duration($estimated_total_duration)
    {
        $this->estimated_total_duration = $estimated_total_duration;
    }

    public function setEstimated_cleaning_duration($estimated_cleaning_duration)
    {
        $this->estimated_cleaning_duration = $estimated_cleaning_duration;
    }

    public function setRecommended_pages_per_day($recommended_pages_per_day)
    {
        $this->recommended_pages_per_day = $recommended_pages_per_day;
    }

    public function setFk_user($fk_user)
    {
        $this->fk_user = $fk_user;
    }

    public function setFkFinal_report($fk_final_report)
    {
        $this->fk_final_report = $fk_final_report;
    }

    public function setAppreciation_label($appreciation_label)
    {
        if($appreciation_label == null) {
            $appreciation_label = "Non renseigné";
        }
        $this->appreciation_label = $appreciation_label;
    }

    //Autres méthodes

    
    public function getDate_beginningFormatted()
    {
       //Convertir la date au format "d-m-Y" avant de la retourner
        $date = DateTime::createFromFormat('Y-m-d', $this->date_beginning);
        if ($date) {
            return $date->format('d-m-Y');
        } else {
            return $this->date_beginning;
        }
    }

    public function getDate_endFormatted()
    {
       //Convertir la date au format "d-m-Y" avant de la retourner
        $date = DateTime::createFromFormat('Y-m-d', $this->date_end);
        if ($date) {
            return $date->format('d-m-Y');
        } else {
            return $this->date_end;
        } 
    }


    public function getDuree()
    {
        $dateBegin = new \DateTime($this->getDate_beginning());
        $dateEnd = new \DateTime($this->getDate_end());
        $interval = $dateBegin->diff($dateEnd);
        return $interval->days;
    }
}
