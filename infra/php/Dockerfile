FROM php:8.2-fpm-buster

ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # composer environment
  COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
  apt-get -y install --no-install-recommends locales git unzip libzip-dev libicu-dev libonig-dev libfreetype6-dev libjpeg62-turbo-dev libwebp-dev libpng-dev && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  locale-gen en_US.UTF-8 && \
  localedef -f UTF-8 -i en_US en_US.UTF-8 && \
  docker-php-ext-install intl pdo_mysql zip bcmath && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-install -j$(nproc) gd && \
  # Node.jsをインストール
  curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
  apt-get install -y nodejs

COPY ./php.ini /usr/local/etc/php/php.ini

WORKDIR /data
