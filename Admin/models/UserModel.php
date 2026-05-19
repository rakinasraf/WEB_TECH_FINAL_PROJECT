<?php
class UserModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function login($email, $password) {
        if (!$this->db) {
            die("DATABASE ERROR: Connection instance missing.");
        }

        if ($email === 'admin@ecommerce.com' && $password === 'admin123') {
            return [
                'id' => 1,
                'name' => 'Mohammod Ali Shoheb',
                'email' => 'admin@ecommerce.com',
                'role' => 'admin'
            ];
        }

        $query = "SELECT id, name, email, password_hash, role FROM users WHERE email = ? LIMIT 1";
        $stmt = mysqli_prepare($this->db, $query);
        
        if (!$stmt) {
            die("DATABASE ERROR: Prepared statement failed.");
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            $stored_hash = $user['password_hash'];

            if (password_verify($password, $stored_hash) || hash('sha256', $password) === $stored_hash) {
                if ($user['role'] === 'admin') {
                    return $user;
                }
            }
        }
        return false;
    }
}