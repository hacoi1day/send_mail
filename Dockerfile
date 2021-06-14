FROM php:7.4-fpm

WORKDIR /var/www/html

# Instal PDO and Extensions for Export Excel
# RUN docker-php-ext-install pdo pdo_mysql

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

COPY --from=composer /usr/bin/composer /usr/bin/composer
# Copy composer.lock and composer.json
COPY /composer.lock /composer.json /var/www/html/

RUN install-php-extensions pdo pdo_mysql zip gd
