<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        }
        .card-custom {
            width: 420px;
            border-radius: 18px;
            padding: 30px;
            animation: fadeIn 0.45s ease;
        }
        button:hover {
            transform: scale(1.02);
            transition: 0.2s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .icon-box {
            font-size: 55px;
            color: #1976d2;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<?php
require_once __DIR__."/../../controller/Usercontroller/forgetpw_ctr.php";
require_once __DIR__ . "/../../controller/DBConnection.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'];
    $conn = (new DBConnection())->getConnection();

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $message = "<div class='alert alert-danger text-center mt-3'>❌ Email không tồn tại trong hệ thống!</div>";
    } else {

        $mailService = new MailService();
        $result = $mailService->sendOTP($email);

        if ($result['status'] === true) {
            header("Location: verify_otp.php");
            exit();
        } else {
            $message = "<div class='alert alert-danger text-center mt-3'>⚠ Lỗi: ".$result['message']."</div>";
        }
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="card shadow card-custom">

        <div class="text-center">
            <div class="icon-box">
                🔑
            </div>
            <h3 class="fw-bold mb-2">Quên mật khẩu</h3>
            <p class="text-muted mb-4">Nhập email để nhận mã OTP đặt lại mật khẩu</p>
        </div>

        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label fw-semibold">Email của bạn</label>
                <input type="email" class="form-control" name="email" required placeholder="example@gmail.com">
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
                Gửi mã OTP
            </button>
        </form>

        <?= $message ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
