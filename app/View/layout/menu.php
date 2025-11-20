<?php
session_start();
$isLogin = isset($_COOKIE['user']);
$username = $isLogin ? htmlspecialchars($_COOKIE['user']) : "";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang chủ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding-top: 80px;
    }
    .navbar-custom { background-color: #e3f2fd; }
    .nav-link { font-weight: 500; }
    .btn-auth { font-weight: bold; margin-left: 10px; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="trangchu.html">
        <img src="imgkhampha/logo.png" class="logo" style="width: 40px; height: 40px; margin-right: 10px">
        <span class="text-dark fw-bold">PetRescue Hub</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav me-3 mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="trangchu.php">Trang Chủ</a></li>
          <li class="nav-item"><a class="nav-link" href="nhannuoi.html">Nhận Nuôi</a></li>
          <li class="nav-item"><a class="nav-link" href="khampha.html">Khám Phá</a></li>
          <li class="nav-item"><a class="nav-link" href="donate.html">Donate</a></li>
        </ul>

        <?php if ($isLogin): ?>
          <span class="text-dark fw-bold" style="margin-right: 10px;">Xin chào, <?= $username ?></span>
          <a href="logout.php" class="btn btn-danger btn-auth">Đăng xuất</a>
        <?php else: ?>
          <a href="login.php" class="btn btn-success btn-auth">Đăng nhập</a>
          <a href="register.php" class="btn btn-warning btn-auth">Đăng ký</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
