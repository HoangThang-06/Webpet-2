<?php
session_start();
include('../../controller/dbconnect.php');
if (!isset($_SESSION['user']['username'])) {
    header("Location: ../login/login.php");
    exit;
}
$username = $_SESSION['user']['username'];
$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$idUser = $user['id_user'];
if (isset($_POST['update_account'])) {
    $fullname = $_POST['fullname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $avatarPath = $user['avatar'];
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $avatarName = time() . '_' . basename($_FILES['avatar']['name']);
        $avatarUploadPath = '../../../public/img/' . $avatarName;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarUploadPath)) {
            $avatarPath = '../../../public/img/' . $avatarName;
        } else {
            echo "<script>alert('Không thể upload file!');</script>";
        }
    }
    $stmt = $conn->prepare("UPDATE users SET fullname=?, phone=?, address=?, birthday=?, gender=?, avatar=? WHERE id_user=?");
    $stmt->bind_param("ssssssi", $fullname, $phone, $address, $birthday, $gender, $avatarPath, $idUser);
    $stmt->execute();
    $stmt = $conn->prepare("SELECT * FROM users WHERE id_user=?");
    $stmt->bind_param("i", $idUser);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    echo "<script>alert('Cập nhật thành công!');</script>";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/ho.css">
    <link rel="stylesheet" href="../../../public/css/profile.css">
    <link rel="stylesheet" href="../../../public/css/cart.css">
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
                    <img src="<?php echo !empty($user['avatar']) ? $user['avatar'] : '../../../public/img/avatars/avtdefault.png'; ?>" alt="Avatar" style="width:50px; height:50px; border-radius:50%; object-fit:cover;">
                </div>
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($user['fullname'] ?? ''); ?></div>
                    <div class="user-email"><?php echo htmlspecialchars($user['email']); ?></div>
                </div>
            </div>
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="profile.php?id=<?php echo $idUser; ?>" class="menu-link active">
                        <i class="fas fa-user"></i>
                        <span>Thông tin tài khoản</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="historyorder.php?id=<?php echo $idUser; ?>" class="menu-link">
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

        <main class="main-content">
            <div class="content-wrapper">
                <div class="header">
                    <h1>👤 Thông tin tài khoản</h1>
                    <p>Xem và chỉnh sửa thông tin cá nhân của bạn</p>
                </div>

                <div class="account-box">
                    <div class="avatar-section">
                        <img id="avatarPreview" src="<?php echo !empty($user['avatar']) ? $user['avatar'] : '../../../public/img/avatars/avtdefault.png'; ?>" alt="Avatar">
                        <label for="avatarInput" class="change-avatar-btn">Đổi ảnh</label>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" hidden>
                        <div class="form-section">
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                            </div>

                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
                            </div>

                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <input type="date" name="birthday" value="<?php echo $user['birthday']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Giới tính</label>
                                <select name="gender">
                                    <option value="Nam" <?php if($user['gender']=='Nam') echo 'selected'; ?>>Nam</option>
                                    <option value="Nữ" <?php if($user['gender']=='Nữ') echo 'selected'; ?>>Nữ</option>
                                    <option value="Khác" <?php if($user['gender']=='Khác') echo 'selected'; ?>>Khác</option>
                                </select>
                            </div>

                            <button class="btn btn-primary" type="submit" name="update_account" style="margin-top: 15px;">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="../../../public/scripts/ho.js"></script>
    <script>
        document.getElementById("avatarInput").addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                document.getElementById("avatarPreview").src = URL.createObjectURL(file);
            }
        });

        function toggleMenu() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>
</body>
</html>
