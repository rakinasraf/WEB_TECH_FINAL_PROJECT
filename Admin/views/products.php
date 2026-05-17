<h2>📦 Central Inventory Monitor Database Matrix</h2>
<p style="margin-bottom:20px; color:#7f8c8d;">A comprehensive overview of third-party product items listed on the platform.</p>

<div style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
    <table width="100%" cellpadding="10" cellspacing="0">
        <tr style="background:#f8f9fa; text-align:left;">
            <th>Product Identity Target</th>
            <th>Fulfillment Store Origin</th>
            <th>Assigned Node Group</th>
            <th>Consumer Price Unit</th>
            <th>Stock Allocations</th>
            <th>Availability Platform Flag</th>
        </tr>
        <?php foreach($products as $prod): ?>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <td><strong><?php echo htmlspecialchars($prod['name']); ?></strong></td>
            <td><?php echo htmlspecialchars($prod['shop_name']); ?></td>
            <td><small><?php echo htmlspecialchars($prod['category_name']); ?></small></td>
            <td><strong>৳<?php echo number_format($prod['price'], 2); ?> BDT</strong></td>
            <td><code><?php echo $prod['stock_qty']; ?> Pcs</code></td>
            <td><?php echo $prod['is_available'] ? '<b style="color:green;">Live</b>' : '<b style="color:red;">Suppressed</b>'; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>