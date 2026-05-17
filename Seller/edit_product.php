<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once("database.php");
require_once("ProductModel.php");
session_start();
if(!isset($_SESSION['seller_id']))
{
    header("Location: Login.php");
    exit();
}
$model = new ProductModel($conn);
$product = $model->getSingleProduct($_GET['id'],$_SESSION['seller_id']);
?>
<div class="navbar">
<h2>Edit Product</h2>
<a href="dashboard.php" class="btn btn-delete">Back</a>
</div>
<div class="container">
<form action="ProductController.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
    Product Name:<br><input type="text" name="name" value="<?php echo $product['name']; ?>"><br><br>
    Description:<br><textarea name="description"><?php echo $product['description']; ?></textarea><br><br>
    Price:<br><input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>"><br><br>
    Stock Quantity:<br><input type="number" name="stock_qty" value="<?php echo $product['stock_qty']; ?>"><br><br>
    Category:<br>
    <select name="category_id">
        <option value="1">Electronics</option>
        <option value="2">Fashion</option>
        <option value="3">Books</option>
    </select>
    <br><br>
    <button type="submit" name="update_product">Update Product</button>
</form>
</div>
</body>
</html>