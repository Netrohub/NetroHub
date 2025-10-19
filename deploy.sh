#!/bin/bash

# NXO Deployment Script
# Usage: ./deploy.sh username@server-ip /path/to/web/directory

if [ $# -ne 2 ]; then
    echo "Usage: $0 username@server-ip /path/to/web/directory"
    echo "Example: $0 root@192.168.1.100 /var/www/html"
    exit 1
fi

SERVER=$1
WEB_PATH=$2
PROJECT_NAME="NetroHub"

echo "🚀 Starting NXO deployment to $SERVER:$WEB_PATH"

# Step 1: Connect to server and prepare directory
echo "📁 Preparing server directory..."
ssh $SERVER "mkdir -p $WEB_PATH/$PROJECT_NAME"

# Step 2: Upload project files (excluding unnecessary files)
echo "📤 Uploading project files..."
rsync -avz --progress \
    --exclude 'node_modules' \
    --exclude 'vendor' \
    --exclude '.git' \
    --exclude 'storage/logs/*' \
    --exclude '.env' \
    --exclude 'bootstrap/cache/*' \
    . $SERVER:$WEB_PATH/$PROJECT_NAME/

# Step 3: Install dependencies and build
echo "📦 Installing dependencies..."
ssh $SERVER "cd $WEB_PATH/$PROJECT_NAME && composer install --no-dev --optimize-autoloader"
ssh $SERVER "cd $WEB_PATH/$PROJECT_NAME && npm install"
ssh $SERVER "cd $WEB_PATH/$PROJECT_NAME && npm run build"

# Step 4: Set up environment file
echo "⚙️ Setting up environment..."
ssh $SERVER "cd $WEB_PATH/$PROJECT_NAME && cp .env.example .env"

# Step 5: Generate app key
echo "🔑 Generating application key..."
ssh $SERVER "cd $WEB_PATH/$PROJECT_NAME && php artisan key:generate"

# Step 6: Run migrations
echo "🗄️ Running database migrations..."
ssh $SERVER "cd $WEB_PATH/$PROJECT_NAME && php artisan migrate --force"

# Step 7: Optimize for production
echo "⚡ Optimizing for production..."
ssh $SERVER "cd $WEB_PATH/$PROJECT_NAME && php artisan config:cache"
ssh $SERVER "cd $WEB_PATH/$PROJECT_NAME && php artisan route:cache"
ssh $SERVER "cd $WEB_PATH/$PROJECT_NAME && php artisan view:cache"

# Step 8: Set proper permissions
echo "🔐 Setting file permissions..."
ssh $SERVER "sudo chown -R www-data:www-data $WEB_PATH/$PROJECT_NAME"
ssh $SERVER "sudo chmod -R 755 $WEB_PATH/$PROJECT_NAME"
ssh $SERVER "sudo chmod -R 775 $WEB_PATH/$PROJECT_NAME/storage"
ssh $SERVER "sudo chmod -R 775 $WEB_PATH/$PROJECT_NAME/bootstrap/cache"

echo "✅ NXO deployment completed successfully!"
echo "🌐 Your application should now be available at: http://your-domain.com"
echo "📝 Don't forget to:"
echo "   1. Update your .env file with production settings"
echo "   2. Configure your web server (Apache/Nginx)"
echo "   3. Set up SSL certificate"
echo "   4. Configure your domain DNS"
