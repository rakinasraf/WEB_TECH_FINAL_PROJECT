<h2>🏪 Merchant Portfolio Ecosystem & Operations</h2>
<p style="margin-bottom:20px; color:#7f8c8d;">.</p>

<?php if(isset($_GET['msg'])): ?>
    <?php if($_GET['msg'] === 'added'): ?>
        <div style="padding: 12px; background: #dcfce7; color: #15803d; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">✓ Merchant profile initialized and verified securely.</div>
    <?php elseif($_GET['msg'] === 'deleted'): ?>
        <div style="padding: 12px; background: #fee2e2; color: #991b1b; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">✓ Merchant workspace deactivated and archived from execution logs successfully.</div>
    <?php elseif($_GET['msg'] === 'error'): ?>
        <div style="padding: 12px; background: #fef9c3; color: #854d0e; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">⚠ Operation execution parameters failed validation criteria.</div>
    <?php endif; ?>
<?php endif; ?>

<details style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.05); margin-bottom:30px;" <?php echo (isset($_GET['msg']) && $_GET['msg'] === 'error') ? 'open' : ''; ?>>
    <summary style="font-weight:bold; color:var(--accent); cursor:pointer; outline:none; font-size:16px;">➕ Register New Vendor Storefront Manually</summary>
    <form action="index.php?action=add_seller" method="POST" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:15px; margin-top:20px;">
        <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">Representative Full Name</label>
            <input type="text" name="name" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-size:14px;">
        </div>
        <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">Account Email Address</label>
            <input type="email" name="email" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-size:14px;">
        </div>
        <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">Security Gateway Password</label>
            <input type="password" name="password" required placeholder="Min 8 characters" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-size:14px;">
        </div>
        <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">Primary Phone Number</label>
            <input type="text" name="phone" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-size:14px;">
        </div>
        <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">Public Storefront Title</label>
            <input type="text" name="shop_name" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-size:14px;">
        </div>
        <div>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">System Commission Split (%)</label>
            <input type="number" step="0.01" name="commission_rate" value="5.00" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-size:14px;">
        </div>
        <div style="grid-column: 1 / -1;">
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:5px; color:#475569;">Physical Fulfillment Address Location</label>
            <textarea name="address" rows="2" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px; font-family:inherit; font-size:14px; resize:vertical;"></textarea>
        </div>
        <div style="grid-column: 1 / -1; text-align:right;">
            <button type="submit" style="background:var(--success); color:white; border:none; padding:12px 24px; border-radius:4px; font-weight:bold; cursor:pointer; font-size:14px; transition:background 0.2s;">Initialize Merchant Entity</button>
        </div>
    </form>
</details>

<table>
    <thead>
        <tr style="background:#f1f5f9; text-align:left; color:#475569;">
            <th>Shop Profile Name</th>
            <th>Merchant Representative</th>
            <th>Physical Address Location</th>
            <th>Commission Rate</th>
            <th>Status Verification</th>
            <th style="text-align:center;">Workspace Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($sellers)): ?>
            <?php foreach($sellers as $seller): ?>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td><strong><?php echo htmlspecialchars($seller['shop_name']); ?></strong></td>
                <td>
                    <?php echo htmlspecialchars($seller['owner_name']); ?><br>
                    <span style="font-size:12px; color:#94a3b8;"><?php echo htmlspecialchars($seller['owner_email']); ?></span>
                </td>
                <td><?php echo htmlspecialchars($seller['address'] ?? 'Not Specified'); ?></td>
                <td><code><?php echo htmlspecialchars($seller['commission_rate']); ?>%</code></td>
                <td>
                    <?php if((int)$seller['is_approved'] === 1): ?>
                        <span style="color: var(--success); font-weight: bold;">✓ Active Verified</span>
                    <?php else: ?>
                        <button style="background: var(--accent); color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight:600;" onclick="approveSeller(<?php echo $seller['id']; ?>, this)">Approve Shop</button>
                    <?php endif; ?>
                </td>
                <td style="text-align:center;">
                    <a href="index.php?action=delete_seller&id=<?php echo $seller['id']; ?>" 
                       onclick="return confirm('Archiving this merchant profile will immediately disconnect active interfaces and suppress product storefront displays. Proceed?');" 
                       style="color: var(--danger); text-decoration: none; font-weight: bold; font-size: 13px; padding: 6px 12px; border: 1px solid var(--danger); border-radius: 4px; background: #fffdfd; display: inline-block; transition: all 0.2s;">
                       Deactivate Account
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center; color:#7f8c8d; padding:30px; font-style:italic;">No operational merchant profiles loaded in system records.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
function approveSeller(id, btn) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php?action=approve_seller_ajax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.success) { 
                    btn.parentElement.innerHTML = '<span style="color: var(--success); font-weight: bold;">✓ Active Verified</span>'; 
                }
            } catch(e) { console.error("AJAX validation response runtime parser failure exception."); }
        }
    };
    xhr.send("id=" + id);
}
</script>