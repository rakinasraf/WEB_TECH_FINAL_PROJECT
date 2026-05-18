<?php include "views/layout/header.php"; ?>

<div style="margin-bottom:10px;">
    <a href="index.php?action=order_history" style="font-size:14px;">&larr; Back to Orders</a>
</div>

<h2>Order #<?= $order['id'] ?></h2>

<div class="grid-2" style="align-items:start;">

   
    <div>
        <div class="card">
            <h3>Order Status</h3>
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">
                <span class="badge badge-<?= $order['status'] ?>" id="orderStatusBadge" style="font-size:14px; padding:6px 16px;">
                    <?= ucfirst($order['status']) ?>
                </span>
                <span style="font-size:13px; color:#888;" id="deliveryStatus">
                    
                </span>
            </div>

            
            <?php
            $steps    = ['pending','processing','shipped','delivered'];
            $curIndex = array_search($order['status'], $steps);
            if ($curIndex === false) $curIndex = -1;
            ?>
            <div style="display:flex; align-items:center; gap:0; margin-bottom:20px;">
                <?php foreach ($steps as $i => $step): ?>
                    <div style="flex:1; text-align:center;">
                        <div style="width:28px; height:28px; border-radius:50%; margin:0 auto 5px;
                                    background:<?= $i <= $curIndex ? '#28a745' : '#ddd' ?>;
                                    color:<?= $i <= $curIndex ? '#fff' : '#999' ?>;
                                    display:flex; align-items:center; justify-content:center;
                                    font-size:13px; font-weight:bold;">
                            <?= $i <= $curIndex ? '✓' : ($i+1) ?>
                        </div>
                        <div style="font-size:11px; color:<?= $i <= $curIndex ? '#28a745' : '#aaa' ?>;">
                            <?= ucfirst($step) ?>
                        </div>
                    </div>
                    <?php if ($i < count($steps)-1): ?>
                    <div style="flex:0.5; height:2px; background:<?= $i < $curIndex ? '#28a745' : '#ddd' ?>;"></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <table style="width:auto; background:transparent; box-shadow:none;">
                <tr><td style="color:#888; padding:5px 15px 5px 0; font-size:13px; border:none;">Order Date</td>
                    <td style="font-size:13px; border:none;"><?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></td></tr>
                <tr><td style="color:#888; padding:5px 15px 5px 0; font-size:13px; border:none;">Total Amount</td>
                    <td style="font-size:13px; font-weight:bold; color:#007bff; border:none;">৳<?= number_format($order['total_amount'], 2) ?></td></tr>
                <?php if ($order['discount_amount'] > 0): ?>
                <tr><td style="color:#888; padding:5px 15px 5px 0; font-size:13px; border:none;">Discount</td>
                    <td style="font-size:13px; color:green; border:none;">-৳<?= number_format($order['discount_amount'], 2) ?></td></tr>
                <?php endif; ?>
            </table>

            
            <?php if ($order['status'] === 'pending'): ?>
            <div style="margin-top:15px;">
                <form action="index.php?action=cancel_order&id=<?= $order['id'] ?>" method="POST"
                      onsubmit="return confirm('Cancel this order?')">
                    <button type="submit" class="btn btn-danger btn-sm">Cancel Order</button>
                </form>
            </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3>Shipping Address</h3>
            <p style="font-size:14px; line-height:1.7;">
                <?= htmlspecialchars($order['shipping_name'] ?? '') ?><br>
                <?= htmlspecialchars($order['shipping_phone'] ?? '') ?><br>
                <?= nl2br(htmlspecialchars($order['shipping_address'] ?? '')) ?><br>
                <?= htmlspecialchars($order['shipping_city'] ?? '') ?><br>
                Zone: <?= htmlspecialchars($order['delivery_zone_name'] ?? 'Not selected') ?>
            </p>
        </div>
    </div>

    
    <div class="card">
        <h3>Items Ordered</h3>
        <?php foreach ($items as $item): ?>
        <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #eee; font-size:14px;">
            <div>
                <div style="font-weight:bold;"><?= htmlspecialchars($item['product_name']) ?></div>
                <div style="color:#888; font-size:13px;">৳<?= number_format($item['price'], 2) ?> × <?= $item['quantity'] ?></div>
            </div>
            <strong>৳<?= number_format($item['price'] * $item['quantity'], 2) ?></strong>
        </div>
        <?php endforeach; ?>
        <div style="display:flex; justify-content:space-between; padding-top:12px; font-size:16px; font-weight:bold;">
            <span>Total</span>
            <span style="color:#007bff;">৳<?= number_format($order['total_amount'], 2) ?></span>
        </div>
    </div>

