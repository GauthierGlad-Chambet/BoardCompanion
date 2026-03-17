<main>
    <h1>Compte</h1>
    <div>
        <h2>Modifier le compte</h2>
        <form action="POST">
            <label for="pseudo">Modifier le pseudo</label>
            <input type="text"  name="pseudo" value="<?= $user->getPseudo() ?>">
            </br>
            <label for="password">Mot de passe actuel :</label>
            <input type="password" name="password" placeholder="**********" required>
            </br>
            <label for="newPassword">Nouveau mot de passe :</label>
            <input type="password" name="newPassword" placeholder="**********">
            </br>
            <label for="newPasswordConfirmation">Confirmez le nouveau mot de passe :</label>
            <input type="password" name="newPasswordConfirmation" placeholder="**********">
            <input type="submit" name="modifier" value="Modifier">
        </form>
            <button>Supprimer</button>
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