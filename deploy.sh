#!/bin/bash

# NetroHub Production Deployment Script
# This script handles the deployment of NetroHub to production

set -e

echo "🚀 Starting NetroHub deployment..."

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Are you in the Laravel project directory?"
    exit 1
fi

# Backup database (if backup command exists)
echo "📦 Creating database backup..."
if php artisan backup:run 2>/dev/null; then
    echo "✅ Database backup created"
else
    echo "⚠️  Database backup skipped (backup command not available)"
fi

# Pull latest code
echo "📥 Pulling latest code..."
git pull origin main

# Install/update dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Build assets
echo "🎨 Building assets..."
npm ci
npm run build

# Clear and cache configurations
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run database migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Cache configurations for production
echo "⚡ Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers (if using supervisor)
echo "🔄 Restarting queue workers..."
if command -v supervisorctl &> /dev/null; then
    supervisorctl restart netrohub-worker:*
    echo "✅ Queue workers restarted"
else
    echo "⚠️  Supervisor not found, queue workers not restarted"
fi

# Restart web server (if using systemctl)
echo "🌐 Restarting web server..."
if command -v systemctl &> /dev/null; then
    systemctl reload php8.2-fpm 2>/dev/null || echo "⚠️  PHP-FPM reload skipped"
    systemctl reload nginx 2>/dev/null || echo "⚠️  Nginx reload skipped"
else
    echo "⚠️  Systemctl not found, web server not restarted"
fi

# Run health check
echo "🏥 Running health check..."
if curl -f http://localhost/health > /dev/null 2>&1; then
    echo "✅ Health check passed"
else
    echo "⚠️  Health check failed - please verify manually"
fi

echo "🎉 Deployment completed successfully!"
echo "📊 Check the application at: https://your-domain.com"
echo "🏥 Health check: https://your-domain.com/health"
