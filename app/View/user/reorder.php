<?php
session_start();
include('../../controller/dbconnect.php');

if (!isset($_SESSION['user']['id_user'])) {
    die("Bạn chưa đăng nhập!");
}

$idUser  = $_SESSION['user']['id_user'];
$orderId = intval($_GET['order_id'] ?? 0);

if ($orderId <= 0) {
    die("Đơn hàng không hợp lệ!");
}

/* ================= LẤY SẢN PHẨM TỪ ĐƠN CŨ ================= */
$stmt = $conn->prepare("
    SELECT oi.product_id, oi.quantity
    FROM order_items oi
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($item = $result->fetch_assoc()) {

    // Kiểm tra tồn kho (KHÔNG TRỪ)
    $stmtCheck = $conn->prepare("SELECT quantity FROM product WHERE id = ?");
    $stmtCheck->bind_param("i", $item['product_id']);
    $stmtCheck->execute();
    $stock = $stmtCheck->get_result()->fetch_assoc();

    if (!$stock || $stock['quantity'] < $item['quantity']) {
        die("Sản phẩm #{$item['product_id']} không đủ số lượng để mua lại.");
    }

    $cartItems[] = $item;
}

if (empty($cartItems)) {
    die("Không có sản phẩm để mua lại.");
}

/* ================= TẠO ĐƠN HÀNG MỚI ================= */
$stmtOrder = $conn->prepare("
    INSERT INTO orders (user_id, payment_method, description, status, created_at)
    VALUES (?, 'COD', ?, 'processing', NOW())
");

$desc = "Mua lại đơn #DH" . str_pad($orderId, 4, "0", STR_PAD_LEFT);
$stmtOrder->bind_param("is", $idUser, $desc);
$stmtOrder->execute();
$newOrderId = $stmtOrder->insert_id;
$stmtOrder->close();

/* ================= THÊM ORDER ITEMS (KHÔNG TRỪ KHO) ================= */
$stmtItem = $conn->prepare("
    INSERT INTO order_items (order_id, product_id, quantity)
    VALUES (?, ?, ?)
");

foreach ($cartItems as $item) {
    $stmtItem->bind_param("iii", $newOrderId, $item['product_id'], $item['quantity']);
    $stmtItem->execute();
}
$stmtItem->close();

echo "<script>
    alert('Đã tạo đơn hàng mới #DH".str_pad($newOrderId,4,"0",STR_PAD_LEFT)." (Đang xử lý)');
    window.location.href='historyorder.php';
</script>";
?>
