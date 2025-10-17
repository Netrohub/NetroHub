# 📱 OTP Verification System - Twilio WhatsApp

Complete OTP verification system using Twilio WhatsApp API for NetroHub.

---

## 🚀 **Quick Setup**

### **Step 1: Add Twilio Configuration to .env**

Add these lines to your `.env` file:

```env
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=your_auth_token_here
TWILIO_WHATSAPP_FROM=+14155238886
```

Get your credentials from: https://console.twilio.com

**📌 See `TWILIO_OTP_SETUP.md` for detailed Twilio WhatsApp setup instructions!**

**🎯 Quick Start with Sandbox:**
1. Get Account SID and Auth Token from Twilio Console
2. Use sandbox number: `+14155238886`
3. Join sandbox by sending "join <code>" to sandbox number on WhatsApp
4. Start testing!

### **Step 2: Run Database Migration**

```bash
php artisan migrate
```

This creates the `otp_verifications` table.

### **Step 3: Test the System**

You're ready to go! Use the API endpoints below.

---

## 📡 **API Endpoints**

### **1. Send OTP**

**Endpoint:** `POST /api/otp/send`

**Request:**
```json
{
    "phone": "+966501234567"
}
```

**Success Response (200):**
```json
{
    "success": true,
    "message": "OTP sent successfully to +966501234567",
    "expires_in": 300,
    "otp_code": "123456"  // Only in development
}
```

**Error Response (422):**
```json
{
    "success": false,
    "message": "Invalid phone number format. Use international format: +1234567890",
    "errors": {
        "phone": ["The phone field is required."]
    }
}
```

**Rate Limit Response (429):**
```json
{
    "success": false,
    "message": "Too many OTP requests. Please try again later."
}
```

---

### **2. Verify OTP**

**Endpoint:** `POST /api/otp/verify`

**Request:**
```json
{
    "phone": "+966501234567",
    "code": "123456"
}
```

**Success Response (200):**
```json
{
    "success": true,
    "message": "Phone number verified successfully!",
    "verified_at": "2025-10-17T12:34:56Z"
}
```

**Error Response (401):**
```json
{
    "success": false,
    "message": "Invalid OTP code."
}
```

**Expired Response (401):**
```json
{
    "success": false,
    "message": "OTP has expired. Please request a new one."
}
```

---

### **3. Resend OTP**

**Endpoint:** `POST /api/otp/resend`

**Request:**
```json
{
    "phone": "+966501234567"
}
```

**Response:** Same as Send OTP

---

## 🎯 **Rate Limiting**

- **Send OTP**: 5 requests per minute
- **Verify OTP**: 10 requests per minute
- **Resend OTP**: 3 requests per minute
- **Per Phone**: Maximum 3 OTPs per hour

---

## 💻 **Frontend Integration Examples**

### **Example 1: Vanilla JavaScript**

```html
<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
</head>
<body>
    <h1>Phone Verification</h1>
    
    <!-- Step 1: Enter Phone -->
    <div id="step1">
        <input type="tel" id="phone" placeholder="+966501234567">
        <button onclick="sendOtp()">Send OTP</button>
    </div>
    
    <!-- Step 2: Enter OTP -->
    <div id="step2" style="display:none;">
        <input type="text" id="otp" placeholder="Enter 6-digit code" maxlength="6">
        <button onclick="verifyOtp()">Verify</button>
        <button onclick="resendOtp()">Resend OTP</button>
    </div>
    
    <div id="message"></div>

    <script>
        const API_BASE = 'https://netrohub.com/api/otp';
        let currentPhone = '';

        async function sendOtp() {
            const phone = document.getElementById('phone').value;
            currentPhone = phone;
            
            try {
                const response = await fetch(`${API_BASE}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ phone })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('step1').style.display = 'none';
                    document.getElementById('step2').style.display = 'block';
                    document.getElementById('message').textContent = data.message;
                    
                    // For testing - show OTP in dev
                    if (data.otp_code) {
                        console.log('OTP:', data.otp_code);
                    }
                } else {
                    document.getElementById('message').textContent = data.message;
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('message').textContent = 'Failed to send OTP';
            }
        }

        async function verifyOtp() {
            const code = document.getElementById('otp').value;
            
            try {
                const response = await fetch(`${API_BASE}/verify`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ 
                        phone: currentPhone,
                        code: code
                    })
                });
                
                const data = await response.json();
                document.getElementById('message').textContent = data.message;
                
                if (data.success) {
                    // Redirect or show success
                    alert('✅ Verified successfully!');
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('message').textContent = 'Verification failed';
            }
        }

        async function resendOtp() {
            await sendOtp();
        }
    </script>
