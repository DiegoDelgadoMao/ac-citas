FROM php:8.1-apache

# 1. Dependencias necesarias
RUN apt-get update \
  && apt-get install -y libicu-dev unzip default-mysql-client \
  && docker-php-ext-install mysqli pdo_mysql intl \
  && rm -rf /var/lib/apt/lists/*

# 2. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 3. Copia código y deps
COPY . .
RUN mkdir -p writable/{cache,logs,session,uploads} \
    && chown -R www-data:www-data writable \
    && chmod -R 0775 writable

# 4. DocumentRoot → /public
RUN sed -ri \
    -e 's!DocumentRoot /var/www/html!DocumentRoot /var/www/html/public!g' \
    -e 's!<Directory /var/www/>!<Directory /var/www/html/public/>!g' \
    /etc/apache2/sites-available/*.conf \
    && sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf \
    && a2enmod rewrite

# Permisos finales
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
