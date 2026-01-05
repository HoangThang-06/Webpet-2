<?php
require_once __DIR__."/../model/DTO/Product.php";
require_once __DIR__."/../model/DAO/ProductDAO.php";
require_once __DIR__."/DBConnection.php";

class ProductController{

    private $dao;

    public function __construct(){
        $conn=(new DBConnection())->getConnection();
        $this->dao = new ProductDAO($conn);
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts() {
        return $this->dao->getAllProduct();
    }

    // public function getTopPet(){
    //     return $this->dao->getTopPet();
    // }

    public function addProduct() {

        if (!isset($_POST["name_product"])) {
            return ["status" => "error", "message" => "Thiếu dữ liệu POST"];
        }

        $name_product = trim($_POST["name_product"]);
        $category  = $_POST["category"];
        $price        = $_POST["price"];
        $quantity     = (int)$_POST["quantity"];
        $description  = $_POST["description"];
        $click        = 0;

        $existProduct = $this->dao->getProductByNameAndCategory(
            $name_product,
            $category
        );

        if ($existProduct) {
            $this->dao->increaseQuantity(
                $existProduct['id_product'],
                $quantity
            );

            return [
                "status" => "success",
                "message" => "Sản phẩm đã tồn tại trong danh mục, đã cộng thêm số lượng"
            ];
        }

        // UPLOAD ẢNH (GIỮ NGUYÊN)
        $imageName = null;

        if (!empty($_FILES["imge"]["name"])) {

            $folder = __DIR__ . "/../../public/img/products/";
            if (!is_dir($folder)) mkdir($folder, 0777, true);

            $fileName   = time() . "_" . basename($_FILES["imge"]["name"]);
            $targetPath = $folder . $fileName;

            if (!move_uploaded_file($_FILES["imge"]["tmp_name"], $targetPath)) {
                return ["status" => "error", "message" => "Upload ảnh thất bại"];
            }

            $imageName = "/public/img/products/" . $fileName;
        }

        // THÊM SẢN PHẨM MỚI
        $product = new Product(
            null,
            $name_product,
            $category,
            $price,
            $quantity,
            $description,
            $imageName,
            $click
        );

        $result = $this->dao->addProduct($product);

        if ($result) {
            return ["status" => "success", "message" => "Thêm sản phẩm mới thành công"];
        } else {
            return ["status" => "error", "message" => "Thêm sản phẩm thất bại"];
        }
    }


    public function handleDeleteProductAPI() {
         $id    = $_POST["id_product"] ?? null;
        $image = $_POST["image"] ?? null;

        if (!$id) {
            echo json_encode([
                "success" => false,
                "message" => "Thiếu ID sản phẩm"
            ]);
            return;
        }
        if (!empty($image)) {
            $imagePath = $_SERVER["DOCUMENT_ROOT"] . $image;
            if (file_exists($imagePath) && strpos($image, "default") === false) {
                unlink($imagePath);
            }
        }
        $result = $this->dao->deleteProduct($id);
        echo json_encode([
            "success" => $result,
            "message" => $result ? "Xóa sản phẩm thành công" : "Xóa sản phẩm thất bại"
        ]);
    }

    public function handleUpdateProductAPI()
{
    $id = $_POST["id_product"] ?? null;

    if (!$id) {
        echo json_encode([
            "success" => false,
            "message" => "Thiếu ID sản phẩm"
        ]);
        return;
    }

    // Ảnh cũ (đường dẫn web)
    $imageOld = $_POST["image_old"] ?? "";

    $data = [
        "id_product"   => $id,
        "name_product" => $_POST["name_product"] ?? "",
        "category"     => $_POST["category"] ?? "",
        "price"        => $_POST["price"] ?? 0,
        "quantity"     => $_POST["quantity"] ?? 0,
        "description"  => $_POST["description"] ?? "",
        "image"        => $imageOld
    ];

    /* ===== UPLOAD ẢNH MỚI ===== */
    if (!empty($_FILES["image"]["name"])) {

        // ĐƯỜNG DẪN VẬT LÝ
        $uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/public/img/product/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $fileName = time() . "_" . uniqid() . "." . $ext;
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {

            // XÓA ẢNH CŨ
            if (!empty($imageOld)) {
                $oldPath = $_SERVER["DOCUMENT_ROOT"] . $imageOld;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // LƯU ĐƯỜNG DẪN WEB VÀO DB
            $data["image"] = "/public/img/product/" . $fileName;
        }
    }

    $result = $this->dao->updateProduct($data);

    echo json_encode([
        "success" => $result,
        "image"   => $data["image"]
    ]);
}
}
?>