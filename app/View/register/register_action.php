<?php
require_once __DIR__ . "/../../controller/Usercontroller/Usercontroller.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST["username"];
    $password=$_POST["password"];
    $role=$_POST["role"];
    $email=$_POST["email"];

    $controller=new UserController();
    $message=$controller->register($username,$password,$role,$email);

    echo $message;
}
?>