<!DOCTYPE html>
<html>
<head>
<title>Manage Product</title>
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
$products = $model->getProducts($_SESSION['seller_id']);
?>
<div class="navbar">
<h2>Manage Products</h2>
<a href="dashboard.php" class="btn btn-delete">Back</a>
</div>
<div class="container">
<a href="add_product.php" class="btn btn-add">Add New Product</a>
<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Status</th>
    <th>Action</th>
</tr>
<?php while($row = $products->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><img src="<?php echo $row['primary_image_path']; ?>" width="80"></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['category_name']; ?></td>
    <td><?php echo $row['price']; ?></td>
    <td><?php echo $row['stock_qty']; ?></td>
    <td>
    <button class="ajaxBtn" data-id="<?php echo $row['id']; ?>">
    <?php
    if($row['is_available'] == 1){echo "Available";}
    else{echo "Unavailable";}
    ?>
    </button></td>
    <td><a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
        <a href="ProductController.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete">Delete</a>
    </td></tr>
<?php } ?>
</table>
</div>
<script>
let buttons = document.querySelectorAll(".ajaxBtn");
buttons.forEach(button => {
    button.addEventListener("click", function(){
        let productId = this.dataset.id;
        let currentButton = this;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if(this.readyState == 4 && this.status == 200)
            {
                let response = JSON.parse(this.responseText);
                if(response.success)
                {
                    if(response.newStatus == 1)
                    {currentButton.innerHTML = "Available";}
                    else
                    {currentButton.innerHTML = "Unavailable";}
                }
            }
        };
        xhttp.open("POST", "toggle_product.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("product_id=" + productId);
    });
});
</script>
</script>
</body>
</html>