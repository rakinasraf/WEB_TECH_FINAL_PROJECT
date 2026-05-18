<!DOCTYPE html>
<html>

<head>

<title>Login</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Delivery Manager Login</h2>

<form method="POST">

<input
type="email"
name="email"
placeholder="Enter Email"

value="<?php
echo isset($_COOKIE['delivery_manager_email'])
? $_COOKIE['delivery_manager_email']
: $data['email'];
?>"
>

<p class="error">
<?php echo $data['emailErr']; ?>
</p>

<input
type="password"
name="password"
placeholder="Enter Password"
>

<p class="error">
<?php echo $data['passwordErr']; ?>
</p>

<label>

<input
type="checkbox"
name="remember"
>

Remember Me

</label>

<br><br>

<input
type="submit"
value="Login"
class="btn"
>

</form>

<p class="error">
<?php echo $data['error']; ?>
</p>

</div>

</body>
</html>