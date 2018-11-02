#!/bin/sh
cd /var/www/mtc-reservation && \
git pull origin master && \
sleep 5 && \
gulp --production && \
sleep 5 && \
php /home/allen/shell/clear_opcache.php && \
php artisan migrate --force && \
php artisan cache:clear && \
php artisan view:clear && \
php artisan config:cache && \
php artisan route:cache
