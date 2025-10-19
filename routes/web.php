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

// Seller verification checklist
Route::middleware(['auth'])->get('/account/verification-checklist', function () {
    return view('account.verification-checklist');
})->name('account.verification.checklist');

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
})->name('legal.terms');

Route::get('/privacy', function () {
    return view('legal.privacy');
})->name('legal.privacy');

Route::get('/refund-policy', function () {
    return view('legal.refund');
})->name('legal.refund');

// About Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// OTP Demo Page (remove in production or protect with auth)
Route::get('/otp-demo', function () {
    return view('otp-demo');
})->name('otp.demo');

// Sitemap
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap/static.xml', [App\Http\Controllers\SitemapController::class, 'static'])->name('sitemap.static');
Route::get('/sitemap/products.xml', [App\Http\Controllers\SitemapController::class, 'products'])->name('sitemap.products');
Route::get('/sitemap/members.xml', [App\Http\Controllers\SitemapController::class, 'members'])->name('sitemap.members');

// Robots.txt
Route::get('/robots.txt', function () {
    $robots = "User-agent: *\n";
    $robots .= "Allow: /\n";
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

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Users Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    
    // Products Management
    Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'show'])->name('products.show');
    Route::patch('/products/{product}/status', [App\Http\Controllers\Admin\ProductController::class, 'updateStatus'])->name('products.update-status');
    Route::delete('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
    
    // Orders Management
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');

    // Disputes Management
    Route::get('/disputes', [App\Http\Controllers\Admin\DisputeController::class, 'index'])->name('disputes.index');
    Route::get('/disputes/{dispute}', [App\Http\Controllers\Admin\DisputeController::class, 'show'])->name('disputes.show');
    Route::post('/disputes/{dispute}/take-action', [App\Http\Controllers\Admin\DisputeController::class, 'takeAction'])->name('disputes.take-action');
    Route::post('/disputes/{dispute}/message', [App\Http\Controllers\Admin\DisputeController::class, 'addMessage'])->name('disputes.message');
    Route::post('/disputes/{dispute}/resolve', [App\Http\Controllers\Admin\DisputeController::class, 'resolve'])->name('disputes.resolve');
    Route::post('/disputes/{dispute}/internal-note', [App\Http\Controllers\Admin\DisputeController::class, 'addInternalNote'])->name('disputes.internal-note');

    // Site Settings
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');

    // CMS Pages
    Route::get('/cms', [App\Http\Controllers\Admin\CmsController::class, 'index'])->name('cms.index');
    Route::get('/cms/{page}/edit', [App\Http\Controllers\Admin\CmsController::class, 'edit'])->name('cms.edit');
    Route::put('/cms/{page}', [App\Http\Controllers\Admin\CmsController::class, 'update'])->name('cms.update');
});

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Subscriptions & Pricing
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing.index');

