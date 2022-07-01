#!/bin/bash
set -e

# wait for mysql
sleep 20

if [ "${APP_ENV}" == "dev" ]; then
    composer install --no-interaction --optimize-autoloader
else
    # strange behaviour when doctrine classes are cached. symlink pro~ and prod together
    mkdir -p /app/var/log/cache/prod
    ln -s /app/var/log/prod /app/var/log/pro~
    composer install --no-dev --no-interaction --optimize-autoloader --classmap-authoritative
fi

##
# run doctrine migrations
#
php bin/console doctrine:migrations:migrate --no-interaction

##
# warmup cache
#
php bin/console cache:clear

printenv > /etc/environment
mkdir -p /app/var/log
chmod -R a+rw /app/var
chown www-data:www-data -R /app/var

# exec is needed to make supervisord pid 1 and able to receive SIGTERM signal
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
