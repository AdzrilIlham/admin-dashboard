<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 20px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #667eea;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            color: #333;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }
        .message-box {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            margin-top: 10px;
            white-space: pre-wrap;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 New Contact Form Submission</h1>
        </div>
        
        <div class="content">
            <p>You have received a new message from your portfolio website:</p>
            
            <div class="field">
                <span class="label">👤 Name:</span>
                <div class="value">{{ $contactName }}</div>
            </div>
            
            <div class="field">
                <span class="label">📧 Email:</span>
                <div class="value">{{ $contactEmail }}</div>
            </div>
            
            <div class="field">
                <span class="label">📝 Subject:</span>
                <div class="value">{{ $contactSubject }}</div>
            </div>
            
            <div class="field">
                <span class="label">💬 Message:</span>
                <div class="message-box">{{ $contactMessage }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p>This email was sent from your portfolio contact form</p>
            <p>© {{ date('Y') }} Portfolio Website. All rights reserved.</p>
        </div>
    </div>
</body>
</html>