    <footer>
      <a href="/mentions-legales">Mentions légales</a>
      <?php if (!empty($_SESSION['user']['role'])) { ?>
        <a href="/panneau-administration">Panneau d'administration</a>
      <?php } ?>
    </footer>

    <script src="Views/assets/js/script.js"></script>

    </body>

    </html>