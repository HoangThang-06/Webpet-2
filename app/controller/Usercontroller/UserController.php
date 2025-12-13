<?php
require_once __DIR__ . "/../../model/DAO/UserDAO.php";
require_once __DIR__ . "/../../model/DTO/User.php";
require_once __DIR__ . "/../DBConnection.php";

class UserController{
    private $userDAO;

    public function __construct(){
        $conn=(new DBConnection())->getConnection();
        $this->userDAO = new UserDAO($conn);
    }

    public function register($username,$password,$role,$email){
        if($this->userDAO->getUserByUsername($username)){
            return "Tai khoan da ton tai";
        }

        $user=new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setRole($role);
        $user->setEmail($email);
        if($role=="admin"){
            $status="disapproved";
            $user->setStatus($status);
        }
        else{
            $status="approved";
            $user->setStatus($status);
        }

        return $this->userDAO->addUser($user)?"Dang ky thanh cong":"Dang ky that bai";
    }

        public function login($username,$password){
        $user = $this->userDAO->getUserByUsername($username);
        if(!$user){
            return "Tai khoan khong ton tai";
        }
        else{
            $messeger = $this->userDAO->loginDAO($user,$password);
            return $messeger;
        }
        
        }

    public function resetpw_ctr($email, $newpw) {
    if ($this->userDAO->resetpw($email, $newpw)) {
        return "Đổi mật khẩu thành công";
    }
    return "Đổi mật khẩu thất bại";
    }

    // Gọi DAO để lấy danh sách user ngoại trừ ID hiện tại
    public function getUsersExceptCurrent($currentUserId) {
        return $this->userDAO->getAllUsersExcept($currentUserId);
    }
    // hàm xóa người dùng
    public function deleteUser($id){
        return $this->userDAO->deleteUser($id);
    }

    public function getUserRegistrationByMonth(){
        return $this->userDAO->getUserRegistrationByMonth();
    }

    public function getUserById($id) {
        return $this->userDAO->getUserById($id);
    }

    public function getUserByUsername($name) {
        return $this->userDAO->getUserByUsername($name);
    }
    //xoa nguoi dung
    public function handleDeleteUserAPI() {
    $id = intval($_POST["id"] ?? 0);

    if ($id <= 0) {
        echo json_encode(["success" => false, "message" => "Thiếu ID"]);
        return;
    }

    $user = $this->userDAO->getUserById($id);

    if (!$user) {
        echo json_encode(["success" => false, "message" => "User không tồn tại"]);
        return;
    }

    $result = $this->userDAO->deleteUser($id);

    echo json_encode([
        "success" => $result,
        "message" => $result ? "Xóa thành công" : "Xóa thất bại"
    ]);
    }

public function handleUpdateUserAPI() {

    $id = $_POST["id_user"] ?? null;

    if (!$id) {
        echo json_encode(["success" => false, "message" => "Thiếu ID"]);
        return;
    }

    $oldUser = $this->userDAO->getUserById($id);

    if (!$oldUser) {
        echo json_encode(["success" => false, "message" => "User không tồn tại"]);
        return;
    }

    // Avatar cũ từ DB
    $oldAvatar = $oldUser["avatar"];
    $oldAvatarFile = null;

    // Nếu avatar cũ tồn tại thì convert sang đường dẫn thật
    if (!empty($oldAvatar)) {
        $oldAvatarFile = $_SERVER["DOCUMENT_ROOT"] . "/public/img/avatars/" . basename($oldAvatar);
    }

    // Xử lý avatar mới
    $avatarPath = $oldAvatar;

    if (!empty($_FILES["avatar"]["name"])) {

        // Tạo thư mục nếu chưa có
        $folder = $_SERVER["DOCUMENT_ROOT"] . "/public/img/avatars/";
        if (!is_dir($folder)) mkdir($folder, 0777, true);

        // Tạo tên mới
        $newName = time() . "_" . basename($_FILES["avatar"]["name"]);
        $target = $folder . $newName;

        // Upload
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target)) {

            // Xóa avatar cũ
            if ($oldAvatarFile && file_exists($oldAvatarFile)) {
                unlink($oldAvatarFile);
            }

            // Lưu đường dẫn mới vào DB
            $avatarPath = "../../../public/img/avatars/" . $newName;

        } else {
            echo json_encode(["success" => false, "message" => "Upload avatar thất bại"]);
            return;
        }
    }

    // Gom dữ liệu update
    $updateData = [
        "id_user" => $id,
        "username" => $_POST["username"] ?? $oldUser["username"],
        "fullname" => $_POST["fullname"] ?? $oldUser["fullname"],
        "phone" => $_POST["phone"] ?? $oldUser["phone"],
        "birthday" => $_POST["birthday"] ?? $oldUser["birthday"],
        "gender" => $_POST["gender"] ?? $oldUser["gender"],
        "address" => $_POST["address"] ?? $oldUser["address"],
        "avatar" => $avatarPath,
        "password" => $_POST["password"] ?? $oldUser["password"],
        "role" => $_POST["role"] ?? $oldUser["role"],
        "email" => $_POST["email"] ?? $oldUser["email"],
        "status" => $_POST["status"] ?? $oldUser["status"],
    ];

    $result = $this->userDAO->updateUser($updateData);

    echo json_encode([
        "success" => $result,
        "message" => $result ? "Cập nhật thành công" : "Cập nhật thất bại"
    ]);
}
}
?>