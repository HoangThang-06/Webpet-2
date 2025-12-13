<?php
session_start();
include('../../controller/dbconnect.php');

if (!isset($_SESSION['user']['id_user'])) {
    die("Bạn chưa đăng nhập!");
}

$idUser = $_SESSION['user']['id_user'];
$total = $_POST['total'] ?? 0;
$payment_method = $_POST['payment_method'] ?? "COD";
$description = $_POST['description'] ?? "";
$directProduct = $_POST['direct_product'] ?? null;

$cartItems = [];

// 1. Lấy sản phẩm trực tiếp
if ($directProduct !== null) {
    $productId = intval($directProduct);
    $sql = "SELECT id AS product_id, name, price, quantity FROM products WHERE id = $productId";
    $result = $conn->query($sql);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        if ($product['quantity'] < 1) {
            die("Sản phẩm '{$product['name']}' hiện đang hết hàng!");
        }
        $product['quantity'] = 1; // mua 1 cái
        $cartItems[] = $product;
    }
}
// 2. Lấy từ giỏ hàng
else {
    $sql = "
        SELECT 
            c.quantity,
            p.id AS product_id,
            p.name,
            p.price,
            p.quantity AS stock
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = $idUser
    ";

    $result = $conn->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['quantity'] > $row['stock']) {
            die("Sản phẩm '{$row['name']}' chỉ còn {$row['stock']} trong kho. Vui lòng điều chỉnh số lượng!");
        }
        $cartItems[] = $row;
    }
}

if (empty($cartItems)) {
    die("Không có sản phẩm nào để đặt hàng!");
}

// 3. Tạo đơn hàng
$stmt = $conn->prepare("
    INSERT INTO orders (user_id, payment_method, description, status, created_at)
    VALUES (?, ?, ?, 'Completed', NOW())
");
$stmt->bind_param("iss", $idUser, $payment_method, $description);
$stmt->execute();
$orderId = $stmt->insert_id;
$stmt->close();

// 4. Thêm order items và trừ số lượng sản phẩm
$stmtItem = $conn->prepare("
    INSERT INTO order_items (order_id, product_id, quantity)
    VALUES (?, ?, ?)
");
$stmtUpdate = $conn->prepare("
    UPDATE products SET quantity = quantity - ? WHERE id = ?
");

foreach ($cartItems as $item) {
    // Thêm vào order_items
    $stmtItem->bind_param("iii", $orderId, $item['product_id'], $item['quantity']);
    $stmtItem->execute();

    // Trừ số lượng trong products
    $stmtUpdate->bind_param("ii", $item['quantity'], $item['product_id']);
    $stmtUpdate->execute();
}

$stmtItem->close();
$stmtUpdate->close();

// 5. Xóa giỏ hàng nếu mua từ giỏ
if ($directProduct === null) {
    $conn->query("DELETE FROM cart WHERE user_id = $idUser");
}

?>
<script>
    alert("Thanh toán thành công!");
    window.location.href = "products.php?order_id=<?= $orderId ?>";
</script>
