<!DOCTYPE html>
<html>

<head>

<title>Dashboard</title>

<link rel="stylesheet"
href="<?php echo BASE_URL; ?>/assets/css/style.css">

</head>

<body>

<div class="container">

<div style="
display:flex;
align-items:center;
justify-content:space-between;
gap:20px;
flex-wrap:wrap;
margin-bottom:30px;
">

<div style="
display:flex;
align-items:center;
gap:15px;
">

<?php
if($data['profile_image']!="")
{
    echo "
    <img
    src='".BASE_URL."/uploads/".$data['profile_image']."'
    width='80'
    height='80'
    style='
    border-radius:50%;
    object-fit:cover;
    margin:0;
    border:3px solid rgba(255,255,255,0.3);
    '>
    ";
}
?>

<div>

<h2 style="
margin:0;
text-align:left;
">

Welcome
<?php echo $_SESSION['manager']; ?>

</h2>

<?php
if(isset($_COOKIE["delivery_manager_email"]))
{
    echo "
    <p style='
    color:white;
    margin-top:5px;
    '>
    ".$_COOKIE["delivery_manager_email"]."
    </p>";
}
?>

</div>

</div>

</div>

<div class="nav">

<a href="<?php echo BASE_URL; ?>/?url=manage-agents">
Agents
</a>

<a href="<?php echo BASE_URL; ?>/?url=manage-zones">
Zones
</a>

<a href="<?php echo BASE_URL; ?>/?url=ready-orders">
Orders
</a>

<a href="<?php echo BASE_URL; ?>/?url=active-deliveries">
Deliveries
</a>

<a href="<?php echo BASE_URL; ?>/?url=delivery-history">
History
</a>

<a href="<?php echo BASE_URL; ?>/?url=agent-report">
Agent Report
</a>

<a href="<?php echo BASE_URL; ?>/?url=zone-report">
Zone Report
</a>

<a href="<?php echo BASE_URL; ?>/?url=delivery-summary">
Summary
</a>

<a href="<?php echo BASE_URL; ?>/?url=manage-profile">
My Profile
</a>

<a href="<?php echo BASE_URL; ?>/?url=logout">
Logout
</a>

</div>

<div class="card-container">

<div class="card">

Pending Dispatch

<br><br>

<?php echo $data['pending']; ?>

</div>

<div class="card">

Active Deliveries

<br><br>

<?php echo $data['active']; ?>

</div>

<div class="card">

Delivered Today

<br><br>

<?php echo $data['today']; ?>

</div>

</div>

</div>

</body>
</html>