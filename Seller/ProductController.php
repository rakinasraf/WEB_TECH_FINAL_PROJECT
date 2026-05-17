<?php
session_start();
require_once("database.php");
require_once("ProductModel.php");

$model = new ProductModel($conn);

// ADD PRODUCT
if(isset($_POST['add_product']))
{
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $stock_qty = trim($_POST['stock_qty']);

    if(empty($name) || empty($description) || empty($price) || empty($stock_qty))
    {
        $_SESSION['error'] = "All fields required";
        header("Location: add_product.php");
        exit();
    }

    if($price <= 0)
    {
        $_SESSION['error'] = "Invalid Price";
        header("Location: add_product.php");
        exit();
    }

    if($stock_qty < 0)
    {
        $_SESSION['error'] = "Invalid Stock";
        header("Location: add_product.php");
        exit();
    }

    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png'];
    if(!in_array($imageExt,$allowed))
    {die("Only JPG, JPEG, PNG allowed");}
    if($imageSize > 2000000)
    {die("Image too large");}
    move_uploaded_file($imageTmp, $imageName);

    $data = [
        'seller_id' => $_SESSION['seller_id'],
        'category_id' => $_POST['category_id'],
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'stock_qty' => $stock_qty,
        'image' => $imageName
    ];

    if($model->addProduct($data))
    {
        header("Location: manage_products.php");
        exit();
    }
}

// UPDATE PRODUCT
if(isset($_POST['update_product']))
{
    $data = [
        'id' => $_POST['id'],
        'category_id' => $_POST['category_id'],
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'stock_qty' => $_POST['stock_qty']
    ];

    if($model->updateProduct($data))
    {
        header("Location: manage_products.php");
        exit();
    }
}

// DELETE PRODUCT
if(isset($_GET['delete']))
{
    $id = $_GET['delete'];
    if($model->deleteProduct($id))
    {
        header("Location: manage_products.php");
        exit();
    }
}
?>