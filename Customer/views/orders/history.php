<?php include "views/layout/header.php"; ?>

<h2>Order History</h2>

<?php if (empty($orders)): ?>
    <div class="card" style="text-align:center; padding:50px; color:#888;">
        <div style="font-size:48px; margin-bottom:15px;">📦</div>
        No orders yet. <a href="index.php?action=products">Start shopping!</a>
    </div>
<?php else: ?>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td><strong>#<?= $o['id'] ?></strong></td>
                    <td><?= date('d M Y, h:i A', strtotime($o['created_at'])) ?></td>
                    <td><strong>৳<?= number_format($o['total_amount'], 2) ?></strong></td>
                    <td>
                        <span class="badge badge-<?= $o['status'] ?>"><?= ucfirst($o['status']) ?></span>
                    </td>
                    <td>
                        <a href="index.php?action=order_detail&id=<?= $o['id'] ?>" class="btn btn-sm btn-secondary">View</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include "views/layout/footer.php"; ?>
