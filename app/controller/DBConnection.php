<?php
class DBConnection{
    private $host = "localhost";
    private $username="root";
    private $password="";
    private $database="projectweb";
    private $conn;

    public function getConnection(){
        if($this->conn==null){
            $this->conn=new mysqli($this->host,$this->username,$this->password,$this->database);

            if($this->conn->connect_error){
                echo "Ket noi that bai";
            }
        }
        return $this->conn;
    }

    public function closeConnection(){
        if($this->conn!=null){
            $this->conn->close();
            $this->conn=null;
        }
    }
}
?>