</div>

<div class="grid-2" style="align-items:start;">
    <div class="card">
        <h3>Return Request</h3>

        <?php if (!empty($returns)): ?>
            <?php foreach ($returns as $ret): ?>
            <div style="border-bottom:1px solid #eee; padding:8px 0; font-size:14px;">
                <strong><?= htmlspecialchars($ret['reason']) ?></strong>
                <span class="badge badge-pending"><?= htmlspecialchars($ret['status']) ?></span>
                <p style="color:#666; margin-top:5px;">
                    Item: <?= htmlspecialchars($ret['product_name'] ?? 'Whole order') ?><br>
                    <?= htmlspecialchars($ret['details'] ?? '') ?>
                </p>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!in_array($order['status'], ['cancelled','returned'])): ?>
        <form action="index.php?action=submit_return_request" method="POST" style="margin-top:12px;">
            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

            <div class="form-group">
                <label>Item</label>
                <select name="order_item_id">
                    <option value="0">Whole order</option>
                    <?php foreach ($items as $item): ?>
                    <option value="<?= $item['id'] ?>"><?= htmlspecialchars($item['product_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Reason</label>
                <input type="text" name="reason" placeholder="Reason for return">
            </div>

            <div class="form-group">
                <label>Details</label>
                <textarea name="details" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-secondary">Submit Return Request</button>
        </form>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3>Dispute</h3>

        <?php if (!empty($disputes)): ?>
            <?php foreach ($disputes as $d): ?>
            <div style="border-bottom:1px solid #eee; padding:8px 0; font-size:14px;">
                <strong><?= htmlspecialchars($d['subject']) ?></strong>
                <span class="badge badge-processing"><?= htmlspecialchars($d['status']) ?></span>
                <p style="color:#666; margin-top:5px;"><?= htmlspecialchars($d['description']) ?></p>
            </div>
            <?php endforeach; ?>
            <p style="margin-top:10px;">
                <a href="index.php?action=disputes">View dispute status</a>
            </p>
        <?php endif; ?>

        <form action="index.php?action=open_dispute" method="POST" style="margin-top:12px;">
            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" placeholder="Dispute subject">
            </div>

            <div class="form-group">
                <label>Details</label>
                <textarea name="description" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-secondary">Open Dispute</button>
        </form>
    </div>
</div>


<script>
function pollOrderStatus() {
    fetch('index.php?action=ajax&type=order_status&order_id=<?= $order['id'] ?>')
    .then(res => res.json())
    .then(function(data) {
        if (data.status === 'ok') {

            
            const badge     = document.getElementById('orderStatusBadge');
            badge.textContent = data.order_status.charAt(0).toUpperCase() + data.order_status.slice(1);
            badge.className   = 'badge badge-' + data.order_status;

            
            const dlv = document.getElementById('deliveryStatus');
            if (data.delivery_status && data.delivery_status !== 'not assigned') {
                dlv.textContent = 'Delivery: ' + data.delivery_status.replace('_',' ');
            }
        }
    })
    .catch(function() {  });
}


<?php if (!in_array($order['status'], ['delivered','cancelled'])): ?>
    pollOrderStatus(); // run immediately
    setInterval(pollOrderStatus, 10000);
<?php endif; ?>
</script>

<?php include "views/layout/footer.php"; ?>
