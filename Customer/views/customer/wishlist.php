<?php include "views/layout/header.php"; ?>

<h2>My Wishlist</h2>

<?php if (empty($wishlist)): ?>
    <div class="card" style="text-align:center; padding:50px; color:#888;">
        <div style="font-size:48px; margin-bottom:15px;">♡</div>
        Your wishlist is empty. <a href="index.php?action=products">Browse products</a>
    </div>
<?php else: ?>
    <p style="color:#666; margin-bottom:15px; font-size:14px;"><?= count($wishlist) ?> item(s) in your wishlist</p>
    <div class="grid-3">
        <?php foreach ($wishlist as $item): ?>
        <div class="card" style="padding:0; overflow:hidden;">

            <?php if (!empty($item['image'])): ?>
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"
                     style="width:100%; height:160px; object-fit:cover;">
            <?php else: ?>
                <div style="width:100%; height:160px; background:#e9ecef; display:flex; align-items:center; justify-content:center; font-size:36px;">🛍️</div>
            <?php endif; ?>

            <div style="padding:14px;">
                <h4 style="font-size:14px; margin-bottom:6px;"><?= htmlspecialchars($item['name']) ?></h4>
                <div style="font-size:17px; font-weight:bold; color:#007bff; margin-bottom:10px;">
                    ৳<?= number_format($item['price'], 2) ?>
                </div>

                <?php if ($item['stock'] <= 0): ?>
                    <span style="color:red; font-size:12px; display:block; margin-bottom:8px;">Out of Stock</span>
                <?php endif; ?>

                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="index.php?action=product_details&id=<?= $item['product_id'] ?>" class="btn btn-secondary btn-sm">View</a>
                    <?php if ($item['stock'] > 0): ?>
                    <form action="index.php?action=add_cart" method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                    </form>
                    <?php endif; ?>
                    
                    <button class="btn btn-sm btn-danger"
                            onclick="removeWishlist(<?= $item['product_id'] ?>, this)">Remove</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
function removeWishlist(productId, btn) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('action', 'toggle');

    fetch('index.php?action=ajax&type=wishlist_toggle', { method:'POST', body:formData })
    .then(res => res.json())
    .then(function(data) {
        if (data.status === 'ok') {
            
            btn.closest('.card').remove();
        }
    });
}
</script>

<?php include "views/layout/footer.php"; ?>
