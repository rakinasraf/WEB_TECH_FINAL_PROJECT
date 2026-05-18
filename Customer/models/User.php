<?php

class User {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function register($name, $email, $password, $phone) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $name  = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $hash  = mysqli_real_escape_string($this->conn, $hash);
        $phone = mysqli_real_escape_string($this->conn, $phone);

        $sql  = "INSERT INTO users (name, email, password_hash, phone, role)
                 VALUES ('$name', '$email', '$hash', '$phone', 'customer')";
        return mysqli_query($this->conn, $sql);
    }

    public function login($email) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $sql   = "SELECT * FROM users WHERE email = '$email' AND is_active = 1";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function emailExists($email) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $sql   = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }

    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function updateProfile($id, $name, $phone) {
        $id    = (int)$id;
        $name  = mysqli_real_escape_string($this->conn, $name);
        $phone = mysqli_real_escape_string($this->conn, $phone);

        $sql = "UPDATE users SET name='$name', phone='$phone' WHERE id=$id";
        return mysqli_query($this->conn, $sql);
    }

    public function updatePassword($id, $hash) {
        $id   = (int)$id;
        $hash = mysqli_real_escape_string($this->conn, $hash);

        $sql = "UPDATE users SET password_hash='$hash' WHERE id=$id";
        return mysqli_query($this->conn, $sql);
    }

    public function updateProfileImage($id, $path) {
        $id   = (int)$id;
        $path = mysqli_real_escape_string($this->conn, $path);

        $sql = "UPDATE users SET profile_image_path='$path' WHERE id=$id";
        return mysqli_query($this->conn, $sql);
    }
}
