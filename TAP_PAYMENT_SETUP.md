# 💳 Tap Payment Gateway Setup Guide

## 🎯 **Quick Setup for Sandbox Mode**

### **Step 1: Get Tap Sandbox Credentials**

1. Go to https://www.tap.company/
2. Sign up for a **free sandbox account**
3. From the Dashboard, copy your sandbox credentials:
   - **Secret Key**: `sk_test_...` (starts with sk_test)
   - **Public Key**: `pk_test_...` (starts with pk_test)
   - **Webhook Secret**: `whsec_...` (for webhook verification)

### **Step 2: Create .env File**

Create a `.env` file in your project root with the following Tap configuration:

```env
# Tap Payment Gateway - SANDBOX MODE
TAP_SECRET_KEY=sk_test_YOUR_ACTUAL_SECRET_KEY_HERE
TAP_PUBLIC_KEY=pk_test_YOUR_ACTUAL_PUBLIC_KEY_HERE
TAP_WEBHOOK_SECRET=whsec_YOUR_ACTUAL_WEBHOOK_SECRET_HERE
TAP_SANDBOX=true
```

### **Step 3: Generate Application Key**

Run this command to generate your Laravel application key:

```bash
php artisan key:generate
```

---

## ✅ **Configuration Status**

The Tap payment gateway is now configured for **SANDBOX MODE** with:

- ✅ **Sandbox API URL**: `https://api-sandbox.tap.company/v2`
- ✅ **Sandbox Mode**: Enabled by default
- ✅ **Service Integration**: TapPaymentService ready
- ✅ **Webhook Support**: Configured for payment callbacks

---

## 🧪 **Testing the Integration**

### **Test Payment Flow:**

1. **Create a subscription** using the TapPaymentService
2. **Process payments** through the sandbox environment
3. **Receive webhooks** for payment status updates

### **Sandbox Test Cards:**

Use these test card numbers for testing:

- **Visa**: `4242424242424242`
- **Mastercard**: `5555555555554444`
- **American Express**: `378282246310005`
- **Any CVV**: `123`
- **Any expiry**: Future date (e.g., `12/25`)

---

## 🔧 **Service Configuration**

The `TapPaymentService` is configured to:

- Use sandbox API endpoints
- Handle subscription payments
- Process one-time charges
- Support webhook callbacks
- Log all transactions for debugging

---

## 📋 **Environment Variables**

Required Tap environment variables:

```env
TAP_SECRET_KEY=sk_test_...          # Your sandbox secret key
TAP_PUBLIC_KEY=pk_test_...          # Your sandbox public key  
TAP_WEBHOOK_SECRET=whsec_...        # Your webhook secret
TAP_SANDBOX=true                    # Enable sandbox mode
```

---

## 🚀 **Production Setup**

When ready for production:

1. **Get production credentials** from Tap dashboard
2. **Update environment variables**:
   ```env
   TAP_SECRET_KEY=sk_live_...        # Production secret key
   TAP_PUBLIC_KEY=pk_live_...        # Production public key
   TAP_WEBHOOK_SECRET=whsec_...      # Production webhook secret
   TAP_SANDBOX=false                 # Disable sandbox mode
   ```
3. **Test thoroughly** before going live

---

## 🔗 **Useful Links**

- **Tap Dashboard**: https://www.tap.company/
- **Tap API Documentation**: https://www.tap.company/developers
- **Sandbox Testing**: https://www.tap.company/developers/sandbox
- **Webhook Documentation**: https://www.tap.company/developers/webhooks

---

## ⚠️ **Important Notes**

- **Sandbox Mode**: All transactions are test transactions
- **No Real Money**: Sandbox doesn't process real payments
- **Webhook Testing**: Use ngrok or similar for local webhook testing
- **Security**: Never commit real API keys to version control
