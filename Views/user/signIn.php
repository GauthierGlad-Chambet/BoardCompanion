<main class="main-signIn">
    <?php if (!empty($_SESSION['success']['CompteSupprime'])) { ?>
        <p class="messageSuccess"><?= $_SESSION['success']['CompteSupprime'] ?></p>
        <?php unset($_SESSION['success']['CompteSupprime']); ?>
    <?php }; ?>
    <div class="container-signIn">
        <div class="logo logo-signIn">
            <img src="/BoardCompanion/Views/assets/img/logo.png" alt="Logo de Board Companion">
            <h1>Board Companion</h1>
            <p>Ton assistant boarder personnel</p>
        </div>
        <div class="container">
            <form action="" method="POST">
                <div>
                    <label for="email">Email :</label>
                    <input type="text" name="email" id="email" required>
                </div>
                <div>
                    <label for="pseudo ">Prénom ou Pseudo :</label>
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
                    <label for="accepteCGU"><input type="checkbox" id="accepteCGU" name="accepteCGU">J'accepte les termes et conditions d'utilisation</label>
                </div>
                <input class="button" type="submit" name="submit_signUp" id="submit_signUp" value="S'inscrire">
                </form>
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
        </div>
        <div class="container">
                <form action="" method="POST">
                    <div>
                        <label for="email">Email :</label>
                        <input type="text" name="email" id="email" required>
                    </div>
                    <div>
                        <label for="password">Mot de passe :</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                        <input class="button" type="submit" name="submit_signIn" id="submit_signIn" value="Se connecter">
                </form>
        </div>
    </div>
</main>