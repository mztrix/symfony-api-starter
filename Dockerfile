# syntax=docker/dockerfile:1.4

FROM postgres as database_upstream

FROM mztrix/php-fpm as app_dev

WORKDIR /var/www/app

RUN set -eux; \
    apk add --no-cache \
    php84-phar \
    php84-mbstring \
    php84-iconv \
    php84-openssl \
    php84-ctype \
    php84-sodium \
    php84-xml \
    php84-tokenizer \
    php84-dom \
    php84-simplexml \
    php84-xmlwriter \
    php84-intl \
    php84-session \
    php84-pdo  \
    php84-pdo_pgsql \
    php84-pecl-xdebug \
    acl \
    file \
    gettext \
    git \
    ;

COPY --link .docker/php/conf.d/app.ini  /etc/php84/php.ini
COPY --link .docker/php/conf.d/50_xdebug.ini  /etc/php84/conf.d/50_xdebug.ini
COPY --from=composer/composer:2-bin --link /composer /usr/local/bin/composer
COPY --chown=www-data:www-data composer.json composer.lock ./

VOLUME /var/www/app/vendor

COPY --link .docker/php/entrypoint.sh /usr/local/bin/entrypoint
RUN set -eux; chmod +x /usr/local/bin/entrypoint

ENTRYPOINT ["entrypoint"]

FROM database_upstream as database_dev

FROM nginx:alpine AS nginx_dev

WORKDIR /var/www/app/public

RUN set -eux; \
    echo -e "\e[1;33m===> Creating www-data user for PHP-FPM\e[0m"; \
    adduser -D -u 82 -S -G www-data -s /sbin/nologin www-data; \
    echo -e "\e[1;33m===> www-data user created with UID 82 and GID 82\e[0m"; \
    chown -R www-data:www-data /var/www/app; \
    echo -e "\e[1;33m===> Set ownership of /var/www to www-data:www-data\e[0m";

COPY --link .docker/nginx/sites-enabled/api.conf /etc/nginx/conf.d/default.conf
COPY --link .docker/nginx/nginx.conf /etc/nginx/nginx.conf

CMD ["nginx", "-g", "daemon off;"]
