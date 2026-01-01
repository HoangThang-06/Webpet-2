<?php
require_once __DIR__."/../model/DTO/Pet.php";
require_once __DIR__."/../model/DAO/PetDAO.php";
require_once __DIR__."/DBConnection.php";

class PetController {

    private $dao;

    public function __construct() {
        $conn = (new DBConnection())->getConnection();
        $this->dao = new PetDAO($conn);
    }

    public function getAllPets() {
        return $this->dao->getAllPets();
    }

    public function getTopPet() {
        return $this->dao->getTopPet();
    }

    /* ================= ADD PET ================= */
    public function addPet() {

        if (!isset($_POST["name"])) {
            return ["status" => "error", "message" => "Thiếu dữ liệu"];
        }

        $name        = trim($_POST["name"]);
        $species     = $_POST["species"];
        $age         = (int)$_POST["age"];
        $gender      = $_POST["gender"];
        $description = $_POST["description"];
        $status      = "available";
        $click       = 0;

        // check trùng tên
        if ($this->dao->getPetByName($name)) {
            return ["status" => "error", "message" => "Tên pet đã tồn tại"];
        }

        /* ===== UPLOAD IMAGE ===== */
        $imagePath = null;
        if (!empty($_FILES["image"]["name"])) {
            $dir = $_SERVER["DOCUMENT_ROOT"] . "/public/img/pet/";
            if (!is_dir($dir)) mkdir($dir, 0777, true);

            $fileName = time() . "_" . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $dir . $fileName);
            $imagePath = "/public/img/pet/" . $fileName;
        }

        $pet = new Pet(
            null,
            $name,
            $species,
            $age,
            $gender,
            $description,
            $status,
            $imagePath,
            $click
        );

        return $this->dao->addPet($pet)
            ? ["status" => "success", "message" => "Thêm pet thành công"]
            : ["status" => "error", "message" => "Thêm pet thất bại"];
    }

    /* ================= DELETE ================= */
    public function handleDeletePetAPI() {
        $id = $_POST["id"] ?? null;
        if (!$id) {
            echo json_encode(["success" => false, "message" => "Thiếu ID"]);
            return;
        }

        echo json_encode([
            "success" => $this->dao->deletePet($id),
            "message" => "Đã xóa pet"
        ]);
    }

    /* ================= UPDATE ================= */
    public function handleUpdatePetAPI() {

        $id = $_POST["id"] ?? null;
        if (!$id) {
            echo json_encode(["success" => false, "message" => "Thiếu ID"]);
            return;
        }

        $image = $_POST["image_old"] ?? "";

        if (!empty($_FILES["image"]["name"])) {
            $dir = $_SERVER["DOCUMENT_ROOT"] . "/public/img/pet/";
            $fileName = time() . "_" . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $dir . $fileName);

            if ($image && file_exists($_SERVER["DOCUMENT_ROOT"] . $image)) {
                unlink($_SERVER["DOCUMENT_ROOT"] . $image);
            }

            $image = "/public/img/pet/" . $fileName;
        }

        $data = [
            "id"          => $id,
            "name"        => $_POST["name"],
            "species"     => $_POST["species"],
            "age"         => (int)$_POST["age"],
            "gender"      => $_POST["gender"],
            "status"      => $_POST["status"],
            "description" => $_POST["description"],
            "image"       => $image
        ];

        echo json_encode([
            "success" => $this->dao->updatePet($data),
            "message" => "Cập nhật thành công"
        ]);
    }
}
