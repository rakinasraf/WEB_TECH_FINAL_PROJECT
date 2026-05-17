<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
if(!isset($_SESSION['seller_id']))
{
    header("Location: Login.php");
    exit();
}
?>
<div class="navbar">
<h2>Add Product</h2>
<a href="dashboard.php" class="btn btn-delete">Back</a>
</div>
<div class="container">
<form action="ProductController.php" method="POST" enctype="multipart/form-data">
    Product Name:<br><input type="text" name="name"><br><br>
    Description:<br><textarea name="description"></textarea><br><br>
    Price:<br><input type="number" step="0.01" name="price"><br><br>
    Stock Quantity:<br><input type="number" name="stock_qty"><br><br>
    Category:<br>
    <select name="category_id">
        <option value="1">Electronics</option>
        <option value="2">Fashion</option>
        <option value="3">Books</option>
    </select><br><br>
    Product Image:<br>
    <input type="file" name="image"><br><br>
    <button type="submit" name="add_product" class="btn btn-add">Add Product</button>
<?php
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