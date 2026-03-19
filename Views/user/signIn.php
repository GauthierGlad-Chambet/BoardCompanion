<main>
<h1>Board Companion</h1>
<p>Ton assistant boarder personnel</p>
<?php if (!empty($_SESSION['success']['CompteSupprime'])) { ?>
    <p class="messageSuccess"><?= $_SESSION['success']['CompteSupprime'] ?></p>
    <?php unset($_SESSION['success']['CompteSupprime']); ?>
<?php }; ?>
    <form action="" method="POST">
            <label for="email">Email :</label>
            <input type="text" name="email" id="email" required>
        </br>
            <label for="pseudo ">Prénom ou Pseudo :</label>
            <input type="text" name="pseudo" id="pseudo" required>
        </br>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
        </br>
            <label for="passwordConfirmation">Confirmez le mot de passe :</label>
            <input type="password" name="passwordConfirmation" id="passwordConfirmation" required>
        </br>
            <input type="checkbox" id="accepteCGU" name="accepteCGU">
            <label for="accepteCGU">J'accepte les <a href="">termes et conditions d'utilisation</a></label>
        </br>
            <input type="submit" name="submit_signUp" id="submit_signUp" value="S'inscrire">
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


    <form action="" method="POST">
            <label for="email">Email :</label>
            <input type="text" name="email" id="email" required>
        </br>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
        </br>
    
            <input type="submit" name="submit_signIn" id="submit_signIn" value="Se connecter">
    </form>
</main>