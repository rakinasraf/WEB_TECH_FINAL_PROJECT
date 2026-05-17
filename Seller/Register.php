<!DOCTYPE html>
<html>
<head>
<title>Seller Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
<h2>Seller Registration</h2>
<a href="Login.php" class="btn btn-add">Login</a>
</div>
<div class="container">
<form action="AuthController.php" method="POST">
    <input type="hidden" name="action" value="register">
    Name:<br><input type="text" name="name"><br><br>
    Email:<br><input type="email" name="email"><br><br>
    Phone:<br><input type="text" name="phone"><br><br>
    Password:<br><input type="password" name="password"><br><br>
    Shop Name:<br><input type="text" name="shop_name"><br><br>
    Address:<br><textarea name="address"></textarea><br><br>
    <input type="submit" value="Register"><br><br>
<?php
session_start();
if(isset($_SESSION['success']))
{
    echo "<p style='color:green'>";
    echo $_SESSION['success'];
    echo "</p>";
    unset($_SESSION['success']);
}
if(isset($_SESSION['error']))
{
    echo "<p style='color:red'>";
    echo $_SESSION['error'];
    echo "</p>";
    unset($_SESSION['error']);
}
?>
</form>
</div>
</body>
</html>