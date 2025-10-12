<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KycVerificationController;
use App\Http\Controllers\MembersController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PaddleWebhookController;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SecureDownloadController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\PayoutController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\WalletController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Members
Route::get('/members', [MembersController::class, 'index'])->name('members.index');
Route::get('/members/{user}', [MembersController::class, 'show'])->name('members.show');

// Social page
Route::get('/social', [App\Http\Controllers\SocialController::class, 'index'])->name('social');

// Games page
Route::get('/games', [App\Http\Controllers\GamesController::class, 'index'])->name('games');

// Leaderboard page
Route::get('/leaderboard', [App\Http\Controllers\LeaderboardController::class, 'index'])->name('leaderboard');

// Legal Pages
Route::get('/terms', function () {
    return view('legal.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('legal.privacy');
})->name('privacy');

// Sitemap
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap/static.xml', [App\Http\Controllers\SitemapController::class, 'static'])->name('sitemap.static');
Route::get('/sitemap/products.xml', [App\Http\Controllers\SitemapController::class, 'products'])->name('sitemap.products');
Route::get('/sitemap/members.xml', [App\Http\Controllers\SitemapController::class, 'members'])->name('sitemap.members');

// Robots.txt
Route::get('/robots.txt', function () {
    $robots = "User-agent: *\n";
    $robots .= "Allow: /\n";
    $robots .= "Disallow: /admin\n";
    $robots .= "Disallow: /account\n";
    $robots .= "Disallow: /seller\n";
    $robots .= "Disallow: /checkout\n";
    $robots .= "\n";
    $robots .= 'Sitemap: '.route('sitemap.index')."\n";

    return response($robots, 200, [
        'Content-Type' => 'text/plain',
    ]);
})->name('robots');

// Health Check
Route::get('/health', [App\Http\Controllers\HealthController::class, 'check'])->name('health');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Subscriptions & Pricing
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing.index');

Route::middleware('auth')->group(function () {
    // Subscription management
    Route::post('/subscribe/{plan}/{interval?}', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('/subscription/resume', [SubscriptionController::class, 'resume'])->name('subscription.resume');
    Route::post('/subscription/change/{plan}/{interval?}', [SubscriptionController::class, 'changePlan'])->name('subscription.change');
    
    // Billing pages
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/success', [BillingController::class, 'success'])->name('billing.success');
    Route::get('/billing/cancel', [BillingController::class, 'cancel'])->name('billing.cancel');
});

// Paddle webhooks (public, no CSRF)
Route::post('/webhook/paddle', [PaddleWebhookController::class, 'handle'])->name('webhook.paddle')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Account area (authenticated)
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::put('/', [AccountController::class, 'update'])->name('update');
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('/sales', [AccountController::class, 'sales'])->name('sales');
    Route::get('/wallet', [AccountController::class, 'wallet'])->name('wallet');
    Route::get('/payouts', [AccountController::class, 'payouts'])->name('payouts');
    Route::get('/promote', [AccountController::class, 'promote'])->name('promote');
    Route::get('/notifications', [AccountController::class, 'notifications'])->name('notifications');
    Route::get('/blocked', [AccountController::class, 'blocked'])->name('blocked');
    Route::get('/fees-calculator', [AccountController::class, 'fees'])->name('fees');
    Route::get('/challenges', [AccountController::class, 'challenges'])->name('challenges');
    Route::get('/billing', [AccountController::class, 'billing'])->name('billing');
    Route::post('/privacy-mode/toggle', [AccountController::class, 'togglePrivacy'])->name('privacy.toggle');
});

// KYC Verification Routes (Legacy - for backward compatibility)
Route::middleware('auth')->prefix('kyc')->name('kyc.')->group(function () {
    Route::get('/verification', [KycVerificationController::class, 'show'])->name('verification.show');
    Route::post('/verification', [KycVerificationController::class, 'store'])->name('verification.store');
    Route::get('/status', [KycVerificationController::class, 'status'])->name('status');
});

// New KYC Verification Routes
Route::middleware('auth')->prefix('account/kyc')->name('account.kyc.')->group(function () {
    Route::get('/', [App\Http\Controllers\Account\KycController::class, 'show'])->name('show');
    Route::post('/', [App\Http\Controllers\Account\KycController::class, 'store'])->name('store')->middleware('throttle:3,1');
    Route::get('/status', [App\Http\Controllers\Account\KycController::class, 'status'])->name('status');
});

// Phone Verification Routes
Route::middleware('auth')->prefix('account/phone')->name('account.phone.')->group(function () {
    Route::get('/', [App\Http\Controllers\Account\PhoneVerificationController::class, 'show'])->name('show');
    Route::post('/send-code', [App\Http\Controllers\Account\PhoneVerificationController::class, 'sendCode'])->name('send-code')->middleware('throttle:5,1');
    Route::post('/verify-code', [App\Http\Controllers\Account\PhoneVerificationController::class, 'verifyCode'])->name('verify-code')->middleware('throttle:5,1');
    Route::post('/resend-code', [App\Http\Controllers\Account\PhoneVerificationController::class, 'resendCode'])->name('resend-code')->middleware('throttle:5,1');
});

