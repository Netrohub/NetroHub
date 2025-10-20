# 🚀 NetroHub - Digital Marketplace Platform

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen.svg)]()

**NetroHub** is a comprehensive digital marketplace platform built with Laravel 11, designed for buying and selling digital goods including game accounts, social media accounts, and other digital products. The platform features a modern dark theme, robust security, and comprehensive seller management tools.

## 📋 Table of Contents

- [🎯 Overview](#-overview)
- [✨ Features](#-features)
- [🏗️ Architecture](#️-architecture)
- [🛠️ Technology Stack](#️-technology-stack)
- [📦 Installation](#-installation)
- [⚙️ Configuration](#️-configuration)
- [🗄️ Database Schema](#️-database-schema)
- [🔐 Security Features](#-security-features)
- [🎨 Design System](#-design-system)
- [📱 API Documentation](#-api-documentation)
- [🧪 Testing](#-testing)
- [🚀 Deployment](#-deployment)
- [📊 Monitoring](#-monitoring)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)

## 🎯 Overview

NetroHub is a full-featured digital marketplace that enables users to:

- **Buy & Sell Digital Products**: Game accounts, social media accounts, digital services
- **Secure Transactions**: Built-in escrow system with dispute resolution
- **Seller Management**: Comprehensive dashboard for product management
- **Multi-Platform Support**: Support for various gaming and social platforms
- **Advanced Security**: KYC verification, phone verification, and fraud protection
- **Subscription Plans**: Tiered seller plans with different features and limits

### 🌟 Key Highlights

- **Modern Dark UI**: Sleek, professional interface with stellar design system
- **Real-time Features**: Live notifications, instant messaging, real-time updates
- **Multi-language Support**: English and Arabic localization
- **Mobile Responsive**: Optimized for all device sizes
- **High Performance**: Optimized database queries and caching
- **Scalable Architecture**: Built to handle high traffic and large product catalogs

## ✨ Features

### 🛒 **Marketplace Features**
- **Product Catalog**: Browse and search digital products by category
- **Advanced Filtering**: Filter by platform, price, rating, and more
- **Product Reviews**: User-generated reviews and ratings system
- **Wishlist**: Save favorite products for later
- **Shopping Cart**: Multi-item cart with secure checkout
- **Instant Delivery**: Automated delivery system for digital products

### 👤 **User Management**
- **User Registration**: Email and phone-based registration
- **Profile Management**: Comprehensive user profiles with verification badges
- **KYC Verification**: Identity verification for enhanced security
- **Phone Verification**: SMS-based phone number verification
- **Social Login**: Integration with social media platforms
- **Privacy Controls**: Granular privacy settings

### 🏪 **Seller Features**
- **Seller Dashboard**: Comprehensive analytics and management tools
- **Product Management**: Create, edit, and manage product listings
- **Inventory Management**: Track stock levels and sales
- **Order Management**: Process orders and handle customer service
- **Payout System**: Automated payout requests and processing
- **Performance Analytics**: Sales reports and performance metrics

### 💰 **Payment & Billing**
- **Multiple Payment Methods**: Stripe, Tap Payments, and more
- **Subscription Plans**: Tiered seller subscription system
- **Wallet System**: Internal wallet for transactions
- **Escrow Protection**: Secure payment holding until delivery
- **Refund System**: Automated refund processing
- **Fee Calculator**: Transparent fee calculation tools

### 🛡️ **Security & Trust**
- **Dispute Resolution**: Comprehensive dispute management system
- **Fraud Protection**: Advanced fraud detection and prevention
- **Content Security Policy**: Strict CSP implementation
- **Rate Limiting**: API and form rate limiting
- **Audit Logging**: Complete activity logging
- **Data Encryption**: Sensitive data encryption at rest

### 🔧 **Admin Features**
- **Admin Dashboard**: Comprehensive admin control panel
- **User Management**: Manage users, sellers, and permissions
- **Content Management**: CMS for pages and announcements
- **Dispute Resolution**: Admin tools for dispute management
- **Analytics**: Platform-wide analytics and reporting
- **Settings Management**: Configure platform settings

## 🏗️ Architecture

### 📁 **Project Structure**

```
netrohub/
├── app/
│   ├── Actions/           # Action classes for business logic
│   ├── Console/           # Artisan commands
│   ├── Exceptions/        # Custom exception handlers
│   ├── Filament/          # Admin panel resources
│   ├── Helpers/           # Helper functions and utilities
│   ├── Http/
│   │   ├── Controllers/   # Application controllers
│   │   ├── Middleware/    # Custom middleware
│   │   └── Requests/      # Form request validation
│   ├── Jobs/              # Background job classes
│   ├── Listeners/         # Event listeners
│   ├── Models/            # Eloquent models
│   ├── Notifications/     # Notification classes
│   ├── Policies/          # Authorization policies
│   ├── Providers/         # Service providers
│   ├── Services/          # Business logic services
│   └── Traits/            # Reusable traits
├── bootstrap/             # Application bootstrap files
├── config/                # Configuration files
├── database/
│   ├── factories/         # Model factories
│   ├── migrations/        # Database migrations
│   └── seeders/           # Database seeders
├── lang/                  # Language files (EN/AR)
├── public/                # Web-accessible files
├── resources/
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript files
│   └── views/             # Blade templates
├── routes/                # Route definitions
├── storage/               # File storage
└── tests/                 # Test files
```

### 🔄 **Request Flow**

1. **Request** → Middleware Stack → Controller
2. **Controller** → Service Layer → Model
3. **Model** → Database → Response
4. **Response** → View Rendering → Client

### 🗃️ **Data Flow**

```
User Input → Validation → Business Logic → Database
     ↓
Response ← View ← Controller ← Service ← Model
```

## 🛠️ Technology Stack

### **Backend**
- **Framework**: Laravel 11.x
- **PHP Version**: 8.4+
- **Database**: MySQL 8.0+
- **Cache**: Redis (optional)
- **Queue**: Database/Redis
- **Search**: Laravel Scout (optional)

### **Frontend**
- **CSS Framework**: Tailwind CSS 3.4+
- **JavaScript**: Alpine.js 3.14+
- **Build Tool**: Vite 6.0+
- **Icons**: Custom SVG icons
- **Charts**: Chart.js 4.4+

### **Admin Panel**
- **Framework**: Filament 4.1+
- **Components**: Livewire 3.4+

### **Payment Processing**
- **Primary**: Stripe 13.0+
- **Secondary**: Tap Payments
- **Webhooks**: Secure webhook handling

### **Security**
- **Authentication**: Laravel Breeze 2.0+
- **Authorization**: Spatie Laravel Permission 6.0+
- **CSRF Protection**: Built-in Laravel CSRF
- **Rate Limiting**: Laravel rate limiting
- **CSP**: Custom Content Security Policy

### **Development Tools**
- **Testing**: Pest 2.34+
- **Code Style**: Laravel Pint 1.13+
- **Error Tracking**: Spatie Laravel Ignition 2.4+
- **Debugging**: Laravel Telescope (optional)

## 📦 Installation

### **Prerequisites**

- PHP 8.4 or higher
- Composer 2.0+
- Node.js 18+ and npm
- MySQL 8.0+
- Redis (optional but recommended)

### **Step 1: Clone Repository**

```bash
git clone https://github.com/Netrohub/NetroHub.git
cd NetroHub
```

### **Step 2: Install Dependencies**

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### **Step 3: Environment Configuration**

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### **Step 4: Database Setup**

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE netrohub;"

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed
```

### **Step 5: Build Assets**

```bash
# Build for development
npm run dev

# Build for production
npm run build
```

### **Step 6: Start Development Server**

```bash
# Start Laravel development server
php artisan serve

# Start Vite development server (in another terminal)
npm run dev
```

## ⚙️ Configuration

### **Environment Variables**

Create a `.env` file with the following configuration:

```env
# Application
APP_NAME=NetroHub
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=netrohub
DB_USERNAME=your-username
DB_PASSWORD=your-password

# Cache & Sessions
CACHE_DRIVER=database
SESSION_DRIVER=file
QUEUE_CONNECTION=database

# Redis (optional)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"

# Payment Gateways
STRIPE_KEY=your-stripe-public-key
STRIPE_SECRET=your-stripe-secret-key
STRIPE_WEBHOOK_SECRET=your-stripe-webhook-secret

TAP_PUBLIC_KEY=your-tap-public-key
TAP_SECRET_KEY=your-tap-secret-key

# Security
TURNSTILE_SITE_KEY=your-turnstile-site-key
TURNSTILE_SECRET_KEY=your-turnstile-secret-key

# File Storage
FILESYSTEM_DISK=local
AWS_ACCESS_KEY_ID=your-aws-key
AWS_SECRET_ACCESS_KEY=your-aws-secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-s3-bucket
```

### **Key Configuration Files**

- `config/app.php` - Application configuration
- `config/database.php` - Database configuration
- `config/cache.php` - Cache configuration
- `config/session.php` - Session configuration
- `config/csp.php` - Content Security Policy
- `config/services.php` - Third-party services

## 🗄️ Database Schema

### **Core Tables**

#### **Users & Authentication**
- `users` - User accounts and profiles
- `sellers` - Seller profiles and settings
- `social_accounts` - Social media account verification
- `kyc_submissions` - KYC verification data
- `phone_verifications` - Phone verification records

#### **Products & Categories**
- `categories` - Product categories
- `products` - Product listings
- `product_codes` - Digital product codes
- `product_files` - Product file attachments
- `reviews` - Product reviews and ratings

#### **Orders & Transactions**
- `orders` - Customer orders
- `order_items` - Individual order items
- `wallet_transactions` - Wallet transactions
- `payout_requests` - Seller payout requests
- `refunds` - Refund records

#### **Disputes & Support**
- `disputes` - Dispute records
- `dispute_messages` - Dispute communication
- `reports` - User reports

#### **Subscriptions & Plans**
- `plans` - Subscription plans
- `plan_features` - Plan feature definitions
- `user_subscriptions` - User subscription records
- `user_entitlements` - User feature entitlements

#### **System & Admin**
- `settings` - System settings
- `site_settings` - Site-specific settings
- `feature_flags` - Feature flag configuration
- `activity_logs` - System activity logs
- `admin_audits` - Admin action audits

### **Key Relationships**

```
User (1:1) Seller
Seller (1:N) Products
Product (1:N) Reviews
Product (1:N) OrderItems
Order (1:N) OrderItems
User (1:N) Orders
User (1:N) Disputes
```

## 🔐 Security Features

### **Authentication & Authorization**
- **Multi-factor Authentication**: Email and phone verification
- **Role-based Access Control**: Granular permission system
- **Session Management**: Secure session handling
- **Password Security**: Bcrypt hashing with configurable rounds

### **Data Protection**
- **Input Validation**: Comprehensive request validation
- **SQL Injection Prevention**: Eloquent ORM protection
- **XSS Protection**: Output escaping and CSP headers
- **CSRF Protection**: Token-based CSRF protection

### **Content Security Policy**
```php
// Strict CSP implementation
'style-src' => ["'self'", "'unsafe-inline'", "https://fonts.googleapis.com", "https://fonts.bunny.net"],
'script-src' => ["'self'", "'unsafe-inline'", "'unsafe-eval'", "https://challenges.cloudflare.com"],
'img-src' => ["'self'", "data:", "https:"],
'font-src' => ["'self'", "data:", "https://fonts.gstatic.com", "https://fonts.bunny.net"]
```

### **Rate Limiting**
- **API Endpoints**: 60 requests per minute
- **Login Attempts**: 5 attempts per minute
- **Registration**: 3 attempts per minute
- **Password Reset**: 2 attempts per minute

### **Fraud Prevention**
- **Turnstile Integration**: Cloudflare bot protection
- **IP Blocking**: Automatic IP blocking for abuse
- **Account Verification**: KYC and phone verification
- **Transaction Monitoring**: Suspicious activity detection

## 🎨 Design System

### **Color Palette**
```css
/* Primary Colors */
--primary-50: #f0f9ff;
--primary-500: #3b82f6;
--primary-900: #1e3a8a;

/* Dark Theme */
--dark-50: #f8fafc;
--dark-100: #f1f5f9;
--dark-800: #1e293b;
--dark-900: #0f172a;

/* Accent Colors */
--accent-purple: #8b5cf6;
--accent-green: #10b981;
--accent-red: #ef4444;
--accent-yellow: #f59e0b;
```

### **Typography**
- **Primary Font**: Inter (400, 500, 600, 700, 800, 900)
- **Secondary Font**: Poppins (400, 500, 600, 700, 800, 900)
- **Monospace**: JetBrains Mono (400, 500, 600, 700)

### **Component Library**
- **Buttons**: Primary, secondary, outline, ghost variants
- **Cards**: Product cards, info cards, glass cards
- **Forms**: Input fields, selectors, checkboxes, radio buttons
- **Navigation**: Header, sidebar, breadcrumbs, pagination
- **Feedback**: Alerts, notifications, modals, tooltips

### **Layout System**
- **Grid**: 12-column responsive grid
- **Spacing**: 4px base unit (4, 8, 12, 16, 24, 32, 40, 48, 64, 80px)
- **Breakpoints**: Mobile (375px), Tablet (768px), Desktop (1200px)
- **Containers**: Max-width containers with responsive padding

## 📱 API Documentation

### **Authentication Endpoints**

```http
POST /api/auth/register
POST /api/auth/login
POST /api/auth/logout
POST /api/auth/refresh
```

### **Product Endpoints**

```http
GET /api/products              # List products
GET /api/products/{id}         # Get product details
POST /api/products             # Create product (seller)
PUT /api/products/{id}         # Update product (seller)
DELETE /api/products/{id}      # Delete product (seller)
```

### **Order Endpoints**

```http
GET /api/orders                # List user orders
POST /api/orders               # Create order
GET /api/orders/{id}           # Get order details
POST /api/orders/{id}/complete # Complete order
```

### **Seller Endpoints**

```http
GET /api/seller/dashboard      # Seller dashboard data
GET /api/seller/products       # Seller products
GET /api/seller/orders         # Seller orders
GET /api/seller/analytics      # Seller analytics
```

### **Response Format**

```json
{
  "success": true,
  "data": {
    // Response data
  },
  "message": "Success message",
  "meta": {
    "pagination": {
      "current_page": 1,
      "per_page": 15,
      "total": 100
    }
  }
}
```

## 🧪 Testing

### **Test Structure**
```
tests/
├── Feature/           # Integration tests
│   ├── Auth/         # Authentication tests
│   ├── Products/     # Product functionality tests
│   ├── Orders/       # Order processing tests
│   └── Sellers/      # Seller functionality tests
└── Unit/             # Unit tests
    ├── Models/       # Model tests
    ├── Services/     # Service tests
    └── Helpers/      # Helper tests
```

### **Running Tests**

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test --filter=ProductTest
```

### **Test Configuration**

```php
// phpunit.xml
<phpunit>
    <testsuites>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

## 🚀 Deployment

### **Production Checklist**

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure database credentials
- [ ] Set up Redis (optional)
- [ ] Configure mail settings
- [ ] Set up payment gateway keys
- [ ] Configure file storage (S3)
- [ ] Set up SSL certificate
- [ ] Configure web server (Nginx/Apache)
- [ ] Set up monitoring and logging

### **Nginx Configuration**

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/netrohub/public;
    index index.php;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;

    # Content Security Policy
    add_header Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://challenges.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net; font-src 'self' data: https://fonts.gstatic.com https://fonts.bunny.net; img-src 'self' data: https:; connect-src 'self' https://challenges.cloudflare.com;" always;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### **Deployment Scripts**

```bash
#!/bin/bash
# deploy.sh

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services
sudo systemctl restart php8.4-fpm
sudo systemctl restart nginx
```

### **Docker Deployment**

```dockerfile
FROM php:8.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm ci && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
```

## 📊 Monitoring

### **Application Monitoring**
- **Laravel Telescope**: Debug and monitor application
- **Laravel Horizon**: Monitor queue jobs
- **Error Tracking**: Spatie Laravel Ignition
- **Performance**: Query optimization and caching

### **Server Monitoring**
- **System Resources**: CPU, memory, disk usage
- **Database Performance**: Query optimization, connection pooling
- **Web Server**: Nginx/Apache performance metrics
- **SSL Certificate**: Expiration monitoring

### **Business Metrics**
- **User Analytics**: Registration, active users, retention
- **Sales Analytics**: Revenue, conversion rates, popular products
- **Seller Performance**: Top sellers, product performance
- **Support Metrics**: Dispute resolution, response times

### **Logging Configuration**

```php
// config/logging.php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'slack'],
    ],
    'single' => [
        'driver' => 'single',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'debug',
    ],
    'slack' => [
        'driver' => 'slack',
        'url' => env('LOG_SLACK_WEBHOOK_URL'),
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
    ],
],
```

## 🤝 Contributing

We welcome contributions to NetroHub! Please follow these guidelines:

### **Development Setup**

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Make your changes
4. Run tests: `php artisan test`
5. Commit changes: `git commit -m 'Add amazing feature'`
6. Push to branch: `git push origin feature/amazing-feature`
7. Open a Pull Request

### **Code Standards**

- Follow PSR-12 coding standards
- Use Laravel Pint for code formatting
- Write tests for new features
- Update documentation as needed
- Follow semantic versioning

### **Pull Request Guidelines**

- Provide clear description of changes
- Include tests for new functionality
- Update documentation if needed
- Ensure all tests pass
- Follow the existing code style

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

- **Documentation**: [Wiki](https://github.com/Netrohub/NetroHub/wiki)
- **Issues**: [GitHub Issues](https://github.com/Netrohub/NetroHub/issues)
- **Discussions**: [GitHub Discussions](https://github.com/Netrohub/NetroHub/discussions)
- **Email**: support@netrohub.com

## 🙏 Acknowledgments

- **Laravel Framework** - The amazing PHP framework
- **Tailwind CSS** - Utility-first CSS framework
- **Alpine.js** - Lightweight JavaScript framework
- **Filament** - Beautiful admin panel
- **Stripe** - Payment processing
- **Cloudflare** - Security and performance

---

**Built with ❤️ by the NetroHub Team**

*Last updated: October 2025*
