FROM php:7.4-fpm

WORKDIR /var/www/html

# Instal PDO
RUN docker-php-ext-install pdo pdo_mysql

# Install Compose
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Supervisor
RUN apt update && apt install supervisor -y
