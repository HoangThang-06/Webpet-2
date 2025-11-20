<?php
require_once __DIR__ . "/../DTO/User.php";

class UserDAO{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function addUser($user){
        $stmt = $this->conn->prepare(
            "INSERT INTO users (username, password, role, email) VALUES (?, ?, ?, ?)"
        );
        $username = $user->getUsername();
        $password = $user->getPassword();
        $role = $user->getRole();
        $email = $user->getEmail();

        $stmt->bind_param("ssss", $username, $password, $role, $email);

        return $stmt->execute();
    }

    public function getUserByUsername($username){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
