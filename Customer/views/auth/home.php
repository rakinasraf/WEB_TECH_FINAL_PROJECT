<!DOCTYPE html>
<html>
<head>
    <title>E-Commerce Store</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .box {
            background: white;
            padding: 50px 40px;
            text-align: center;
            border-radius: 15px;
            width: 420px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        h1 { margin-bottom: 10px; font-size: 24px; }
        p  { color: #555; margin-bottom: 30px; font-size: 15px; line-height: 1.5; }
        .btns a {
            display: inline-block;
            margin: 8px;
            padding: 12px 24px;
            text-decoration: none;
            color: white;
            background: #007bff;
            border-radius: 5px;
            font-size: 15px;
        }
        .btns a:hover { background: #0056b3; }
        .btns a.outline {
            background: transparent;
            border: 2px solid #007bff;
            color: #007bff;
        }
        .btns a.outline:hover { background: #007bff; color: white; }
        .features {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .feat { font-size: 12px; color: #888; text-align: center; }
        .feat span { display: block; font-size: 22px; margin-bottom: 5px; }
    </style>
</head>
<body>

    <div class="box">
        <h1>Welcome To E-Commerce Store</h1>
        <p>Discover products across multiple sellers, shop easily, and enjoy a seamless online shopping experience.</p>
        <div class="btns">
            <a href="index.php?action=login">Login</a>
            <a href="index.php?action=register" class="outline">Register</a>
        </div>
        <div class="features">
            <div class="feat"><span>🛍️</span>Shop</div>
            <div class="feat"><span>🚚</span>Track</div>
            <div class="feat"><span>⭐</span>Review</div>
            <div class="feat"><span>♡</span>Wishlist</div>
        </div>
    </div>

    <p style="color:white; margin-top:20px; font-size:13px;">
        Just browsing? <a href="index.php?action=products" style="color:white; font-weight:bold;">View Products</a>
    </p>

</body>
</html>
