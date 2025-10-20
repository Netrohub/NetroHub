#!/bin/bash

# NXO Marketplace Deployment Fix Script
echo "🔧 Fixing deployment issues..."

# 1. Build assets
echo "📦 Building assets..."
npm install
npm run build

# 2. Clear Laravel caches
echo "🧹 Clearing Laravel caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 3. Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Set proper permissions
echo "🔐 Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 755 public/build

# 5. Check if Vite manifest exists
if [ -f "public/build/manifest.json" ]; then
    echo "✅ Vite manifest found"
else
    echo "❌ Vite manifest missing - running build again..."
    npm run build
fi

echo "🎉 Deployment fix complete!"
