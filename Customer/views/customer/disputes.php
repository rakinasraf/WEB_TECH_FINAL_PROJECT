<?php include "views/layout/header.php"; ?>

<h2>Dispute Status</h2>

<?php if (empty($disputes)): ?>
    <div class="card" style="text-align:center; padding:40px; color:#888;">
        No disputes found.
    </div>
<?php else: ?>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Opened</th>
                    <th>Resolution</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($disputes as $d): ?>
                <tr>
                    <td>
                        <a href="index.php?action=order_detail&id=<?= $d['order_id'] ?>">
                            #<?= htmlspecialchars($d['order_number'] ?? $d['order_id']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($d['subject']) ?></td>
                    <td><span class="badge badge-processing"><?= htmlspecialchars($d['status']) ?></span></td>
                    <td><?= date('d M Y', strtotime($d['created_at'])) ?></td>
                    <td><?= htmlspecialchars($d['resolution'] ?? 'Pending') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include "views/layout/footer.php"; ?>
