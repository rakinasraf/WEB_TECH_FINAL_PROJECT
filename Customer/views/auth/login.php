<?php include "views/layout/header.php"; ?>

<style>
.login-box { max-width: 400px; margin: 0 auto; }
.login-box h2 { margin-bottom: 20px; }
</style>

<div class="login-box">
    <h2>Customer Login</h2>

    <?php
    
    if (!empty($_SESSION['login_error'])) {
        echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['login_error']) . '</div>';
        unset($_SESSION['login_error']);
    }
    ?>

    <div class="card">
        <form action="index.php?action=do_login" method="POST" id="loginForm">

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email">
                <span class="error" id="emailErr"></span>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password">
                <span class="error" id="passErr"></span>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">Login</button>
        </form>

        <p style="text-align:center; margin-top:15px; font-size:14px;">
            Don't have an account? <a href="index.php?action=register">Register here</a>
        </p>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {

    let valid = true;

    const email  = document.getElementById('email').value.trim();
    const pass   = document.getElementById('password').value.trim();

    document.getElementById('emailErr').textContent = '';
    document.getElementById('passErr').textContent  = '';

    if (!email) {
        document.getElementById('emailErr').textContent = 'Email is required.';
        valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('emailErr').textContent = 'Invalid email format.';
        valid = false;
    }

    if (!pass) {
        document.getElementById('passErr').textContent = 'Password is required.';
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>

<?php include "views/layout/footer.php"; ?>
