# NXO Deployment Script for Windows PowerShell
# Usage: .\deploy.ps1 -Server "username@server-ip" -WebPath "/path/to/web/directory"

param(
    [Parameter(Mandatory=$true)]
    [string]$Server,
    
    [Parameter(Mandatory=$true)]
    [string]$WebPath
)

$ProjectName = "nxo"

Write-Host "🚀 Starting NXO deployment to $Server`:$WebPath" -ForegroundColor Green

# Step 1: Prepare server directory
Write-Host "📁 Preparing server directory..." -ForegroundColor Yellow
ssh $Server "mkdir -p $WebPath/$ProjectName"

# Step 2: Upload project files using rsync (if available) or scp
Write-Host "📤 Uploading project files..." -ForegroundColor Yellow
try {
    # Try rsync first (faster and more efficient)
    rsync -avz --progress --exclude 'node_modules' --exclude 'vendor' --exclude '.git' --exclude 'storage/logs/*' --exclude '.env' --exclude 'bootstrap/cache/*' . "$Server`:$WebPath/$ProjectName/"
} catch {
    # Fallback to scp if rsync is not available
    Write-Host "Using SCP as fallback..." -ForegroundColor Yellow
    scp -r . "$Server`:$WebPath/$ProjectName/"
}

# Step 3: Install dependencies and build
Write-Host "📦 Installing dependencies..." -ForegroundColor Yellow
ssh $Server "cd $WebPath/$ProjectName && composer install --no-dev --optimize-autoloader"
ssh $Server "cd $WebPath/$ProjectName && npm install"
ssh $Server "cd $WebPath/$ProjectName && npm run build"

# Step 4: Set up environment file
Write-Host "⚙️ Setting up environment..." -ForegroundColor Yellow
ssh $Server "cd $WebPath/$ProjectName && cp .env.example .env"

# Step 5: Generate app key
Write-Host "🔑 Generating application key..." -ForegroundColor Yellow
ssh $Server "cd $WebPath/$ProjectName && php artisan key:generate"

# Step 6: Run migrations
Write-Host "🗄️ Running database migrations..." -ForegroundColor Yellow
ssh $Server "cd $WebPath/$ProjectName && php artisan migrate --force"

# Step 7: Optimize for production
Write-Host "⚡ Optimizing for production..." -ForegroundColor Yellow
ssh $Server "cd $WebPath/$ProjectName && php artisan config:cache"
ssh $Server "cd $WebPath/$ProjectName && php artisan route:cache"
ssh $Server "cd $WebPath/$ProjectName && php artisan view:cache"

# Step 8: Set proper permissions
Write-Host "🔐 Setting file permissions..." -ForegroundColor Yellow
ssh $Server "sudo chown -R www-data:www-data $WebPath/$ProjectName"
ssh $Server "sudo chmod -R 755 $WebPath/$ProjectName"
ssh $Server "sudo chmod -R 775 $WebPath/$ProjectName/storage"
ssh $Server "sudo chmod -R 775 $WebPath/$ProjectName/bootstrap/cache"

Write-Host "✅ NXO deployment completed successfully!" -ForegroundColor Green
Write-Host "🌐 Your application should now be available at: http://your-domain.com" -ForegroundColor Cyan
Write-Host "📝 Don't forget to:" -ForegroundColor Yellow
Write-Host "   1. Update your .env file with production settings" -ForegroundColor White
Write-Host "   2. Configure your web server (Apache/Nginx)" -ForegroundColor White
Write-Host "   3. Set up SSL certificate" -ForegroundColor White
Write-Host "   4. Configure your domain DNS" -ForegroundColor White
