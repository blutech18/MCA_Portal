<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Login Credentials</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f3f4f6; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); overflow: hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #7a222b 0%, #5a1a20 100%); padding: 30px 20px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 700; letter-spacing: -0.3px;">
                                MCA Montessori School
                            </h1>
                            <p style="margin: 8px 0 0 0; color: rgba(255, 255, 255, 0.95); font-size: 14px;">
                                Student Portal Login Credentials
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px 25px;">
                            
                            <!-- Welcome Message -->
                            <div style="margin-bottom: 20px;">
                                <h2 style="margin: 0 0 10px 0; color: #333; font-size: 18px; font-weight: 600;">
                                    Welcome, {{ $studentName }}!
                                </h2>
                                <p style="margin: 0; color: #555; font-size: 14px; line-height: 1.5;">
                                    Your enrollment has been accepted and your student account has been created. Below are your login credentials.
                                </p>
                            </div>

                            <!-- Credentials Box -->
                            <div style="background: linear-gradient(135deg, #7a222b 0%, #5a1a20 100%); border-radius: 8px; padding: 20px; margin: 20px 0;">
                                <h3 style="margin: 0 0 15px 0; color: white; font-size: 16px; font-weight: 600; text-align: center;">
                                    Login Credentials
                                </h3>
                                
                                <!-- Username -->
                                <div style="background: #ffffff; border-radius: 6px; padding: 15px; margin-bottom: 12px;">
                                    <label style="display: block; font-size: 10px; font-weight: 600; color: #666; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Username
                                    </label>
                                    <div style="background: #f9f1f2; border: 1px dashed #7a222b; border-radius: 4px; padding: 12px; text-align: center;">
                                        <code style="font-size: 16px; font-weight: 700; color: #7a222b; font-family: 'Courier New', monospace; letter-spacing: 1px;">
                                            {{ $username }}
                                        </code>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div style="background: #ffffff; border-radius: 6px; padding: 15px;">
                                    <label style="display: block; font-size: 10px; font-weight: 600; color: #666; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Password
                                    </label>
                                    <div style="background: #f9f1f2; border: 1px dashed #7a222b; border-radius: 4px; padding: 12px; text-align: center;">
                                        <code style="font-size: 16px; font-weight: 700; color: #7a222b; font-family: 'Courier New', monospace; letter-spacing: 1px;">
                                            {{ $password }}
                                        </code>
                                    </div>
                                </div>
                            </div>

                            <!-- Important Instructions -->
                            <div style="background: #f4e9ea; border-left: 3px solid #7a222b; border-radius: 6px; padding: 15px; margin: 20px 0;">
                                <h4 style="margin: 0 0 8px 0; color: #7a222b; font-size: 14px; font-weight: 600;">
                                    Important Instructions:
                                </h4>
                                <ul style="margin: 0; padding-left: 18px; color: #2b0f12; font-size: 13px; line-height: 1.6;">
                                    <li>Keep credentials safe and confidential</li>
                                    <li>Change password on first login</li>
                                    <li>Do not share credentials with anyone</li>
                                    <li>Contact registrar if issues arise</li>
                                </ul>
                            </div>

                            <!-- Login Button -->
                            <div style="text-align: center; margin: 25px 0;">
                                <a href="{{ $loginUrl }}" style="display: inline-block; background: linear-gradient(135deg, #7a222b 0%, #5a1a20 100%); color: #ffffff; text-decoration: none; padding: 14px 35px; border-radius: 6px; font-size: 14px; font-weight: 600; box-shadow: 0 2px 4px rgba(122, 34, 43, 0.3);">
                                    Login to Student Portal
                                </a>
                            </div>

                            <!-- Footer Note -->
                            <div style="border-top: 1px solid #e5e7eb; padding-top: 20px; margin-top: 25px;">
                                <p style="margin: 0; color: #666; font-size: 12px; line-height: 1.5; text-align: center;">
                                    For security reasons, do not share these credentials. If you did not request this account, contact the administration immediately.
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f4e9ea; padding: 20px 25px; text-align: center; border-top: 1px solid #bd8c91;">
                            <p style="margin: 0; color: #5a1a20; font-size: 13px;">
                                <strong>MCA Montessori School</strong><br>
                                Student Portal
                            </p>
                            <p style="margin: 8px 0 0 0; color: #7a222b; font-size: 11px;">
                                This is an automated email. Please do not reply.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
