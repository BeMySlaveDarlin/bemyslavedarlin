FROM php:8.3-fpm AS php_base

ARG APP_PORT
ARG TIMEZONE
ARG COMPOSER_VERSION

RUN apt-get update && apt-get install -y --no-install-recommends \
    gnupg g++ git procps openssl mc nano make acl \
    curl wget unzip gettext \
    zlib1g-dev libzip-dev libonig-dev libxslt1-dev \
    libicu-dev libpq-dev && \
    rm -rf /var/lib/apt/lists/*

RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

RUN docker-php-ext-install \
    pdo pdo_pgsql pgsql \
    opcache intl mbstring \
    bcmath zip xml

COPY --link conf.d/app.ini $PHP_INI_DIR/conf.d/
COPY --link conf.d/www.custom.conf /usr/local/etc/php-fpm.d/zz-custom.conf

RUN php -r "readfile('https://getcomposer.org/installer');" |  \
    php -- --install-dir=/usr/bin/ --filename=composer --version=${COMPOSER_VERSION} \
    && mkdir /run/php

RUN echo 'alias console="php bin/console"' >> ~/.bashrc

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH=/root/composer/vendor/bin:/var/www/app/vendor/bin:/var/www/app/bin:${PATH}

WORKDIR /var/www/app

EXPOSE $APP_PORT

HEALTHCHECK --interval=10s --timeout=3s --retries=3 --start-period=30s \
    CMD php -r "echo 'ok';" || exit 1

FROM php_base AS php_dev

ENV APP_ENV=dev XDEBUG_MODE=off

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY --link conf.d/app.dev.ini $PHP_INI_DIR/conf.d/

RUN pecl update-channels
RUN pecl install xdebug && docker-php-ext-enable xdebug

FROM php_base AS php_prod

ENV APP_ENV=prod

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --link conf.d/app.prod.ini $PHP_INI_DIR/conf.d/
