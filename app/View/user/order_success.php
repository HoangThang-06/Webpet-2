<?php
session_start();
include('../../controller/dbconnect.php');

if (!isset($_SESSION['user']['id_user'])) {
    die("Bạn chưa đăng nhập!");
}
$idUser = $_SESSION['user']['id_user'];
$payment_method = $_POST['payment_method'] ?? "COD";
$description = $_POST['description'] ?? "";
$directProduct = $_POST['direct_product'] ?? null;
$cartItems = [];
if ($directProduct !== null) {
    $productId = intval($directProduct);
    $sql = "SELECT id AS product_id, name, price, quantity FROM products WHERE id = $productId";
    $result = $conn->query($sql);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        if ($product['quantity'] < 1) {
            die("Sản phẩm '{$product['name']}' hiện đang hết hàng!");
        }
        $product['quantity'] = 1;
        $cartItems[] = $product;
    }
}
else {
    $sql = "SELECT c.quantity, p.id AS product_id, p.name, p.price, p.quantity AS stock
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = $idUser";

    $result = $conn->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['quantity'] > $row['stock']) {
            die("Sản phẩm '{$row['name']}' chỉ còn {$row['stock']} trong kho!");
        }
        $cartItems[] = $row;
    }
}
if (empty($cartItems)) {
    die("Không có sản phẩm nào để đặt hàng!");
}
$stmt = $conn->prepare("
    INSERT INTO orders (user_id, payment_method, description, status, created_at)
    VALUES (?, ?, ?, 'Processing', NOW())
");
$stmt->bind_param("iss", $idUser, $payment_method, $description);
$stmt->execute();
$orderId = $stmt->insert_id;
$stmt->close();
$stmtItem = $conn->prepare("
    INSERT INTO order_items (order_id, product_id, quantity)
    VALUES (?, ?, ?)
");

foreach ($cartItems as $item) {
    $stmtItem->bind_param("iii", $orderId, $item['product_id'], $item['quantity']);
    $stmtItem->execute();
}

$stmtItem->close();
if ($directProduct === null) {
    $conn->query("DELETE FROM cart WHERE user_id = $idUser");
}
?>
<script>
    alert("Đặt hàng thành công! Đơn hàng đang chờ xử lý.");
    window.location.href = "products.php?order_id=<?= $orderId ?>";
</script>