</body>
</html>
```

---

### **Example 2: Axios (for Vue/React)**

```javascript
import axios from 'axios';

const API_BASE = 'https://netrohub.com/api/otp';

// Send OTP
export async function sendOtp(phone) {
    try {
        const response = await axios.post(`${API_BASE}/send`, { phone });
        return response.data;
    } catch (error) {
        throw error.response?.data || error;
    }
}

// Verify OTP
export async function verifyOtp(phone, code) {
    try {
        const response = await axios.post(`${API_BASE}/verify`, { phone, code });
        return response.data;
    } catch (error) {
        throw error.response?.data || error;
    }
}

// Resend OTP
export async function resendOtp(phone) {
    try {
        const response = await axios.post(`${API_BASE}/resend`, { phone });
        return response.data;
    } catch (error) {
        throw error.response?.data || error;
    }
}
```

---

### **Example 3: Fetch API (Modern)**

```javascript
const API_BASE = 'https://netrohub.com/api/otp';

async function sendOtp(phone) {
    const response = await fetch(`${API_BASE}/send`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ phone })
    });
    
    return await response.json();
}

async function verifyOtp(phone, code) {
    const response = await fetch(`${API_BASE}/verify`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ phone, code })
    });
    
    return await response.json();
}
```

---

## 🧪 **Testing**

### **Test with cURL:**

**Send OTP:**
```bash
curl -X POST https://netrohub.com/api/otp/send \
  -H "Content-Type: application/json" \
  -d '{"phone":"+966501234567"}'
```

**Verify OTP:**
```bash
curl -X POST https://netrohub.com/api/otp/verify \
  -H "Content-Type: application/json" \
  -d '{"phone":"+966501234567","code":"123456"}'
```

---

## ⚙️ **Configuration**

### **Environment Variables:**

```env
# MessageBird Configuration
MESSAGEBIRD_API_KEY=your_live_or_test_api_key
MESSAGEBIRD_ORIGINATOR=NetroHub

# Optional: For local testing without SMS
APP_ENV=local  # This will return OTP in response
```

---

## 🗄️ **Database Schema**

Table: `otp_verifications`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| phone | string(20) | Phone number |
| otp | string(6) | 6-digit code |
| expires_at | timestamp | Expiry time (5 min) |
| verified | boolean | Verification status |
| verified_at | timestamp | When verified |
| created_at | timestamp | Created timestamp |
| updated_at | timestamp | Updated timestamp |

---

## 🔒 **Security Features**

1. **Rate Limiting**: Max 3 OTPs per phone per hour
2. **Expiry**: OTPs expire after 5 minutes
3. **One-time Use**: OTPs can't be reused after verification
4. **Throttling**: API endpoints have request limits
5. **Validation**: Phone number format validation
6. **Logging**: All OTP operations are logged

---

## 🛠️ **Maintenance**

### **Clean Up Expired OTPs (Cron Job)**

Add to `routes/console.php`:

```php
Schedule::call(function () {
    app(\App\Http\Controllers\OtpVerificationController::class)->cleanupExpiredOtps();
})->daily();
```

Or run manually:

```bash
php artisan schedule:run
```

---

## 📞 **MessageBird Setup**

1. Sign up at https://messagebird.com
2. Get your API key from Dashboard
3. Add credits to your account
4. Test with the Test API key first
5. Switch to Live API key for production

**Test API Key:** Doesn't send real SMS but validates API calls
**Live API Key:** Sends actual SMS (costs money)

---

## ✅ **Deployment Checklist**

- [ ] Add `MESSAGEBIRD_API_KEY` to production `.env`
- [ ] Run migrations on production
- [ ] Test OTP send endpoint
- [ ] Test OTP verify endpoint
- [ ] Check logs for errors
- [ ] Set up cron job for cleanup
- [ ] Monitor SMS credits

---

## 🎉 **You're Done!**

Your OTP verification system is ready to use. Send a test SMS to verify everything works correctly!

