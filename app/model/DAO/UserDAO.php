<?php
require_once __DIR__ . "/../DTO/User.php";

class UserDAO{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function addUser($user){
        $stmt = $this->conn->prepare(
            "INSERT INTO users (username, password, role, email,status) VALUES (?, ?, ?, ?, ?)"
        );
        $username = $user->getUsername();
        $password = password_hash($user->getPassword(),PASSWORD_DEFAULT);
        $role = $user->getRole();
        $email = $user->getEmail();
        $status=$user->getstatus();

        $stmt->bind_param("sssss", $username, $password, $role, $email,$status);

        return $stmt->execute();
    }

    public function getUserByUsername($username){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function loginDAO($user,$password){
        if(password_verify($password,$user['password'])){
            unset($user['password']);//xoa password trong $user
            $_SESSION['user']=$user;
            if($user["role"]=="admin"){
                if($user["status"]=="disapproved")
                    return "admin 1";
                else return "admin 2";
            }
            else return "user";
        }

        return "error";
    }

    public function resetpw($email, $newpw) {
    $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $password = password_hash($newpw, PASSWORD_DEFAULT);

    $stmt->bind_param("ss", $password, $email);
    $stmt->execute();

    return $stmt->affected_rows > 0;
    }
}
?>
