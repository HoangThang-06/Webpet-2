<?php
require_once __DIR__."/../DTO/Pet.php";

class PetDAO{
    private $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }

    // Thêm pet mới
    public function addPet(Pet $pet) {
        $sql = "INSERT INTO pet (name_pet, gender, description, state, image, click)
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $name = $pet->getNamePet();
        $gender = $pet->getGender();
        $desc = $pet->getDescription();
        $state = $pet->getState();
        $image = $pet->getImage();
        $click = $pet->getClick();

        $stmt->bind_param("sssssi", $name, $gender, $desc, $state, $image, $click);

        return $stmt->execute();
    }

    public function deletePet($id_pet){
        // Lấy đường dẫn ảnh để xóa file
        $sqlGet = "SELECT image FROM pet WHERE id_pet = ?";
        $stmt = $this->conn->prepare($sqlGet);
        $stmt->bind_param("i", $id_pet);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result && !empty($result["image"])) {
            $imagePath = __DIR__ . "/../../public" . $result["image"]; 
            // Ví dụ: /public/img/pet/xxx.webp → thành đường dẫn vật lý

            if (file_exists($imagePath)) {
                unlink($imagePath); // Xóa file ảnh
            }
        }

        // Xóa pet trong DB
        $sqlDelete = "DELETE FROM pet WHERE id_pet = ?";
        $stmtDelete = $this->conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id_pet);

        return $stmtDelete->execute();
    }

    //Lay pet hot
    public function getTopPet(){
        $sql="SELECT * FROM pet ORDER BY click DESC LIMIT 1";
        $result=$this->conn->query($sql);
        if($result && $result->num_rows>0){
            return $result->fetch_assoc();
        }
        return null;
    }
}
?>