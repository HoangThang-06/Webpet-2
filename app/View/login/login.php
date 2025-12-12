<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/login.css" />    
</head>
<body>

<?php
    require_once __DIR__ . "/../../controller/Usercontroller/Usercontroller.php";
    session_start();

    $success_message = "";

    if (isset($_SESSION['success_message'])) {
        $success_message = "<div class='alert alert-success text-center mt-3'>".$_SESSION['success_message']."</div>";
        unset($_SESSION['success_message']);
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username=$_POST["username"];
        $password=$_POST["password"];

        $controller=new UserController();
        $message=$controller->login($username,$password);
        switch ($message) {

        case "error_user":
            $error = "Tài khoản không tồn tại";
            break;

        case "error_password":
            $error = "Mật khẩu không đúng";
            break;

        case "admin_disapproved":
            $error = "Admin chưa được phê duyệt!";
            break;

        case "admin_ok":
            header("Location: ../admin/home.php");
            exit;

        case "user":
            header("Location: ../user/index.php");
            exit;

        default:
            $error = "Đăng nhập thất bại!";
    }
    }
?>

<div class="auth-box">

    <h3 class="text-center auth-title">
        <i class="fa-solid fa-right-to-bracket me-2"></i>Đăng nhập
    </h3>

    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Nhập username..." required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu..." required>
            </div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <?= $success_message ?>

        <button class="btn btn-primary w-100 mt-3">
            <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Đăng nhập
        </button>

        <div class="text-center mt-3">
            <span>Chưa có tài khoản?</span>
            <a href="../register/register.php">Đăng ký ngay</a>
        </div>

        <div class="text-center mt-3">
            <a href="forgetpw.php">Quên mật khẩu?</a>
        </div>

    </form>
</div>
</body>
</html>
