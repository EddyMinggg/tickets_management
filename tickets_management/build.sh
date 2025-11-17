#!/bin/bash
set -e

echo "Installing PHP dependencies..."
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

echo "Running composer install..."
/usr/local/bin/composer install --no-dev --optimize-autoloader

echo "Running npm install..."
npm install

echo "Creating SQLite database..."
mkdir -p /var/data
touch /var/data/database.sqlite

echo "Generating app key..."
php artisan key:generate --force

echo "Running migrations with SQLite..."
php artisan migrate --force

echo "Build completed successfully!"

