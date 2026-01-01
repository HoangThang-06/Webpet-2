<?php
require_once __DIR__."/../DTO/Pet.php";
class PetDAO {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    // Thêm pet mới
    public function addPet(Pet $pet) {
        $sql = "INSERT INTO pets (name, species, age, gender, description, status, image, click)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        $name        = $pet->getName();
        $species     = $pet->getSpecies();
        $age         = $pet->getAge();
        $gender      = $pet->getGender();
        $description = $pet->getDescription();
        $status      = $pet->getStatus();
        $image       = $pet->getImage();
        $click       = $pet->getClick();
        $stmt->bind_param(
            "ssissssi",
            $name,
            $species,
            $age,
            $gender,
            $description,
            $status,
            $image,
            $click
        );
        return $stmt->execute();
    }
    // Lấy pet theo tên
    public function getPetByName($name) {
        $sql = "SELECT id, name FROM pets WHERE name = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;

        $stmt->bind_param("s", $name);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    // Xóa pet
    public function deletePet($id) {
        // Lấy đường dẫn ảnh
        $sqlGet = "SELECT image FROM pets WHERE id = ?";
        $stmt = $this->conn->prepare($sqlGet);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result && !empty($result["image"])) {
            $imagePath = __DIR__ . "/../../public" . $result["image"];
            if (file_exists($imagePath)) unlink($imagePath);
        }
        // Xóa pet trong DB
        $sqlDelete = "DELETE FROM pets WHERE id = ?";
        $stmtDelete = $this->conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id);
        return $stmtDelete->execute();
    }
    // Lấy pet hot nhất
    public function getTopPet() {
        $sql = "SELECT * FROM pets ORDER BY click DESC LIMIT 1";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    // Lấy tất cả pet
    public function getAllPets() {
        $sql = "SELECT * FROM pets ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $pets = [];
        while ($row = $result->fetch_assoc()) {
            $pets[] = $row;
        }
        return $pets;
    }
    // Cập nhật pet
    public function updatePet($data) {
        $sql = "UPDATE pets 
                SET name = ?, species = ?, age = ?, gender = ?, status = ?, description = ?, image = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssissssi",
            $data["name"],
            $data["species"],
            $data["age"],
            $data["gender"],
            $data["status"],
            $data["description"],
            $data["image"],
            $data["id"]
        );
        return $stmt->execute();
    }
}
?>
