<main>
    <h1>Nouveau Projet</h1>
    <form class="container" action="" method="POST" enctype="multipart/form-data">
        <div>
                <label for="name">Nom du Projet :</label>
                <input type="text" name="name" id="name" required>
        </div>
        <div>
                <label for="studio">Nom du Studio :</label>
                <input type="text" name="studio" id="studio" required>
        </div>
        <div>
                <label for="episode_nb">Numéro d'épisode :</label>
                <input type="text" name="episode_nb" id="episode_nb" pattern="[0-9]+" inputmode="numeric" minlength="3" required>
                <p class="note">(format : NumSaisonNumEpisode)</p>
        </div>
        <div>
                <label for="episode_title">Titre de l'épisode :</label>
                <input type="text" name="episode_title" id="episode_title" required>
        </div>
        <div>
                <label for="nb_predec">Nombre de parties de prédecs :</label>
                <input type="number" name="nb_predec" id="nb_predec" min="1" required>
        </div>
        <div class="block-radio">
                <p>Je m'occupe seul du script :</p>
                <div>
                        <label class="customLabel radioLabel" for="alone">Oui
                                <input type="radio" id="alone" name="is_alone" value="1" checked />
                                <span class="checkmark"></span>
                        </label>
                        <label class="customLabel radioLabel" for="not_alone">Non
                                <input type="radio" id="not_alone" name="is_alone" value="0" />
                                <span class="checkmark"></span>
                        </label>
                </div>
        </div>
        <div class="block-radio">
                <p>Je m'occupe du cleaning :</p>
                <div>
                        <label class="customLabel radioLabel" for="cleaning">Oui
                                <input type="radio" id="cleaning" name="is_cleaning" value="1" checked />
                                <span class="checkmark"></span>
                        </label>
                        <label class="customLabel radioLabel" for="no_cleaning">Non
                                <input type="radio" id="no_cleaning" name="is_cleaning" value="0" />
                                <span class="checkmark"></span>
                        </label>

                </div>
        </div>
        <div class="block-files">
                <label for="script">Script :</label>
                <input type="file" name="script" id="script" accept=".pdf" required>
                <p class="note">(.pdf)</p>
        </div>
        <div class="block-files">
                <label for="template">Fichier de template :</label>
                <input type="file" name="template" id="template" accept=".sbbkp, .psd">
                <p class="note">(.sbbkp ou .psd)</p>
        </div>
        <div class="block-dates">
                <p>Période de contrat :</p>
                <label for="date_begin">Début
                        <input type="date" name="date_begin" id="date_begin" required>
                </label>
                
                <label for="date_end">Fin 
                        <input type="date" name="date_end" id="date_end" required>
                </label>
                
        </div>
        <div class="block-radio">
                <p>Je veux une analyse détaillée du script :</p>  
                <div>
                        <label class="customLabel radioLabel" for="details">Oui
                                <input type="radio" id="details" name="script_detailed" value="1" checked />
                                <span class="checkmark"></span>
                        </label>
                        <label class="customLabel radioLabel" for="no_details">Non
                                <input type="radio" id="no_details" name="script_detailed" value="0" />
                                <span class="checkmark"></span>
                        </label>
                </div>
        </div>
        <input class="button" type="submit" name="submit_new_project" id="submit_new_project" value="Valider">
    </form>
</main>