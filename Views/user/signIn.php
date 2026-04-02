<main class="main-signIn">    
    <div class="logo-signIn">
        <img src="/BoardCompanion/Views/assets/icons/Boardy/boardy.png" alt="Logo de Board Companion">
        <h1>Board Companion</h1>
        <p class="text-primary-color">Ton assistant boarder personnel</p>
    </div>
    <div class="container-signIn">
        <div class="login-onglets">
            <div class="container login-button" id="button-inscription">
                <h2 id="label-inscription">Inscription</h2>
            </div>
            <div class="container login-button color-green" id="button-connection">
                <h2 class="color-green" id="label-connection">Connexion</h2>
            </div>
        </div>

        <div class="container block-login" id="block-connection">
            <form action="" method="POST">
                <div>
                    <label for="email2">Email :</label>
                    <input <?php if (!empty($_SESSION['error']['sigin-email']) || !empty($_SESSION['error']['verifIdentifiants'])) { ?> class="inputError" <?php } ?> type="text" name="email" id="email2" autocomplete="email" required>
                    <?php if (!empty($_SESSION['error']['sigin-email'])) { ?>
                        <p class="messageError"><?= $_SESSION['error']['sigin-email'] ?></p>
                    <?php } unset($_SESSION['error']['sigin-email']); ?>
                </div>
                <div>
                    <label for="password2">Mot de passe :</label>
                    <input <?php if (!empty($_SESSION['error']['verifIdentifiants']) || !empty($_SESSION['error']['sigin-incorrectPassword'])) { ?> class="inputError" <?php } ?> type="password" name="password" id="password2" autocomplete="current-password" required>
                    <?php if ( !empty($_SESSION['error']['sigin-incorrectPassword'])) { ?>
                        <p class="messageError"><?= $_SESSION['error']['sigin-incorrectPassword'] ?></p>
                    <?php } unset($_SESSION['error']['sigin-incorrectPassword']); ?>
                    <?php if ( !empty($_SESSION['error']['verifIdentifiants'])) { ?>
                        <p class="messageError"><?= $_SESSION['error']['verifIdentifiants'] ?></p>
                    <?php } unset($_SESSION['error']['verifIdentifiants']); ?>
                </div>
                    <input class="button" type="submit" name="submit_signIn" id="submit_signIn" value="Se connecter">
            </form>
        </div>

        <div class="container block-login" id="block-inscription">
            <form action="" method="POST">
                <div>
                    <label for="email">Email :</label>
                    <input <?php if (!empty($_SESSION['error']['emailExists'])) { ?> class="inputError" <?php } ?> type="text" name="email" id="email" autocomplete="off" value="<?= $email??'' ?>" required>
                    <?php if (!empty($_SESSION['error']['emailExists'])) { ?>
                        <p class="messageError"><?= $_SESSION['error']['emailExists'] ?></p>
                    <?php } unset($_SESSION['error']['emailExists']); ?>
                </div>
                <div>
                    <label for="pseudo">Prénom ou Pseudo :</label>
                    <input <?php if (!empty($_SESSION['error']['pseudo'])) { ?> class="inputError" <?php } ?> type="text" name="pseudo" id="pseudo" value="<?= $pseudo??'' ?>" required>
                    <?php if (!empty($_SESSION['error']['pseudo'])) { ?>
                        <p class="messageError"><?= $_SESSION['error']['pseudo'] ?></p>
                    <?php } unset($_SESSION['error']['pseudo']); ?>
                </div>
                <div>
                    <label for="password">Mot de passe :</label>
                    <input <?php if (!empty($_SESSION['error']['incorrectPassword']) || !empty($_SESSION['error']['regex'])) { ?> class="inputError" <?php } ?> type="password" autocomplete="off" name="password" id="password" required>
                    <?php if (!empty($_SESSION['error']['incorrectPassword'])) { ?>
                        <p class="messageError"><?= $_SESSION['error']['incorrectPassword'] ?></p>
                    <?php } unset($_SESSION['error']['incorrectPassword']); ?>
                    <?php if (!empty($_SESSION['error']['regex'])) { ?>
                        <p class="messageError"><?= $_SESSION['error']['regex'] ?></p>
                    <?php } unset($_SESSION['error']['regex']); ?>
                </div>
                <div>
                    <label for="passwordConfirmation">Confirmez le mot de passe :</label>
                    <input <?php if (!empty($_SESSION['error']['matching'])) { ?> class="inputError" <?php } ?> type="password" name="passwordConfirmation" id="passwordConfirmation" required>
                    <?php if (!empty($_SESSION['error']['matching'])) { ?>
                        <p class="messageError"><?= $_SESSION['error']['matching'] ?></p>
                    <?php } unset($_SESSION['error']['matching']); ?>
                </div>
                <div>
                    <label class="customLabel" id="checkboxLabel" for="accepteCGU">J'accepte les termes et conditions d'utilisation
                        <input type="checkbox" id="accepteCGU" name="accepteCGU">
                        <span <?php if (!empty($_SESSION['error']['accepteCGU'])) { ?> class="checkmark inputError" <?php } ?> class="checkmark" ></span>
                    </label>
                    <?php if (!empty($_SESSION['error']['accepteCGU'])) { ?>
                        <p class="messageError"><?= $_SESSION['error']['accepteCGU'] ?></p>
                    <?php } unset($_SESSION['error']['accepteCGU']); ?>
                </div>
                <input class="button" type="submit" name="submit_signUp" id="submit_signUp" value="S'inscrire">
            </form>
        </div>
    </div>    
    <?php if (!empty($_SESSION['success']['CompteSupprime'])) { ?>
        <p class="messageSuccess"><?= $_SESSION['success']['CompteSupprime'] ?></p>
    <?php } unset($_SESSION['success']['CompteSupprime']); ?>
    <?php if (!empty($_SESSION['success']['utilisateurAjoute'])) { ?>
        <p class="messageSuccess"><?= $_SESSION['success']['utilisateurAjoute'] ?></p>
    <?php } unset($_SESSION['success']['utilisateurAjoute']); ?>      
</main>