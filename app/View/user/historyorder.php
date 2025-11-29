<?php
$conn = mysqli_connect('localhost', 'root', '1905', 'webpet');
$idUser = 1;
$sql = "SELECT * FROM users WHERE id=$idUser";
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
                        echo !empty($user['avatar']) ? $user['avatar'] : 'public/img/default.png'; 
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
                    <a href="index.php" class="menu-link">
                        <i class="fas fa-home"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="logout.php" class="menu-link logout">
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
                    <!-- Đơn hàng 1 -->
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <div class="order-id">Đơn hàng #DH001234</div>
                                <div class="order-date">Ngày đặt: 20/11/2025</div>
                            </div>
                            <span class="status completed">Hoàn thành</span>
                        </div>

                        <div class="order-items">
                            <div class="item">
                                <div class="item-image">📱</div>
                                <div class="item-details">
                                    <div class="item-name">iPhone 15 Pro Max</div>
                                    <div class="item-quantity">Số lượng: 1</div>
                                </div>
                                <div class="item-price">29.990.000₫</div>
                            </div>

                            <div class="item">
                                <div class="item-image">🎧</div>
                                <div class="item-details">
                                    <div class="item-name">AirPods Pro Gen 2</div>
                                    <div class="item-quantity">Số lượng: 1</div>
                                </div>
                                <div class="item-price">5.990.000₫</div>
                            </div>
                        </div>

                        <div class="order-footer">
                            <div>
                                <span class="total-label">Tổng tiền:</span>
                                <span class="total-price">35.980.000₫</span>
                            </div>
                            <div class="action-buttons">
                                <button class="btn btn-primary">Xem chi tiết</button>
                                <button class="btn btn-secondary">Mua lại</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../../../public/scripts/ho.js"></script>
</body>
</html>