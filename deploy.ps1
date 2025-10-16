# NetroHub Production Deployment Script for Windows
Write-Host "🚀 Starting NetroHub Production Deployment..." -ForegroundColor Green

# Set production environment
$env:APP_ENV = "production"
$env:APP_DEBUG = "false"

# Install Composer dependencies (production only)
Write-Host "📦 Installing Composer dependencies..." -ForegroundColor Yellow
composer install --no-dev --optimize-autoloader --no-interaction

# Clear and optimize Laravel caches
Write-Host "⚡ Optimizing Laravel application..." -ForegroundColor Yellow
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Generate optimized caches for production
Write-Host "🔧 Generating production caches..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Run database migrations
Write-Host "🗄️ Running database migrations..." -ForegroundColor Yellow
php artisan migrate --force

# Clear application cache
Write-Host "🧹 Clearing application cache..." -ForegroundColor Yellow
php artisan cache:clear

Write-Host "✅ Deployment completed successfully!" -ForegroundColor Green
Write-Host "🌐 Your NetroHub application is ready for production!" -ForegroundColor Cyan
