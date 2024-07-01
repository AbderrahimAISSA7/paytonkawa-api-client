# Utilisez la bonne version de PHP (8.1.29)
FROM php:8.1.29-fpm

# Installez les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip

# Installez les extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip opcache

# Définissez le répertoire de travail
WORKDIR /var/www

# Copiez les fichiers de votre application dans le conteneur
COPY . .

# Configurez Composer et installez les dépendances en ignorant les exigences de plate-forme
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && COMPOSER_ALLOW_SUPERUSER=1 composer install --ignore-platform-reqs --no-scripts

# Exposez le port 9000 et démarrez PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]

