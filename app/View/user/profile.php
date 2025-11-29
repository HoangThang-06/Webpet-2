<?php
$conn = mysqli_connect('localhost', 'root', '1905', 'webpet');
$idUser = 1;
$sql = "SELECT * FROM users WHERE id=$idUser";
$result = $conn->query($sql);
$user = mysqli_fetch_assoc($result);

if(isset($_POST['update_account'])){
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];

    if(isset($_FILES['avatar']) && $_FILES['avatar']['error']==0){
    $avatarName = time().'_'.$_FILES['avatar']['name'];
    $avatarPath = '../../../public/img/' . $avatarName;
    if(move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath)){
        $avatarSQL = ", avatar='$avatarPath'";
    } else {
        echo "<script>alert('Không thể upload file!');</script>";
    }
}
 else {
        $avatarSQL = "";
    }

    $sqlUpdate = "UPDATE users 
                  SET fullname='$fullname', phone='$phone', address='$address',birthday='$birthday', gender='$gender' $avatarSQL
                  WHERE id=".$user['id'];
    mysqli_query($conn, $sqlUpdate);

    // Load lại dữ liệu mới
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=".$user['id']));
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
        <main class="main-content">
            <div class="content-wrapper">
                <div class="header">
                    <h1>👤 Thông tin tài khoản</h1>
                    <p>Xem và chỉnh sửa thông tin cá nhân của bạn</p>
                </div>

                <div class="account-box">
                    <div class="avatar-section">
                        <img id="avatarPreview" src="<?php echo $user['avatar']; ?>" alt="Avatar">
                        <label for="avatarInput" class="change-avatar-btn">Đổi ảnh</label>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" hidden>
                        <div class="form-section">
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" name="fullname" value="<?php echo $user['fullname']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" value="<?php echo $user['email']; ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" value="<?php echo $user['phone']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" name="address" value="<?php echo $user['address']; ?>">
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
    </script>
</body>
</html>
