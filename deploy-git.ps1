# PowerShell Deployment Script for Windows
# This pushes to Git and pulls on server

Write-Host "🚀 Deploying via Git..." -ForegroundColor Green

# Add all changes
git add .

# Commit with timestamp
$timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
git commit -m "Deploy: $timestamp"

# Push to origin
git push origin main

Write-Host "✅ Pushed to Git!" -ForegroundColor Green
Write-Host ""
Write-Host "⚠️  Now SSH to server and run:" -ForegroundColor Yellow
Write-Host "ssh root@46.202.194.218" -ForegroundColor Cyan
Write-Host "cd /var/www/netrohub" -ForegroundColor Cyan
Write-Host "git pull origin main" -ForegroundColor Cyan
Write-Host "composer install --no-dev --optimize-autoloader" -ForegroundColor Cyan
Write-Host "php artisan migrate --force" -ForegroundColor Cyan
Write-Host "php artisan translations:import" -ForegroundColor Cyan
Write-Host "npm install && npm run build" -ForegroundColor Cyan
Write-Host "php artisan optimize" -ForegroundColor Cyan
Write-Host "chown -R www-data:www-data storage bootstrap/cache" -ForegroundColor Cyan
Write-Host "chmod -R 775 storage bootstrap/cache" -ForegroundColor Cyan
Write-Host ""
Write-Host "🎉 Deployment complete!" -ForegroundColor Green

