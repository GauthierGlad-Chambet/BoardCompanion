FROM php:8.1-apache

# Installe les extensions PHP nécessaires pour MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Installe unzip, nécessaire à Composer pour décompresser les paquets téléchargés
RUN apt-get update && apt-get install -y --no-install-recommends unzip \
    && rm -rf /var/lib/apt/lists/*

# Active le module Apache mod_rewrite (utile pour les URLs propres / .htaccess)
RUN a2enmod rewrite

# Autorise les fichiers .htaccess à surcharger la config Apache
RUN { \
    echo '<Directory /var/www/html/>'; \
    echo '    AllowOverride All'; \
    echo '</Directory>'; \
    } > /etc/apache2/conf-available/htaccess.conf \
    && a2enconf htaccess

# Autorise les requêtes/uploads volumineux
COPY apache-uploads.conf /etc/apache2/conf-available/uploads.conf
RUN a2enconf uploads

# Copie la config PHP personnalisée (logs + uploads volumineux)
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Installe Composer (copié depuis l'image officielle Composer)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copie le code de l'application dans l'image (voir .dockerignore pour les exclusions)
COPY ./src /var/www/html
WORKDIR /var/www/html

# Installe uniquement les dépendances de PRODUCTION (ignore phpunit et le reste du require-dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction