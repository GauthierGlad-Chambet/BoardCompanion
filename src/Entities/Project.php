<?php

namespace GauthierGladchambet\BoardCompanion\Entities;

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
    private string $date_begining;
    private string $date_end;
    private float $nb_total_pages;
    private float $nb_assigned_pages;
    private float $estimated_total_duration;
    private float $estimated_cleaning_duration;
    private float $recommended_pages_per_day;
    private int $fk_user;
    private FinalReport $finalReport;


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

    public function getEpisodeNb(): string
    {
        return $this->episode_nb;
    }

    public function getEpisodeTitle(): string
    {
        return $this->episode_title;
    }

    public function getDateBegin(): string
    {
        return $this->date_begining;
    }

    public function getDateEnd(): string
    {
        return $this->date_end;
    }

    public function getNbPredecs(): int
    {
        return $this->nb_predec;
    }

    public function getIsCleaning(): bool
    {
        return $this->is_cleaning;
    }

    public function getIsAlone(): bool
    {
        return $this->is_alone;
    }

    public function getScriptFilePath(): string
    {
        return $this->script_path;
    }

    public function getTemplateFilePath(): ?string
    {
        return $this->template_path;
    }

    public function getNbTotalPages(): float
    {
        return $this->nb_total_pages;
    }

    public function getNbAssignedPages(): float
    {
        return $this->nb_assigned_pages;
    }

    public function getEstimTotalDuration(): float
    {
        return $this->estimated_total_duration;
    }

    public function getEstimCleaningDuration(): float
    {
        return $this->estimated_cleaning_duration;
    }

    public function getRecoPagesDays(): float
    {
        return $this->recommended_pages_per_day;
    }

    public function getUser(): int
    {
        return $this->fk_user;
    }

    public function getFinalReport(): FinalReport
    {
        return $this->finalReport;
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

    public function setEpisodeNb($episodeNb)
    {
        $this->episode_nb = $episodeNb;
    }

    public function setEpisodeTitle($episodeTitle)
    {
        $this->episode_title = $episodeTitle;
    }

    public function setDateBegin($dateBegin)
    {
        $this->date_begining = $dateBegin;
    }

    public function setDateEnd($dateEnd)
    {
        $this->date_end = $dateEnd;
    }

    public function setNbPredecs($nbPredecs)
    {
        $this->nb_predec = $nbPredecs;
    }

    public function setIsCleaning($isCleaning)
    {
        $this->is_cleaning = $isCleaning;
    }

    public function setIsAlone($isAlone)
    {
        $this->is_alone = $isAlone;
    }

    public function setScriptFilePath($scriptFilePath)
    {
        $this->script_path = $scriptFilePath;
    }

    public function setTemplateFilePath($templateFilePath)
    {
        $this->template_path = $templateFilePath;
    }

    public function setNbTotalPages($nbTotalPages)
    {
        $this->nb_total_pages = $nbTotalPages;
    }

    public function setNbAssignedPages($nbAssignedPages)
    {
        $this->nb_assigned_pages = $nbAssignedPages;
    }

    public function setEstimTotalDuration($estimTotalDuration)
    {
        $this->estimated_total_duration = $estimTotalDuration;
    }

    public function setEstimCleaningDuration($estimCleaningDuration)
    {
        $this->estimated_cleaning_duration = $estimCleaningDuration;
    }

    public function setRecoPagesDays($recoPagesDays)
    {
        $this->recommended_pages_per_day = $recoPagesDays;
    }

    public function setUser($user)
    {
        $this->fk_user = $user;
    }

    public function setFinalReport($finalReport)
    {
        $this->finalReport = $finalReport;
    }
}
