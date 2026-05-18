<?php include "views/layout/header.php"; ?>

<h2>My Cart</h2>

<?php if (empty($products)): ?>
    <div class="card" style="text-align:center; padding:50px; color:#888;">
        <div style="font-size:48px; margin-bottom:15px;">🛒</div>
        Your cart is empty. <a href="index.php?action=products">Continue Shopping</a>
    </div>
<?php else: ?>

<div class="grid-2" style="align-items:start;">

    
    <div class="card">
        <h3>Cart Items</h3>
        <form action="index.php?action=update_cart" method="POST" id="cartForm">
            <?php $subtotal = 0; ?>
            <?php foreach ($_SESSION['cart'] as $pid => $qty): ?>
                <?php if (!isset($products[$pid])) continue; $p = $products[$pid]; ?>
                <?php $line = $p['price'] * $qty; $subtotal += $line; ?>
                <div style="display:flex; align-items:center; gap:12px; padding:12px 0; border-bottom:1px solid #eee;">

                    <!-- Image -->
                    <?php if (!empty($p['image'])): ?>
                    <img src="<?= htmlspecialchars($p['image']) ?>" style="width:60px; height:60px; object-fit:cover; border-radius:5px;">
                    <?php else: ?>
                    <div style="width:60px; height:60px; background:#e9ecef; border-radius:5px; display:flex; align-items:center; justify-content:center; font-size:22px;">🛍️</div>
                    <?php endif; ?>

                    <div style="flex:1;">
                        <div style="font-weight:bold; font-size:14px;"><?= htmlspecialchars($p['name']) ?></div>
                        <div style="color:#007bff; font-size:14px;">৳<?= number_format($p['price'], 2) ?> each</div>
                        <div style="color:#888; font-size:13px;">Subtotal: ৳<?= number_format($line, 2) ?></div>
                    </div>

                    <!-- Qty -->
                    <div style="display:flex; align-items:center; gap:6px;">
                        <input type="number" name="qty[<?= $pid ?>]" value="<?= $qty ?>"
                               min="0" max="<?= $p['stock'] ?>"
                               style="width:60px; text-align:center; padding:5px;"
                               onchange="document.getElementById('cartForm').submit()">
                        <button type="submit" formaction="index.php?action=remove_cart" name="product_id" value="<?= $pid ?>"
                                class="btn btn-sm btn-danger" onclick="return confirm('Remove item?')">Remove</button>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php
            $coupon = $coupon ?? null;
            $discount = $discount ?? ($coupon ? (float)$coupon['discount_amount'] : 0);
            $finalTotal = $finalTotal ?? max(0, $subtotal - $discount);
            ?>
        </form>
    </div>

    
    <div class="card">
        <h3>Order Summary</h3>

        <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee; font-size:15px;">
            <span>Subtotal</span>
            <strong id="subtotalDisplay">৳<?= number_format($subtotal, 2) ?></strong>
        </div>

        
        <?php if (isset($_SESSION['user'])): ?>
        <div style="padding:15px 0; border-bottom:1px solid #eee;">
            <label style="font-size:13px;">Coupon Code</label>
            <div style="display:flex; gap:8px; margin-top:5px;">
                <input type="text" id="couponCode" placeholder="Enter coupon" style="flex:1;"
                       value="<?= htmlspecialchars($coupon['coupon_code'] ?? '', ENT_QUOTES) ?>">
                <button class="btn btn-secondary btn-sm" onclick="applyCoupon()">Apply</button>
            </div>
            <div id="couponMsg" style="font-size:13px; margin-top:6px;">
                <?php if ($coupon): ?>
                    <?= htmlspecialchars($coupon['coupon_code']) ?> applied.
                <?php endif; ?>
            </div>
            <div id="discountRow" style="<?= $coupon ? 'display:flex;' : 'display:none;' ?> justify-content:space-between; margin-top:8px; font-size:14px; color:green;">
                <span>Discount</span>
                <span id="discountAmt"><?= $coupon ? '-৳' . number_format($discount, 2) : '' ?></span>
            </div>
        </div>
        <?php endif; ?>

        <div style="display:flex; justify-content:space-between; padding:12px 0; font-size:17px; font-weight:bold;">
            <span>Total</span>
            <span id="totalDisplay" style="color:#007bff;">৳<?= number_format($finalTotal, 2) ?></span>
        </div>

        <?php if (isset($_SESSION['user'])): ?>
        <a href="index.php?action=checkout" class="btn btn-primary" style="width:100%; text-align:center; display:block;">
            Proceed to Checkout
        </a>
        <?php else: ?>
        <a href="index.php?action=login" class="btn btn-primary" style="width:100%; text-align:center; display:block;">
            Login to Checkout
        </a>
        <?php endif; ?>

        <a href="index.php?action=products" class="btn btn-secondary" style="width:100%; text-align:center; display:block; margin-top:10px;">
            Continue Shopping
        </a>
    </div>

</div>

<script>
const subtotal = <?= $subtotal ?>;

function applyCoupon() {
    const code = document.getElementById('couponCode').value.trim();
    const msg  = document.getElementById('couponMsg');

    if (!code) {
        msg.style.color   = 'red';
        msg.textContent   = 'Enter a coupon code.';
        return;
    }

    msg.style.color   = '#555';
    msg.textContent   = 'Validating...';

    const formData = new FormData();
    formData.append('code', code);
    formData.append('subtotal', subtotal);

    fetch('index.php?action=ajax&type=validate_coupon', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(function(data) {
        if (data.status === 'ok') {
            msg.style.color = 'green';
            msg.textContent = data.message;

            const discountRow = document.getElementById('discountRow');
            discountRow.style.display = 'flex';
            document.getElementById('discountAmt').textContent = '-৳' + data.discount_amt.toFixed(2);
            document.getElementById('totalDisplay').textContent = '৳' + data.new_total.toFixed(2);
        } else {
            msg.style.color = 'red';
            msg.textContent = data.message;
        }
    })
    .catch(function() {
        msg.style.color = 'red';
        msg.textContent = 'Something went wrong.';
    });
}
</script>

<?php endif; ?>

<?php include "views/layout/footer.php"; ?>
