<main class="main-signIn">
    <?php if (!empty($_SESSION['success']['CompteSupprime'])) { ?>
        <p class="messageSuccess"><?= $_SESSION['success']['CompteSupprime'] ?></p>
        <?php unset($_SESSION['success']['CompteSupprime']); ?>
    <?php }; ?>
    <?php if (!empty($_SESSION['error'])){ 
                            foreach($_SESSION['error'] as $message) {
                        ?>
                            <p class="messageError"><?= $message ?></p>
                        <?php }
                            unset($_SESSION['error']);
                        } ?>
                    
                        <?php if (!empty($_SESSION['success']['utilisateurAjoute'])) { ?>
                            <p class="messageSuccess"><?= $_SESSION['success']['utilisateurAjoute'] ?></p>
                            <?php unset($_SESSION['success']['utilisateurAjoute']); ?>
                        <?php }; ?>
    <div class="logo-signIn">
        <img src="/BoardCompanion/Views/assets/icons/Boardy/boardy.png" alt="Logo de Board Companion">
        <h1>Board Companion</h1>
        <p class="text-primary-color"">Ton assistant boarder personnel</p>
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
                    <input type="text" name="email" id="email2" autocomplete="on" required>
                </div>
                <div>
                    <label for="password2">Mot de passe :</label>
                    <input type="password" name="password" id="password2" required>
                </div>
                    <input class="button" type="submit" name="submit_signIn" id="submit_signIn" value="Se connecter">
            </form>
        </div>

        <div class="container block-login" id="block-inscription">
            <form action="" method="POST">
                <div>
                    <label for="email">Email :</label>
                    <input type="text" name="email" id="email" autocomplete="on" required>
                </div>
                <div>
                    <label for="pseudo">Prénom ou Pseudo :</label>
                    <input type="text" name="pseudo" id="pseudo" required>
                </div>
                <div>
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div>
                    <label for="passwordConfirmation">Confirmez le mot de passe :</label>
                    <input type="password" name="passwordConfirmation" id="passwordConfirmation" required>
                </div>
                <div>
                    <label class="customLabel" id="checkboxLabel" for="accepteCGU">J'accepte les termes et conditions d'utilisation
                        <input type="checkbox" id="accepteCGU" name="accepteCGU" required>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <input class="button" type="submit" name="submit_signUp" id="submit_signUp" value="S'inscrire">
            </form>
        </div>
    </div>                
</main>