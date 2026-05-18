<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkAuth() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?action=login");
        exit();
    }
}
