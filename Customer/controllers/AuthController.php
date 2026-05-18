<?php

require_once __DIR__ . "/../models/db.php";
require_once __DIR__ . "/../models/User.php";

// ── LOGIN ─────────────────────────────────────────────────────────────
function login() {

    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $err      = '';

    if (empty($email) || empty($password)) {
        $err = "All fields are required.";
    }

    if (!$err) {
        global $conn;
        $userModel = new User($conn);
        $user      = $userModel->login($email);

        if ($user && password_verify($password, $user['password_hash'])) {

            if ($user['role'] !== 'customer') {
                $err = "Access denied. Customer portal only.";
            } else {
                $_SESSION['user']    = $user;
                $_SESSION['success'] = "Welcome back, " . $user['name'] . "!";
                header("Location: index.php?action=dashboard");
                exit();
            }

        } else {
            $err = "Invalid email or password.";
        }
    }

    $_SESSION['login_error'] = $err;
    header("Location: index.php?action=login");
    exit();
}

// ── REGISTER ──────────────────────────────────────────────────────────
function register() {

    // Carry form values back on error
    $name     = trim($_POST['name']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $phone    = trim($_POST['phone']    ?? '');
    $password = trim($_POST['password'] ?? '');

    $nameErr = $emailErr = $phoneErr = $passErr = '';

    // Validate — same style as your original register.php
    if (empty($name)) {
        $nameErr = "Name is required.";
    } elseif (!preg_match("/^[a-zA-Z-' ]+$/", $name)) {
        $nameErr = "Only letters allowed.";
    }

    if (empty($email)) {
        $emailErr = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format.";
    }

    if (empty($phone)) {
        $phoneErr = "Phone is required.";
    } elseif (!preg_match("/^[0-9]{11}$/", $phone)) {
        $phoneErr = "Phone must be 11 digits.";
    }

    if (empty($password)) {
        $passErr = "Password is required.";
    } elseif (strlen($password) < 6) {
        $passErr = "Password must be at least 6 characters.";
    }

    // If any error, send back with values
    if ($nameErr || $emailErr || $phoneErr || $passErr) {
        $_SESSION['reg_errors'] = compact('nameErr','emailErr','phoneErr','passErr');
        $_SESSION['reg_old']    = compact('name','email','phone');
        header("Location: index.php?action=register");
        exit();
    }

    // Check duplicate email
    global $conn;
    $userModel = new User($conn);

    if ($userModel->emailExists($email)) {
        $_SESSION['reg_errors'] = ['emailErr' => 'This email is already registered.'];
        $_SESSION['reg_old']    = compact('name','email','phone');
        header("Location: index.php?action=register");
        exit();
    }

    $userModel->register($name, $email, $password, $phone);
    $_SESSION['success'] = "Registration successful! Please login.";
    header("Location: index.php?action=login");
    exit();
}

// ── LOGOUT ────────────────────────────────────────────────────────────
function logout() {
    session_destroy();
    header("Location: index.php?action=login");
    exit();
}

// ── UPDATE PROFILE ────────────────────────────────────────────────────
function updateProfile() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=profile");
        exit();
    }

    $id    = $_SESSION['user']['id'];
    $name  = trim($_POST['name']  ?? '');
    $phone = trim($_POST['phone'] ?? '');

    $nameErr = $phoneErr = '';

    if (empty($name)) {
        $nameErr = "Name is required.";
    } elseif (!preg_match("/^[a-zA-Z-' ]+$/", $name)) {
        $nameErr = "Only letters allowed.";
    }

    if (!empty($phone) && !preg_match("/^[0-9]{11}$/", $phone)) {
        $phoneErr = "Phone must be 11 digits.";
    }

    if ($nameErr || $phoneErr) {
        $_SESSION['profile_errors'] = compact('nameErr','phoneErr');
        header("Location: index.php?action=profile");
        exit();
    }

    $userModel = new User($conn);
    $userModel->updateProfile($id, $name, $phone);

    // Refresh session
    $_SESSION['user'] = $userModel->getById($id);
    $_SESSION['success'] = "Profile updated.";
    header("Location: index.php?action=profile");
    exit();
}

// ── CHANGE PASSWORD ───────────────────────────────────────────────────
function uploadProfilePicture() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=profile");
        exit();
    }

    if (empty($_FILES['profile_image']['name'])) {
        $_SESSION['error'] = "Please choose an image.";
        header("Location: index.php?action=profile");
        exit();
    }

    if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Image upload failed.";
        header("Location: index.php?action=profile");
        exit();
    }

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        $_SESSION['error'] = "Only JPG, PNG, or GIF images are allowed.";
        header("Location: index.php?action=profile");
        exit();
    }

    if ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) {
        $_SESSION['error'] = "Image must be under 2MB.";
        header("Location: index.php?action=profile");
        exit();
    }

    $uploadDir = __DIR__ . "/../views/uploads/profiles";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = "profile_" . $_SESSION['user']['id'] . "_" . time() . "." . $ext;
    $target   = $uploadDir . "/" . $fileName;
    $path     = "views/uploads/profiles/" . $fileName;

    if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
        $_SESSION['error'] = "Could not save uploaded image.";
        header("Location: index.php?action=profile");
        exit();
    }

    $userModel = new User($conn);
    $userModel->updateProfileImage($_SESSION['user']['id'], $path);
    $_SESSION['user'] = $userModel->getById($_SESSION['user']['id']);
    $_SESSION['success'] = "Profile picture updated.";

    header("Location: index.php?action=profile");
    exit();
}

function changePassword() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?action=profile");
        exit();
    }

    $id      = $_SESSION['user']['id'];
    $current = $_POST['current_password'] ?? '';
    $new     = $_POST['new_password']     ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $userModel = new User($conn);
    $user      = $userModel->getById($id);

    if (!password_verify($current, $user['password_hash'])) {
        $_SESSION['pass_error'] = "Current password is incorrect.";
        header("Location: index.php?action=profile");
        exit();
    }

    if (strlen($new) < 6) {
        $_SESSION['pass_error'] = "New password must be at least 6 characters.";
        header("Location: index.php?action=profile");
        exit();
    }

    if ($new !== $confirm) {
        $_SESSION['pass_error'] = "Passwords do not match.";
        header("Location: index.php?action=profile");
        exit();
    }

    $userModel->updatePassword($id, password_hash($new, PASSWORD_DEFAULT));
    $_SESSION['success'] = "Password changed successfully.";
    header("Location: index.php?action=profile");
    exit();
}
