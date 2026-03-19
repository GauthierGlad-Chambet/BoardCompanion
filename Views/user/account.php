<main>
    <h1>Compte</h1>
    <div>
        <h2>Modifier le compte</h2>
        <form method="POST" action="index.php?controller=user&action=updatePassword">
            <label for="pseudo">Pseudo<span class="champObligatoire"> *</span> :</label>
            <input id="pseudo" type="text"  name="pseudo" value="<?= $user->getPseudo() ?>">
            </br>
            <label for="oldPassword">Mot de passe<span class="champObligatoire"> *</span> :</label>
            <input id="oldPassword" type="password" name="oldPassword" placeholder="**********" required>
            </br>
            <label for="newPassword">Nouveau mot de passe<span class="champObligatoire"> *</span> :</label>
            <input id="newPassword" type="password" name="newPassword">
            </br>
            <label for="newPasswordConfirmation">Confirmez le nouveau mot de passe<span class="champObligatoire"> *</span> :</label>
            <input id="newPasswordConfirmation" type="password" name="newPasswordConfirmation">
            <input type="submit" name="modifier" value="Modifier">
        </form>


        <button class="bouttonSupprimer">Supprimer le compte</button>
        <div class="popup popupSuppr" id="popupCompte">
        <form method="POST" action="index.php?controller=user&action=deleteAccount">
            <p>Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.</p>
            </br>
            <label for="confirmPassword">Veuillez entrer votre mot de passe pour confirmer la suppression :</label>
            <input id="confirmPassword" type="password" name="confirmPassword" placeholder="**********" required/>
            </br>
            <button type="submit">Supprimer le compte</button>
        </form>
        <button class="annulerSuppr">Annuler</button>
    </div>

    <?php if (!empty($_SESSION['error'])){ 
        foreach($_SESSION['error'] as $message) {
    ?>
        <p class="messageError"><?= $message ?></p>
    <?php }
        unset($_SESSION['error']);
    } ?>

    <?php if (!empty($_SESSION['success'])) { ?>
        <p class="messageSuccess"><?= $_SESSION['success']['CompteMAJ'] ?></p>
        <?php unset($_SESSION['success']['CompteMAJ']); ?>
    <?php }; ?>

    </div>
    <div>
        <h2>Statistiques du compte</h2>
        <h3>Satisfaction globale :</h3> <p> <?= $user->getAppreciation_label() ?></p>
        <h3>Vitesse moyenne :</h3> <p><?= $user->getAvg_pages_per_day() ?> pages / jours</p>
        <h3>action :</h3> <p><?=  $statAction ?> pages / jours</p>
        <h3>comédie :</h3> <p><?=  $statComedie ?> pages / jours</p>
        <h3>mixte :</h3> <p><?=  $statMixte ?> pages / jours</p>
        <h3>Moyenne de plans par page :</h3> <p><?= $user->getAvg_shots_per_page() ?> plans</p>
        <h3>Moyenne de cleaning par projet :</h3><p><?= $user->getAvg_cleaning_duration() ?> jours</p>
    </div>
</main>