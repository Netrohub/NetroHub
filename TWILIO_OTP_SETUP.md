# 📱 Twilio WhatsApp OTP Verification Setup

Complete guide to setup WhatsApp OTP verification using Twilio API for NetroHub.

---

## 🎯 **What You Need from Twilio**

### **Required:**
1. ✅ **Account SID**
2. ✅ **Auth Token**
3. ✅ **WhatsApp-enabled Number** (Sandbox or approved number)

---

## 📋 **Step-by-Step Setup**

### **Step 1: Create Twilio Account**

1. Go to https://www.twilio.com/try-twilio
2. Sign up for a **free trial account**
3. Verify your email and phone number
4. You'll get **$15 free credit** to test!

---

### **Step 2: Get Your Credentials**

#### **A. Account SID and Auth Token:**

1. Login to https://console.twilio.com
2. You'll see your credentials on the **Dashboard**:
   - **Account SID**: `ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx`
   - **Auth Token**: Click "Show" to reveal it

#### **B. Setup WhatsApp:**

**Option 1: Use Twilio WhatsApp Sandbox (For Testing - FREE)**

1. Go to **Messaging** → **Try it out** → **Send a WhatsApp message**
2. You'll see instructions to join the sandbox:
   - Send a message from your WhatsApp to the sandbox number
   - Message format: `join <sandbox-code>` (e.g., "join happy-tiger")
