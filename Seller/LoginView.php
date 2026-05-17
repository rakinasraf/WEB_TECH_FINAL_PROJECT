<!DOCTYPE html>
<html>
<head>
<title>Seller Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
<h2>Seller Login</h2>
<a href="Register.php" class="btn btn-delete">Register</a>
</div>
<div class="container">
<form action="AuthController.php" method="POST">
    <input type="hidden" name="action" value="login">
    Email:<br><input type="email" name="email"><br><br>
    Password:<br><input type="password" name="password"><br><br>
    <button type="submit">Login</button><br><br>
<?php
session_start();
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