Route::middleware(['auth', 'verified'])->group(function () {
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

// Tap webhooks and callbacks (public, no CSRF for webhook)
Route::post('/webhook/tap', [App\Http\Controllers\TapWebhookController::class, 'handle'])
    ->name('webhook.tap')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/subscription/callback', [App\Http\Controllers\TapWebhookController::class, 'callback'])
    ->name('subscription.callback')
    ->middleware('auth');

// Account area (authenticated and verified)
Route::middleware(['auth', 'verified'])->prefix('account')->name('account.')->group(function () {
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

// Disputes (authenticated and verified)
Route::middleware(['auth', 'verified'])->prefix('disputes')->name('disputes.')->group(function () {
    Route::get('/', [App\Http\Controllers\DisputeController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\DisputeController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\DisputeController::class, 'store'])->name('store');
    Route::get('/{dispute}', [App\Http\Controllers\DisputeController::class, 'show'])->name('show');
    Route::post('/{dispute}/message', [App\Http\Controllers\DisputeController::class, 'addMessage'])->name('message');
    Route::post('/{dispute}/escalate', [App\Http\Controllers\DisputeController::class, 'escalate'])->name('escalate');
    Route::post('/{dispute}/mark-resolved', [App\Http\Controllers\DisputeController::class, 'markResolved'])->name('mark-resolved');
});

// KYC Verification Routes (Legacy - redirects to Persona)
Route::middleware(['auth', 'verified'])->prefix('kyc')->name('kyc.')->group(function () {
    Route::get('/verification', function() {
        return redirect()->route('persona.kyc.show');
    })->name('verification.show');
    Route::get('/status', function() {
        return redirect()->route('persona.kyc.status');
    })->name('status');
});

// Redirect old KYC route to new Persona KYC
Route::middleware(['auth', 'verified'])->prefix('account/kyc')->name('account.kyc.')->group(function () {
    Route::get('/', function() {
        return redirect()->route('persona.kyc.show');
    })->name('show');
    Route::get('/status', function() {
        return redirect()->route('persona.kyc.status');
    })->name('status');
});

// Persona KYC Verification Routes
Route::middleware(['auth', 'verified'])->prefix('persona/kyc')->name('persona.kyc.')->group(function () {
    Route::get('/', [App\Http\Controllers\PersonaKycController::class, 'show'])->name('show');
    Route::post('/create', [App\Http\Controllers\PersonaKycController::class, 'createInquiry'])->name('create');
    Route::get('/status', [App\Http\Controllers\PersonaKycController::class, 'status'])->name('status');
});

// Persona Webhook (no auth middleware)
Route::post('/webhooks/persona', [App\Http\Controllers\PersonaKycController::class, 'webhook'])->name('webhooks.persona');

// Phone Verification Routes
Route::middleware(['auth', 'verified'])->prefix('account/phone')->name('account.phone.')->group(function () {
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
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('super-admin') && auth()->user()->email !== 'admin@nxo.com') {
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
Route::middleware(['auth', 'verified'])->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

// Paddle webhook (public - no auth)
Route::post('/webhook/paddle', [CheckoutController::class, 'webhook'])->name('webhook.paddle');

// Order delivery (secure credential viewing)
Route::middleware(['auth', 'verified', 'throttle:delivery'])->prefix('orders')->name('orders.')->group(function () {
    Route::get('/{order}/delivery', [App\Http\Controllers\OrderDeliveryController::class, 'show'])->name('delivery');
    Route::post('/{order}/delivery/reveal/{orderItem}', [App\Http\Controllers\OrderDeliveryController::class, 'reveal'])->name('delivery.reveal');
});

// Secure download routes
Route::middleware(['auth', 'verified'])->prefix('downloads')->name('downloads.')->group(function () {
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
Route::middleware(['auth'])->prefix('sell')->name('sell.')->group(function () {
    Route::get('/', [SellController::class, 'index'])->name('index');
    Route::get('/game', [SellController::class, 'createGame'])->name('game.create');
    Route::get('/social', [SellController::class, 'createSocial'])->name('social.create');
    Route::post('/game', [SellController::class, 'storeGame'])->name('game.store');
    Route::post('/social', [SellController::class, 'storeSocial'])->name('social.store');
});

// Legacy sell entry point (redirect to new landing)
Route::middleware('auth')->get('/sell-entry', [SellController::class, 'entry'])->name('sell.entry');

// Seller Routes
Route::middleware(['auth', 'verified', 'require.kyc', 'require.phone', 'require.seller.verifications'])->prefix('seller')->name('seller.')->group(function () {
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


});

// Social account verification routes (accessible from sell pages)
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    Route::prefix('social-verification')->name('social-verification.')->group(function () {
        Route::post('/start', [App\Http\Controllers\SocialAccountVerificationController::class, 'start'])->name('start');
        Route::post('/verify', [App\Http\Controllers\SocialAccountVerificationController::class, 'verify'])->name('verify');
        Route::get('/status', [App\Http\Controllers\SocialAccountVerificationController::class, 'status'])->name('status');
        Route::get('/verified-accounts', [App\Http\Controllers\SocialAccountVerificationController::class, 'getVerifiedAccounts'])->name('verified-accounts');
    });
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
