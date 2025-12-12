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

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id_user=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getUserByUsername($username){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function loginDAO($user, $password) {
    if (password_verify($password, $user['password'])) {

        unset($user['password']); // Xóa password khỏi session
        
        $_SESSION['user'] = $user;

        if ($user["role"] === "admin") {
            if ($user["status"] === "disapproved")
                return "admin_disapproved";
            else 
                return "admin_ok";
        } else {
            return "user";
        }
    }

    return "error_password";
    }

    public function resetpw($email, $newpw) {
    $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $password = password_hash($newpw, PASSWORD_DEFAULT);

    $stmt->bind_param("ss", $password, $email);
    $stmt->execute();

    return $stmt->affected_rows > 0;
    }

    // Lấy tất cả user ngoại trừ user hiện tại
    public function getAllUsersExcept($currentUserId) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id_user != ?");
        $stmt->bind_param("i", $currentUserId);
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    // xóa người dùng
    public function deleteUser($id) {
        // Lấy đường dẫn avatar trước
        $stmt = $this->conn->prepare("SELECT avatar FROM users WHERE id_user=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        $avatarPath = $result["avatar"] ?? null;

        // Xóa user trong DB
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id_user=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Xóa file avatar nếu tồn tại
            if (!empty($avatarPath)) {
                $file = __DIR__ . "/../../../public/img/avatars/" . basename($avatarPath);
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            return true;
        }
        return false;
    }

    // Sửa thông tin người dùng
    public function updateUser($user) {
        $sql = "UPDATE users 
                SET username = ?, fullname = ?, phone = ?, birthday = ?, gender = ?, 
                    address = ?, avatar = ?, password = ?, role = ?, email = ?, status = ?
                WHERE id_user = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssssssssssi",
            $user["username"],
            $user["fullname"],
            $user["phone"],
            $user["birthday"],
            $user["gender"],
            $user["address"],
            $user["avatar"],
            $user["password"],
            $user["role"],
            $user["email"],
            $user["status"],
            $user["id_user"]
        );

        return $stmt->execute();
    }

    public function getUserRegistrationByMonth() {
        $sql = "SELECT MONTH(created_at) AS month, COUNT(*) AS total 
                FROM users 
                GROUP BY MONTH(created_at)
                ORDER BY month";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;  // Thêm từng hàng vào mảng
        }

        return $data;
    }   
}
?>
