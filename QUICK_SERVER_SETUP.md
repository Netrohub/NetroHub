# NetroHub - Quick Server Setup Commands

## 📦 What to Upload to Server

Upload these files from your local machine to `/var/www/netrohub/`:
- `package.json`
- `vite.config.js`
- `tailwind.config.js`
- `postcss.config.js`
- `.npmrc`

## ⚡ Quick Commands (Copy & Paste)

### Fix Directory Structure
```bash
cd /var/www/netrohub
if [ -d "NetroHub" ]; then mv NetroHub/* . 2>/dev/null; mv NetroHub/.* . 2>/dev/null; rmdir NetroHub; fi
```

### Create Storage Directories
```bash
mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### Install & Build
```bash
cd /var/www/netrohub
npm install
npm run build
composer install --no-dev --optimize-autoloader
```

### Laravel Setup
```bash
cp .env.example .env
nano .env  # Edit database credentials
php artisan key:generate --force
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Set Permissions
```bash
chown -R deploy:www-data /var/www/netrohub
chmod -R 755 /var/www/netrohub
chmod -R 775 storage bootstrap/cache
chmod 600 .env
```

### Database Setup
```bash
sudo mysql -u root -p
```
```sql
CREATE DATABASE netrohub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'netrohub_user'@'localhost' IDENTIFIED WITH mysql_native_password BY 'YOUR_PASSWORD_HERE';
GRANT ALL PRIVILEGES ON netrohub.* TO 'netrohub_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Test Everything
```bash
# Test database connection
mysql -u netrohub_user -p netrohub

# Check Laravel
php artisan about

# Check build files
ls -la public/build/manifest.json

# Restart services
sudo systemctl restart php8.3-fpm
sudo systemctl restart nginx
```

## 🔑 Required .env Values

```env
DB_DATABASE=netrohub
DB_USERNAME=netrohub_user
DB_PASSWORD=YOUR_PASSWORD_HERE

APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

## ✅ Verification Checklist

- [ ] Files uploaded to `/var/www/netrohub/` (not `/var/www/netrohub/NetroHub/`)
- [ ] `package.json` exists
- [ ] `composer.json` exists
- [ ] `.env` file created and configured
- [ ] Database created and user has permissions
- [ ] `npm run build` completed successfully
- [ ] `public/build/manifest.json` exists
- [ ] Storage directories have correct permissions (775)
- [ ] Nginx pointing to `public` directory
- [ ] SSL certificate installed

## 🐛 Quick Fixes

**"Please provide a valid cache path"**
```bash
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage bootstrap/cache
php artisan config:clear
```

**"package.json not found"**
```bash
pwd  # Make sure you're in /var/www/netrohub (not NetroHub subdirectory)
ls -la package.json  # Verify file exists
```

**"Database connection failed"**
```bash
# Test connection manually
mysql -u netrohub_user -p netrohub

# If fails, recreate user with mysql_native_password
sudo mysql -u root -p
DROP USER IF EXISTS 'netrohub_user'@'localhost';
CREATE USER 'netrohub_user'@'localhost' IDENTIFIED WITH mysql_native_password BY 'YOUR_PASSWORD';
GRANT ALL PRIVILEGES ON netrohub.* TO 'netrohub_user'@'localhost';
FLUSH PRIVILEGES;
```

**"Permission denied"**
```bash
sudo chown -R deploy:www-data /var/www/netrohub
sudo chmod -R 775 storage bootstrap/cache
```

