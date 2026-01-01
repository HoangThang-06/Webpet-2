<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../../../public/css/home.css" />   
</head>
<?php
session_start();
?>
<?php
require_once __DIR__ . "/../../controller/Article_ctr.php";
require_once __DIR__ . "/../../controller/Pet_ctr.php";
require_once __DIR__ . "/../../controller/Usercontroller/Usercontroller.php";
$articleCtr = new ArticleController();
$topArticle = $articleCtr->getTopArticle();
$petCtr = new PetController();
$topPet = $petCtr->getTopPet();
$userCtr = new UserController();
$stats = $userCtr->getUserRegistrationByMonth();
$monthlyData = array_fill(1, 12, 0);
foreach ($stats as $row) {
    $monthlyData[(int)$row['month']] = (int)$row['total'];
}
?>
<body>
    <?php include("../layout/menuadmin.php"); ?>
    <div class="main-content">
        <div class="banner"></div>
        <div class="content">
            <div class="title-desc">
            <h1>BẢNG ĐIỀU KHIỂN ADMIN</h1>
                Quản lý toàn bộ nội dung và dữ liệu của hệ thống tại một nơi duy nhất.
                Theo dõi thống kê, cập nhật thông tin và tối ưu hoạt động website nhanh chóng.
            </p>
            </div>
            <div class="cards">
                <div class="card">
                    <i class="fas fa-user"></i>
                    <h3>NGƯỜI DÙNG NỔI BẬT</h3>
                    <p>Hiển thị thông tin về người dùng hàng đầu.</p>
                </div>
                <!-- Nguoi dung noi bat-->
                <div class="card highlight-card">
                    <div class="highlight-header">
                        <i class="fas fa-file-alt"></i>
                        <h3>BÀI BÁO NỔI BẬT</h3>
                    </div>
                    <?php if ($topArticle): ?>
                        <div class="highlight-image">
                            <img src="<?= '/Webpet-2'.$topArticle['image'] ?>" alt="thumbnail">
                        </div>
                        <h4 class="highlight-title">
                            <?= $topArticle['title'] ?>
                        </h4>
                        <p class="highlight-views">
                            <i class="fas fa-eye"></i> <?= $topArticle['click'] ?> lượt xem
                        </p>
                        <a href="../article/detail.php?id=<?= $topArticle['id_article'] ?>" 
                        class="btn btn-primary highlight-btn">
                            Xem bài viết
                        </a>
                    <?php else: ?>
                        <p class="text-muted">Chưa có bài viết nào.</p>
                    <?php endif; ?>
                </div>
                    <!-- Pet noi bat-->
                <div class="card highlight-card">
                    <div class="highlight-header">
                        <i class="fas fa-file-alt"></i>
                        <h3>PET NGOAN NỔI BẬT</h3>
                    </div>
                    <?php if ($topPet): ?>
                        <div class="highlight-image">
                            <img src="<?= $topPet['image'] ?>" alt="thumbnail">
                        </div>
                        <h4 class="highlight-title">
                            <?= $topPet['name'] ?>
                        </h4>
                        <p class="highlight-views">
                            <i class="fas fa-eye"></i> <?= $topPet['click'] ?> lượt xem
                        </p>
                        <a href="../article/detail.php?id=<?= $topPet['id'] ?>" 
                        class="btn btn-primary highlight-btn">
                            Xem pet
                        </a>
                    <?php else: ?>
                        <p class="text-muted">Chưa có pet nao.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="registrationChart"></canvas>
            </div>
        </div>
    </div>
    <script src="../../../public/scripts/home.js"></script>
</body>
</html>
