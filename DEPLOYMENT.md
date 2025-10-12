# Deployment Guide

## Production Deployment Checklist

### 1. Environment Configuration
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Add Google Analytics Measurement ID
- [ ] Configure payment provider keys
- [ ] Set up SSL certificate

### 2. Database Setup
```bash
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder
```

### 3. Asset Building
```bash
npm run build
```

### 4. Cache Optimization
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. File Permissions
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 6. Web Server Configuration
Point your web server document root to the `public` directory.

### 7. Queue Workers (Optional)
If using queues, set up supervisor or similar:
```bash
php artisan queue:work --daemon
```

## Environment Variables for Production

```env
APP_NAME=NetroHub
APP_ENV=production
APP_KEY=base64:your_generated_key
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=your_db_host
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Google Analytics
GOOGLE_ANALYTICS_MEASUREMENT_ID=G-XXXXXXXXXX

# Payments
STRIPE_KEY=pk_live_...
STRIPE_SECRET=sk_live_...
```

## Security Checklist

- [ ] SSL certificate installed
- [ ] Environment file secured (not accessible via web)
- [ ] Database credentials secured
- [ ] API keys secured
- [ ] File permissions set correctly
- [ ] Regular backups configured
