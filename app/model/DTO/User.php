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
    private $fullname;
    private $phone;
    private $address;
    private $birthday;
    private $gender;
    private $avatar;

    // Constructor
    public function __construct(
        $id_user = null, 
        $username = null, 
        $password = null,
        $role = null, 
        $email = null, 
        $created_at = null, 
        $status = null,
        $fullname = null,
        $phone = null,
        $address = null,
        $birthday = null,
        $gender = null,
        $avatar = null
    ) {
        $this->id_user    = $id_user;
        $this->username   = $username;
        $this->password   = $password;
        $this->role       = $role;
        $this->email      = $email;
        $this->created_at = $created_at;
        $this->status     = $status;
        $this->fullname   = $fullname;
        $this->phone      = $phone;
        $this->address    = $address;
        $this->birthday   = $birthday;
        $this->gender     = $gender;
        $this->avatar     = $avatar;
    }

    /* =======================
         GETTERS
    ======================= */

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

    public function getStatus() {
        return $this->status;
    }

    public function getFullname() {
        return $this->fullname;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    /* =======================
         SETTERS
    ======================= */

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

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }
}

?>
