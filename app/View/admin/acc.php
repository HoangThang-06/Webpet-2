<?php
session_start();

// Kiểm tra user đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: ../layout/login.php");
    exit();
}

require_once __DIR__ . "/../../controller/Usercontroller/UserController.php";

$userCtr = new UserController();

// Lấy thông tin người dùng
$user = $userCtr->getUserById($_SESSION['user']['id_user']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản</title>
    <link rel="stylesheet" href="../../../public/css/ho.css">
    <link rel="stylesheet" href="../../../public/css/acc.css">
    <link rel="stylesheet" href="../../../public/css/cart.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<div class="main-container">

    <!-- SIDEBAR -->
        <?php include("../layout/menuadmin.php"); ?>

    <div class="account-box">

        <div class="avatar-section">
            <img id="avatarPreview" 
                 src="<?php echo !empty($user['avatar']) ? $user['avatar'] : '../../../public/img/avatars/avtdefault.png'; ?>" 
                 alt="Avatar">
            <label for="avatarInput" class="change-avatar-btn">Đổi ảnh</label>
        </div>

        <!-- FORM UPDATE -->
        <form id="updateForm" enctype="multipart/form-data">

            <input type="file" id="avatarInput" name="avatar" accept="image/*" hidden>

            <div class="header">
                <h1>👤 Thông tin tài khoản</h1>
                <p>Xem và chỉnh sửa thông tin cá nhân của bạn</p>
            </div>

            <div class="form-section">

                <input type="hidden" name="id_user" value="<?php echo $_SESSION['user']['id_user']; ?>">

                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>">
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
                        <option value="Nam"   <?php if($user['gender']=='Nam') echo 'selected'; ?>>Nam</option>
                        <option value="Nữ"    <?php if($user['gender']=='Nữ') echo 'selected'; ?>>Nữ</option>
                        <option value="Khác"  <?php if($user['gender']=='Khác') echo 'selected'; ?>>Khác</option>
                    </select>
                </div>

                <button class="btn btn-primary" type="submit" style="margin-top: 15px;">Lưu thay đổi</button>

                <a href="../layout/logout.php" class="menu-link logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Đăng xuất</span>
                </a>

            </div>
        </form>

    </div>
</div>

<script>
    // Preview avatar
    $("#avatarInput").on("change", function() {
        const file = this.files[0];
        if (file) {
            $("#avatarPreview").attr("src", URL.createObjectURL(file));
        }
    });

    // AJAX UPDATE
    $("#updateForm").on("submit", function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "../../controller/Usercontroller/UserAPI.php?action=update",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                if (res.success) {
                    alert("Cập nhật thành công!");
                    location.reload();
                } else {
                    alert("Lỗi: " + res.message);
                }
            },
            error: function() {
                alert("Lỗi AJAX");
            }
        });
    });
</script>

</body>
</html>
