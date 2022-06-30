#!/bin/bash
set -e

# wait for mysql
sleep 20

if [ "${APP_ENV}" == "dev" ]; then
    composer install --no-interaction --optimize-autoloader
else
    composer install --no-dev --no-interaction --optimize-autoloader --classmap-authoritative
fi

##
# warmup cache
#
rm -rf /app/var/cache
php bin/console cache:clear
ls -lF /app/var/cache/

##
# run doctrine migrations
#
php bin/console doctrine:migrations:migrate --no-interaction

ls -lF /app/var/cache/
rm -rf /app/var/cache
php bin/console cache:clear
ls -lF /app/var/cache/

printenv > /etc/environment
mkdir -p /app/var/log
chmod -R a+rw /app/var
chown www-data:www-data -R /app/var

# exec is needed to make supervisord pid 1 and able to receive SIGTERM signal
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
