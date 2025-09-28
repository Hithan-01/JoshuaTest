FROM php:8.2-apache 
 
# Instalar extensiones PHP necesarias 
RUN docker-php-ext-install pdo pdo_mysql 
RUN apt-get update && apt-get install -y libicu-dev && docker-php-ext-install intl 
 
# Instalar Composer 
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 
# Configurar Apache 
ENV APACHE_DOCUMENT_ROOT=/var/www/html/webroot 
RUN a2enmod rewrite 
 
# Copiar c¢digo 
COPY . /var/www/html/ 
 
# Instalar dependencias 
WORKDIR /var/www/html 
RUN composer install --no-dev --optimize-autoloader 
 
EXPOSE 80 
