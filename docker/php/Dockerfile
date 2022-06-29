FROM php:8.1.0-fpm-alpine
ENV PS1="\u@\h:\w\\$ "

RUN apk add --no-cache bash git tzdata openntpd && \
    apk add --no-cache zlib-dev icu-dev libzip-dev unzip gnu-libiconv file libmcrypt-dev libmcrypt libpng-dev libpq-dev openldap-dev libxml2-dev && \
    docker-php-ext-install pcntl zip bcmath intl iconv ldap xml soap && \
    apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS && \
    apk del .phpize-deps

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql

# Setup GD extension
RUN apk add --no-cache \
      freetype \
      libjpeg-turbo \
      libpng \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
    && rm -rf /tmp/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]
