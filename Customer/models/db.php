<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "ecommerce_store";

$conn = mysqli_connect($host, $user, $pass, $db,3307);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
