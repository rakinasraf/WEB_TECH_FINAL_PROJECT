<?php include "views/layout/header.php"; ?>

<div style="margin-bottom:10px;">
    <a href="index.php?action=products" style="font-size:14px;">&larr; Back to Products</a>
</div>


<div class="grid-2" style="margin-bottom:25px;">

    
    <div>
        <?php if (!empty($product['image'])): ?>
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                 style="width:100%; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
        <?php else: ?>
            <div style="width:100%; height:300px; background:#e9ecef; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:60px;">
                🛍️
            </div>
        <?php endif; ?>
    </div>

    
    <div class="card">
        <?php if ($product['category']): ?>
        <span style="font-size:12px; color:#888; background:#f4f4f4; padding:3px 10px; border-radius:10px;">
            <?= htmlspecialchars($product['category']) ?>
        </span>
        <?php endif; ?>

        <h2 style="margin:12px 0 8px;"><?= htmlspecialchars($product['name']) ?></h2>

        
        <div style="margin-bottom:10px; font-size:14px; color:#555;">
            <?php
            $avg = round($rating_info['avg_rating'] ?? 0);
            echo str_repeat('★', $avg) . str_repeat('☆', 5 - $avg);
            echo " <span style='color:#888;'>(" . ($rating_info['total'] ?? 0) . " reviews)</span>";
            ?>
        </div>

        <div style="font-size:26px; font-weight:bold; color:#007bff; margin-bottom:15px;">
            ৳<?= number_format($product['price'], 2) ?>
        </div>

        <?php if (!empty($product['description'])): ?>
        <p style="color:#555; font-size:14px; line-height:1.6; margin-bottom:15px;">
            <?= nl2br(htmlspecialchars($product['description'])) ?>
        </p>
        <?php endif; ?>

        <p style="font-size:14px; margin-bottom:15px;">
            Stock:
            <?php if ($product['stock'] <= 0): ?>
                <span style="color:red; font-weight:bold;">Out of Stock</span>
            <?php else: ?>
                <span style="color:green; font-weight:bold;"><?= $product['stock'] ?> available</span>
            <?php endif; ?>
        </p>

        
        <div style="display:flex; flex-wrap:wrap; gap:10px;">
            <?php if ($product['stock'] > 0): ?>
            <form action="index.php?action=add_cart" method="POST" style="display:inline;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
            <?php else: ?>
            <button class="btn btn-secondary" disabled>Out of Stock</button>
            <?php endif; ?>

            
            <?php if (isset($_SESSION['user'])): ?>
            <button id="wlBtn" class="btn <?= $in_wishlist ? 'btn-danger' : 'btn-secondary' ?>"
                    onclick="toggleWishlist(<?= $product['id'] ?>)">
                <?= $in_wishlist ? '♥ Remove from Wishlist' : '♡ Add to Wishlist' ?>
            </button>
            <?php endif; ?>
        </div>

        <div id="wlMsg" style="margin-top:10px; font-size:13px; color:green;"></div>
    </div>
</div>


