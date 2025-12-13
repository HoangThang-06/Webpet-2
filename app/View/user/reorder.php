<?php
session_start();
include('../../controller/dbconnect.php');

if (!isset($_SESSION['user']['id_user'])) {
    die("Bạn chưa đăng nhập!");
}

$idUser = $_SESSION['user']['id_user'];
$orderId = intval($_GET['order_id'] ?? 0);

// Lấy sản phẩm và số lượng từ đơn cũ
$stmt = $conn->prepare("
    SELECT oi.product_id, oi.quantity, p.price
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($item = $result->fetch_assoc()) {
    // Kiểm tra tồn kho
    $stmtCheck = $conn->prepare("SELECT quantity FROM products WHERE id=?");
    $stmtCheck->bind_param("i", $item['product_id']);
    $stmtCheck->execute();
    $stockResult = $stmtCheck->get_result()->fetch_assoc();
    if ($stockResult['quantity'] < $item['quantity']) {
        die("Sản phẩm #{$item['product_id']} không đủ số lượng để mua lại.");
    }
    $cartItems[] = $item;
}

// Tạo đơn hàng mới
$stmtOrder = $conn->prepare("
    INSERT INTO orders (user_id, payment_method, description, status, created_at)
    VALUES (?, 'COD', 'Mua lại đơn #$orderId', 'Completed', NOW())
");
$stmtOrder->bind_param("i", $idUser);
$stmtOrder->execute();
$newOrderId = $stmtOrder->insert_id;
$stmtOrder->close();

// Thêm order_items mới và trừ số lượng sản phẩm
$stmtItem = $conn->prepare("
    INSERT INTO order_items (order_id, product_id, quantity)
    VALUES (?, ?, ?)
");
$stmtUpdate = $conn->prepare("
    UPDATE products SET quantity = quantity - ? WHERE id = ?
");

foreach ($cartItems as $item) {
    $stmtItem->bind_param("iii", $newOrderId, $item['product_id'], $item['quantity']);
    $stmtItem->execute();

    $stmtUpdate->bind_param("ii", $item['quantity'], $item['product_id']);
    $stmtUpdate->execute();
}

$stmtItem->close();
$stmtUpdate->close();

echo "<script>
    alert('Mua lại thành công đơn hàng #DH".str_pad($newOrderId,4,"0",STR_PAD_LEFT)."!');
    window.location.href='historyorder.php';
</script>";
?>
