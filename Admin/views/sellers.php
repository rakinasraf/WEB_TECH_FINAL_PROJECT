<h2>🏪 Merchant Approval Queue & Registration Logs</h2>
<p style="margin-bottom:20px; color:#7f8c8d;">Manage third-party Bangladeshi storefront profiles globally.</p>

<table border="0" cellspacing="0" cellpadding="12" style="width:100%; background:#fff; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
    <thead>
        <tr style="background:#f1f5f9; text-align:left; color:#475569;">
            <th>Shop Profile Name</th>
            <th>Merchant Representative</th>
            <th>Physical Address Location</th>
            <th>Commission Rate</th>
            <th>Status Verification</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($sellers as $seller): ?>
        <tr style="border-bottom:1px solid #e2e8f0;">
            <td><strong><?php echo htmlspecialchars($seller['shop_name']); ?></strong></td>
            <td><?php echo htmlspecialchars($seller['owner_name']); ?><br><span style="font-size:12px; color:#94a3b8;"><?php echo htmlspecialchars($seller['owner_email']); ?></span></td>
            <td><?php echo htmlspecialchars($seller['address']); ?></td>
            <td><code><?php echo $seller['commission_rate']; ?>%</code></td>
            <td>
                <?php if($seller['is_approved']): ?>
                    <span style="color:#2ecc71; font-weight:bold;">Active Verified</span>
                <?php else: ?>
                    <button style="background:#2ecc71; color:white; border:none; padding:6px 12px; border-radius:4px; cursor:pointer;" onclick="approveSeller(<?php echo $seller['id']; ?>, this)">Approve Shop</button>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
function approveSeller(id, btn) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php?action=approve_seller_ajax", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const res = JSON.parse(xhr.responseText);
            if (res.success) { btn.parentElement.innerHTML = '<span style="color:#2ecc71; font-weight:bold;">Active Verified</span>'; }
        }
    };
    xhr.send("id=" + id);
}
</script>