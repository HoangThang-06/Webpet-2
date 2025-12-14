<?php
require_once __DIR__."/../model/DTO/Pet.php";
require_once __DIR__."/../model/DAO/PetDAO.php";
require_once __DIR__."/DBConnection.php";

class PetController{

    private $dao;

    public function __construct(){
        $conn=(new DBConnection())->getConnection();
        $this->dao = new PetDAO($conn);
    }

    public function getAllPets() {
    return $this->dao->getAllPets();
    }

    public function getTopPet(){
        return $this->dao->getTopPet();
    }

    public function addPet() {

        if (!isset($_POST["name_pet"])) {
            return ["status" => "error", "message" => "Thiếu dữ liệu POST"];
        }

        $name_pet    = trim($_POST["name_pet"]);
        $gender      = $_POST["gender"];
        $description = $_POST["description"];
        $state       = $_POST["state"] ?? "available";
        $click       = 0;

        // KIỂM TRA TRÙNG TÊN
        $existPet = $this->dao->getPetByName($name_pet);
        if ($existPet) {
            return [
                "status"  => "error",
                "message" => "Tên thú cưng đã tồn tại"
            ];
        }

        // ========== UPLOAD ẢNH ==========
        $imageName = null;

        if (!empty($_FILES["image"]["name"])) {

            $folder = __DIR__ . "/../../public/img/pet/";
            if (!is_dir($folder)) mkdir($folder, 0777, true);

            $fileName   = time() . "_" . basename($_FILES["image"]["name"]);
            $targetPath = $folder . $fileName;

            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
                return ["status" => "error", "message" => "Upload ảnh thất bại"];
            }

            $imageName = "/public/img/pet/" . $fileName;
        }

        // ========== INSERT ==========
        $pet = new Pet(
            null,
            $name_pet,
            $gender,
            $description,
            $state,
            $imageName,
            $click
        );

        $result = $this->dao->addPet($pet);

        if ($result) {
            return ["status" => "success", "message" => "Thêm thú cưng thành công"];
        } else {
            return ["status" => "error", "message" => "Thêm thất bại"];
        }
    }

    public function handleDeletePetAPI() {
        $id = $_POST["id"] ?? null;
        $image = $_POST["image"] ?? null;

        if (!$id) {
            echo json_encode([
                "success" => false,
                "message" => "Thiếu ID pet"
            ]);
            return;
        }

        if (!empty($image)) {
            $imagePath = $_SERVER["DOCUMENT_ROOT"] . $image;

            if (file_exists($imagePath) && strpos($image, "avtdefault") === false) {
                unlink($imagePath);
            }
        }

        $result = $this->dao->deletePet($id);

        echo json_encode([
            "success" => $result,
            "message" => $result ? "Xóa pet thành công" : "Xóa pet thất bại"
        ]);
    }


 public function handleUpdatePetAPI() {
    $id = $_POST["id_pet"] ?? null;

    if (!$id) {
        echo json_encode([
            "success" => false,
            "message" => "Thiếu ID pet"
        ]);
        return;
    }

    $imageOld = $_POST["image_old"] ?? "";

    $data = [
        "id_pet"      => $id,
        "name_pet"    => $_POST["name_pet"] ?? "",
        "gender"      => $_POST["gender"] ?? "",
        "state"       => $_POST["state"] ?? "",
        "description" => $_POST["description"] ?? "",
        "image"       => $imageOld
    ];

    /* ===== UPLOAD ẢNH MỚI ===== */
    if (!empty($_FILES["image"]["name"])) {
        $uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/public/img/pet/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {

            // ===== XÓA ẢNH CŨ =====
            if (!empty($imageOld)) {
                $oldPath = $_SERVER["DOCUMENT_ROOT"] . $imageOld;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $data["image"] = "/public/img/pet/" . $fileName;
        }
    }

    $result = $this->dao->updatePet($data);

    echo json_encode([
        "success" => $result,
        "message" => $result ? "Cập nhật thành công" : "Cập nhật thất bại"
    ]);
}
}
?>