3. Copy the **Sandbox Number**: `+14155238886` (or your region's number)

**Option 2: Get Approved WhatsApp Number (For Production)**

1. Go to **Messaging** → **WhatsApp** → **Senders**
2. Click **Get Started** or **Request Approval**
3. Submit your business details
4. Wait for approval (can take a few days)
5. Once approved, you'll get your WhatsApp Business number

**💡 Recommendation:**
- Start with **Sandbox** (free, instant setup)
- Move to **Approved Number** when ready for production

---

### **Step 3: Add to .env File**

Add these lines to your `.env`:

```env
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=your_auth_token_here
TWILIO_WHATSAPP_FROM=+14155238886
```

**Example (Using Sandbox):**
```env
TWILIO_ACCOUNT_SID=AC1a2b3c4d5e6f7g8h9i0j1k2l3m4n5o6
TWILIO_AUTH_TOKEN=abcdef1234567890abcdef1234567890
TWILIO_WHATSAPP_FROM=+14155238886
```

**Example (Using Your Own Approved Number):**
```env
TWILIO_ACCOUNT_SID=AC1a2b3c4d5e6f7g8h9i0j1k2l3m4n5o6
TWILIO_AUTH_TOKEN=abcdef1234567890abcdef1234567890
TWILIO_WHATSAPP_FROM=+19876543210
```

---

## 🔧 **Complete Configuration**

Your `.env` should have:

```env
# Twilio WhatsApp Configuration
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=your_auth_token_here
TWILIO_WHATSAPP_FROM=+14155238886
```

---

## 📱 **WhatsApp Message Format**

Users will receive on WhatsApp:

```
🔐 *NetroHub Verification*

Your verification code is:

*123456*

This code will expire in 5 minutes.

_Please do not share this code with anyone._
```

WhatsApp supports rich formatting:
- **Bold**: `*text*`
- **Italic**: `_text_`  
- **Emojis**: 🔐 ✅ ⏰

---

## 🧪 **Testing with WhatsApp Sandbox**

### **Step 1: Join Twilio WhatsApp Sandbox**

Before you can receive test messages, you need to join the sandbox:

1. Go to Twilio Console → **Messaging** → **Try it out** → **Send a WhatsApp message**
2. You'll see a **sandbox code** (e.g., `join happy-tiger`)
3. **On your phone**, open WhatsApp
4. Send a message to `+14155238886` (or your region's sandbox number)
5. Type: `join happy-tiger` (use the exact code from Twilio)
6. You'll get a confirmation: "You are all set! The sandbox can now send you messages."

**Important:** Each phone number must join the sandbox before receiving messages.

### **Step 2: Test the API**

```bash
curl -X POST https://netrohub.com/api/otp/send \
  -H "Content-Type: application/json" \
  -d '{"phone":"+966501234567"}'
```

The OTP will be sent to your WhatsApp!

### **Step 3: Test with Demo Page**

Visit: `https://netrohub.com/otp-demo`

Enter the phone number that joined the sandbox.

---

## 💰 **Pricing**

### **Twilio WhatsApp Pricing:**

- **Sandbox**: **FREE** (for testing only)
- **Business Messages**: $0.005 - $0.02 per message (varies by country)
- **Utility Messages** (like OTP): $0.005 per message
- **Authentication Messages**: $0.005 per message

**Example Costs:**
- **Saudi Arabia**: ~$0.006 per WhatsApp message
- **USA**: ~$0.005 per WhatsApp message  
- **UAE**: ~$0.006 per WhatsApp message

**Much cheaper than SMS!** WhatsApp is typically 60-80% cheaper than traditional SMS.

Check exact pricing: https://www.twilio.com/whatsapp/pricing

### **No Monthly Fees:**
- ✅ Pay only for what you use
- ✅ No subscription required
- ✅ Sandbox is completely FREE

---

## 🌍 **Supported Countries**

Twilio WhatsApp works in **180+ countries** including:
- 🇸🇦 Saudi Arabia
- 🇦🇪 UAE
- 🇰🇼 Kuwait
- 🇶🇦 Qatar
- 🇧🇭 Bahrain
- 🇴🇲 Oman
- 🇪🇬 Egypt
- 🇺🇸 USA
- 🇬🇧 UK
- And many more...

**Note:** WhatsApp has better delivery rates than SMS in most countries!

---

## 🔒 **Security Best Practices**

### **Protect Your Credentials:**

1. Never commit `.env` to Git
2. Use environment variables on server
3. Rotate tokens periodically
4. Monitor usage for unusual activity

### **Rate Limiting:**

Already implemented:
- ✅ Max 3 OTPs per phone per hour
- ✅ 5 requests per minute on send endpoint
- ✅ 10 requests per minute on verify endpoint

---

## 📞 **Twilio Dashboard**

- **Console**: https://console.twilio.com
- **Phone Numbers**: https://console.twilio.com/phone-numbers
- **SMS Logs**: https://console.twilio.com/monitor/logs/sms
- **Usage**: https://console.twilio.com/usage
- **API Keys**: https://console.twilio.com/project/api-keys

---

## ⚙️ **Advanced Features**

### **Custom Sender ID (Alpha Sender):**

In some countries, you can use a custom name instead of a phone number:

```env
TWILIO_FROM_NUMBER=NetroHub
```

**Note:** Not available in all countries. Check Twilio docs.

### **Verify API (Premium):**

Twilio has a dedicated Verify API for OTP:

```php
// Using Twilio Verify (alternative approach)
$response = Http::withBasicAuth($accountSid, $authToken)
    ->asForm()
    ->post("https://verify.twilio.com/v2/Services/{$verifyServiceSid}/Verifications", [
        'To' => $phone,
        'Channel' => 'sms'
    ]);
```

---

## 🚀 **Deployment Steps**

### **1. On Your Local Machine:**

```powershell
git add .
git commit -m "Switched to Twilio SMS for OTP verification"
git push origin main
```

### **2. On Your Server:**

```bash
cd /var/www/netrohub/NetroHub
git pull origin main
```

### **3. Add Twilio Credentials to .env:**

```bash
nano .env
```

Add:
```env
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=your_auth_token_here
TWILIO_FROM_NUMBER=+1234567890
```

### **4. Deploy:**

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan optimize
sudo systemctl restart php8.2-fpm nginx
```

---

## ✅ **Testing**

### **Send OTP:**

```bash
curl -X POST https://netrohub.com/api/otp/send \
  -H "Content-Type: application/json" \
  -d '{"phone":"+966501234567"}'
```

### **Verify OTP:**

```bash
curl -X POST https://netrohub.com/api/otp/verify \
  -H "Content-Type: application/json" \
  -d '{"phone":"+966501234567","code":"123456"}'
```

---

## 🎉 **You're Done!**

Twilio is simpler than MessageBird:
- ✅ No channel setup needed
- ✅ Just 3 credentials (Account SID, Auth Token, Phone Number)
- ✅ Works immediately after setup
- ✅ Great documentation and support

**Get started:** https://www.twilio.com/try-twilio 🚀

