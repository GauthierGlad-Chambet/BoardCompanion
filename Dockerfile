FROM php:8.1-apache
 
# Installe les extensions PHP nécessaires pour MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli
 
# Active le module Apache mod_rewrite (utile pour les URLs propres / .htaccess)
RUN a2enmod rewrite
 
# Autorise les fichiers .htaccess à surcharger la config Apache (nécessaire pour ton .htaccess)
RUN { \
    echo '<Directory /var/www/html/>'; \
    echo '    AllowOverride All'; \
    echo '</Directory>'; \
    } > /etc/apache2/conf-available/htaccess.conf \
    && a2enconf htaccess

# Installe unzip, nécessaire à Composer pour décompresser les paquets téléchargés
RUN apt-get update && apt-get install -y --no-install-recommends unzip \
    && rm -rf /var/lib/apt/lists/*
 
# Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copie la config PHP personnalisée (logue les erreurs au lieu de les afficher)
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
 
# Définit le dossier racine du site (Apache sert déjà /var/www/html par défaut)
WORKDIR /var/www/html
 
