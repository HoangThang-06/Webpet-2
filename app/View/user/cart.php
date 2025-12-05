<?php
session_start();
 if(isset($_SESSION['toast'])):?>
<div class="toast <?= $_SESSION['toast']['type'] ?>">
    <?= $_SESSION['toast']['message'] ?>
</div>
<?php unset($_SESSION['toast']); endif; ?>
<?php 
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
                    <a href="historyorder.php" class="menu-link">
                        <i class="fas fa-bell"></i>
                        <span>Lịch sử đơn hàng</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="cart.php" class="menu-link active">
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
        <main class="main-content">
            <div class="content-wrapper">
                <div class="header">
                    <h1>🛒 Giỏ Hàng</h1>
                    <p>Quản lý và theo dõi giỏ hàng của bạn</p>
                </div>
                <div class="filters">
                    <button class="filter-btn active">Tất cả</button>
                    <button class="filter-btn">7 Ngày</button>
                    <button class="filter-btn">15 Ngày</button>
                    <button class="filter-btn">1 Tháng</button>
                    <button class="filter-btn">6 Tháng</button>
                </div>
                <div class="orders-list">
                <?php
                $cartQuery = $conn->prepare("
                    SELECT c.id AS cart_id, c.quantity, c.create_at, p.name, p.price, p.image
                    FROM cart c
                    JOIN products p ON c.product_id = p.id
                    WHERE c.user_id = ?
                    ORDER BY c.create_at DESC
                ");
                $cartQuery->bind_param("i", $idUser);
                $cartQuery->execute();
                $cartResult = $cartQuery->get_result();
                $total=0;
                while ($cartItem = $cartResult->fetch_assoc()):
                    $subtotal = $cartItem['price'] * $cartItem['quantity'];
                    $total=$total+$subtotal;
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
                                    <img src="<?= htmlspecialchars($cartItem['image']) ?>" alt="<?= htmlspecialchars($cartItem['name']) ?>" style="width:50px;height:50px;border-radius:50%;object-fit:cover;">
                                </div>
                                <div class="item-details">
                                    <div class="item-name"><?= htmlspecialchars($cartItem['name']) ?></div>
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
                </div>
                <div class="cart-total-box">
                    <div class="cart-total-left">
                        <span class="label">Tổng tiền:</span>
                        <span class="value"><?= number_format($total, 0, ',', '.') ?>₫</span>
                    </div>
                    <a href="checkout.php" class="btn-checkout-all">Thanh toán tất cả</a>
                </div>
        </main>
    </div>
    <script src="../../../public/scripts/ho.js"></script>
    <script src="../../../public/scripts/cart.js"></script>
</body>
</html>