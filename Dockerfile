FROM php:8.2-fpm
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y git curl libpng-dev libonig-dev libxml2-dev zip unzip
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .
#Set permissions
RUN chown -R www-data:www-data /var/www/html/storage
RUN composer install --optimize-autoloader --no-dev
RUN php artisan passport:install
RUN php artisan key:generate
RUN php artisan migrate
RUN php artisan db:seed
RUN mv .env.example .env
RUN php artisan optimize
# Expose port
EXPOSE 8081
# Start PHP server
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8081"]
