FROM php:apache

WORKDIR "/var/www/html"

ENTRYPOINT ["symfony", "server:start"]
