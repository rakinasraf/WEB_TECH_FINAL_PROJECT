<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gateway Authentication Panel | Admin Console</title>
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #3498db;
            --danger: #e74c3c;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { background: linear-gradient(135deg, #1abc9c, #2c3e50); display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        
        .login-card { background: #ffffff; width: 100%; max-width: 420px; padding: 40px; border-radius: 10px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
        .login-card h2 { text-align: center; color: var(--primary); font-size: 26px; margin-bottom: 8px; }
        .login-card p { text-align: center; color: #7f8c8d; font-size: 14px; margin-bottom: 30px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #34495e; font-size: 14px; font-weight: 600; }
        .form-control { width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; border-radius: 6px; font-size: 15px; transition: border-color 0.3s ease; }
        .form-control:focus { outline: none; border-color: var(--accent); }
        
        .btn-submit { width: 100%; background-color: var(--accent); color: #fff; padding: 12px; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background-color 0.3s ease; margin-top: 10px; }
        .btn-submit:hover { background-color: #2980b9; }
        
        .alert { background-color: #fde8e8; color: var(--danger); border-left: 4px solid var(--danger); padding: 12px; border-radius: 4px; font-size: 14px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Admin Gateway</h2>
    <p>Please log in to manage marketplace systems.</p>

    <!-- Error Alert Messaging Banner output dynamically inside AuthController validation context loops -->
    <?php if (isset($error) && !empty($error)): ?>
        <div class="alert">
            ❌ <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?action=login" method="POST" autocomplete="off">
        <div class="form-group">
            <label for="email">Administrator Email Registered Account</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="admin@ecommerce.com" required>
        </div>
        
        <div class="form-group">
            <label for="password">Security Account Key Phrase</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        
        <button type="submit" class="btn-submit">Authenticate Securely</button>
    </form>
</div>

</body>
</html>