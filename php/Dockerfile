FROM  php:apache

WORKDIR /var/www/html

COPY ./app .

COPY ./apache2.conf /etc/apache2/apache2.conf

RUN apt-get update && apt-get upgrade -y && \
    apt-get install unzip p7zip libzip-dev -y && \
    apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/* 

RUN mkdir -p /usr/src/php/ext/imagick
RUN curl -fsSL https://github.com/Imagick/imagick/archive/06116aa24b76edaf6b1693198f79e6c295eda8a9.tar.gz | tar xvz -C "/usr/src/php/ext/imagick" --strip 1
RUN docker-php-ext-install imagick

RUN docker-php-ext-enable imagick && \
    docker-php-ext-install zip && \
    docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli && \
    docker-php-ext-install pdo pdo_mysql && \
    docker-php-ext-enable pdo_mysql && \
    docker-php-ext-install gd && \
    docker-php-ext-enable gd
RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
RUN bash -c "source ~/.bashrc && nvm install 20.10.0 && composer install && npm install -g gulp-cli && npm install && gulp"

RUN service apache2 restart
EXPOSE 8000