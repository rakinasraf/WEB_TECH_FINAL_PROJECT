<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard Marketplace Panel</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .dashboard-grid { display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); min-width: 220px; }
        .btn-approve { background-color: #28a745; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 4px; font-weight: bold; }
        .btn-approve:hover { background-color: #218838; }
        .no-sellers { color: #7f8c8d; font-style: italic; }
    </style>
</head>
<body>
    <h2>Admin Dashboard Overview</h2>
    <p style="color: #7f8c8d; margin-bottom: 25px;">Welcome back, <?php echo htmlspecialchars($_SESSION['admin_name']); ?> | <a href="index.php?action=logout" style="color: #e74c3c; text-decoration: none; font-weight: 600;">Logout Securely</a></p>
    
    <div class="dashboard-grid">
        <div class="card">
            <h3>Registered Users Breakdown</h3>
            <p style="margin-top: 10px;">Customers: <strong><?php echo $userStats['customer']; ?></strong></p>
            <p>Sellers: <strong><?php echo $userStats['seller']; ?></strong></p>
            <p>Delivery Managers: <strong><?php echo $userStats['delivery_manager']; ?></strong></p>
        </div>
        <div class="card">
            <h3>Financial Metrics</h3>
            <p style="margin-top: 10px;">Gross Merchandise Value: <strong>৳<?php echo number_format($revenueStats['gv'] ?? 0, 2); ?> BDT</strong></p>
            <p>Platform Commission: <strong>৳<?php echo number_format($revenueStats['platform_commission'] ?? 0, 2); ?> BDT</strong></p>
        </div>
    </div>

    <!-- Cleaned Headline Entry -->
    <h3 style="margin-bottom: 15px; color: #2c3e50;">Seller Verification</h3>
    
    <table border="0" cellpadding="12" cellspacing="0" style="background:#fff; width:100%; max-width:700px; border-collapse: collapse; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <tr style="background:#eee; text-align: left; color: #4fa3b8;">
            <th>Seller Store Name</th>
            <th>Action</th>
        </tr>
        
        <?php 
        // Filter down to show ONLY unapproved merchants dynamically
        $unapprovedSellers = array_filter($unapprovedSellers ?? [], function($s) {
            return (int)$s['is_approved'] === 0;
        });
        
        if (!empty($unapprovedSellers)): 
            foreach ($unapprovedSellers as $seller): 
        ?>
            <tr style="border-bottom: 1px solid #e2e8f0;">
                <td><strong><?php echo htmlspecialchars($seller['shop_name']); ?></strong></td>
                <td><button class="btn-approve" onclick="approveSeller(<?php echo $seller['id']; ?>, this)">Approve Instantly</button></td>
            </tr>
        <?php 
            endforeach; 
        else: 
        ?>
            <tr>
                <td colspan="2" class="no-sellers" style="text-align: center; padding: 20px;">No pending sellers require verification. All stores active.</td>
            </tr>
        <?php endif; ?>
    </table>

    <script>
    function approveSeller(sellerId, buttonElement) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "index.php?action=approve_seller_ajax", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        buttonElement.parentElement.innerHTML = '<span style="color: #2ecc71; font-weight: bold;">✓ Approved Successfully</span>';
                    } else {
                        alert("Error: " + response.message);
                    }
                } catch(e) {
                    alert("System tracking runtime layout failure parser error.");
                }
            }
        };
        xhr.send("id=" + sellerId);
    }
    </script>
</body>
</html>