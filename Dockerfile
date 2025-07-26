FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar archivos al contenedor
COPY . /var/www/html/

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www/html
