# BoardCompanion
A web application designed to help storyboarders manage their projects and optimize their workflow.

Démarrer le projet :
git clone https://github.com/GauthierGlad-Chambet/BoardCompanion.git


dans le terminal : composer install

Modifier les paramètres serveur :

Dans php.ini :

upload_max_filesize = 5G
post_max_size = 5G
max_execution_time = 300
max_input_time = 300
memory_limit = 512M



Dans Appache httpd.Conf :

Remplacer 

<Directory />
    AllowOverride none
    Require all denied
</Directory>

par

<Directory "C:/wamp64/www/BoardCompanion">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
    LimitRequestBody 5368709120
</Directory>