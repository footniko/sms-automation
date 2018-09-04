FROM footniko/ubuntu-base-php
MAINTAINER <footniko@gmail.com>

# Prepare Apache environment configs
COPY build/etc/apache2 /etc/apache2

# Deploy and build application
COPY . /var/www/html
WORKDIR /var/www/html
RUN composer install --prefer-dist --optimize-autoloader --no-progress --no-interaction
