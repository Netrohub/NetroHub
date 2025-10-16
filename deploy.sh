#!/bin/bash

# NetroHub Production Deployment Script
echo "🚀 Starting NetroHub Production Deployment..."

# Set production environment
export APP_ENV=production
export APP_DEBUG=false

# Install Composer dependencies (production only)
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Clear and optimize Laravel caches
echo "⚡ Optimizing Laravel application..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Generate optimized caches for production
echo "🔧 Generating production caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Set proper permissions
echo "🔐 Setting file permissions..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Clear application cache
echo "🧹 Clearing application cache..."
php artisan cache:clear

echo "✅ Deployment completed successfully!"
echo "🌐 Your NetroHub application is ready for production!"
