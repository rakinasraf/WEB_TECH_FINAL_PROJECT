<h2>🎫 Promotional Code Markdown Registry</h2>
<p style="margin-bottom:20px; color:#7f8c8d;">Platform-wide marketing discount tokens issued dynamically.</p>

<div style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
    <table width="100%" cellpadding="10" cellspacing="0">
        <tr style="background:#f8f9fa; text-align:left;">
            <th>Promo Verification Token</th>
            <th>Authorized Merchant Shop</th>
            <th>Discount Value Matrix</th>
            <th>Usage Capacity Bounds</th>
            <th>Calendar Limit Horizon</th>
        </tr>
        <?php foreach($coupons as $cp): ?>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <td><strong style="color:#2563eb; background:#eff6ff; padding:4px 8px; border-radius:4px; font-family:monospace;"><?php echo htmlspecialchars($cp['code']); ?></strong></td>
            <td><?php echo htmlspecialchars($cp['shop_name']); ?></td>
            <td><b style="color:#e11d48;"><?php echo $cp['discount_pct']; ?>% OFF</b></td>
            <td><code><?php echo $cp['uses_count']; ?></code> / <code><?php echo $cp['max_uses']; ?> Redemptions</code></td>
            <td><small><?php echo $cp['valid_until']; ?></small></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>