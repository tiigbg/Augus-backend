# Apache container with PHP and MySQL support, running a Laravel app
# We start with a fresh Ubuntu 16.04 Docker image
FROM ubuntu:16.04
MAINTAINER Niels Swinkels <niels@tii.se>

RUN apt-get update && \
    apt-get -y install apache2 php libapache2-mod-php php-mcrypt php-json curl git nodejs npm php-mysql unzip php-mbstring php-dom vim && \
    apt-get clean && \
    update-rc.d apache2 defaults && \
    phpenmod mcrypt && \
    rm -rf /var/www/html && \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Fix node command with a symlink
RUN ln -s /usr/bin/nodejs /usr/bin/node

# Apache config
RUN /usr/sbin/a2enmod rewrite
ADD dockerdeployment/000-default.conf /etc/apache2/sites-available/

# Run NPM in separate dir. This makes it possible for Docker to cache the modules, greatly speeding up deployment
ADD package.json /tmp/package.json
RUN cd /tmp && npm install && npm install gulp -g
# Copy over to final serving location
RUN mkdir -p /var/www/laravel && cp -a /tmp/node_modules /var/www/laravel

# Copy the local repo files to the served laravel dir (and make Docker aware of them for caching)
ADD . /var/www/laravel

# Switch over to serving location, all subsequent commands are done relative to this
WORKDIR /var/www/laravel

# Copy over Laravel environment config to project root
ADD dockerdeployment/env-docker ./.env

# Update php config
RUN echo "extension=php_mbstring.dll" >> /etc/php/7.0/apache2/php.ini

# Install composer deps
RUN /usr/local/bin/composer install

# Ensure the right permissions
RUN /bin/chown www-data:www-data -R /var/www/laravel/storage /var/www/laravel/bootstrap/cache 

# Run gulp with production flag (no watch etc)
RUN gulp --production

# Expose ports. TODO: Add SSL support and expose port 443
EXPOSE 80

VOLUME ["/var/www/laravel/storage/app/uploads"]

# Update DB structure from models and start webserver
# CMD are only executed when the container is started, while RUN is done when the container is initally built
CMD php artisan migrate && /usr/sbin/apache2ctl -D FOREGROUND
