<?php include "views/layout/header.php"; ?>

<h2>Checkout</h2>

<?php

$subtotal = 0;
foreach ($_SESSION['cart'] as $pid => $qty) {
    if (isset($products[$pid])) {
        $subtotal += $products[$pid]['price'] * $qty;
    }
}

$coupon = $coupon ?? null;
$discount = $discount ?? ($coupon ? (float)$coupon['discount_amount'] : 0);
$discountedTotal = $discountedTotal ?? max(0, $subtotal - $discount);
?>

<div class="grid-2" style="align-items:start;">

    
    <div class="card">
        <h3>Order Details</h3>
        <form action="index.php?action=place_order" method="POST" id="checkoutForm">

           
            <div style="background:#f9f9f9; border-radius:5px; padding:12px; margin-bottom:18px;">
                <strong style="font-size:13px; color:#555; display:block; margin-bottom:8px;">Items in Order:</strong>
                <?php foreach ($_SESSION['cart'] as $pid => $qty): ?>
                    <?php if (!isset($products[$pid])) continue; $p = $products[$pid]; ?>
                    <div style="display:flex; justify-content:space-between; font-size:13px; padding:3px 0;">
                        <span><?= htmlspecialchars($p['name']) ?> × <?= $qty ?></span>
                        <span>৳<?= number_format($p['price'] * $qty, 2) ?></span>
                    </div>
                <?php endforeach; ?>
                <div style="border-top:1px solid #ddd; margin-top:8px; padding-top:8px; font-weight:bold; font-size:14px; display:flex; justify-content:space-between;">
                    <span>Total</span>
                    <span style="color:#007bff;">৳<?= number_format($discountedTotal, 2) ?></span>
                </div>
                <?php if ($coupon): ?>
                <div style="display:flex; justify-content:space-between; font-size:13px; padding-top:6px; color:green;">
                    <span>Coupon <?= htmlspecialchars($coupon['coupon_code']) ?></span>
                    <span>-৳<?= number_format($discount, 2) ?></span>
                </div>
                <?php endif; ?>
            </div>

            <h4 style="margin-bottom:12px;">Shipping Address</h4>

            <?php if (!empty($addresses)): ?>
            <div class="form-group">
                <label>Saved Address</label>
                <select name="address_id">
                    <option value="">Use new address below</option>
                    <?php foreach ($addresses as $address): ?>
                    <option value="<?= $address['id'] ?>" <?= $address['is_default'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($address['full_name']) ?> -
                        <?= htmlspecialchars($address['address_line']) ?>
                        <?= $address['is_default'] ? '(Default)' : '' ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="shipping_name" value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '', ENT_QUOTES) ?>">
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="shipping_phone" value="<?= htmlspecialchars($_SESSION['user']['phone'] ?? '', ENT_QUOTES) ?>">
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="shipping_address" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>City</label>
                <input type="text" name="shipping_city" value="Dhaka">
            </div>

            <div class="form-group">
                <label>Delivery Zone</label>
                <select name="delivery_zone_id">
                    <option value="">Use saved address zone / Select zone</option>
                    <?php foreach ($zones as $zone): ?>
                    <option value="<?= $zone['id'] ?>">
                        <?= htmlspecialchars($zone['name']) ?> - <?= htmlspecialchars($zone['city']) ?>
                        (৳<?= number_format($zone['delivery_fee'], 2) ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Payment Method</label>
                <select name="payment_method">
                    <option value="cod">Cash on Delivery</option>
                    <option value="card">Card Payment</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success" style="width:100%; margin-top:5px;">
                ✓ Place Order
            </button>
        </form>
    </div>

   
    <div class="card">
        <h3>Order Summary</h3>
        <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee; font-size:14px;">
            <span>Items</span>
            <span><?= array_sum($_SESSION['cart']) ?></span>
        </div>
        <div style="display:flex; justify-content:space-between; padding:8px 0; font-size:16px; font-weight:bold;">
            <span>Subtotal</span>
            <span style="color:#007bff;">৳<?= number_format($subtotal, 2) ?></span>
        </div>
        <?php if ($coupon): ?>
        <div style="display:flex; justify-content:space-between; padding:8px 0; font-size:14px; color:green;">
            <span>Coupon <?= htmlspecialchars($coupon['coupon_code']) ?></span>
            <span>-৳<?= number_format($discount, 2) ?></span>
        </div>
        <div style="display:flex; justify-content:space-between; padding:8px 0; font-size:16px; font-weight:bold;">
            <span>Discounted Total</span>
            <span style="color:#007bff;">৳<?= number_format($discountedTotal, 2) ?></span>
        </div>
        <?php endif; ?>
        <p style="font-size:13px; color:#888; margin-top:8px;">
            Delivery fee will be added based on the selected delivery zone.
        </p>
        <div style="margin-top:15px; font-size:13px; color:#888; line-height:1.6;">
            ✓ Secure checkout<br>
            ✓ Order tracking available<br>
            ✓ Cancel anytime before shipping
        </div>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>
