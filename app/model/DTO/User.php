<?php

class User
{
    private $id_user;
    private $username;
    private $password;
    private $role;
    private $email;
    private $created_at;
    private $status;

    // Constructor
    public function __construct($id_user = null, $username = null, $password = null, 
                                $role = null, $email = null, $created_at = null, $status=null) {
        $this->id_user = $id_user;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->email = $email;
        $this->created_at = $created_at;
    }

    // Getters
    public function getIdUser() {
        return $this->id_user;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getStatus(){
        return $this->status;
    }

    // Setters
    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function setStatus($status){
        $this->status = $status;
    }
}

?>
