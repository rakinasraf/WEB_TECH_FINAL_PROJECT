<?php
include "views/layout/header.php";
require_once "models/Order.php";

$orderModel = new Order($conn);
$orders     = $orderModel->getByUser($_SESSION['user']['id']);
$total      = count($orders);
$delivered  = count(array_filter($orders, fn($o) => $o['status'] === 'delivered'));
$pending    = count(array_filter($orders, fn($o) => $o['status'] === 'pending'));
?>

<h2>Dashboard</h2>
<p style="color:#666; margin-bottom:20px;">Welcome back, <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong>!</p>

<!-- Stats -->
<div class="grid-3" style="margin-bottom:25px;">
    <div class="card" style="text-align:center; padding:25px;">
        <div style="font-size:32px; font-weight:bold; color:#007bff;"><?= $total ?></div>
        <div style="color:#666; margin-top:5px;">Total Orders</div>
    </div>
    <div class="card" style="text-align:center; padding:25px;">
        <div style="font-size:32px; font-weight:bold; color:#28a745;"><?= $delivered ?></div>
        <div style="color:#666; margin-top:5px;">Delivered</div>
    </div>
    <div class="card" style="text-align:center; padding:25px;">
        <div style="font-size:32px; font-weight:bold; color:#ffc107;"><?= $pending ?></div>
        <div style="color:#666; margin-top:5px;">Pending</div>
    </div>
</div>


<div class="card">
    <h3>Quick Links</h3>
    <div style="display:flex; flex-wrap:wrap; gap:10px;">
        <a href="index.php?action=products"      class="btn btn-primary">🛍️ Browse Products</a>
        <a href="index.php?action=cart"           class="btn btn-secondary">🛒 My Cart</a>
        <a href="index.php?action=wishlist"       class="btn btn-secondary">♡ Wishlist</a>
        <a href="index.php?action=order_history"  class="btn btn-secondary">📦 Order History</a>
        <a href="index.php?action=addresses"      class="btn btn-secondary">Addresses</a>
        <a href="index.php?action=disputes"       class="btn btn-secondary">Disputes</a>
        <a href="index.php?action=profile"        class="btn btn-secondary">👤 My Profile</a>
    </div>
</div>


<?php if ($orders): ?>
<div class="card">
    <h3>Recent Orders</h3>
    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (array_slice($orders, 0, 5) as $o): ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                <td><strong>৳<?= number_format($o['total_amount'], 2) ?></strong></td>
                <td><span class="badge badge-<?= $o['status'] ?>"><?= $o['status'] ?></span></td>
                <td><a href="index.php?action=order_detail&id=<?= $o['id'] ?>" class="btn btn-sm btn-secondary">View</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($total > 5): ?>
    <p style="text-align:center; margin-top:12px;">
        <a href="index.php?action=order_history">View all <?= $total ?> orders &rarr;</a>
    </p>
    <?php endif; ?>
</div>
<?php else: ?>
<div class="card" style="text-align:center; color:#888; padding:40px;">
    No orders yet. <a href="index.php?action=products">Start shopping!</a>
</div>
<?php endif; ?>

<?php include "views/layout/footer.php"; ?>
