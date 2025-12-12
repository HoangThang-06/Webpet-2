<?php
session_start();
include ('../../controller/dbconnect.php');
$idUser=$_SESSION['user']['id_user'];
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
                    <a href="historyorder.php?filter=all" class="filter-btn <?= ($_GET['filter'] ?? 'all')=='all'?'active':'' ?>">Tất cả</a>
                    <a href="historyorder.php?filter=7" class="filter-btn <?= ($_GET['filter'] ?? '')=='7'?'active':'' ?>">7 Ngày</a>
                    <a href="historyorder.php?filter=15" class="filter-btn <?= ($_GET['filter'] ?? '')=='15'?'active':'' ?>">15 Ngày</a>
                    <a href="historyorder.php?filter=30" class="filter-btn <?= ($_GET['filter'] ?? '')=='30'?'active':'' ?>">1 Tháng</a>
                    <a href="historyorder.php?filter=180" class="filter-btn <?= ($_GET['filter'] ?? '')=='180'?'active':'' ?>">6 Tháng</a>
                </div>
                <div class="orders-list">
                <?php
                $filter = $_GET['filter'] ?? 'all';
                $sql = "SELECT * FROM orders WHERE user_id = ? ";
                if ($filter != 'all') {
                    $days = intval($filter);
                    $sql .= " AND created_at >= DATE_SUB(NOW(), INTERVAL $days DAY) ";
                }
                $sql .= " ORDER BY created_at DESC";
                $orderQuery = $conn->prepare($sql);
                $orderQuery->bind_param("i", $idUser);
                $orderQuery->execute();
                $orderResult = $orderQuery->get_result();
                while ($order = $orderResult->fetch_assoc()):
                    $itemsQuery = $conn->prepare("SELECT oi.quantity, p.name, p.price,p.image FROM order_items oi
                        JOIN products p ON oi.product_id = p.id
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
                                        <img src="<?= htmlspecialchars($item['image']) ?>" alt=" <?= htmlspecialchars($item['name']) ?>" style="width:50px; height:50px; border-radius:50%; object-fit:cover;">
                                    </div>
                                    <div class="item-details">
                                        <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
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
                                <a href="add-review.php?order_id=<?= $order['order_id'] ?>" class="btn btn-primary">Đánh giá</a>
                                <a href="reorder.php?order_id=<?= $order['order_id'] ?>" class="btn btn-secondary">Mua lại</a>
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