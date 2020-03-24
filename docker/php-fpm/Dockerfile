FROM php:7.4-fpm-buster

ARG USER_ID=1000
ARG PHP_INI_PATH=/usr/local/etc/php/php.ini

#XDEBUG
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=\"dbgp\"" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_host=\"localhost\"" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_mode=req" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

#COMMON LIBS
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

RUN DEBIAN_FRONTEND=noninteractive apt-get update -q \
    && DEBIAN_FRONTEND=noninteractive apt-get install -qq -y \
      curl \
      git \
      zip unzip \
    && install-php-extensions \
      bcmath \
      bz2 \
      calendar \
      exif \
      gd \
      intl \
      ldap \
      memcached \
      opcache \
      pdo_pgsql \
      pgsql \
      redis \
      soap \
      xsl \
      zip \
      sockets

#COMPOSER
RUN curl -O 'https://getcomposer.org/download/1.9.3/composer.phar' && \
    mv composer.phar /usr/bin/composer && \
    chmod +x /usr/bin/composer

RUN sed -ri -e 's/^expose_php\s*=.*/expose_php = Off/' ${PHP_INI_PATH}

RUN useradd -u ${USER_ID} -p z5B9_!4]7 -U php_docker_user
USER ${USER_ID}
