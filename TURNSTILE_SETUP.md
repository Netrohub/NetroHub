# Cloudflare Turnstile Setup Guide

## Overview
This guide explains how to configure Cloudflare Turnstile for your NetroHub application to fix the error 300031 (widget crashed) issue.

## Environment Variables Required

Add these variables to your `.env` file:

```env
# Cloudflare Turnstile Configuration
TURNSTILE_SITE_KEY=your_site_key_here
TURNSTILE_SECRET_KEY=your_secret_key_here
```

## How to Get Turnstile Keys

1. **Go to Cloudflare Dashboard**
   - Visit [https://dash.cloudflare.com/](https://dash.cloudflare.com/)
   - Log in to your account

2. **Navigate to Turnstile**
   - Go to "Turnstile" in the left sidebar
   - Click "Add site"

3. **Configure Your Site**
   - **Site name**: `netrohub.com` (or your domain)
   - **Domain**: `netrohub.com` (add your actual domain)
   - **Widget mode**: Choose "Managed" for automatic challenges
   - **Pre-clearance**: Enable if you want to reduce challenges for trusted users

4. **Get Your Keys**
   - After creating the site, you'll see:
     - **Site Key**: This is your `TURNSTILE_SITE_KEY`
     - **Secret Key**: This is your `TURNSTILE_SECRET_KEY` (click "Show" to reveal)

## Configuration Steps

1. **Update .env file**
   ```env
   TURNSTILE_SITE_KEY=0x4AAAAAAABkMYinukE8nzYr
   TURNSTILE_SECRET_KEY=0x4AAAAAAABkMYinukE8nzYr_secret_key_here
   ```

2. **Clear Laravel Cache**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Test the Login Page**
   - Visit your login page
   - The Turnstile widget should now load properly
   - Error 300031 should be resolved

## Troubleshooting

### Error 300030 (Widget Hung)
- **Cause**: Widget initialization timeout or network issues
- **Solution**: The new implementation automatically retries and resets hung widgets

### Error 300031 (Widget Crashed)
- **Cause**: Usually due to invalid site key or domain mismatch
- **Solution**: Verify your site key and ensure the domain in Cloudflare matches your actual domain

### Error 300032 (Invalid Site Key)
- **Cause**: The site key is incorrect or not properly set
- **Solution**: Double-check your `TURNSTILE_SITE_KEY` in the `.env` file

### Error 300033 (Invalid Domain)
- **Cause**: The domain in Cloudflare doesn't match your current domain
- **Solution**: Update the domain in your Cloudflare Turnstile configuration

### Error 300034 (Widget Expired)
- **Cause**: Widget session expired
- **Solution**: The new implementation automatically resets expired widgets

### Error 300035 (Widget Already Rendered)
- **Cause**: Multiple widget initializations
- **Solution**: The new implementation prevents multiple initializations

### Widget Not Loading
- **Cause**: Missing environment variables or network issues
- **Solution**: 
  1. Check if `TURNSTILE_SITE_KEY` is set in `.env`
  2. Clear browser cache
  3. Check browser console for errors
  4. Verify CSP headers allow Cloudflare scripts

## Features Implemented

The updated Turnstile implementation includes:

- ✅ **Comprehensive error handling** for all common error codes (300030-300035)
- ✅ **Automatic retry mechanism** with configurable retry limits
- ✅ **Widget state management** to prevent multiple initializations
- ✅ **Alpine.js modal compatibility** with IntersectionObserver
- ✅ **Manual initialization functions** for custom scenarios
- ✅ **CSP header compatibility** with Cloudflare domains
- ✅ **User-friendly error messages** with retry indicators
- ✅ **Visual error indicators** with styled error messages
- ✅ **Console logging** for debugging and monitoring
- ✅ **Timeout handling** for hung widgets (error 300030)
- ✅ **Automatic widget reset** for crashed/expired widgets
- ✅ **Performance optimizations** to prevent browser violations
- ✅ **Debounced error handling** to reduce excessive processing
- ✅ **RequestAnimationFrame usage** for smooth DOM operations
- ✅ **RequestIdleCallback support** for non-blocking operations

## Alpine.js Integration

The new implementation is fully compatible with Alpine.js modals:

### For Login Page
```javascript
// Manual initialization in Alpine.js
window.initTurnstile();

// Manual reset
window.resetTurnstile();
```

### For Register Page
```javascript
// Manual initialization in Alpine.js
window.initTurnstileRegister();

// Manual reset
window.resetTurnstileRegister();
```

### Modal Integration Example
```html
<div x-data="{ showModal: false }" x-init="
    $watch('showModal', value => {
        if (value) {
            setTimeout(() => window.initTurnstile(), 100);
        }
    })
">
    <!-- Modal content with Turnstile -->
</div>
```

## Performance Optimizations

The implementation includes several performance optimizations to prevent browser violations:

### **RequestAnimationFrame Usage**
- DOM manipulations are scheduled using `requestAnimationFrame`
- Prevents blocking the main thread during widget operations
- Ensures smooth animations and interactions

### **Debounced Error Handling**
- Error callbacks are debounced to prevent excessive processing
- 1-second cooldown between error handling attempts
- Reduces CPU usage during error scenarios

### **RequestIdleCallback Support**
- Non-critical operations use `requestIdleCallback` when available
- Falls back to `setTimeout` for older browsers
- Ensures operations don't interfere with user interactions

### **Optimized IntersectionObserver**
- Uses `rootMargin: '50px'` and `threshold: 0.1` for better performance
- Prevents unnecessary widget initializations
- Reduces memory usage and CPU cycles

## Testing

After configuration, test the following scenarios:

1. **Normal login flow** - Should work without errors
2. **Expired widget** - Should auto-reset and show appropriate message
3. **Network issues** - Should show helpful error message
4. **Invalid credentials** - Should still show Turnstile validation errors
5. **Modal visibility** - Widget should initialize when modal becomes visible
6. **Error recovery** - Widget should automatically retry on errors 300030, 300031, 300034
7. **Performance** - No browser violation warnings in console
8. **Smooth interactions** - No UI blocking during widget operations

## Support

If you continue to experience issues:

1. Check the browser console for specific error messages
2. Verify your Cloudflare Turnstile configuration
3. Ensure your domain is properly configured in Cloudflare
4. Test with a fresh browser session (incognito mode)
