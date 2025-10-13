#!/bin/bash

# NetroHub Production Deployment Script
# Server: 46.202.194.218

echo "🚀 Starting deployment to production..."

# Sync files (excluding unnecessary folders)
rsync -avz \
    --exclude=".env" \
    --exclude=".git" \
    --exclude="node_modules" \
    --exclude="vendor" \
    --exclude="storage/logs/*" \
    --exclude="storage/framework/cache/*" \
    --exclude="storage/framework/sessions/*" \
    --exclude="storage/framework/views/*" \
    --exclude="bootstrap/cache/*" \
    --exclude=".env.example" \
    --exclude="deploy-to-server.sh" \
    --progress \
    ./ root@46.202.194.218:/var/www/netrohub

echo "✅ Files synced!"
echo ""
echo "⚠️  IMPORTANT: Now run these commands on the server:"
echo ""
echo "ssh root@46.202.194.218"
echo "cd /var/www/netrohub"
echo "composer install --optimize-autoloader --no-dev"
echo "php artisan migrate --force"
echo "php artisan config:cache"
echo "php artisan route:cache"
echo "php artisan view:cache"
echo "php artisan storage:link"
echo "npm install && npm run build"
echo "chown -R www-data:www-data storage bootstrap/cache"
echo "chmod -R 775 storage bootstrap/cache"
echo "php artisan queue:restart"
echo "php artisan optimize"
echo ""
echo "🎉 Deployment complete!"

