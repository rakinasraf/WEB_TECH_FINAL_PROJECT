<!DOCTYPE html>
<html>

<head>

<title>Edit Agent</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Edit Agent</h2>

<form method="POST">

<input
type="text"
name="name"

value="<?php
echo $data['agent']['name'];
?>">

<input
type="email"
name="email"

value="<?php
echo $data['agent']['email'];
?>">

<input
type="text"
name="phone"

value="<?php
echo $data['agent']['phone'];
?>">

<select name="vehicle">

<option value="Bike">
Bike
</option>

<option value="Cycle">
Cycle
</option>

<option value="Car">
Car
</option>

</select>

<input
type="submit"
name="update"
value="Update Agent"
class="btn">

<a href="<?php echo BASE_URL; ?>/?url=manage-agents"
class="btn back-btn">

Back to Delivery Agent

</a>

</form>

</div>

</body>
</html>