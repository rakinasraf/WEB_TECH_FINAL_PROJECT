<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "e-commerce_store";

$conn = new mysqli($host, $user, $pass, $dbname,3307);

if($conn->connect_error)
{
    die("Connection Failed: " . $conn->connect_error);
}
?>