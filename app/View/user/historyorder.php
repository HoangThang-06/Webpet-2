<?php
session_start();
require_once __DIR__."/../../controller/DBConnection.php";
$conn=(new DBConnection())->getConnection();
$idUser=$_SESSION['user']['id_user'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $orderId = intval($_POST['order_id']);
    $status  = $_POST['status'];
    $allowStatus = ['cancelled', 'completed'];
    if (!in_array($status, $allowStatus)) {
        die("Trạng thái không hợp lệ");
    }
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ? AND user_id = ?");
    $stmt->bind_param("sii", $status, $orderId, $idUser);
    $stmt->execute();
    $stmt->close();
    header("Location: historyorder.php");
    exit;
}
$sql = "SELECT * FROM users WHERE id_user=$idUser";
$result = $conn->query($sql);
$user = mysqli_fetch_assoc($result);    
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Đơn Hàng</title>
    <link rel="icon" type="image/png" href="../../../public/icon/pawprint.png"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/ho.css?v=<?php echo time(); ?>"></link>
    <link rel="stylesheet" href="../../../public/css/cart.css"></link>
</head>
<body>
    <button class="menu-toggle" onclick="toggleMenu()">
        <i class="fas fa-bars"></i>
    </button>
    <div class="main-container">
        <!-- Sidebar -->
        <?php include('../layout/sidebar.php'); ?>
        <!-- Main Content -->
        <main class="main-content">
            <div class="content-wrapper">
                <div class="header">
                    <h1>📦 Lịch Sử Đơn Hàng</h1>
                    <p>Quản lý và theo dõi tất cả đơn hàng của bạn</p>
                </div>
                <div class="filters">
                    <a href="historyorder.php?filter=all" class="filter-btn <?= ($_GET['filter'] ?? 'all') == 'all' ? 'active' : '' ?>">Tất cả</a>
                    <a href="historyorder.php?filter=processing" class="filter-btn <?= ($_GET['filter'] ?? '') == 'processing' ? 'active' : '' ?>">Đang xử lý</a>
                    <a href="historyorder.php?filter=shipping" class="filter-btn <?= ($_GET['filter'] ?? '') == 'shipping' ? 'active' : '' ?>">Đang giao</a>
                    <a href="historyorder.php?filter=completed"class="filter-btn <?= ($_GET['filter'] ?? '') == 'completed' ? 'active' : '' ?>">Hoàn tất</a>
                    <a href="historyorder.php?filter=cancelled"class="filter-btn <?= ($_GET['filter'] ?? '') == 'cancelled' ? 'active' : '' ?>">Đã hủy</a>
                </div>
                <div class="orders-list">
                <?php
                $filter = $_GET['filter'] ?? 'all';
                $sql = "SELECT * FROM orders WHERE user_id = ?";
                if ($filter != 'all') {
                    $sql .= " AND status = ?";
                }
                $sql .= " ORDER BY created_at DESC";
                $orderQuery = $conn->prepare($sql);
                if ($filter != 'all') {
                    $orderQuery->bind_param("is", $idUser, $filter);
                } else {
                    $orderQuery->bind_param("i", $idUser);
                }
                $orderQuery->execute();
                $orderResult = $orderQuery->get_result();
                while ($order = $orderResult->fetch_assoc()):
                    $itemsQuery = $conn->prepare("SELECT oi.quantity, p.name_product, p.price,p.image FROM order_items oi
                        JOIN product p ON oi.product_id = p.id_product
                        WHERE oi.order_id = ?
                    ");
                    $itemsQuery->bind_param("i", $order['order_id']);
                    $itemsQuery->execute();
                    $itemsResult = $itemsQuery->get_result();
                    $total = 0;
                    while ($item = $itemsResult->fetch_assoc()) {
                        $total += $item['price'] * $item['quantity'];
                    }
                    $itemsQuery->execute();
                    $itemsResult = $itemsQuery->get_result();
                    ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <div class="order-id">Đơn hàng #DH<?= str_pad($order['order_id'], 4, "0", STR_PAD_LEFT) ?></div>
                                <div class="order-date">Ngày đặt: <?= date("d/m/Y", strtotime($order['created_at'])) ?></div>
                            </div>
                            <span class="status <?= strtolower($order['status']) ?>"><?= ucfirst($order['status']) ?></span>
                        </div>
                        <div class="order-items">
                            <?php while ($item = $itemsResult->fetch_assoc()): ?>
                                <div class="item">
                                    <div class=item-img>
                                        <img src="<?='/Webpet-2'. $item['image']; ?>" alt=" <?= htmlspecialchars($item['name_product']) ?>" style="width:50px; height:50px; border-radius:50%; object-fit:cover;">
                                    </div>
                                    <div class="item-details">
                                        <div class="item-name"><?= htmlspecialchars($item['name_product']) ?></div>
                                        <div class="item-quantity">Số lượng: <?= $item['quantity'] ?></div>
                                    </div>
                                    <div class="item-price"><?= number_format($item['price'], 0, ',', '.') ?>₫</div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="order-footer">
                            <div>
                                <span class="total-label">Tổng tiền:</span>
                                <span class="total-price"><?= number_format($total, 0, ',', '.') ?>₫</span>
                            </div>
                            <div class="action-buttons">
                            <?php if ($order['status'] == 'processing'): ?>
                                <form method="POST" action="" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">
                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                                </form>
                            <?php elseif ($order['status'] == 'shipping'): ?>
                                <form method="POST" action="" onsubmit="return confirm('Xác nhận đã nhận được hàng?');">
                                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn btn-success">Đã nhận được hàng</button>
                                </form>
                            <?php elseif ($order['status'] == 'completed'): ?>
                                <a href="add-review.php?order_id=<?= $order['order_id'] ?>" class="btn btn-primary">Đánh giá</a>
                                <a href="reorder.php?order_id=<?= $order['order_id'] ?>" class="btn btn-secondary">Mua lại</a>
                            <?php elseif ($order['status']=='cancelled'): ?>
                                <a href="reorder.php?order_id=<?= $order['order_id'] ?>" class="btn btn-secondary">Mua lại</a>
                            <?php endif; ?>    
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
            </div>
        </main>
    </div>
    <script src="../../../public/scripts/ho.js"></script>
</body>
</html>