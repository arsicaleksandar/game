FROM php:8.0-fpm
RUN apt-get update
RUN apt-get install -y autoconf pkg-config libssl-dev libzip-dev git gcc make libc-dev vim unzip
RUN docker-php-ext-install bcmath pdo pdo_mysql mysqli sockets zip

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

WORKDIR /home/guess

ENTRYPOINT ["php", "-S", "0.0.0.0:8080", "-t", "/home/guess/public"]
