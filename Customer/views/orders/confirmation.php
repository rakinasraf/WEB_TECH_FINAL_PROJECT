<?php include "views/layout/header.php"; ?>

<div class="card" style="text-align:center;">
    <h2 style="margin-bottom:10px;">Order Confirmed</h2>
    <p style="color:#555; margin-bottom:15px;">Your order has been placed successfully.</p>
    <p style="font-size:18px; font-weight:bold;">Order #<?= htmlspecialchars($order['order_number'] ?? $order['id']) ?></p>
    <p style="margin-top:8px;">Total: <strong>৳<?= number_format($order['total_amount'], 2) ?></strong></p>

    <div style="margin-top:18px;">
        <a href="index.php?action=order_detail&id=<?= $order['id'] ?>" class="btn btn-primary">View Order</a>
        <a href="index.php?action=products" class="btn btn-secondary">Continue Shopping</a>
    </div>
</div>

<div class="grid-2" style="align-items:start;">
    <div class="card">
        <h3>Shipping To</h3>
        <p style="font-size:14px; line-height:1.7;">
            <?= htmlspecialchars($order['shipping_name'] ?? '') ?><br>
            <?= htmlspecialchars($order['shipping_phone'] ?? '') ?><br>
            <?= nl2br(htmlspecialchars($order['shipping_address'] ?? '')) ?><br>
            <?= htmlspecialchars($order['shipping_city'] ?? '') ?><br>
            Zone: <?= htmlspecialchars($order['delivery_zone_name'] ?? 'Not selected') ?>
        </p>
    </div>

    <div class="card">
        <h3>Items</h3>
        <?php foreach ($items as $item): ?>
            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee; font-size:14px;">
                <span><?= htmlspecialchars($item['product_name']) ?> x <?= $item['quantity'] ?></span>
                <strong>৳<?= number_format($item['line_total'], 2) ?></strong>
            </div>
        <?php endforeach; ?>
        <div style="display:flex; justify-content:space-between; padding-top:10px; font-size:14px;">
            <span>Delivery Fee</span>
            <strong>৳<?= number_format($order['delivery_fee'], 2) ?></strong>
        </div>
        <?php if ($order['discount_amount'] > 0): ?>
        <div style="display:flex; justify-content:space-between; padding-top:10px; font-size:14px; color:green;">
            <span>Discount</span>
            <strong>-৳<?= number_format($order['discount_amount'], 2) ?></strong>
        </div>
        <?php endif; ?>
        <div style="display:flex; justify-content:space-between; padding-top:10px; font-size:16px; font-weight:bold;">
            <span>Total</span>
            <span>৳<?= number_format($order['total_amount'], 2) ?></span>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>
