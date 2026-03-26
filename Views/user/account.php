<main>
    <div class="page-container">
        <h1>Compte</h1>
        <div>
            <form class="container" method="POST" action="index.php?controller=user&action=updateAccount">
                <h2 class="h2-account">Modifier le compte</h2>
                <h3>Modifier le pseudo :</h3>
                <div>
                    <label for="pseudo">Pseudo<span class="champObligatoire"> *</span> :</label>
                    <input id="pseudo" type="text"  name="pseudo" value="<?= $user->getPseudo() ?>">
                </div>
                <div>
                    <label for="oldPassword">Mot de passe<span class="champObligatoire"> *</span> :</label>
                    <input id="oldPassword" type="password" name="oldPassword" placeholder="**********" required>
                </div>
                <h3>Modifier le mot de passe :</h3>
                <div>
                    <label for="newPassword">Nouveau mot de passe<span class="champObligatoire"> *</span> :</label>
                    <input id="newPassword" type="password" name="newPassword">
                </div>
                <div>
                    <label for="newPasswordConfirmation">Confirmez le nouveau mot de passe<span class="champObligatoire"> *</span> :</label>
                    <input id="newPasswordConfirmation" type="password" name="newPasswordConfirmation">
                </div>
                <div class="button-modify-account">
                    <button class="button" id="button-modify-account" type="submit" name="modifier">
                        <svg viewBox="-1.5 -1.5 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" id="Pen-2--Streamline-Solar-Broken">
                            <path d="M7.5 41.25h7.5m22.5 0h-15" stroke-linecap="round" stroke-width="3"></path>
                            <path d="m26.0401875 6.867993749999999 1.3903125 -1.39033125c2.3034375 -2.30355 6.038250000000001 -2.30355 8.341875 0 2.3034375 2.3035687499999997 2.3034375 6.0383625 0 8.3419125l-1.3903125 1.39033125m-8.341875 -8.3419125s0.173625 2.95441875 2.780625 5.56126875c2.6068125 2.60685 5.56125 2.78064375 5.56125 2.78064375m-8.341875 -8.3419125L13.2582375 19.649812500000003c-0.8657437499999999 0.8656874999999999 -1.298625 1.298625 -1.6708875 1.776 -0.43914375 0.562875 -0.81564375 1.1720625 -1.12284375 1.8166875 -0.2604 0.5463749999999999 -0.45399375000000003 1.1272499999999999 -0.8411625 2.2888124999999997l-1.640625 4.921875M34.382062499999996 15.20990625l-6.3909375 6.39084375m-6.3909375 6.3909375c-0.8656874999999999 0.865875 -1.298625 1.298625 -1.776 1.671 -0.562875 0.439125 -1.17215625 0.815625 -1.816725 1.12275 -0.5464125 0.2604375 -1.127175 0.454125 -2.2887 0.841125l-4.921875 1.6408125m0 0 -1.20313125 0.400875c-0.57159375 0.1906875 -1.2017624999999998 0.0418125 -1.62781875 -0.3841875 -0.4260375 -0.42600000000000005 -0.5748 -1.0561875 -0.3842625 -1.627875l0.40104375 -1.2029999999999998m2.8141687500000003 2.8141874999999996 -2.8141687500000003 -2.8141874999999996" stroke-linecap="round" stroke-width="3"></path>
                        </svg>
                        Modifier le compte
                    </button>
                    <button class="bouttonSupprimer button">
                        <svg viewBox="-1.5 -1.5 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" id="Trash-Bin-Minimalistic--Streamline-Solar-Broken">
                            <path d="M17.19496875 7.5c0.7722 -2.18473125 2.85571875 -3.75 5.30484375 -3.75 2.4493125 0 4.5328125 1.56526875 5.304937499999999 3.75" stroke-linecap="round" stroke-width="3"></path>
                            <path d="M38.4376875 11.25H6.5625" stroke-linecap="round" stroke-width="3"></path>
                            <path d="M34.4503125 28.8733125c-0.331875 4.9779375 -0.49781250000000005 7.4670000000000005 -2.1196875 8.98425C30.708750000000002 39.375 28.21425 39.375 23.22525 39.375h-1.4501249999999999c-4.989 0 -7.4835 0 -9.10539375 -1.5174375 -1.62189375 -1.51725 -1.78783125 -4.0063125 -2.1196875 -8.98425L9.68765625 15.9375m25.62496875 0 -0.375 5.625" stroke-linecap="round" stroke-width="3"></path>
                            <path d="m17.8125 20.625 0.9375 9.375" stroke-linecap="round" stroke-width="3"></path>
                            <path d="m27.1875 20.625 -0.9375 9.375" stroke-linecap="round" stroke-width="3"></path>
                        </svg>
                        Supprimer le compte</button>
                </div>
            </form>
    
    
            
    
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
        <div class="container" id="account-container">
            <h2 class="h2-account">Statistiques du compte</h2>
            <div>
                <h3>Satisfaction globale :</h3>
                <img src="Views/assets/img/<?= $user->getAppreciation_label() ?>" alt="Smiley symbolisant l'appréciation">
            </div>
            <div class="block-vitesse">
                <h3>Vitesses :</h3>
                <div>
                    <h4>Vitesse moyenne :</h4> <p><?= $user->getAvg_pages_per_day() ?> pages / jours</p>
                </div>
                <div>
                    <h4>Action :</h4> <p><?=  $statAction ?> pages / jours</p>
                </div>
                <div>
                    <h4>Comédie :</h4> <p><?=  $statComedie ?> pages / jours</p>
                </div>
                <div>
                    <h4>Mixte :</h4> <p><?=  $statMixte ?> pages / jours</p>
                </div>
            </div>
            <div>
                <h3>Moyenne de plans par page :</h3>
                <p><?= $user->getAvg_shots_per_page() ?> plans</p>
            </div>
            <div>
                <h3>Moyenne de cleaning par projet :</h3>
                <p><?= $user->getAvg_cleaning_duration() ?> jours</p>
            </div>
        </div>
    </div>
    <div class="popup popupSuppr container" id="popupCompte">
                <form method="POST" action="index.php?controller=user&action=deleteAccount">
                    <p>Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.</p>
                    <label for="confirmPassword">Veuillez entrer votre mot de passe pour confirmer la suppression :</label>
                    <input id="confirmPassword" type="password" name="confirmPassword" placeholder="**********" required/>
                <div>
                    <button class="annulerSuppr button">Annuler</button>
                    <button  class="button"type="submit">Supprimer le compte</button>

                </div>
                </form>
            </div>
</main>