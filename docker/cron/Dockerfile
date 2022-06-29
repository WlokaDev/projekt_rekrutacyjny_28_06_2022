FROM php:8.1-fpm
WORKDIR /usr/share/nginx/web
RUN apt-get update && apt-get install -y cron libpq-dev libpng-dev libzip-dev zip \
&& docker-php-ext-enable opcache

# Add docker custom crontab
ADD schedule /etc/cron.d/laravel_schedule

# Specify crontab file for running
RUN crontab /etc/cron.d/laravel_schedule

# execute crontab
CMD ["cron", "-f"]
