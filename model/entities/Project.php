<?php

 require_once "entity.php";

 class Project extends Entity {
    private string $id;
    private string $name;
    private string $studio;
    private string $episodeNb;
    private string $episodeTitle;
    private date $dateBegin;
    private date $dateEnd;
    private int $nbPredecs;
    private bool $isCleaning;
    private bool $isAlone;
    private string $scriptFilePath;
    private string $templateFilePath;
    private float $nbTotalPages;
    private float $nbAssignedPages;
    private float $estimTotalDuration;
    private float $estimCleaningDuration;
    private float $recoPagesDays;
    private User $user;
    private FinalReport $finalReport;
    

    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getStudio() : string {
        return $this->studio;
    }

    public function getEpisodeNb() : string {
        return $this->episodeNb;
    }

    public function getEpisodeTitle() : string {
        return $this->episodeTitle;
    }

    public function getDateBegin() : date {
        return $this->dateBegin;
    }

    public function getDateEnd() : date {
        return $this->dateEnd;
    }

    public function getNbPredecs() : int {
        return $this->nbPredecs;
    }

    public function getIsCleaning() : bool {
        return $this->isCleaning;
    }

    public function getIsAlone() : bool {
        return $this->isAlone;
    }

    public function getScriptFilePath() : string {
        return $this->scriptFilePath;
    }

    public function getTemplateFilePath() : string {
        return $this->templateFilePath;
    }

    public function getNbTotalPages() : float {
        return $this->nbTotalPages;
    }

    public function getNbAssignedPages() : float {
        return $this->nbAssignedPages;
    }

    public function getEstimTotalDuration() : float {
        return $this->estimTotalDuration;
    }

    public function getEstimCleaningDuration() : float {
        return $this->estimCleaningDuration;
    }

    public function getRecoPagesDays() : float {
        return $this->recoPagesDays;
    }

    public function getUser() : User {
        return $this->user;
    }

    public function getFinalReport() : FinalReport {
        return $this->finalReport;
    }    


    // Setters

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setStudio($studio) {
        $this->studio = $studio;
    }

    public function setEpisodeNb($episodeNb) {
        $this->episodeNb = $episodeNb;
    }

    public function setEpisodeTitle($episodeTitle) {
        $this->episodeTitle = $episodeTitle;
    }

    public function setDateBegin($dateBegin) {
        $this->dateBegin = $dateBegin;
    }

    public function setDateEnd($dateEnd) {
        $this->dateEnd = $dateEnd;
    }

    public function setNbPredecs($nbPredecs) {
        $this->nbPredecs = $nbPredecs;
    }

    public function setIsCleaning($isCleaning) {
        $this->isCleaning = $isCleaning;
    }

    public function setIsAlone($isAlone) {
        $this->isAlone = $isAlone;
    }

    public function setScriptFilePath($scriptFilePath) {
        $this->scriptFilePath = $scriptFilePath;
    }

    public function setTemplateFilePath($templateFilePath) {
        $this->templateFilePath = $templateFilePath;
    }

    public function setNbTotalPages($nbTotalPages) {
        $this->nbTotalPages = $nbTotalPages;
    }

    public function setNbAssignedPages($nbAssignedPages) {
        $this->nbAssignedPages = $nbAssignedPages;
    }

    public function setEstimTotalDuration($estimTotalDuration) {
        $this->estimTotalDuration = $estimTotalDuration;
    }

    public function setEstimCleaningDuration($estimCleaningDuration) {
        $this->estimCleaningDuration = $estimCleaningDuration;
    }

    public function setRecoPagesDays($recoPagesDays) {
        $this->recoPagesDays = $recoPagesDays;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setFinalReport($finalReport) {
        $this->finalReport = $finalReport;
    }    
 }