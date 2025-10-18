# 🚀 Deploy to SSH Server - Complete Guide

## Quick Deploy (Recommended)

### From Windows (PowerShell):

```powershell
# Option 1: Using Git on Server (EASIEST!)
ssh user@your-server-ip
cd /var/www/netrohub
git pull origin main
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Option 2: Using Deployment Script

```bash
# SSH into your server
ssh user@your-server-ip

# Navigate to your project
cd /var/www/netrohub

# Pull latest changes
git pull origin main

# Run deployment script
bash deploy.sh
```

---

## 🔧 Detailed Step-by-Step Guide

### Step 1: Connect to Your Server

```powershell
# From Windows PowerShell or Terminal
ssh root@your-server-ip

# Or if using a specific user
ssh username@your-server-ip
```

**Replace**:
- `your-server-ip` with your actual server IP
- `username` with your SSH username (usually `root` or `ubuntu`)

---

### Step 2: Navigate to Your Project

```bash
cd /var/www/netrohub
```

**If your project is elsewhere**, use that path instead.

---

### Step 3: Pull Latest Changes from GitHub

```bash
# Pull the latest code
git pull origin main
```

**Output should show**:
```
Updating 9f3a7fd..2980873
Fast-forward
 43 files changed, 6110 insertions(+), 17 deletions(-)
```

---

### Step 4: Install Dependencies (if needed)

```bash
# Install/Update Composer packages
composer install --no-dev --optimize-autoloader

# Install/Update NPM packages (if changed)
npm install
npm run build
```

---

### Step 5: Run Database Migrations

```bash
# Run new migrations
php artisan migrate --force
```

This will create:
- `dispute_messages` table
- Add `escalated_at` column to disputes
- Any other new migrations

---

### Step 6: Clear and Cache Everything

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Generate fresh caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

### Step 7: Set Permissions (if needed)

```bash
# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

### Step 8: Restart Services

```bash
# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Or if using different PHP version
sudo systemctl restart php8.1-fpm

# Restart web server
sudo systemctl restart nginx
# OR
sudo systemctl restart apache2

# Restart queue worker (if using)
sudo supervisorctl restart netrohub-worker:*
```

---

## 🎯 One-Command Deploy

Use the included deployment script:

```bash
bash deploy.sh
```

This runs all necessary steps automatically!

---

## 🔐 First Time Setup on Server

### If Project Not on Server Yet:

```bash
# 1. Install Git (if not installed)
sudo apt update
sudo apt install git -y

# 2. Navigate to web directory
cd /var/www

# 3. Clone your repository
git clone https://github.com/Netrohub/NetroHub.git netrohub

# 4. Enter project directory
cd netrohub

# 5. Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# 6. Copy environment file
cp .env.example .env

# 7. Edit .env file
nano .env
# Set your database, mail, and other credentials

# 8. Generate app key
php artisan key:generate

# 9. Run migrations
php artisan migrate --force

# 10. Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 11. Link storage
php artisan storage:link
```

---

## 📋 What Gets Updated on Server

### After `git pull`, these are NEW:

**Dispute System**:
- ✅ 2 Controllers
- ✅ 2 Models  
- ✅ 3 Notifications
- ✅ 1 Policy
- ✅ 8 Views
- ✅ 3 Migrations

**OTP System**:
- ✅ 1 Controller
- ✅ 1 Migration
- ✅ API Routes

**Owner System**:
- ✅ 2 Commands

**Updated**:
- ✅ Routes (web.php, api.php)
- ✅ Navigation views
- ✅ Order views

---

## 🔍 Verify Deployment

```bash
# Check if tables were created
php artisan migrate:status

# Test the application
curl http://your-domain.com

# Check logs for errors
tail -f storage/logs/laravel.log
```

---

## 🚨 Troubleshooting

### Problem: Permission Denied

```bash
sudo chown -R www-data:www-data /var/www/netrohub
sudo chmod -R 755 /var/www/netrohub/storage
```

### Problem: 500 Error

```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear all caches
php artisan config:clear
php artisan cache:clear
```

### Problem: Git Pull Fails

```bash
# If you have local changes
git stash

# Pull again
git pull origin main

# Restore changes if needed
git stash pop
```

### Problem: Migration Fails

```bash
# Check database connection
php artisan tinker
DB::connection()->getPdo();

# Force run migrations
php artisan migrate --force
```

---

## 🔄 Quick Deploy Commands (Copy & Paste)

### Full Deploy:
```bash
cd /var/www/netrohub && \
git pull origin main && \
composer install --no-dev --optimize-autoloader && \
php artisan migrate --force && \
php artisan config:cache && \
php artisan route:cache && \
php artisan view:cache && \
sudo systemctl restart php8.2-fpm && \
sudo systemctl restart nginx
```

### Quick Update (No Dependencies):
```bash
cd /var/www/netrohub && \
git pull origin main && \
php artisan migrate --force && \
php artisan cache:clear && \
php artisan config:cache && \
sudo systemctl restart php8.2-fpm
```

---

## 📱 Deploy from Mobile (Using SSH App)

1. **Install** Termux (Android) or Terminus (iOS)
2. **Connect**: `ssh user@your-server-ip`
3. **Navigate**: `cd /var/www/netrohub`
4. **Deploy**: `git pull && bash deploy.sh`

---

## 🎯 Automated Deployment (Optional)

### Setup Webhook (Advanced):

1. Create deploy webhook on server:
```bash
nano /var/www/deploy-webhook.php
```

2. Add this code:
```php
<?php
// Verify secret
$secret = 'your-secret-key';
$payload = file_get_contents('php://input');
$signature = hash_hmac('sha256', $payload, $secret);

if (hash_equals($signature, $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '')) {
    exec('cd /var/www/netrohub && git pull origin main && bash deploy.sh 2>&1', $output);
    echo implode("\n", $output);
}
```

3. Add webhook in GitHub:
   - Go to: Repository → Settings → Webhooks
   - Add: `http://your-domain.com/deploy-webhook.php`
   - Secret: `your-secret-key`

Now code auto-deploys on every push! 🎉

---

## ✅ Deployment Checklist

Before deploying:
- [ ] All changes committed to Git
- [ ] Changes pushed to GitHub
- [ ] .env file configured on server
- [ ] Database credentials correct
- [ ] Backups taken (database + files)

After deploying:
- [ ] Migrations ran successfully
- [ ] No errors in logs
- [ ] Website loads correctly
- [ ] New features work
- [ ] Permissions correct

---

## 🆘 Need Help?

### Check Logs:
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Nginx logs
sudo tail -f /var/log/nginx/error.log

# PHP logs
sudo tail -f /var/log/php8.2-fpm.log
```

### Common Commands:
```bash
# Check PHP version
php -v

# Check Composer
composer --version

# Check disk space
df -h

# Check memory
free -m

# List running processes
ps aux | grep php
```

---

## 🎉 Success!

Your dispute system is now live! 

**Test it**:
1. Go to: `https://yourdomain.com/disputes`
2. Create a test dispute
3. Check moderator panel: `https://yourdomain.com/admin/disputes`

---

**Need more help? Check other guides:**
- `DEPLOYMENT_GUIDE.md` - Full deployment docs
- `DISPUTE_SYSTEM_GUIDE.md` - Dispute system usage
- `README_DISPUTE_SYSTEM.md` - Quick reference


