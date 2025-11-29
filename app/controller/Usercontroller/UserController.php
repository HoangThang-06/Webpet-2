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
}
?>