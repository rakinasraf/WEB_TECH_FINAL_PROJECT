<h2>🛒 Real-Time Order Management System Suite</h2>
<p style="margin-bottom:20px; color:#7f8c8d;">Track fulfillment status parameters and checkout payment verification across Bangladesh.</p>

<div style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
    <table width="100%" cellpadding="10" cellspacing="0">
        <tr style="background:#f8f9fa; text-align:left;">
            <th>Order Ref ID</th>
            <th>Customer Account Profile</th>
            <th>Destination Dropoff Map</th>
            <th>Transaction Channel</th>
            <th>Gross Revenue Matrix</th>
            <th>Tracking Phase Status</th>
        </tr>
        <?php foreach($orders as $ord): ?>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <td><code>#ORD-2026-0<?php echo $ord['id']; ?></code></td>
            <td><b><?php echo htmlspecialchars($ord['customer_name']); ?></b></td>
            <td style="font-size:13px; max-width:250px;"><?php echo htmlspecialchars($ord['shipping_address']); ?></td>
            <td><span style="font-family:monospace; background:#e0f2fe; color:#0369a1; padding:2px 6px; border-radius:4px;"><?php echo htmlspecialchars($ord['payment_method']); ?></span></td>
            <td><strong>৳<?php echo number_format($ord['total_amount'], 2); ?> BDT</strong></td>
            <td>
                <span style="padding:4px 10px; border-radius:20px; font-weight:bold; font-size:12px; background:<?php echo $ord['status'] === 'delivered' ? '#dcfce7;color:#15803d;' : '#fef9c3;color:#a16207;'; ?>">
                    <?php echo strtoupper($ord['status']); ?>
                </span>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>