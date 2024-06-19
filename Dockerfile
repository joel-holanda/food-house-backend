FROM php:8.0.13-cli

RUN apt-get update \
    &&  apt-get install -y --no-install-recommends \
        locales apt-utils git libicu-dev libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev unzip libpq-dev wget \
        apt-transport-https lsb-release ca-certificates

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony


# RUN docker-php-ext-configure \
#             intl \
#     &&  docker-php-ext-install \
#             pdo pdo_mysql pdo_pgsql opcache intl zip calendar dom mbstring gd xsl

# WORKDIR /var/www/html/