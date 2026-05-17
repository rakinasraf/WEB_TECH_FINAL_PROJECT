<!DOCTYPE html>
<html>
<head>
    <title>Seller Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once("database.php");
require_once("ProfileModel.php");
session_start();
if(!isset($_SESSION['seller_id']))
{
    header("Location: login.php");
    exit();
}
$model = new ProfileModel($conn);
$profile = $model->getProfile($_SESSION['seller_id']);
?>
<div class="navbar">
<h2>Seller Profile</h2>
<a href="dashboard.php">Dashboard</a>
</div>
<div class="container">
<form action="ProfileController.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?php echo $profile['user_id']; ?>">
    Name:<input type="text" name="name" value="<?php echo htmlspecialchars($profile['name']); ?>">
    Email:<input type="email" value="<?php echo htmlspecialchars($profile['email']); ?>" disabled>
    Phone:<input type="text" name="phone" value="<?php echo htmlspecialchars($profile['phone']); ?>">
    Shop Name:<input type="text" name="shop_name" value="<?php echo htmlspecialchars($profile['shop_name']); ?>">
    Description:<textarea name="description"><?php echo $profile['shop_description']; ?></textarea>
    Address:<textarea name="address"><?php echo htmlspecialchars($profile['address']); ?></textarea>
    Current Logo:<br><br><img src="<?php echo $profile['shop_logo_path']; ?>" width="120"><br><br>
    Change Logo:<input type="file" name="logo">
    <button type="submit" name="update_profile">Update Profile</button><br><br>
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