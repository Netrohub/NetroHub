# NetroHub - Digital Marketplace Platform

A modern Laravel-based digital marketplace for social media and gaming accounts.

## Features

- 🎮 **Gaming Accounts**: Fortnite, Whiteout Survival, and more
- 📱 **Social Media Accounts**: Instagram, TikTok profiles
- 💳 **Secure Payments**: Integrated payment processing
- 🔐 **KYC Verification**: Identity and phone verification system
- 📊 **Analytics**: Google Analytics 4 integration
- 🎨 **Modern UI**: Gaming-themed responsive design
- ⚡ **Fast Performance**: Optimized for speed and scalability

## Technology Stack

- **Backend**: Laravel 11.x
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL
- **Admin Panel**: Filament
- **Payments**: Stripe/Paddle integration
- **Analytics**: Google Analytics 4
- **Authentication**: Laravel Breeze

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd netrohub
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start development server**
   ```bash
   php artisan serve
   ```

## Configuration

### Google Analytics
Add your GA4 Measurement ID to `.env`:
```env
GOOGLE_ANALYTICS_MEASUREMENT_ID=G-XXXXXXXXXX
```

### Database
Configure your database connection in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=netrohub
DB_USERNAME=root
DB_PASSWORD=
```

### Payments
Configure payment providers in `.env`:
```env
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret
```

## Categories

The platform supports the following product categories:
- **Instagram** accounts
- **TikTok** accounts  
- **Fortnite** gaming accounts
- **Whiteout Survival** gaming accounts

## Admin Panel

Access the admin panel at `/admin` after running:
```bash
php artisan make:filament-user
```

## Testing

```bash
php artisan test
```

## Deployment

1. Set `APP_ENV=production` in your production `.env`
2. Configure your production database
3. Run migrations: `php artisan migrate --force`
4. Build assets: `npm run build`
5. Set up your web server to point to the `public` directory

## License

This project is proprietary software. All rights reserved.

## Support

For support, please contact the development team.