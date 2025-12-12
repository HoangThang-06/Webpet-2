<?php
session_start();
require_once __DIR__."/../../controller/DBConnection.php";
$conn=(new DBConnection())->getConnection();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/ho.css"></link>
    <link rel="stylesheet" href="../../../public/css/cart.css"></link>
</head>
<body>
    <button class="menu-toggle" onclick="toggleMenu()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="user-profile">
                <div class="user-avatar">
                    <img src="<?php 
                        echo !empty($user['avatar']) ? $user['avatar'] : '../../../public/img/avatars/avtdefault.png'; 
                    ?>" alt="Avatar" style="width:50px; height:50px; border-radius:50%; object-fit:cover;">
                </div>
                <div class="user-info">
                    <div class="user-name"><?php echo $user['fullname']; ?></div>
                    <div class="user-email"><?php echo $user['email']; ?></div>
                </div>
            </div>
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="profile.php" class="menu-link ">
                        <i class="fas fa-user"></i>
                        <span>Thông tin cá nhân</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="historyorder.php" class="menu-link active">
                        <i class="fas fa-bell"></i>
                        <span>Lịch sử đơn hàng</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="cart.php" class="menu-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Giỏ hàng</span>
                        <?php
                        $resultCount=mysqli_query($conn,"SELECT * FROM cart WHERE user_id=$idUser");
                        $total=mysqli_num_rows($resultCount);
                        if($total>0){
                            echo '<span class="cart-badge">'.$total.'</span>';
                        }
                        ?>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="index.php" class="menu-link">
                        <i class="fas fa-home"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../layout/logout.php" class="menu-link logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </aside>
        <!-- Main Content -->
        <main class="main-content">
            <div class="content-wrapper">
                <div class="header">
                    <h1>📦 Lịch Sử Đơn Hàng</h1>
                    <p>Quản lý và theo dõi tất cả đơn hàng của bạn</p>
                </div>
                <div class="filters">
                    <button class="filter-btn active">Tất cả</button>
                    <button class="filter-btn">Đang xử lý</button>
                    <button class="filter-btn">Đang giao</button>
                    <button class="filter-btn">Hoàn thành</button>
                    <button class="filter-btn">Đã hủy</button>
                </div>

                <div class="orders-list">
                <?php
                $orderQuery = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
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
                                <a href="#" class="btn btn-secondary">Mua lại</a>
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