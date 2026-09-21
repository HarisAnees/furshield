#!/bin/bash
set -e

# Create writable storage directories if they do not exist
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache
mkdir -p /var/www/html/database

# Handle SQLite initialization
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_CONNECTION" ]; then
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        touch /var/www/html/database/database.sqlite
    fi
    chown -R www-data:www-data /var/www/html/database
fi

# Set proper permissions for web server
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate app key if missing
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run database migrations and seeds
echo "Running database migrations..."
php artisan migrate --force

echo "Seeding database with competition demo records..."
php artisan db:seed --force

# Optimize Laravel cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "FurShield backend successfully initialized and listening on port ${PORT:-80}!"

# Pass control to CMD (apache2-foreground)
exec "$@"
