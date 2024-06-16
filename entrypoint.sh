#!/bin/bash

echo "Adding permission for storage"
chmod -R 777 /var/www/storage/

ENV_FILE="/var/www/.env"

echo "Installing project dependencies"
composer install

echo "Migrating tables"
php artisan migrate

echo "Seeding tables"
php artisan db:seed

exec "$@"