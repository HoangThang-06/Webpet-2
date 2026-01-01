<?php
require_once __DIR__."/../DTO/Product.php";

class ProductDAO{
    private $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }

    // Thêm sản phẩm mới
    public function addProduct(Product $product) {
        $sql = "INSERT INTO product (name_product, category, price, quantity, description, image, click)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $name = $product->getNameProduct();
        $Category = $product->getCategory();
        $price = $product->getPrice();
        $quantity = $product->getQuantity();
        $description = $product->getDescription();
        $imge = $product->getImage();
        $click = $product->getClick();

        $stmt->bind_param("ssiiisi", $name, $Category, $price, $quantity, $description, $imge, $click);

        return $stmt->execute();
    }
    public function getProductByNameAndCategory($name, $category) {
        $sql = "SELECT id_product, quantity 
                FROM product 
                WHERE name_product = ? AND category = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $name, $category);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc(); // null nếu không có
    }


    public function increaseQuantity($id_product, $addQty) {
        $sql = "UPDATE product SET quantity = quantity + ? WHERE id_product = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $addQty, $id_product);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM product WHERE id_product = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function updateProduct($data) {
        $sql = "UPDATE product 
                SET name_product = ?, category = ?, price = ?, quantity = ?, 
                    description = ?, image = ?
                WHERE id_product = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssdissi",
            $data["name_product"],
            $data["category"],
            $data["price"],
            $data["quantity"],
            $data["description"],
            $data["image"],
            $data["id_product"]
        );

        return $stmt->execute();
    }

    // Lấy tất cả pet
    public function getAllProduct() {
    $sql = "SELECT * FROM product ORDER BY id_product DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result(); // Lấy kết quả từ prepared statement
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row; // Lưu từng bản ghi vào mảng
    }
    return $products;
    }
}
?>