<?php
session_start();

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgetpw.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userOTP = $_POST['otp'];

    if (time() > $_SESSION['reset_expire']) {
        $message = "<div class='alert alert-danger mt-3 text-center'>⏳ OTP đã hết hạn. Vui lòng gửi lại mã mới.</div>";
    } elseif ($userOTP != $_SESSION['reset_otp']) {
        $message = "<div class='alert alert-danger mt-3 text-center'>❌ OTP không đúng. Vui lòng thử lại.</div>";
    } else {
        header("Location: resetpw.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác thực OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        }
        .otp-card {
            border-radius: 18px;
            padding: 30px;
            animation: fadeIn 0.5s ease;
        }
        .otp-input {
            letter-spacing: 10px;
            font-size: 30px;
            text-align: center;
            height: 55px;
        }
        button:hover {
            transform: scale(1.02);
            transition: 0.2s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow otp-card" style="width: 420px;">
        
        <h3 class="text-center mb-2 fw-bold">
            🔐 Xác thực OTP
        </h3>

        <p class="text-center text-muted mb-3">
            Mã OTP đã được gửi đến email:<br>
            <span class="fw-semibold text-dark"><?php echo $_SESSION['reset_email']; ?></span>
        </p>

        <?= $message ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="otp" class="form-label fw-semibold">Nhập mã OTP</label>
                <input type="text" name="otp" maxlength="6" required 
                       class="form-control otp-input"
                       placeholder="------">
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
                Xác nhận
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="forgetpw.php" class="text-decoration-none fw-semibold">🔄 Gửi lại mã OTP</a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
