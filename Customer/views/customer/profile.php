<?php
include "views/layout/header.php";
require_once "models/User.php";
$userModel = new User($conn);
$user      = $userModel->getById($_SESSION['user']['id']);

$profileErrors = $_SESSION['profile_errors'] ?? [];
$passError     = $_SESSION['pass_error']     ?? '';
unset($_SESSION['profile_errors'], $_SESSION['pass_error']);
?>

<h2>My Profile</h2>

<div class="grid-2">

    
    <div class="card">
        <h3>Profile Picture</h3>
        <div style="display:flex; gap:15px; align-items:center;">
            <?php if (!empty($user['profile_image_path'])): ?>
                <img src="<?= htmlspecialchars($user['profile_image_path']) ?>" alt="Profile"
                     style="width:90px; height:90px; border-radius:50%; object-fit:cover;">
            <?php else: ?>
                <div style="width:90px; height:90px; border-radius:50%; background:#e9ecef; display:flex; align-items:center; justify-content:center; font-size:13px; color:#888;">
                    Photo
                </div>
            <?php endif; ?>

            <form action="index.php?action=upload_profile_picture" method="POST" enctype="multipart/form-data" style="flex:1;">
                <div class="form-group">
                    <label>Upload New Picture</label>
                    <input type="file" name="profile_image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Upload</button>
            </form>
        </div>
    </div>

    
    <div class="card">
        <h3>Shipping</h3>
        <p style="font-size:14px; color:#555; margin-bottom:12px;">Manage saved delivery addresses for checkout.</p>
        <a href="index.php?action=addresses" class="btn btn-secondary">Manage Addresses</a>
    </div>

    
    <div class="card">
        <h3>Personal Information</h3>
        <form action="index.php?action=update_profile" method="POST" id="profileForm">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" id="pname" placeholder="Your name"
                       value="<?= htmlspecialchars($user['name'], ENT_QUOTES) ?>">
                <span class="error" id="pnameErr"><?= htmlspecialchars($profileErrors['nameErr'] ?? '') ?></span>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>" disabled
                       style="background:#f4f4f4; color:#888; cursor:not-allowed;">
                <span style="font-size:12px; color:#888;">Email cannot be changed.</span>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" id="pphone" placeholder="01XXXXXXXXX"
                       value="<?= htmlspecialchars($user['phone'] ?? '', ENT_QUOTES) ?>">
                <span class="error" id="pphoneErr"><?= htmlspecialchars($profileErrors['phoneErr'] ?? '') ?></span>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    
    <div class="card">
        <h3>Change Password</h3>
        <?php if ($passError): ?>
            <div class="alert alert-error"><?= htmlspecialchars($passError) ?></div>
        <?php endif; ?>
        <form action="index.php?action=change_password" method="POST" id="passForm">

            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" id="cpwd" placeholder="Current password">
                <span class="error" id="cpwdErr"></span>
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" id="npwd" placeholder="Min 6 characters">
                <span class="error" id="npwdErr"></span>
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" id="cfpwd" placeholder="Repeat new password">
                <span class="error" id="cfpwdErr"></span>
            </div>

            <button type="submit" class="btn btn-danger">Update Password</button>
        </form>
    </div>

</div>

<script>

document.getElementById('profileForm').addEventListener('submit', function(e) {
    let valid = true;
    document.getElementById('pnameErr').textContent  = '';
    document.getElementById('pphoneErr').textContent = '';

    const name  = document.getElementById('pname').value.trim();
    const phone = document.getElementById('pphone').value.trim();

    if (!name) {
        document.getElementById('pnameErr').textContent = 'Name is required.';
        valid = false;
    } else if (!/^[a-zA-Z\-' ]+$/.test(name)) {
        document.getElementById('pnameErr').textContent = 'Only letters allowed.';
        valid = false;
    }

    if (phone && !/^[0-9]{11}$/.test(phone)) {
        document.getElementById('pphoneErr').textContent = 'Phone must be 11 digits.';
        valid = false;
    }

    if (!valid) e.preventDefault();
});


document.getElementById('passForm').addEventListener('submit', function(e) {
    let valid = true;
    ['cpwdErr','npwdErr','cfpwdErr'].forEach(id => document.getElementById(id).textContent = '');

    const cur = document.getElementById('cpwd').value.trim();
    const nw  = document.getElementById('npwd').value.trim();
    const cf  = document.getElementById('cfpwd').value.trim();

    if (!cur) { document.getElementById('cpwdErr').textContent = 'Current password is required.'; valid = false; }
    if (!nw)  { document.getElementById('npwdErr').textContent = 'New password is required.'; valid = false; }
    else if (nw.length < 6) { document.getElementById('npwdErr').textContent = 'Min 6 characters.'; valid = false; }
    if (nw && cf !== nw) { document.getElementById('cfpwdErr').textContent = 'Passwords do not match.'; valid = false; }

    if (!valid) e.preventDefault();
});
</script>

<?php include "views/layout/footer.php"; ?>
