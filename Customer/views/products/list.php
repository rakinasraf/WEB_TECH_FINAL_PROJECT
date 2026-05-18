<?php include "views/layout/header.php"; ?>

<h2>Products</h2>

<style>
.products-table-wrap {
    overflow-x: auto;
}
.products-table {
    min-width: 920px;
    table-layout: fixed;
}
.products-table th,
.products-table td {
    vertical-align: middle;
}
.products-table .col-name { width: 18%; }
.products-table .col-category { width: 13%; }
.products-table .col-description { width: 32%; }
.products-table .col-price { width: 10%; }
.products-table .col-stock { width: 9%; }
.products-table .col-action { width: 18%; }
.products-table .price-cell,
.products-table .stock-cell {
    white-space: nowrap;
}
.product-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    align-items: center;
}
.product-actions form {
    display: inline;
}
.product-actions .btn {
    min-width: 84px;
    text-align: center;
    padding-left: 10px;
    padding-right: 10px;
}
</style>

<div class="card">
    <form method="GET" action="index.php" style="display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
        <input type="hidden" name="action" value="products">

        <div style="flex:2; min-width:180px;">
            <label>Search</label>
            <input type="text" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '', ENT_QUOTES) ?>">
        </div>

        <div style="flex:1; min-width:150px;">
            <label>Category</label>
            <select name="category">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat['slug'], ENT_QUOTES) ?>"
                    <?= (($_GET['category'] ?? '') === $cat['slug']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="flex:1; min-width:120px;">
            <label>Min Price</label>
            <input type="number" name="min_price" min="0" value="<?= htmlspecialchars($_GET['min_price'] ?? '', ENT_QUOTES) ?>">
        </div>

        <div style="flex:1; min-width:120px;">
            <label>Max Price</label>
            <input type="number" name="max_price" min="0" value="<?= htmlspecialchars($_GET['max_price'] ?? '', ENT_QUOTES) ?>">
        </div>

        <div style="display:flex; gap:8px;">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="index.php?action=products" class="btn btn-secondary">Clear</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="products-table-wrap">
        <table class="products-table">
            <colgroup>
                <col class="col-name">
                <col class="col-category">
                <col class="col-description">
                <col class="col-price">
                <col class="col-stock">
                <col class="col-action">
            </colgroup>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock Qty</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="6">No products found.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
                        <td><?= htmlspecialchars($p['category'] ?? 'Uncategorized') ?></td>
                        <td><?= htmlspecialchars($p['description'] ?? 'NULL') ?></td>
                        <td class="price-cell"><?= number_format((float)$p['price'], 2) ?></td>
                        <td class="stock-cell"><?= htmlspecialchars($p['stock_qty']) ?></td>
                        <td>
                            <div class="product-actions">
                                <a href="index.php?action=product_details&id=<?= $p['id'] ?>" class="btn btn-sm btn-secondary">View</a>
                                <?php if ($p['stock_qty'] > 0): ?>
                                <form action="index.php?action=add_cart" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-primary">Add to Cart</button>
                                </form>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['user'])): ?>
                                    <button type="button" class="btn btn-sm btn-secondary"
                                            onclick="addWishlist(<?= $p['id'] ?>, this)">Wishlist</button>
                                <?php else: ?>
                                    <a href="index.php?action=login" class="btn btn-sm btn-secondary">Wishlist</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function addWishlist(productId, btn) {
    const oldText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Adding...';

    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('action', 'add');

    fetch('index.php?action=ajax&type=wishlist_toggle', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(function(data) {
        if (data.status === 'ok') {
            btn.textContent = 'In Wishlist';
            btn.className = 'btn btn-sm btn-danger';
        } else {
            alert(data.message);
            btn.textContent = oldText;
            btn.disabled = false;
        }
    })
    .catch(function() {
        alert('Something went wrong.');
        btn.textContent = oldText;
        btn.disabled = false;
    });
}
</script>

<?php include "views/layout/footer.php"; ?>
