#!/bin/bash

# NXO Deployment Script for /var/www/netrohub/NetroHub
# Usage: ./deploy-nxo.sh

SERVER="root@srv1000113"
PROJECT_PATH="/var/www/netrohub/NetroHub"

echo "🚀 Starting NXO deployment to $SERVER:$PROJECT_PATH"

# Step 1: Connect to server and pull latest changes
echo "📥 Pulling latest changes from Git..."
ssh $SERVER "cd $PROJECT_PATH && git stash && git pull origin main"

# Step 2: Install dependencies
echo "📦 Installing dependencies..."
ssh $SERVER "cd $PROJECT_PATH && composer install --no-dev --optimize-autoloader"
ssh $SERVER "cd $PROJECT_PATH && npm install"

# Step 3: Build frontend assets
echo "🔨 Building frontend assets..."
ssh $SERVER "cd $PROJECT_PATH && npm run build"

# Step 4: Laravel optimization
echo "⚡ Optimizing Laravel..."
ssh $SERVER "cd $PROJECT_PATH && php artisan config:clear && php artisan config:cache"
ssh $SERVER "cd $PROJECT_PATH && php artisan route:clear && php artisan route:cache"
ssh $SERVER "cd $PROJECT_PATH && php artisan view:clear && php artisan view:cache"
ssh $SERVER "cd $PROJECT_PATH && php artisan cache:clear"
ssh $SERVER "cd $PROJECT_PATH && php artisan optimize"

# Step 5: Database updates
echo "🗄️ Updating database..."
ssh $SERVER "cd $PROJECT_PATH && php artisan migrate --force"

# Step 6: Set permissions
echo "🔐 Setting file permissions..."
ssh $SERVER "sudo chown -R www-data:www-data $PROJECT_PATH"
ssh $SERVER "sudo chmod -R 755 $PROJECT_PATH"
ssh $SERVER "sudo chmod -R 775 $PROJECT_PATH/storage"
ssh $SERVER "sudo chmod -R 775 $PROJECT_PATH/bootstrap/cache"

echo "✅ NXO deployment completed successfully!"
echo "🌐 Your NXO application is now live!"
echo "🎉 All NetroHub branding has been updated to NXO!"
