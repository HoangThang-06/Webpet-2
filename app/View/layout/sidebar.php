<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="user-profile">
                <div class="user-avatar">
                    <img src="<?php echo !empty($user['avatar']) ? $user['avatar'] : '../../../public/img/avatars/avtdefault.png'; ?>" alt="Avatar" style="width:50px; height:50px; border-radius:50%; object-fit:cover;">
                </div>
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($user['fullname'] ?? ''); ?></div>
                    <div class="user-email"><?php echo htmlspecialchars($user['email']); ?></div>
                </div>
            </div>
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="profile.php?" class="menu-link <?= ($current_page == 'profile.php') ? 'active' : '' ?>">
                        <i class="fas fa-user"></i>
                        <span>Thông tin tài khoản</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="historyorder.php?" class="menu-link <?= ($current_page == 'historyorder.php') ? 'active' : '' ?>">
                        <i class="fas fa-bell"></i>
                        <span>Lịch sử đơn hàng</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="cart.php" class="menu-link <?= ($current_page == 'cart.php') ? 'active' : '' ?>">
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
                    <a href="notification.php" class="menu-link <?= ($current_page == 'notification.php') ? 'active' : '' ?>">
                        <i class="fas fa-list-check"></i>
                        <span>Quản lý hoạt động</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="index.php" class="menu-link <?= ($current_page == 'index.php') ? 'active' : '' ?>">
                        <i class="fas fa-home"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" onclick="confirmLogout()" class="menu-link logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </aside>
        <script>
            function confirmLogout() {
                if (confirm("Bạn có chắc chắn muốn đăng xuất không?")) {
                    window.location.href = "../layout/logout.php";
                }
            }
        </script>

     