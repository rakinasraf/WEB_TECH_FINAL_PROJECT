<h2>🛒 Order Tracking Workspace</h2>
<p style="margin-bottom:20px; color:#7f8c8d;">.</p>

<div style="background: #fff; padding: 15px 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <form action="index.php" method="GET" style="display: flex; gap: 10px; align-items: center; width: 100%; max-width: 500px;">
        <input type="hidden" name="action" value="orders">
        <div style="position: relative; flex: 1;">
            <input type="number" 
                   name="search_id" 
                   placeholder="Search by precise Order ID (e.g. 1002)..." 
                   value="<?php echo isset($_GET['search_id']) ? htmlspecialchars($_GET['search_id']) : ''; ?>"
                   style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 14px; outline: none;">
        </div>
        
        <button type="submit" style="background: var(--accent, #3498db); color: white; border: none; padding: 10px 20px; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 14px; transition: background 0.2s;">
            🔍 Search
        </button>

        <?php if(!empty($_GET['search_id'])): ?>
            <a href="index.php?action=orders" style="background: #e2e8f0; color: #475569; text-decoration: none; padding: 10px 15px; border-radius: 4px; font-size: 14px; font-weight: 600; text-align: center;">
                Clear
            </a>
        <?php endif; ?>
    </form>
    
    <div>
        <span style="font-size: 13px; color: #64748b;">
            Found: <strong><?php echo count($orders); ?></strong> target item logs
        </span>
    </div>
</div>

<table>
    <thead>
        <tr style="background:#f1f5f9; text-align:left; color:#475569;">
            <th>ID</th>
            <th>Customer Profile</th>
            <th>Fulfillment Destination</th>
            <th>Payment Strategy</th>
            <th>Financial Summary</th>
            <th style="text-align:center;">Fulfillment Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($orders)): ?>
            <?php foreach($orders as $order): ?>
            <tr style="border-bottom:1px solid #e2e8f0;">
                <td><code>#<?php echo htmlspecialchars($order['id']); ?></code></td>
                <td>
                    <strong><?php echo htmlspecialchars($order['customer_name']); ?></strong><br>
                    <span style="font-size:12px; color:#94a3b8;"><?php echo htmlspecialchars($order['customer_email']); ?></span>
                </td>
                <td>
                    <div style="font-size:13px; max-width:250px; color:#475569;" title="<?php echo htmlspecialchars($order['shipping_address']); ?>">
                        <?php echo htmlspecialchars($order['shipping_address']); ?>
                    </div>
                </td>
                <td>
                    <span style="text-transform: uppercase; font-size: 12px; font-weight: 600; color: #64748b; background: #f8f9fa; padding: 4px 8px; border-radius: 4px; border: 1px solid #e2e8f0;">
                        <?php echo htmlspecialchars($order['payment_method']); ?>
                    </span>
                </td>
                <td>
                    <div style="font-size: 13px; color: #64748b;">Subtotal: ৳<?php echo number_format($order['subtotal'], 2); ?></div>
                    <div style="font-size: 13px; color: var(--danger, #e74c3c);">Discount: -৳<?php echo number_format($order['discount_amount'], 2); ?></div>
                    <div style="font-weight: bold; color: #1e293b; margin-top: 2px;">Total: ৳<?php echo number_format($order['total_amount'], 2); ?></div>
                </td>
                <td style="text-align:center;">
                    <?php 
                        $statusColors = [
                            'pending'    => ['bg' => '#fef3c7', 'text' => '#d97706'],
                            'confirmed'  => ['bg' => '#e0f2fe', 'text' => '#0369a1'],
                            'processing' => ['bg' => '#f3e8ff', 'text' => '#6b21a8'],
                            'shipped'    => ['bg' => '#e0e7ff', 'text' => '#4338ca'],
                            'delivered'  => ['bg' => '#dcfce7', 'text' => '#15803d'],
                            'cancelled'  => ['bg' => '#fee2e2', 'text' => '#b91c1c']
                        ];
                        $currentStatus = strtolower($order['status']);
                        $style = $statusColors[$currentStatus] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
                    ?>
                    <span style="display:inline-block; padding:6px 12px; border-radius:20px; font-size:12px; font-weight:bold; text-transform:uppercase; background: <?php echo $style['bg']; ?>; color: <?php echo $style['text']; ?>;">
                        <?php echo htmlspecialchars($order['status']); ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center; color:#7f8c8d; padding:40px; font-style:italic;">
                    <?php if (!empty($_GET['search_id'])): ?>
                        No transaction record matches order invoice token sequence ID "#<?php echo htmlspecialchars($_GET['search_id']); ?>".
                    <?php else: ?>
                        No active operational purchases tracked across ledger records.
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>