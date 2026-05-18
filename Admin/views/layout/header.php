<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Hub | Control Panel</title>
    <!-- Reset and modern layout styling -->
    <style>
        :root {
            --primary: #2c3e50;
            --accent: #3498db;
            --success: #2ecc71;
            --danger: #e74c3c;
            --bg-light: #f8f9fa;
            --text-dark: #333;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--bg-light); color: var(--text-dark); display: flex; min-height: 100vh; }
        
        /* Sidebar Layout styling */
        .sidebar { width: 260px; background-color: var(--primary); color: #fff; padding: 20px; display: flex; flex-direction: column; flex-shrink: 0; }
        .sidebar h2 { font-size: 20px; margin-bottom: 30px; text-align: center; color: var(--accent); border-bottom: 1px solid #415b76; padding-bottom: 15px; }
        .sidebar a { color: #ecf0f1; text-decoration: none; padding: 12px 15px; border-radius: 4px; margin-bottom: 8px; display: block; transition: all 0.3s ease; }
        .sidebar a:hover, .sidebar a.active { background-color: var(--accent); color: #fff; transform: translateX(5px); }
        .sidebar .logout-btn { background-color: var(--danger); margin-top: auto; text-align: center; }
        .sidebar .logout-btn:hover { background-color: #c0392b; transform: none; }
        
        /* Main Workspace Window Container wrapper */
        .main-wrapper { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        header.top-navbar { background: #fff; height: 60px; padding: 0 30px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .user-profile-badge { display: flex; align-items: center; gap: 10px; }
        .content-body { padding: 30px; flex: 1; }
        
        /* System Messaging Alerts */
        .alert { padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; }
        .alert-danger { background-color: #fde8e8; color: var(--danger); border-left: 4px solid var(--danger); }
        
        /* Data Presentation Tables Formatting Core */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; background: #fff; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background-color: #f1f5f9; color: #475569; font-weight: 600; }
        tr:hover { background-color: #f8fafc; }
    </style>
</head>
<body>

<?php if ($is_logged_in): ?>
    <!-- Active Admin Dashboard Sidebar Navigation Context -->
    <nav class="sidebar">
        <h2>Admin Management</h2>
        <a href="index.php?action=dashboard">📊 Dashboard</a>
        <a href="index.php?action=sellers">🏪 Seller Management</a>
        <a href="index.php?action=categories">📁 Category System</a>
        <a href="index.php?action=products">📦 Product Catalog</a>
        <a href="index.php?action=orders">🛒 Order Tracking</a>
        <a href="index.php?action=coupons">🎫 Coupon Campaigns</a>
        <a href="index.php?action=disputes">⚖️ Dispute Resolutions</a>
        <a href="index.php?action=analytics">📈 Sales Analytics</a>
        <a href="index.php?action=logout" class="logout-btn">🔒 Secure Logout</a>
    </nav>
<?php endif; ?>

<div class="main-wrapper">
    <?php if ($is_logged_in): ?>
        <header class="top-navbar">
            <div class="breadcrumb">Store Management Suite Application Dashboard v3.2</div>
            <div class="user-profile-badge">
                <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?></strong></span>
            </div>
        </header>
    <?php endif; ?>
    
    <!-- Open content body frame layout container element context dynamically -->
    <main class="content-body">