<div class="card">
    <h3>Customer Reviews (<?= count($reviews) ?>)</h3>

    
    <?php if (isset($_SESSION['user'])): ?>
        <?php if ($already_reviewed): ?>
            <div style="background:#fff3cd; color:#856404; padding:10px 14px; border-radius:5px; margin-bottom:20px; font-size:14px;">
                You have already reviewed this product.
            </div>
        <?php else: ?>
        <div style="margin-bottom:25px; padding-bottom:20px; border-bottom:1px solid #eee;">
            <h4 style="margin-bottom:12px; font-size:15px;">Write a Review</h4>
            <form action="index.php?action=submit_review" method="POST" id="reviewForm">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <div class="form-group">
                    <label>Rating</label>
                    <div id="starRating" style="font-size:28px; cursor:pointer; margin-bottom:5px;">
                        <span data-val="1">☆</span>
                        <span data-val="2">☆</span>
                        <span data-val="3">☆</span>
                        <span data-val="4">☆</span>
                        <span data-val="5">☆</span>
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="0">
                    <span class="error" id="ratingErr"></span>
                </div>

                <div class="form-group">
                    <label>Comment</label>
                    <textarea name="comment" id="rcomment" rows="3" placeholder="Share your experience..."></textarea>
                    <span class="error" id="commentErr"></span>
                </div>

                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
        <?php endif; ?>
    <?php else: ?>
        <p style="margin-bottom:20px; font-size:14px; color:#555;">
            <a href="index.php?action=login">Login</a> to write a review.
        </p>
    <?php endif; ?>

    
    <?php if (empty($reviews)): ?>
        <p style="color:#888; font-size:14px;">No reviews yet. Be the first!</p>
    <?php else: ?>
        <?php foreach ($reviews as $rv): ?>
        <div style="padding:15px 0; border-bottom:1px solid #f0f0f0;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <strong style="font-size:14px;"><?= htmlspecialchars($rv['user_name']) ?></strong>
                    <span style="color:#f5a623; margin-left:8px;">
                        <?= str_repeat('★', $rv['rating']) ?><?= str_repeat('☆', 5 - $rv['rating']) ?>
                    </span>
                    <span style="color:#888; font-size:12px; margin-left:8px;">
                        <?= date('d M Y', strtotime($rv['created_at'])) ?>
                    </span>
                </div>
                <!-- Edit/delete own review -->
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $rv['user_id']): ?>
                <form action="index.php?action=delete_review" method="POST"
                      onsubmit="return confirm('Delete this review?')">
                    <input type="hidden" name="id" value="<?= $rv['id'] ?>">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
                <?php endif; ?>
            </div>
            <p style="margin-top:6px; font-size:14px; color:#444;">
                <?= nl2br(htmlspecialchars($rv['comment'])) ?>
            </p>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $rv['user_id']): ?>
            <form action="index.php?action=edit_review" method="POST" style="margin-top:10px; background:#f9f9f9; padding:10px; border-radius:5px;">
                <input type="hidden" name="review_id" value="<?= $rv['id'] ?>">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <div class="form-group">
                    <label>Edit Rating</label>
                    <select name="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>" <?= $rv['rating'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Edit Comment</label>
                    <textarea name="comment" rows="2"><?= htmlspecialchars($rv['comment']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-sm btn-secondary">Update Review</button>
            </form>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>

const stars = document.querySelectorAll('#starRating span');
stars.forEach(function(star) {
    star.addEventListener('click', function() {
        const val = parseInt(this.dataset.val);
        document.getElementById('ratingInput').value = val;
        stars.forEach(function(s, i) {
            s.textContent = i < val ? '★' : '☆';
            s.style.color = i < val ? '#f5a623' : '#ccc';
        });
    });
    star.addEventListener('mouseover', function() {
        const val = parseInt(this.dataset.val);
        stars.forEach(function(s, i) {
            s.textContent = i < val ? '★' : '☆';
            s.style.color = i < val ? '#f5a623' : '#ccc';
        });
    });
    star.addEventListener('mouseout', function() {
        const current = parseInt(document.getElementById('ratingInput').value) || 0;
        stars.forEach(function(s, i) {
            s.textContent = i < current ? '★' : '☆';
            s.style.color = i < current ? '#f5a623' : '#ccc';
        });
    });
});


const reviewForm = document.getElementById('reviewForm');
if (reviewForm) {
    reviewForm.addEventListener('submit', function(e) {
        let valid = true;
        document.getElementById('ratingErr').textContent  = '';
        document.getElementById('commentErr').textContent = '';

        const rating  = parseInt(document.getElementById('ratingInput').value);
        const comment = document.getElementById('rcomment').value.trim();

        if (!rating || rating < 1 || rating > 5) {
            document.getElementById('ratingErr').textContent = 'Please select a star rating.';
            valid = false;
        }
        if (!comment) {
            document.getElementById('commentErr').textContent = 'Comment is required.';
            valid = false;
        }
        if (!valid) e.preventDefault();
    });
}


function toggleWishlist(productId) {
    const btn = document.getElementById('wlBtn');
    const msg = document.getElementById('wlMsg');

    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('action', 'toggle');

    fetch('index.php?action=ajax&type=wishlist_toggle', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(function(data) {
        if (data.status === 'ok') {
            msg.textContent   = data.message;
            msg.style.color   = data.in_wishlist ? 'green' : '#888';
            btn.textContent   = data.in_wishlist ? '♥ Remove from Wishlist' : '♡ Add to Wishlist';
            btn.className     = 'btn ' + (data.in_wishlist ? 'btn-danger' : 'btn-secondary');
        } else {
            msg.style.color   = 'red';
            msg.textContent   = data.message;
        }
    })
    .catch(function() {
        msg.style.color   = 'red';
        msg.textContent   = 'Something went wrong.';
    });
}
</script>

<?php include "views/layout/footer.php"; ?>
