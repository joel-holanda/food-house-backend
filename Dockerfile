FROM php:apache

WORKDIR "/var/www/html"

RUN apt update && apt install -y \
    unzip

RUN docker-php-ext-install pdo pdo_mysql


#rodar apenas uma vez para instalar
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv ~/.symfony5/bin/symfony /usr/local/bin/symfony 

CMD ["./startup.sh"]