// Phone Verification Routes
Route::middleware('auth')->prefix('phone')->name('phone.')->group(function () {
    Route::get('/verification', [PhoneVerificationController::class, 'show'])->name('verification.show');
    Route::post('/send-code', [PhoneVerificationController::class, 'sendCode'])->name('send-code');
    Route::post('/verify-code', [PhoneVerificationController::class, 'verifyCode'])->name('verify-code');
    Route::post('/resend-code', [PhoneVerificationController::class, 'resendCode'])->name('resend-code');
});

// Admin KYC Document Routes (Secure access to private documents)
Route::middleware(['auth'])->prefix('admin/kyc')->name('admin.kyc.')->group(function () {
    Route::get('/document/{file}', function ($file) {
        // Verify the file exists in private storage
        if (!Storage::disk('private')->exists($file)) {
            abort(404, 'Document not found');
        }
        
        // Check if user is admin (temporarily more permissive for testing)
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('super-admin') && auth()->user()->email !== 'admin@netrohub.com') {
            abort(403, 'Unauthorized access');
        }
        
        $filePath = Storage::disk('private')->path($file);
        $mimeType = Storage::disk('private')->mimeType($file);
        
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($file) . '"'
        ]);
    })->name('document');
});

// Checkout
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

// Paddle webhook (public - no auth)
Route::post('/webhook/paddle', [CheckoutController::class, 'webhook'])->name('webhook.paddle');

// Order delivery (secure credential viewing)
Route::middleware(['auth', 'throttle:delivery'])->prefix('orders')->name('orders.')->group(function () {
    Route::get('/{order}/delivery', [App\Http\Controllers\OrderDeliveryController::class, 'show'])->name('delivery');
    Route::post('/{order}/delivery/reveal/{orderItem}', [App\Http\Controllers\OrderDeliveryController::class, 'reveal'])->name('delivery.reveal');
});

// Secure download routes
Route::middleware('auth')->prefix('downloads')->name('downloads.')->group(function () {
    Route::get('/secure', [SecureDownloadController::class, 'download'])->name('secure');
    Route::post('/generate/{orderItem}', [SecureDownloadController::class, 'generateUrl'])->name('generate');
    Route::get('/stats/{orderItem}', [SecureDownloadController::class, 'stats'])->name('stats');
});

// Reviews
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/products/{product}/review-form', [ReviewController::class, 'form'])
        ->name('reviews.form');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store')
        ->middleware('throttle:reviews');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])
        ->name('reviews.update')
        ->middleware('throttle:reviews');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');
    Route::post('/reviews/{review}/reply', [ReviewController::class, 'reply'])
        ->name('reviews.reply')
        ->middleware('throttle:reviews');
    Route::post('/reviews/{review}/report', [ReviewController::class, 'report'])
        ->name('reviews.report')
        ->middleware('throttle:reviews');
});

// Sell Routes (auto-creates seller profile)
Route::middleware(['auth', 'require.kyc'])->prefix('sell')->name('sell.')->group(function () {
    Route::get('/', [SellController::class, 'index'])->name('index');
    Route::get('/game', [SellController::class, 'createGame'])->name('game.create');
    Route::get('/social', [SellController::class, 'createSocial'])->name('social.create');
    Route::post('/game', [SellController::class, 'storeGame'])->name('game.store');
    Route::post('/social', [SellController::class, 'storeSocial'])->name('social.store');
});

// Legacy sell entry point (redirect to new landing)
Route::middleware('auth')->get('/sell-entry', [SellController::class, 'entry'])->name('sell.entry');

// Seller Routes
Route::middleware(['auth', 'require.kyc'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', SellerProductController::class);

    // Wallet
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/transactions', [WalletController::class, 'transactions'])->name('wallet.transactions');

    // Payouts
    Route::get('/payouts', [PayoutController::class, 'index'])->name('payouts.index');
    Route::get('/payouts/create', [PayoutController::class, 'create'])->name('payouts.create');
    Route::post('/payouts', [PayoutController::class, 'store'])->name('payouts.store');

    // Settings
    Route::get('/settings', [SellerDashboardController::class, 'settings'])->name('settings');
    Route::put('/settings', [SellerDashboardController::class, 'updateSettings'])->name('settings.update');
});

// Impersonation routes (admin only)
Route::middleware(['auth'])->group(function () {
    Route::get('/impersonate/{user}', [App\Http\Controllers\ImpersonationController::class, 'impersonate'])
        ->name('impersonate');
    Route::get('/impersonate/stop', [App\Http\Controllers\ImpersonationController::class, 'stopImpersonating'])
        ->name('impersonate.stop');
    Route::get('/stop-impersonating', [App\Http\Controllers\ImpersonationController::class, 'stopImpersonating'])
        ->name('stop-impersonating');
});

// Auth routes (will be added by Breeze)
require __DIR__.'/auth.php';

// Locale toggle (simple session switcher)
Route::post('/locale/toggle', function (Request $request) {
    $locale = session('locale', 'en') === 'en' ? 'ar' : 'en';
    session(['locale' => $locale]);

    return back();
})->middleware('auth')->name('locale.toggle');
