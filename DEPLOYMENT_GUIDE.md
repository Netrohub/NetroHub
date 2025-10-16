# NetroHub Deployment Guide for Ubuntu 22.04 LTS

## 📋 Prerequisites

- Ubuntu 22.04 LTS VPS
- Root or sudo access
- Domain name pointed to your server IP

## 🚀 Step-by-Step Deployment

### 1. Upload Files to Server

```bash
# On your LOCAL machine (Windows), upload these files to your server:
scp package.json root@YOUR_SERVER_IP:/var/www/netrohub/
scp vite.config.js root@YOUR_SERVER_IP:/var/www/netrohub/
scp tailwind.config.js root@YOUR_SERVER_IP:/var/www/netrohub/
scp postcss.config.js root@YOUR_SERVER_IP:/var/www/netrohub/
scp .npmrc root@YOUR_SERVER_IP:/var/www/netrohub/

# OR use WinSCP, FileZilla, or any SFTP client
```

### 2. On Your Ubuntu Server

```bash
# SSH into your server
ssh root@YOUR_SERVER_IP

# Navigate to the project directory
cd /var/www/netrohub

# Verify files are in the correct location (not in NetroHub subdirectory)
ls -la package.json composer.json artisan .env

# If files are in NetroHub subdirectory, move them:
if [ -d "NetroHub" ]; then
    mv NetroHub/* . 2>/dev/null || true
    mv NetroHub/.* . 2>/dev/null || true
    rmdir NetroHub 2>/dev/null || true
fi
```

### 3. Install Node.js Dependencies

```bash
cd /var/www/netrohub

# Install dependencies
npm install

# Build assets for production
npm run build

# Verify build completed successfully
ls -la public/build/manifest.json
```

### 4. Configure Laravel

```bash
# Copy environment file if not exists
cp .env.example .env

# Edit .env file
nano .env
```

**Important .env settings:**

```env
APP_NAME=NetroHub
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=netrohub
DB_USERNAME=netrohub_user
DB_PASSWORD=YourNewSecurePassword123!

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

FILESYSTEM_DISK=local

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@netrohub.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Set Up Database

```bash
# Login to MySQL
sudo mysql -u root -p

# Create database and user
CREATE DATABASE netrohub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'netrohub_user'@'localhost' IDENTIFIED WITH mysql_native_password BY 'YourNewSecurePassword123!';
GRANT ALL PRIVILEGES ON netrohub.* TO 'netrohub_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Test connection
mysql -u netrohub_user -p netrohub
```

### 6. Install PHP Dependencies & Run Migrations

```bash
cd /var/www/netrohub

# Create storage directories
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Install Composer dependencies (NOT as root!)
# Create a deploy user first if you haven't
adduser deploy
usermod -aG www-data deploy
chown -R deploy:www-data /var/www/netrohub
su - deploy
cd /var/www/netrohub

# Now install
composer install --no-dev --optimize-autoloader

# Generate app key
php artisan key:generate --force

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize
php artisan optimize
```

### 7. Configure Nginx

```bash
# Exit from deploy user back to root
exit

# Create Nginx configuration
sudo nano /etc/nginx/sites-available/netrohub
```

**Nginx Configuration:**

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/netrohub/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Handle static files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires max;
        access_log off;
        add_header Cache-Control "public, immutable";
    }

    client_max_body_size 50M;
}
```

**Enable site:**

```bash
# Enable the site
sudo ln -s /etc/nginx/sites-available/netrohub /etc/nginx/sites-enabled/

# Remove default site if exists
sudo rm /etc/nginx/sites-enabled/default

# Test Nginx configuration
sudo nginx -t

# Restart Nginx
sudo systemctl restart nginx
```

### 8. Install SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Get SSL certificate
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# Test auto-renewal
sudo certbot renew --dry-run
```

### 9. Set Up Queue Worker (Optional but Recommended)

```bash
# Install Supervisor
sudo apt install -y supervisor

# Create supervisor config
sudo nano /etc/supervisor/conf.d/netrohub-worker.conf
```

**Supervisor Configuration:**

```ini
[program:netrohub-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/netrohub/artisan queue:work --sleep=3 --tries=3 --timeout=120
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=deploy
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/supervisor/netrohub-worker.log
stopwaitsecs=3600
```

**Start Supervisor:**

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start netrohub-worker:*
sudo supervisorctl status
```

### 10. Set Up Cron Jobs

```bash
# Edit crontab for deploy user
sudo -u deploy crontab -e

# Add this line:
* * * * * cd /var/www/netrohub && php artisan schedule:run >> /dev/null 2>&1
```

### 11. Final Security Hardening

```bash
# Set proper permissions
sudo chown -R deploy:www-data /var/www/netrohub
sudo chmod -R 755 /var/www/netrohub
sudo chmod -R 775 /var/www/netrohub/storage
sudo chmod -R 775 /var/www/netrohub/bootstrap/cache

# Secure .env file
sudo chmod 600 /var/www/netrohub/.env

# Configure firewall
sudo ufw allow OpenSSH
sudo ufw allow 'Nginx Full'
sudo ufw --force enable
sudo ufw status
```

## 🔄 Future Deployments

Create a deployment script:

```bash
nano /var/www/netrohub/deploy.sh
```

```bash
#!/bin/bash
set -e

echo "🚀 Deploying NetroHub..."

cd /var/www/netrohub

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Run migrations
php artisan migrate --force

# Clear and cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Restart services
sudo systemctl reload php8.3-fpm
sudo systemctl reload nginx
sudo supervisorctl restart netrohub-worker:*

echo "✅ Deployment complete!"
```

```bash
chmod +x /var/www/netrohub/deploy.sh
```

Deploy with:
```bash
./deploy.sh
```

## 🐛 Troubleshooting

### Check logs:
```bash
# Laravel logs
tail -f /var/www/netrohub/storage/logs/laravel.log

# Nginx error logs
sudo tail -f /var/log/nginx/error.log

# PHP-FPM logs
sudo tail -f /var/log/php8.3-fpm.log

# Supervisor logs
sudo tail -f /var/log/supervisor/netrohub-worker.log
```

### Common Issues:

**500 Error:**
- Check storage permissions: `sudo chmod -R 775 storage bootstrap/cache`
- Check .env file exists and has correct values
- Run `php artisan config:clear`

**404 on all routes:**
- Check Nginx root points to `/var/www/netrohub/public`
- Verify `try_files` directive in Nginx config

**Assets not loading:**
- Run `npm run build` again
- Check `public/build/manifest.json` exists
- Verify APP_URL in .env matches your domain

**Database connection failed:**
- Test MySQL connection: `mysql -u netrohub_user -p netrohub`
- Check DB credentials in .env
- Ensure MySQL service is running: `sudo systemctl status mysql`

## 📞 Support

If you encounter any issues, check:
1. Laravel logs: `storage/logs/laravel.log`
2. Nginx logs: `/var/log/nginx/error.log`
3. PHP-FPM status: `sudo systemctl status php8.3-fpm`
4. Nginx status: `sudo systemctl status nginx`

---

**🎉 Your NetroHub application should now be live at https://your-domain.com**

