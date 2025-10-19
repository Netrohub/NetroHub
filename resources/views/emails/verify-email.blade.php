<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - NXO</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #0f1318; color: #e5e7eb;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #0f1318; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #1a1f2e; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 900;">Welcome to NXO!</h1>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #e5e7eb; font-size: 16px; line-height: 1.6;">
                                Hi <strong>{{ $user->name ?? 'there' }}</strong>,
                            </p>
                            
                            <p style="margin: 0 0 20px; color: #9ca3af; font-size: 15px; line-height: 1.6;">
                                Thank you for creating an account with NXO. To get started, please verify your email address by clicking the button below:
                            </p>
                            
                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $verificationUrl }}" style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 700; border-radius: 12px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                            Verify Email Address
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 20px 0; color: #9ca3af; font-size: 14px; line-height: 1.6;">
                                This link will expire in <strong>60 minutes</strong> for security reasons.
                            </p>
                            
                            <p style="margin: 20px 0; color: #9ca3af; font-size: 14px; line-height: 1.6;">
                                If you did not create an account, no further action is required.
                            </p>
                            
                            <!-- Alternative Link -->
                            <div style="margin: 30px 0; padding: 20px; background-color: #0f1318; border-radius: 8px;">
                                <p style="margin: 0 0 10px; color: #9ca3af; font-size: 13px;">
                                    If the button doesn't work, copy and paste this link into your browser:
                                </p>
                                <p style="margin: 0; color: #667eea; font-size: 12px; word-break: break-all;">
                                    {{ $verificationUrl }}
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px; background-color: #0f1318; text-align: center; border-top: 1px solid #2d3748;">
                            <p style="margin: 0 0 10px; color: #6b7280; font-size: 13px;">
                                © {{ now()->year }} NXO. All rights reserved.
                            </p>
                            <p style="margin: 0; color: #6b7280; font-size: 12px;">
                                Empowering gamers worldwide.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>


