<?php
session_start();
include('../../controller/dbconnect.php');
setcookie('user', 'Tuyen', time() + 3600, '/');
$isLogin = isset($_COOKIE['user']);
$username = $isLogin ? htmlspecialchars($_COOKIE['user']) : "";
$avatar = '../../../public/img/logo.png';
if ($isLogin) {
    $stmt = $conn->prepare("SELECT avatar FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if($user = $result->fetch_assoc()){
        if(!empty($user['avatar'])){
            $avatar = $user['avatar'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang chủ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
  <link rel="stylesheet" href="../../../public/css/menu.css">
  <style>
    .size-10 { width: 40px; height: 40px; cursor: pointer; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-custom fixed-top bg-light">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="../../../public/img/logo.png" class="logo" style="width: 40px; height: 40px; margin-right: 10px">
        <span class="fw-bold">PetRescue Hub</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="adoption.php">Nhận Nuôi</a></li>
          <li class="nav-item"><a class="nav-link" href="discover.php">Khám Phá</a></li>
          <li class="nav-item"><a class="nav-link" href="products.php">Sản phẩm</a></li>
          <li class="nav-item"><a class="nav-link" href="donate.php">Ủng hộ</a></li>
        </ul>
        <div class="d-flex align-items-center gap-3">
          <?php if ($isLogin): ?>
            <button class="icon-btn position-relative">
              <span class="material-symbols-outlined">shopping_cart</span>
              <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">3</span>
            </button>
            <button class="icon-btn position-relative">
              <span class="material-symbols-outlined">notifications</span>
              <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">5</span>
            </button>
            <a href="profile.php?">
              <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-circle size-10"
                   data-alt="User avatar"
                   style='background-image: url("<?php echo htmlspecialchars($avatar); ?>");'>
              </div>
            </a>
          <?php else: ?>
            <a href="login.php" class="btn btn-success me-2">Đăng nhập</a>
            <a href="register.php" class="btn btn-warning">Đăng ký</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
