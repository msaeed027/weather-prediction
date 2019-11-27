FROM php:alpine

WORKDIR /app

COPY . /app
COPY .env-docker-compose .env

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && chmod a+x /usr/local/bin/composer

RUN apk add --update --no-cache autoconf g++ make \
    && pecl install redis \
    && docker-php-ext-enable redis

RUN composer install --no-scripts --no-autoloader
RUN composer dump-autoload

EXPOSE 8000
