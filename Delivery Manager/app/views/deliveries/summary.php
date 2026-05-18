<!DOCTYPE html>
<html>

<head>

<title>Delivery Summary</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<h2>Delivery Summary</h2>

<div class="card-container">

<div class="card">

Total Delivered

<br><br>

<?php echo $data['delivered']; ?>

</div>

<div class="card">

Total Failed

<br><br>

<?php echo $data['failed']; ?>

</div>

<div class="card">

In Transit

<br><br>

<?php echo $data['transit']; ?>

</div>

</div>

<br><br>

<h2>Daily Summary</h2>

<div class="card-container">

<div class="card">

Delivered Today

<br><br>

<?php
echo $data['daily_delivered'];
?>

</div>

<div class="card">

Failed Today

<br><br>

<?php
echo $data['daily_failed'];
?>

</div>

</div>

<br><br>

<h2>Weekly Summary</h2>

<div class="card-container">

<div class="card">

Delivered This Week

<br><br>

<?php
echo $data['weekly_delivered'];
?>

</div>

<div class="card">

Failed This Week

<br><br>

<?php
echo $data['weekly_failed'];
?>

</div>

</div>

<br><br>

<div style="text-align:center;">

<a href="<?php echo BASE_URL; ?>/?url=dashboard"
class="btn back-btn">

Back to Dashboard

</a>

</div>

</div>

</body>
</html>