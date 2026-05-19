<h2>🎫 Coupon Campaign Management</h2>
<p style="margin-bottom:20px; color:#7f8c8d;">.</p>

<?php if(isset($_GET['msg'])): ?>
    <?php if($_GET['msg'] === 'added'): ?>
        <div style="padding: 12px; background: #dcfce7; color: #15803d; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">✓ Promotional campaign tracking code initialized successfully.</div>
    <?php elseif($_GET['msg'] === 'deleted'): ?>
        <div style="padding: 12px; background: #fee2e2; color: #991b1b; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">✓ Voucher code dropped and flushed from databank instances safely.</div>
    <?php elseif($_GET['msg'] === 'error'): ?>
        <div style="padding: 12px; background: #fef9c3; color: #854d0e; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">⚠ Error validating processing request configuration parameters.</div>
    <?php endif; ?>
<?php endif; ?>

<details style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.05); margin-bottom:30px;" <?php echo (isset($_GET['msg']) && $_GET['msg'] === 'error') ? 'open' : ''; ?>>
    <summary style="font-weight:bold; color:var(--accent); cursor:pointer; outline:none; font-size:16px;">➕ Generate New Discount Coupon</summary>
    <form action="index.php?action=add_coupon" method="POST" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:15px; margin-top:20px;">
        <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">Coupon Format Code</label>
            <input type="text" name="code" required placeholder="E.g., BANGLA10" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-size:14px; text-transform:uppercase;">
        </div>
        <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">Discount Percentage (%)</label>
            <input type="number" step="0.01" min="1" max="100" name="discount_pct" required placeholder="10.00" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-size:14px;">
        </div>
        <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">Max Permitted Uses</label>
            <input type="number" min="1" name="max_uses" required placeholder="500" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-size:14px;">
        </div>
        <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">Campaign Expiry Target Date</label>
            <input type="date" name="valid_until" required min="<?php echo date('Y-m-d'); ?>" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-size:14px;">
        </div>
        <div style="grid-column: span 2;">
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">Scope Domain Assignment (Optional)</label>
            <select name="seller_id" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-size:14px; background:#fff;">
                <option value="">Global Marketplace Voucher (All Stores)</option>
                <?php if(!empty($sellers)): ?>
                    <?php foreach($sellers as $seller): ?>
                        <option value="<?php echo $seller['id']; ?>">Exclusive to: <?php echo htmlspecialchars($seller['shop_name']); ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div style="grid-column: 1 / -1; text-align:right; margin-top:5px;">
            <button type="submit" style="background:var(--success); color:white; border:none; padding:12px 24px; border-radius:4px; font-weight:bold; cursor:pointer; font-size:14px;">Inject Promotional Code</button>
        </div>
    </form>
</details>

<table>
    <thead>
        <tr style="background:#f1f5f9; text-align:left; color:#475569;">
            <th>Promo Code</th>
            <th>Voucher Affiliation Scope</th>
            <th>Markdown Ratio</th>
            <th>Redemption Frequency</th>
            <th>Expiration Timeline</th>
            <th style="text-align:center;">Workspace Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($coupons)): ?>
            <?php foreach($coupons as $coupon): ?>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td><strong style="font-family:monospace; font-size:16px; background:#f1f5f9; padding:4px 8px; border-radius:4px; color:#1e293b; border:1px dashed #cbd5e1;"><?php echo htmlspecialchars($coupon['code']); ?></strong></td>
                <td>
                    <?php if(!empty($coupon['shop_name'])): ?>
                        <span style="color:#4338ca; font-weight:600;">🏪 <?php echo htmlspecialchars($coupon['shop_name']); ?></span>
                    <?php else: ?>
                        <span style="color:#15803d; font-weight:600;">🌍 Platform Global Link</span>
                    <?php endif; ?>
                </td>
                <td><strong style="color:var(--success); font-size:15px;"><?php echo htmlspecialchars($coupon['discount_pct']); ?>% OFF</strong></td>
                <td>
                    <div style="font-size:13px; font-weight:500; color:#475569;">
                        <?php echo $coupon['uses_count']; ?> / <?php echo $coupon['max_uses']; ?> Redemptions
                    </div>
                    <div style="width:100%; max-width:140px; background:#e2e8f0; height:6px; border-radius:3px; margin-top:4px; overflow:hidden;">
                        <?php 
                            $pct = ($coupon['max_uses'] > 0) ? ($coupon['uses_count'] / $coupon['max_uses']) * 100 : 0;
                            $barColor = $pct >= 100 ? 'var(--danger)' : 'var(--accent)';
                        ?>
                        <div style="width:<?php echo min($pct, 100); ?>%; background:<?php echo $barColor; ?>; height:100%;"></div>
                    </div>
                </td>
                <td>
                    <?php 
                        $isExpired = strtotime($coupon['valid_until']) < time();
                    ?>
                    <span style="font-size:13px; font-weight:600; color: <?php echo $isExpired ? 'var(--danger)' : '#475569'; ?>;">
                        📅 <?php echo date("d M, Y", strtotime($coupon['valid_until'])); ?>
                        <?php echo $isExpired ? ' (Expired)' : ''; ?>
                    </span>
                </td>
                <td style="text-align:center;">
                    <a href="index.php?action=delete_coupon&id=<?php echo $coupon['id']; ?>" 
                       onclick="return confirm('Are you sure you want to completely erase this coupon rule? This action cannot be undone.');" 
                       style="color: var(--danger); text-decoration: none; font-weight: bold; font-size: 13px; padding: 6px 12px; border: 1px solid var(--danger); border-radius: 4px; background: #fffdfd; display: inline-block; transition: all 0.2s;">
                       🗑 Delete
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center; color:#7f8c8d; padding:30px; font-style:italic;">No active promotion codes registered across database configurations.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>