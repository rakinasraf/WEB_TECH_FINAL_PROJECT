<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Commerce Store</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #333;
        }

        /* NAV */
        nav {
            background: #222;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 55px;
        }
        nav .brand {
            color: #fff;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
        }
        nav .brand span { color: #007bff; }
        nav .nav-links a {
            color: #ccc;
            text-decoration: none;
            margin-left: 15px;
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 4px;
        }
        nav .nav-links a:hover { background: #333; color: #fff; }
        nav .nav-links .btn-nav {
            background: #007bff;
            color: #fff;
        }
        nav .nav-links .btn-nav:hover { background: #0056b3; }
        .cart-count {
            background: #ff4444;
            color: #fff;
            border-radius: 10px;
            font-size: 11px;
            padding: 1px 6px;
            margin-left: 3px;
        }

        
        .wrapper { max-width: 1100px; margin: 30px auto; padding: 0 20px; }

        
        .alert {
            padding: 12px 16px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error   { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        
        .btn {
            display: inline-block;
            padding: 8px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-family: Arial, sans-serif;
            text-decoration: none;
        }
        .btn-primary  { background: #007bff; color: #fff; }
        .btn-primary:hover  { background: #0056b3; }
        .btn-danger   { background: #dc3545; color: #fff; }
        .btn-danger:hover   { background: #bd2130; }
        .btn-secondary { background: #6c757d; color: #fff; }
        .btn-secondary:hover { background: #545b62; }
        .btn-success  { background: #28a745; color: #fff; }
        .btn-success:hover  { background: #1e7e34; }
        .btn-sm { padding: 5px 12px; font-size: 13px; }

       
        label { display: block; font-size: 13px; margin-bottom: 4px; color: #555; font-weight: bold; }
        input[type=text], input[type=email], input[type=password],
        input[type=number], input[type=tel], select, textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #007bff;
        }
        .error { color: red; font-size: 12px; margin-top: 3px; display: block; }
        .form-group { margin-bottom: 15px; }

       
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 6px; overflow: hidden; }
        th { background: #007bff; color: #fff; padding: 10px 14px; text-align: left; font-size: 13px; }
        td { padding: 10px 14px; border-bottom: 1px solid #eee; font-size: 14px; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f9f9f9; }

        
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 20px;
        }
        .card h3 { margin-bottom: 15px; font-size: 17px; border-bottom: 2px solid #007bff; padding-bottom: 8px; }

        
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-pending    { background: #fff3cd; color: #856404; }
        .badge-processing { background: #cce5ff; color: #004085; }
        .badge-shipped    { background: #d4edda; color: #155724; }
        .badge-delivered  { background: #d4edda; color: #155724; }
        .badge-cancelled  { background: #f8d7da; color: #721c24; }

        
        .grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media(max-width:768px) {
            .grid-3, .grid-2 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php" class="brand">Shop<span>Zone</span></a>
    <div class="nav-links">
        <a href="index.php?action=products">Products</a>
        <?php if (isset($_SESSION['user'])): ?>
            <?php $cartTotal = array_sum($_SESSION['cart'] ?? []); ?>
            <a href="index.php?action=cart">
                🛒 Cart <?php if ($cartTotal): ?><span class="cart-count"><?= $cartTotal ?></span><?php endif; ?>
            </a>
            <a href="index.php?action=wishlist">♡ Wishlist</a>
            <a href="index.php?action=order_history">Orders</a>
            <a href="index.php?action=dashboard">Hi, <?= htmlspecialchars($_SESSION['user']['name']) ?></a>
            <form action="index.php?action=logout" method="POST" style="display:inline;">
                <button type="submit" class="btn-nav" style="border:none; cursor:pointer; margin-left:15px; padding:6px 12px; border-radius:4px;">
                    Logout
                </button>
            </form>
        <?php else: ?>
            <a href="index.php?action=login">Login</a>
            <a href="index.php?action=register" class="btn-nav">Register</a>
        <?php endif; ?>
    </div>
</nav>

<div class="wrapper">

<?php

if (!empty($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
    unset($_SESSION['success']);
}
if (!empty($_SESSION['error'])) {
    echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}
?>
