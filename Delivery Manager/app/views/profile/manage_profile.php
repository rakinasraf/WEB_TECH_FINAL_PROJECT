<!DOCTYPE html>
<html>

<head>

<title>Manage Profile</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>My Profile</h2>

<a href="<?php echo BASE_URL; ?>/?url=dashboard"
class="btn">

Back To Dashboard

</a>

<br><br>

<?php
if(
$data['user']['profile_image']
!=
""
)
{
?>

<img

src="<?php
echo BASE_URL;
?>/uploads/<?php
echo $data['user']['profile_image'];
?>"

width="120"
height="120"

style="
border-radius:50%;
object-fit:cover;
">

<?php } ?>

<form
method="POST"
enctype="multipart/form-data"
>

<h3>Update Profile</h3>

<input
type="text"
name="name"

value="<?php
echo $data['user']['name'];
?>"

placeholder="Enter Name"

required
>

<input
type="email"
name="email"

value="<?php
echo $data['user']['email'];
?>"

placeholder="Enter Email"

required
>

<input
type="text"
name="phone"

value="<?php
echo $data['user']['phone'];
?>"

placeholder="Enter Phone"
>

<label>
Profile Image
</label>

<input
type="file"
name="profile_image"
>

<br><br>

<input
type="submit"
name="update_profile"
value="Update Profile"
class="btn"
>

</form>

<hr>

<form method="POST">

<h3>Change Password</h3>

<input
type="password"
name="old_password"
placeholder="Old Password"
required
>

<input
type="password"
name="new_password"
placeholder="New Password"
required
>

<input
type="password"
name="confirm_password"
placeholder="Confirm Password"
required
>

<input
type="submit"
name="change_password"
value="Change Password"
class="btn"
>

</form>

<p class="success">

<?php
echo $data['success'];
?>

</p>

<p class="error">

<?php
echo $data['error'];
?>

</p>

</div>

</body>
</html>