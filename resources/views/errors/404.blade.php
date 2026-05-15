<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #E8621A;
            --dark: #1A0A00;
            --gray: #6B7280;
            --bg: #F9FAFB;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            color: var(--dark);
        }
        .container {
            max-width: 500px;
            padding: 40px;
        }
        .error-code {
            font-size: 100px;
            font-weight: 800;
            color: var(--primary);
            margin: 0;
            letter-spacing: -2px;
        }
        .message {
            font-size: 24px;
            font-weight: 600;
            margin: 10px 0;
            color: var(--dark);
        }
        .sub-message {
            font-size: 16px;
            color: var(--gray);
            margin-bottom: 40px;
            line-height: 1.5;
        }
        .redirect-status {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            color: var(--primary);
            background: white;
            padding: 12px 24px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(232, 98, 26, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        
        .btn-home {
            display: inline-block;
            margin-top: 24px;
            color: var(--gray);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }
        .btn-home:hover {
            color: var(--primary);
        }
    </style>
    <meta http-equiv="refresh" content="3;url=/">
</head>
<body>
    <div class="container">
        <div class="error-code">404</div>
        <div class="message">Page Not Found</div>
        <div class="sub-message">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</div>
        
        <div class="redirect-status">
            <div class="spinner"></div>
            Redirecting to homepage...
        </div>

        <a href="/" class="btn-home">Or click here to return manually</a>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "/";
        }, 3000);
    </script>
</body>
</html>
