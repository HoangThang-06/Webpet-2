<?php
session_start();
require_once __DIR__."/../../controller/DBConnection.php";
$conn=(new DBConnection())->getConnection();
$userSession = $_SESSION['user'] ?? null;
$isLogin = $userSession ? true : false;
$avatar = "../../../public/img/avatars/avtdefault.png";
$cartCount = 0;
if ($isLogin) {
    $username = $userSession['username'];
    $stmt = $conn->prepare("SELECT avatar FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (!empty($user['avatar'])) {
            $avatar = $user['avatar'];
        }
    }
    $id = $userSession['id_user'];

    $stmt = $conn->prepare("SELECT COUNT(id) AS total FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $cartCount = $row['total'] ?? 0;
}
?>
<link rel="stylesheet" href="../../../public/css/menu.css?v=<?php echo time(); ?>">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<header>
  <div class="logo">
    <img src="../../../public/img/logo.png" alt="Logo">
    PetRecueHub
  </div>
  <div class="menu-container" id="menu-container">
    <nav>
      <a href="index.php">Trang chủ</a>
      <a href="products.php">Sản phẩm</a>
      <a href="discover.php">Khám phá</a>
      <a href="adoption.php">Nhận nuôi</a>
      <a href="donate.php">Ủng hộ</a>
    </nav>
    <?php if($isLogin): ?>
    <div class="auth-buttons">
      <a href="profile.php" class="avatar-wrapper">
        <div class="avatar" style="background-image: url('<?php echo htmlspecialchars($avatar); ?>');"></div>
        <span class="badge"><?php echo $cartCount; ?></span>
      </a>
    </div>
    <?php else: ?>  
    <div class="auth-buttons">
      <button class="login-btn"><a href="../login/login.php">Đăng nhập</a></button>
      <button class="signup-btn"><a href="../register/register.php">Đăng ký</a></button>
    </div>
    <?php endif; ?>
  </div>
  <div class="menu-toggle" id="menu-toggle">
    <span></span>
    <span></span>
    <span></span>
  </div>
</header>
<script>
  const menuToggle = document.getElementById('menu-toggle');
  const menuContainer = document.getElementById('menu-container');
  menuToggle.addEventListener('click', () => {
    menuContainer.classList.toggle('active');
  });
</script>
