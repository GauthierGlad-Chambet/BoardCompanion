<main>
    <h1>Nouveau Projet</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Nom du Projet</label>
        <input type="text" name="name" id="name" required>
</br>
        <label for="studio">Nom du Studio</label>
        <input type="text" name="studio" id="studio" required>
</br>
        <label for="episode_nb">Numéro d'épisode</label>
        <input type="text" name="episode_nb" id="episode_nb" pattern="[0-9]+" inputmode="numeric" minlength="3" required>
        <p>(format : NumSaisonNumEpisode)</p>
</br>
        <label for="episode_title">Titre de l'épisode</label>
        <input type="text" name="episode_title" id="episode_title" required>
</br>
        <label for="nb_predec">Nombre de parties de prédecs</label>
        <input type="number" name="nb_predec" id="nb_predec" min="1" required>
</br>
        <p>Je m'occupe seul du script</p>
        <input type="radio" id="alone" name="is_alone" value="oui" checked />
        <label for="alone">Oui</label>
        <input type="radio" id="not_alone" name="is_alone" value="non" />
        <label for="not_alone">Non</label>
</br>
        <p>Je m'occupe du cleaning</p>
        <input type="radio" id="cleaning" name="is_cleaning" value="oui" checked />
        <label for="cleaning">Oui</label>
        <input type="radio" id="no_cleaning" name="is_cleaning" value="non" />
        <label for="no_cleaning">Non</label>
</br>
</br>
        <label for="script">Script (.pdf)</label>
        <input type="file" name="script" id="script" accept=".pdf" required>
</br>
        <label for="template">Fichier de template (.sbbkp ou .psd)</label>
        <input type="file" name="template" id="template" accept=".sbbkp, .psd">
</br>
        <p>Période de contrat</p>
        <label for="date_begin">Début</label>
        <input type="date" name="date_begin" id="date_begin" required>
        <label for="date_end">Fin</label>
        <input type="date" name="date_end" id="date_end" required>
</br>
        <p>Je veux une analyse du script détaillée</p>
        <input type="radio" id="script_detailed" name="script_detailed" value="oui" checked />
        <label for="details">Oui</label>
        <input type="radio" id="not_alone" name="script_detailed" value="non" />
        <label for="no_details">Non</label>
</br>
        <input type="submit" name="submit_new_project" id="submit_new_project" value="Valider">

    </form>
</main>