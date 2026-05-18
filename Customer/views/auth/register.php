<?php
include "views/layout/header.php";


$old    = $_SESSION['reg_old']    ?? [];
$errors = $_SESSION['reg_errors'] ?? [];
unset($_SESSION['reg_old'], $_SESSION['reg_errors']);

$name    = $old['name']  ?? '';
$email   = $old['email'] ?? '';
$phone   = $old['phone'] ?? '';

$nameErr  = $errors['nameErr']  ?? '';
$emailErr = $errors['emailErr'] ?? '';
$phoneErr = $errors['phoneErr'] ?? '';
$passErr  = $errors['passErr']  ?? '';
?>

<style>
.reg-box { max-width: 450px; margin: 0 auto; }
.reg-box h2 { margin-bottom: 20px; }
</style>

<div class="reg-box">
    <h2>Customer Registration</h2>

    <div class="card">
        <form action="index.php?action=do_register" method="POST" id="regForm">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" id="fname" placeholder="Your full name"
                       value="<?= htmlspecialchars($name, ENT_QUOTES) ?>">
                <span class="error" id="nameErr"><?= htmlspecialchars($nameErr) ?></span>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="text" name="email" id="femail" placeholder="you@example.com"
                       value="<?= htmlspecialchars($email, ENT_QUOTES) ?>">
                <span class="error" id="emailErr"><?= htmlspecialchars($emailErr) ?></span>
            </div>

            <div class="form-group">
                <label>Phone Number (11 digits)</label>
                <input type="text" name="phone" id="fphone" placeholder="01XXXXXXXXX"
                       value="<?= htmlspecialchars($phone, ENT_QUOTES) ?>">
                <span class="error" id="phoneErr"><?= htmlspecialchars($phoneErr) ?></span>
            </div>

            <div class="form-group">
                <label>Password (min 6 characters)</label>
                <input type="password" name="password" id="fpass" placeholder="••••••">
                <span class="error" id="passErr"><?= htmlspecialchars($passErr) ?></span>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">Register</button>
        </form>

        <p style="text-align:center; margin-top:15px; font-size:14px;">
            Already have an account? <a href="index.php?action=login">Login here</a>
        </p>
    </div>
</div>

<script>

document.getElementById('regForm').addEventListener('submit', function(e) {

    let valid = true;

    
    ['nameErr','emailErr','phoneErr','passErr'].forEach(function(id) {
        document.getElementById(id).textContent = '';
    });

    const name  = document.getElementById('fname').value.trim();
    const email = document.getElementById('femail').value.trim();
    const phone = document.getElementById('fphone').value.trim();
    const pass  = document.getElementById('fpass').value.trim();

    if (!name) {
        document.getElementById('nameErr').textContent = 'Name is required.';
        valid = false;
    } else if (!/^[a-zA-Z\-' ]+$/.test(name)) {
        document.getElementById('nameErr').textContent = 'Only letters allowed.';
        valid = false;
    }

    if (!email) {
        document.getElementById('emailErr').textContent = 'Email is required.';
        valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('emailErr').textContent = 'Invalid email format.';
        valid = false;
    }

    if (!phone) {
        document.getElementById('phoneErr').textContent = 'Phone is required.';
        valid = false;
    } else if (!/^[0-9]{11}$/.test(phone)) {
        document.getElementById('phoneErr').textContent = 'Phone must be 11 digits.';
        valid = false;
    }

    if (!pass) {
        document.getElementById('passErr').textContent = 'Password is required.';
        valid = false;
    } else if (pass.length < 6) {
        document.getElementById('passErr').textContent = 'Password must be at least 6 characters.';
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>

<?php include "views/layout/footer.php"; ?>
