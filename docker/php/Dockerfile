FROM ubuntu:22.04

LABEL maintainer="nazar"

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    software-properties-common \
    curl \
    git \
    unzip \
    zip \
    gnupg \
    ca-certificates \
    lsb-release \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libsqlite3-dev \
    nano \
    nodejs \
    npm

RUN add-apt-repository ppa:ondrej/php -y && apt-get update

RUN apt-get install -y \
    php8.2 \
    php8.2-cli \
    php8.2-common \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-curl \
    php8.2-mysql \
    php8.2-pgsql \
    php8.2-sqlite3 \
    php8.2-zip \
    php8.2-bcmath \
    php8.2-gd \
    php8.2-soap \
    php8.2-readline \
    php8.2-opcache \
    php8.2-intl \
    php8.2-gettext \
    php8.2-xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
