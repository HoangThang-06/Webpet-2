<?php
session_start();
include('../../controller/dbconnect.php');
$idUser = $_SESSION['user']['id_user'];
if (isset($_SESSION['toast'])): ?>
    <div class="toast <?= $_SESSION['toast']['type'] ?>">
        <?= $_SESSION['toast']['message'] ?>
    </div>
<?php 
    unset($_SESSION['toast']); 
endif; 
$userQuery = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
$userQuery->bind_param("i", $idUser);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();
$filter = $_GET['filter'] ?? 'all';
$sqlCart = "
    SELECT c.id AS cart_id, c.quantity, c.create_at, p.name_product, p.price, p.image
    FROM cart c
    JOIN product p ON c.product_id = p.id_product
    WHERE c.user_id = ?
";
if ($filter !== 'all') {
    $days = intval($filter);
    $sqlCart .= " AND c.create_at >= DATE_SUB(NOW(), INTERVAL ? DAY)";
}
$sqlCart .= " ORDER BY c.create_at DESC";
$cartStmt = $conn->prepare($sqlCart);
if ($filter !== 'all') {
    $cartStmt->bind_param("ii", $idUser, $days);
} else {
    $cartStmt->bind_param("i", $idUser);
}
$cartStmt->execute();
$cartData = $cartStmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
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
       <?php include('../layout/sidebar.php'); ?>
        <main class="main-content">
            <div class="content-wrapper">
                <div class="header">
                    <h1>🛒 Giỏ Hàng</h1>
                    <p>Quản lý và theo dõi giỏ hàng của bạn</p>
                </div>
                <div class="filters">
                    <a href="cart.php?filter=all" class="filter-btn <?= ($_GET['filter'] ?? 'all')=='all'?'active':'' ?>">Tất cả</a>
                    <a href="cart.php?filter=7" class="filter-btn <?= ($_GET['filter'] ?? '')=='7'?'active':'' ?>">7 Ngày</a>
                    <a href="cart.php?filter=15" class="filter-btn <?= ($_GET['filter'] ?? '')=='15'?'active':'' ?>">15 Ngày</a>
                    <a href="cart.php?filter=30" class="filter-btn <?= ($_GET['filter'] ?? '')=='30'?'active':'' ?>">1 Tháng</a>
                    <a href="cart.php?filter=180" class="filter-btn <?= ($_GET['filter'] ?? '')=='180'?'active':'' ?>">6 Tháng</a>
                </div>
                <div class="orders-list">
                <?php $total = 0;
                if ($cartData->num_rows > 0): ?>
                    <?php while ($cartItem = $cartData->fetch_assoc()):
                        $subtotal = $cartItem['price'] * $cartItem['quantity'];
                        $total += $subtotal;
                    ?>
                        <div class="order-card" data-id="<?= $cartItem['cart_id'] ?>">
                            <div class="order-header">
                                <div>
                                    <div class="order-id">Giỏ hàng #GH<?= str_pad($cartItem['cart_id'], 4, "0", STR_PAD_LEFT) ?></div>
                                    <div class="order-date">Ngày thêm: <?= date("d/m/Y H:i", strtotime($cartItem['create_at'])) ?></div>
                                </div>
                            </div>
                            <div class="order-items">
                                <div class="item">
                                    <div class="item-img">
                                        <img src="<?='/Webpet-2'. $cartItem['image']; ?>" alt="<?= htmlspecialchars($cartItem['name_product']) ?>" style="width:50px;height:50px;border-radius:50%;object-fit:cover;">
                                    </div>
                                    <div class="item-details">
                                        <div class="item-name"><?= htmlspecialchars($cartItem['name_product']) ?></div>
                                        <div class="item-quantity-controls">
                                            <button class="btn-qty" data-action="minus" data-id="<?= $cartItem['cart_id'] ?>">-</button>
                                            <input type="number" min="1" value="<?= $cartItem['quantity'] ?>" class="quantity-input" data-id="<?= $cartItem['cart_id'] ?>">
                                            <button class="btn-qty" data-action="plus" data-id="<?= $cartItem['cart_id'] ?>">+</button>
                                        </div>
                                    </div>
                                    <div class="item-price" data-id="<?= $cartItem['cart_id'] ?>" data-price="<?= $cartItem['price'] ?>">
                                        <?= number_format($subtotal,0,',','.') ?>₫
                                    </div>
                                </div>
                            </div>
                            <div class="order-footer">
                                <div>
                                    <span class="total-label">Thành tiền:</span>
                                    <span class="total-price"><?= number_format($subtotal, 0, ',', '.') ?>₫</span>
                                </div>
                                <div class="action-buttons">
                                    <button class="btn-info" data-id="<?= $cartItem['cart_id'] ?>" data-action="save">Lưu</button>
                                    <button class="btn-danger" data-id="<?= $cartItem['cart_id'] ?>" data-action="delete">Xóa</button>
                                    <a href="checkout.php" class="btn btn-primary">Thanh toán</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="empty-cart-message" style="text-align:center; padding:20px; font-size:18px;">Giỏ hàng của bạn đang trống</p>
                <?php endif; ?>
                </div>
                <?php if ($cartData->num_rows > 0): ?>
                    <div class="cart-total-box">
                        <div class="cart-total-left">
                            <span class="label">Tổng tiền:</span>
                            <span class="value"><?= number_format($total, 0, ',', '.') ?>₫</span>
                        </div>
                        <a href="checkout.php" class="btn-checkout-all">Thanh toán tất cả</a>
                    </div>
                <?php endif; ?>
        </main>
    </div>
    <script src="../../../public/scripts/ho.js"></script>
    <script src="../../../public/scripts/cart.js"></script>
</body>
</html>