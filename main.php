<!DOCTYPE html>
<html>
<head>
<title>Home Page</title>
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Arial, sans-serif;
}
body{
    background:#f4f6f9;
}
.navbar{
    width:100%;
    background:#1f2937;
    padding:20px;
    text-align:center;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
}
.navbar h1{
    color:white;
    font-size:32px;
    letter-spacing:1px;
}
.container{
    width:450px;
    background:white;
    margin:40px auto;
    padding:40px;
    border-radius:10px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    text-align:center;
}
.container p{
    font-size:20px;
    color:#333;
    margin-bottom:30px;
    font-weight:bold;
}
.container a{
    display:block;
    text-decoration:none;
    background:#2563eb;
    color:white;
    padding:10px;
    margin:5px 0;
    border-radius:6px;
    font-size:17px;
    transition:0.3s;
}
.container a:hover{
    background:#1d4ed8;
}
</style>
</head>
<body>
<div class="navbar">
<h1>Home Page</h1>
</div>
<div class="container">
Welcome to E-COMMERCE STORE<br><br>
<a href="Admin/index.php">Enter As Admin</a><br><br>
<a href="Seller/index.php">Enter As Seller</a><br><br>
<a href="Customer/index.php">Enter As Customer</a><br><br>
<a href="Delivery Manager/public/index.php">Enter As Delivery Manager</a><br><br>
</div>
</body>
</html>