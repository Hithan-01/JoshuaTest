FROM php:8.1-apache

# Instalar dependencias del sistema necesarias para PostgreSQL y otras extensiones
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install intl pdo pdo_mysql pdo_pgsql pgsql

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

# Instalar dependencias PHP con Composer
RUN composer install --optimize-autoloader --no-interaction --no-scripts --no-dev

# Crear directorios necesarios y dar permisos
RUN mkdir -p /var/www/html/tmp && \
    chown -R www-data:www-data logs tmp && \
    chmod -R 775 logs tmp

EXPOSE 80

CMD ["apache2-foreground"]
