FROM php:8.3-apache AS php-base

RUN usermod -u 1000 www-data

RUN mkdir -p /home/application

RUN chown -R 1000:1000 /var/www/

RUN curl -S https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update -y && apt-get install -y \
    git \
    libzip-dev \
    zip \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libpng-dev \
    libmagickwand-dev
#    imagemagick

RUN docker-php-ext-install gd
#RUN docker-php-ext-enable gd

# ext-imagick
RUN git clone https://github.com/Imagick/imagick.git --depth 1 /tmp/imagick && \
    cd /tmp/imagick && \
    git fetch origin master && \
    git switch master && \
    cd /tmp/imagick && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    docker-php-ext-enable imagick

RUN docker-php-ext-install zip

RUN a2enmod rewrite

RUN docker-php-ext-install pdo_mysql mysqli

RUN apt-get install bash

RUN pecl install mongodb
RUN docker-php-ext-enable mongodb

RUN ln -s /etc/apache2/mods-available/headers.load /etc/apache2/mods-enabled/headers.load


FROM php-base AS php-dev

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
