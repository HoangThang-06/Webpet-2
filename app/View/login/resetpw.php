<?php
session_start();
require_once __DIR__ . "/../../controller/Usercontroller/Usercontroller.php";

$message = "";

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgetpw.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];

    if ($password1 != $password2) {
        $message = "<div class='alert alert-danger mt-3'>❌ Xác nhận mật khẩu không khớp!</div>";
    } else {

        $controller = new UserController();
        $email = $_SESSION['reset_email'];

        $result = $controller->resetpw_ctr($email, $password1);

        if ($result === "Đổi mật khẩu thành công") {
            $_SESSION['success_message'] = "🎉 Đổi mật khẩu thành công! Vui lòng đăng nhập.";

            unset($_SESSION['reset_email']);
            unset($_SESSION['reset_otp']);
            unset($_SESSION['reset_expire']);

            header("Location: login.php");
            exit();
        } else {
            $message = "<div class='alert alert-danger mt-3'>❌ $result</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #dfe9f3, #ffffff);
            font-family: "Segoe UI", sans-serif;
        }
        .reset-card {
            width: 420px;
            border-radius: 15px;
            padding: 30px;
            background: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            animation: fadeIn .4s ease-in-out;
        }
        .btn-primary {
            background: linear-gradient(90deg, #4a6cf7, #3754de);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #3754de, #2c45c9);
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="reset-card">

        <h3 class="text-center fw-bold mb-2">Đặt lại mật khẩu</h3>
        <p class="text-center text-muted">Tạo mật khẩu mới cho tài khoản:</p>
        <p class="text-center"><b><?php echo $_SESSION['reset_email']; ?></b></p>

        <?= $message ?>

        <form action="" method="post">

            <div class="mb-3">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control form-control-lg" 
                       name="password1" required placeholder="Nhập mật khẩu mới">
            </div>

            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu</label>
                <input type="password" class="form-control form-control-lg"
                       name="password2" required placeholder="Nhập lại mật khẩu">
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg mt-2">
                ✔ Xác nhận
            </button>
        </form>

    </div>
</div>

</body>
</html>
