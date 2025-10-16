# 🚀 NetroHub - Server Deployment Files Ready!

## ✅ Created Files

I've created all the necessary configuration files for your project:

1. **package.json** - Node.js dependencies and build scripts
2. **vite.config.js** - Vite bundler configuration
3. **tailwind.config.js** - Tailwind CSS configuration
4. **postcss.config.js** - PostCSS configuration
5. **.npmrc** - NPM configuration
6. **DEPLOYMENT_GUIDE.md** - Complete deployment instructions
7. **QUICK_SERVER_SETUP.md** - Quick reference commands
8. **upload-to-server.ps1** - Windows PowerShell upload script

## 🎯 Two Ways to Upload Files to Your Server

### Option 1: Using PowerShell Script (Recommended)

```powershell
# Open PowerShell in your project directory
# Run this command (replace with your server IP):
.\upload-to-server.ps1 -ServerIP "YOUR_SERVER_IP"

# Or if you're using a different user:
.\upload-to-server.ps1 -ServerIP "YOUR_SERVER_IP" -ServerUser "deploy"
```

### Option 2: Manual Upload (Using WinSCP or FileZilla)

1. Download **WinSCP** or **FileZilla**
2. Connect to your server (IP: YOUR_SERVER_IP)
3. Upload these files to `/var/www/netrohub/`:
   - package.json
   - vite.config.js
   - tailwind.config.js
   - postcss.config.js
   - .npmrc

## 📝 After Uploading Files

SSH into your server and run:

```bash
ssh root@YOUR_SERVER_IP
cd /var/www/netrohub

# Fix directory structure if needed
if [ -d "NetroHub" ]; then
    mv NetroHub/* . 2>/dev/null
    mv NetroHub/.* . 2>/dev/null
    rmdir NetroHub
fi

# Install Node dependencies
npm install

# Build assets
npm run build

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Set up Laravel
php artisan key:generate --force
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📖 Full Documentation

- **Complete step-by-step guide:** See `DEPLOYMENT_GUIDE.md`
- **Quick command reference:** See `QUICK_SERVER_SETUP.md`

## ⚠️ Important Notes

1. **Make sure you're in the correct directory!**
   - Your files should be in `/var/www/netrohub/`
   - NOT in `/var/www/netrohub/NetroHub/`

2. **Database credentials:**
   - Username: `netrohub_user`
   - Password: Choose a strong password
   - Database: `netrohub`

3. **Don't run composer as root:**
   - Create a `deploy` user
   - Or use your regular user account
   - Only use root for system-level tasks

## 🆘 Getting Errors?

### "package.json not found"
```bash
# Check you're in the right directory
pwd  # Should show: /var/www/netrohub
ls package.json  # Should show the file
```

### "Please provide a valid cache path"
```bash
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage bootstrap/cache
php artisan config:clear
```

### "Database connection failed"
```bash
# Create database user with correct authentication
sudo mysql -u root -p
CREATE USER 'netrohub_user'@'localhost' IDENTIFIED WITH mysql_native_password BY 'YOUR_PASSWORD';
GRANT ALL PRIVILEGES ON netrohub.* TO 'netrohub_user'@'localhost';
FLUSH PRIVILEGES;
```

## 🎉 Once Everything is Set Up

Your site will be accessible at:
- HTTP: `http://your-domain.com`
- HTTPS: `https://your-domain.com` (after SSL setup)

Admin panel:
- URL: `https://your-domain.com/admin`

---

**Need help?** Check the detailed guides:
- DEPLOYMENT_GUIDE.md - Full deployment walkthrough
- QUICK_SERVER_SETUP.md - Quick command reference

