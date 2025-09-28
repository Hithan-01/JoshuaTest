FROM php:8.1-apache

# Instalar dependencias del sistema incluyendo SQLite
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libsqlite3-dev \
    unzip \
    && docker-php-ext-install intl pdo pdo_mysql pdo_sqlite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar Apache para CakePHP
ENV APACHE_DOCUMENT_ROOT /var/www/html/webroot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# Copiar código
COPY . /var/www/html/
WORKDIR /var/www/html

# Instalar dependencias
RUN composer install --optimize-autoloader --ignore-platform-reqs

# Crear directorio para SQLite y dar permisos
RUN mkdir -p /var/www/html/tmp && \
    chown -R www-data:www-data logs tmp && \
    chmod -R 775 logs tmp

EXPOSE 80