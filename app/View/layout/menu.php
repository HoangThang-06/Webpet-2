<?php
session_start();
require_once __DIR__."/../../controller/DBConnection.php";
setcookie('user', 'Tuyen', time() + 3600, '/');
$isLogin = isset($_COOKIE['user']);
$username = $isLogin ? htmlspecialchars($_COOKIE['user']) : "";
>>>>>>> b71cec2 (update)
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
}*/
?>
<link rel="stylesheet" href="../../../public/css/menu.css">
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
      <button class="icon-btn">
        <span class="material-symbols-outlined">shopping_cart</span>
        <span class="badge">3</span>
      </button>
      <a href="profile.php">
      <div class="avatar" style="background-image: url('<?php echo htmlspecialchars($avatar); ?>');"></div>
    </a>
    </div>
    <?php else: ?>  
    <div class="auth-buttons">
      <button class="login-btn">Đăng nhập</button>
      <button class="signup-btn">Đăng ký</button>
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
