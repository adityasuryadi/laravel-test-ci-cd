# 2022 update
FROM php:8.1-fpm

# setup user as root
USER root

WORKDIR /var/www

# setup node js source will be used later to install node js
RUN curl -sL https://deb.nodesource.com/setup_16.x -o nodesource_setup.sh
RUN ["sh",  "./nodesource_setup.sh"]

# Install environment dependencies
RUN apt-get update \
	# gd
	&& apt-get install -y libpq-dev build-essential  openssl nginx libfreetype6-dev libjpeg-dev libpng-dev libwebp-dev zlib1g-dev libzip-dev gcc g++ make vim unzip curl git jpegoptim optipng pngquant gifsicle locales libonig-dev npm  \
	&& docker-php-ext-configure gd  \
	&& docker-php-ext-install gd \
	# gmp
	&& apt-get install -y --no-install-recommends libgmp-dev \
	&& docker-php-ext-install gmp \
	# pdo
	&& docker-php-ext-install pdo \
    # pdo_pgsql
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql  \
	&& docker-php-ext-install pgsql pdo_pgsql mbstring \
	# opcache
	&& docker-php-ext-enable opcache \
	# exif
    && docker-php-ext-install exif \
    && docker-php-ext-install sockets \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath \
	# zip
	&& docker-php-ext-install zip \
	&& apt-get autoclean -y \
	&& rm -rf /var/lib/apt/lists/* \
	&& rm -rf /tmp/pear/

# Copy files
COPY . /var/www

COPY ./nginx.conf /etc/nginx/nginx.conf

# RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && \
#     sed -i 's/upload_max_filesize = 20M/upload_max_filesize = 128M/g' /usr/local/etc/php/php.ini

COPY ./upload.ini /usr/local/etc/php/conf.d/uploads.ini

RUN chmod +rwx /var/www

RUN chmod -R 777 /var/www

# setup FE
RUN npm install

RUN npm run build

# setup composer and laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --working-dir="/var/www"

RUN composer dump-autoload --working-dir="/var/www"

RUN php artisan optimize

RUN php artisan route:clear

RUN php artisan route:cache

RUN php artisan config:clear

RUN php artisan config:cache

RUN php artisan view:clear

RUN php artisan view:cache

EXPOSE 80

RUN ["chmod", "+x", "post_deploy.sh"]

CMD [ "sh", "./post_deploy.sh" ]

# CMD php artisan serve --host=127.0.0.1 --port=9000
