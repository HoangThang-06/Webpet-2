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

        return $this->userDAO->addUser($user)?"Dang ky thanh cong":"Dang ky that bai";
    }
}
?>