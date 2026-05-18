<h2>📦 Product Catalog Workspace</h2>
<p style="margin-bottom:20px; color:#7f8c8d;">.</p>

<?php if(isset($_GET['msg'])): ?>
    <?php if($_GET['msg'] === 'deleted'): ?>
        <div style="padding: 12px; background: #fee2e2; color: #991b1b; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">✓ Product successfully removed from active store catalogs.</div>
    <?php elseif($_GET['msg'] === 'error'): ?>
        <div style="padding: 12px; background: #fef9c3; color: #854d0e; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">⚠ Error executing product removal process.</div>
    <?php endif; ?>
<?php endif; ?>

<table>
    <thead>
        <tr style="background:#f1f5f9; text-align:left; color:#475569;">
            <th>Product Details</th>
            <th>Vendor Store</th>
            <th>Category Group</th>
            <th>Unit Pricing</th>
            <th>Stock Qty</th>
            <th style="text-align:center;">Workspace Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach($products as $product): ?>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <?php if(!empty($product['primary_image_path'])): ?>
                            <img src="<?php echo htmlspecialchars($product['primary_image_path']); ?>" alt="product" style="width:40px; height:40px; object-fit:cover; border-radius:4px;">
                        <?php else: ?>
                            <div style="width:40px; height:40px; background:#e2e8f0; border-radius:4px; display:flex; align-items:center; justify-content:center; font-size:10px; color:#94a3b8;">No Image</div>
                        <?php endif; ?>
                        <div>
                            <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                            <div style="font-size:12px; color:#7f8c8d; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?php echo htmlspecialchars($product['description'] ?? ''); ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td><span style="color:#475569; font-weight:500;"><?php echo htmlspecialchars($product['shop_name']); ?></span></td>
                <td><span style="background:#f1f5f9; padding:4px 8px; border-radius:4px; font-size:13px; color:#475569;"><?php echo htmlspecialchars($product['category_name']); ?></span></td>
                <td><strong>৳<?php echo number_format($product['price'], 2); ?></strong></td>
                <td>
                    <?php if((int)$product['stock_qty'] > 10): ?>
                        <span style="color:var(--success); font-weight:600;"><?php echo $product['stock_qty']; ?> left</span>
                    <?php elseif((int)$product['stock_qty'] > 0): ?>
                        <span style="color:#e67e22; font-weight:600;">Low Stock (<?php echo $product['stock_qty']; ?>)</span>
                    <?php else: ?>
                        <span style="color:var(--danger); font-weight:600;">Out of Stock</span>
                    <?php endif; ?>
                </td>
                <td style="text-align:center;">
                    <a href="index.php?action=delete_product&id=<?php echo $product['id']; ?>" 
                       onclick="return confirm('Are you sure you want to remove this product from the marketplace? Active order historical charts will be unaffected.');" 
                       style="color: var(--danger); text-decoration: none; font-weight: bold; font-size: 13px; padding: 6px 12px; border: 1px solid var(--danger); border-radius: 4px; background: #fffdfd; display: inline-block; transition: all 0.2s;">
                       🗑 Delete Item
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center; color:#7f8c8d; padding:30px; font-style:italic;">No active inventory products tracked in system catalog profiles.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
