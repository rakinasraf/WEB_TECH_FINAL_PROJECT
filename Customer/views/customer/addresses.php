<?php include "views/layout/header.php"; ?>

<h2>Shipping Addresses</h2>

<div class="grid-2" style="align-items:start;">

    <div class="card">
        <h3><?= $edit ? 'Edit Address' : 'Add Address' ?></h3>
        <form action="index.php?action=save_address" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($edit['id'] ?? '') ?>">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($edit['full_name'] ?? ($_SESSION['user']['name'] ?? ''), ENT_QUOTES) ?>">
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($edit['phone'] ?? ($_SESSION['user']['phone'] ?? ''), ENT_QUOTES) ?>">
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address_line" rows="3"><?= htmlspecialchars($edit['address_line'] ?? '', ENT_QUOTES) ?></textarea>
            </div>

            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" value="<?= htmlspecialchars($edit['city'] ?? 'Dhaka', ENT_QUOTES) ?>">
            </div>

            <div class="form-group">
                <label>Delivery Zone</label>
                <select name="delivery_zone_id">
                    <option value="">Select zone</option>
                    <?php foreach ($zones as $zone): ?>
                    <option value="<?= $zone['id'] ?>"
                        <?= (($edit['delivery_zone_id'] ?? '') == $zone['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($zone['name']) ?> - <?= htmlspecialchars($zone['city']) ?>
                        (৳<?= number_format($zone['delivery_fee'], 2) ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <label style="font-weight:normal; margin-bottom:15px;">
                <input type="checkbox" name="is_default" value="1" <?= !empty($edit['is_default']) ? 'checked' : '' ?>>
                Set as default
            </label>

            <button type="submit" class="btn btn-primary"><?= $edit ? 'Update Address' : 'Save Address' ?></button>
            <?php if ($edit): ?>
                <a href="index.php?action=addresses" class="btn btn-secondary">Cancel</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card">
        <h3>Saved Addresses</h3>
        <?php if (empty($addresses)): ?>
            <p style="color:#888; font-size:14px;">No saved addresses yet.</p>
        <?php else: ?>
            <?php foreach ($addresses as $address): ?>
            <div style="border-bottom:1px solid #eee; padding:12px 0;">
                <strong><?= htmlspecialchars($address['full_name']) ?></strong>
                <?php if ($address['is_default']): ?>
                    <span class="badge badge-delivered">Default</span>
                <?php endif; ?>
                <p style="font-size:14px; margin:5px 0; color:#555;">
                    <?= nl2br(htmlspecialchars($address['address_line'])) ?><br>
                    <?= htmlspecialchars($address['city']) ?>, <?= htmlspecialchars($address['phone']) ?><br>
                    Zone: <?= htmlspecialchars($address['zone_name'] ?? 'Not selected') ?>
                </p>
                <div style="display:flex; gap:8px;">
                    <a href="index.php?action=addresses&edit_id=<?= $address['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                    <form action="index.php?action=delete_address" method="POST" onsubmit="return confirm('Delete this address?')">
                        <input type="hidden" name="id" value="<?= $address['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>
