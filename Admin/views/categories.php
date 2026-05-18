<h2>📁 System Categories Mapping Structure</h2>
<p style="margin-bottom:20px; color:#7f8c8d;">.</p>

<div style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
    <table width="100%" cellpadding="10" cellspacing="0">
        <tr style="background:#f8f9fa; border-bottom:2px solid #eee;">
            <th align="left">Category System ID</th>
            <th align="left">Category Node Label</th>
            <th align="left">Nesting Tier Parent Path</th>
            <th align="left">Description Framework Scope</th>
        </tr>
        <?php foreach($categories as $cat): ?>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <td><code>#CAT-0<?php echo $cat['id']; ?></code></td>
            <td><strong><?php echo htmlspecialchars($cat['name']); ?></strong></td>
            <td><span style="background:#e2e8f0; padding:3px 8px; border-radius:12px; font-size:12px;"><?php echo $cat['parent_name'] ? htmlspecialchars($cat['parent_name']) : 'Root Matrix Core'; ?></span></td>
            <td style="color:#64748b; font-size:14px;"><?php echo htmlspecialchars($cat['description']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
