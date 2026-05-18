<!DOCTYPE html>
<html>

<head>

<title>Add Agent</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Add Delivery Agent</h2>

<form method="POST">

<input
type="text"
name="name"
placeholder="Agent Name"
required>

<input
type="email"
name="email"
placeholder="Email"
required>

<input
type="text"
name="phone"
placeholder="Phone Number"
maxlength="11"
required>

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
type="password"
name="password"
placeholder="Password"
required>

<input
type="submit"
value="Add Agent"
class="btn">

<a href="<?php echo BASE_URL; ?>/?url=manage-agents"
class="btn back-btn">

Back to Delivery Agent

</a>

</form>

<p class="success">
<?php echo $data['success']; ?>
</p>

<p class="error">
<?php echo $data['error']; ?>
</p>

</div>

</body>
</html>