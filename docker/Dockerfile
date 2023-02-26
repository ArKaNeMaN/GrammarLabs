ARG APP_PATH='/app'

FROM composer:2 as composer
ARG APP_PATH
WORKDIR ${APP_PATH}

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev

FROM node:lts-alpine3.15 as npm
ARG APP_PATH
WORKDIR ${APP_PATH}

COPY package.json package.json
COPY package-lock.json package-lock.json
RUN npm i

COPY node_modules node_modules
COPY resources resources
COPY public public
COPY --from=composer ${APP_PATH}/vendor/tightenco/ziggy/dist/vue.m.js ./vendor/tightenco/ziggy/dist/vue.m.js

RUN npm run build

FROM php:8.2-apache-buster
ARG APP_PATH
WORKDIR ${APP_PATH}

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY . .

COPY --from=composer ${APP_PATH}/vendor/ ./vendor/
COPY --from=npm ${APP_PATH}/public/ ./public/
RUN php artisan vendor:publish --tag=laravel-assets --ansi --force

COPY ./docker/start-container.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

RUN a2enmod rewrite
COPY docker/apache.conf /etc/apache2/sites-enabled
RUN rm /etc/apache2/sites-enabled/000-default.conf

RUN docker-php-ext-install mysqli pdo_mysql

CMD ["/usr/local/bin/start-container"]
