# 🚀 Complete Deployment Instructions

## 📤 **PART 1: Upload to Git (From Local Windows Machine)**

### **Step 1: Open PowerShell in Project Folder**

```powershell
cd C:\Users\p5l\Desktop\netrohub
```

### **Step 2: Check Changes**

```powershell
git status
```

### **Step 3: Add All Changes**

```powershell
git add .
```

### **Step 4: Commit**

```powershell
git commit -m "Added OTP verification system with MessageBird + UI improvements"
```

### **Step 5: Push to Git**

```powershell
git push origin main
```

---

## 📥 **PART 2: Deploy to Server (SSH)**

### **Step 1: Connect to Server**

```bash
ssh root@srv1000113
```

### **Step 2: Navigate to Project**

```bash
cd /var/www/netrohub/NetroHub
```

### **Step 3: Pull Latest Code**

```bash
git config --global --add safe.directory /var/www/netrohub/NetroHub
git pull origin main
```

### **Step 4: Install Dependencies**

```bash
composer install --no-dev --optimize-autoloader
```

### **Step 5: Run Migrations**

```bash
php artisan migrate --force
```

### **Step 6: Add Twilio WhatsApp Credentials to .env**

```bash
nano .env
```

Add these lines:

```env
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=your_auth_token_here
TWILIO_WHATSAPP_FROM=+14155238886
```

Press `CTRL+O` to save, then `CTRL+X` to exit.

**Get credentials from:** https://console.twilio.com

**For Sandbox Number:** Use `+14155238886` (Twilio's WhatsApp Sandbox)

**⚠️ Important:** Users must join the sandbox first by sending "join <code>" to the sandbox number on WhatsApp.

**See `TWILIO_OTP_SETUP.md` for complete WhatsApp setup instructions!**

### **Step 7: Clear & Rebuild Caches**

```bash
php artisan optimize:clear
php artisan optimize
```

### **Step 8: Fix Permissions**

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### **Step 9: Restart Services**

```bash
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

---

## ✅ **Verify Deployment**

### **Check if Site is Working:**

```bash
curl https://netrohub.com
```

### **Test OTP API:**

```bash
curl -X POST https://netrohub.com/api/otp/send \
  -H "Content-Type: application/json" \
  -d '{"phone":"+966501234567"}'
```

### **Visit Demo Page:**

Open browser: `https://netrohub.com/otp-demo`

---

## 🔧 **Troubleshooting**

### **If You Get 500 Error:**

```bash
# Check logs
tail -50 storage/logs/laravel.log

# Fix permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Clear everything
php artisan optimize:clear
rm -rf bootstrap/cache/*.php
php artisan optimize

# Restart
sudo systemctl restart php8.2-fpm nginx
```

### **If Mobile Account Menu Not Showing:**

```bash
# Verify file updated
cat resources/views/components/stellar/account-sidebar.blade.php | grep "قائمة الحساب"

# Clear views
php artisan view:clear

# Restart
sudo systemctl restart php8.2-fpm
```

### **Check Logs:**

```bash
# Laravel log
tail -50 storage/logs/laravel.log

# Nginx error log
tail -50 /var/log/nginx/error.log

# PHP-FPM log
tail -50 /var/log/php8.2-fpm.log
```

---

## 🎯 **Complete One-Command Deployment**

Run this on your server after pushing to Git:

```bash
cd /var/www/netrohub/NetroHub && \
git pull origin main && \
composer install --no-dev --optimize-autoloader && \
php artisan migrate --force && \
php artisan optimize:clear && \
php artisan optimize && \
chmod -R 775 storage bootstrap/cache && \
chown -R www-data:www-data storage bootstrap/cache && \
sudo systemctl restart php8.2-fpm nginx && \
echo "✅ Deployment Complete!"
```

---

## 📋 **What Was Added:**

1. ✅ **OTP Verification System** with MessageBird SMS API
2. ✅ **Mobile Account Menu** restored with enhanced design
3. ✅ **Enhanced Login/Register Buttons** with better UX
4. ✅ **Phone Country Selector** improvements
5. ✅ **Duplicate Prevention** for usernames, emails, phones
6. ✅ **Refund Policy Page** design matching other legal pages
7. ✅ **Logo Spacing** improvements
8. ✅ **Project Cleanup** for production deployment

---

## 🎉 **You're Ready to Deploy!**

Follow the steps above in order and your application will be live with all the new features!

