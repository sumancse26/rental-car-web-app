<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                color: #333;
            }

            .email-container {
                width: 100%;
                padding: 20px;
                background-color: #f4f4f4;
            }

            .email-content {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .header {
                text-align: center;
                border-bottom: 1px solid #eeeeee;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }

            .header h1 {
                font-size: 24px;
                color: #333333;
            }

            .content {
                text-align: center;
            }

            .content p {
                font-size: 16px;
                margin: 20px 0;
                line-height: 1.5;
                color: #555555;
            }

            .otp-code {
                font-size: 28px;
                font-weight: bold;
                color: #333333;
                background-color: #f7f7f7;
                padding: 10px 20px;
                border-radius: 5px;
                display: inline-block;
                margin: 20px 0;
                letter-spacing: 2px;
            }

            .footer {
                text-align: center;
                margin-top: 30px;
                color: #999999;
                font-size: 14px;
            }
        </style>
    </head>

    <body>
        <div class="email-container">
            <div class="email-content">
                <div class="header">
                    <h1>[Your Service Name]</h1>
                </div>
                <div class="content">
                    <p>Dear {{ $name }},</p>
                    <p>We received a request to verify your identity. Please use the One-Time Password (OTP) below to
                        proceed:</p>
                    <div class="otp-code">{{ $otp }}</div>
                    <p>This code is valid for the next 10 minutes.</p>
                    <p>If you did not request this, please ignore this email or contact our support team.</p>
                </div>
                <div class="footer">
                    <p>Thank you for using [Your Service Name]!</p>
                    <p>[Company Address or Contact Information]</p>
                </div>
            </div>
        </div>
    </body>

</html>
