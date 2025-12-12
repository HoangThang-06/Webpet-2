<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhân Viên</title>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
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
// tạo mảng 12 tháng
$monthlyData = array_fill(1, 12, 0);

// Gán số người đăng ký vào đúng tháng
foreach ($stats as $row) {
    $monthlyData[(int)$row['month']] = (int)$row['total'];
}
?>

<body>
    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <?php include("../layout/menuadmin.php"); ?>
    </div>

    <!-- Nội dung chính -->
    <div class="main-content">
        <!-- Ảnh banner -->
        <div class="banner"></div>

        <div class="content">
            <div class="title-desc">
            <h1>BẢNG ĐIỀU KHIỂN ADMIN</h1>
            <p>
                Quản lý toàn bộ nội dung và dữ liệu của hệ thống tại một nơi duy nhất.
                Theo dõi thống kê, cập nhật thông tin và tối ưu hoạt động website nhanh chóng.
            </p>
        </div>


            <!-- Hàng thẻ -->
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
                                    <img src="<?= $topArticle['image'] ?>" alt="thumbnail">
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
                                            <?= $topPet['name_pet'] ?>
                                        </h4>

                                        <p class="highlight-views">
                                            <i class="fas fa-eye"></i> <?= $topPet['click'] ?> lượt xem
                                        </p>

                                        <a href="../article/detail.php?id=<?= $topPet['id_pet'] ?>" 
                                        class="btn btn-primary highlight-btn">
                                            Xem pet
                                        </a>

                                    <?php else: ?>
                                        <p class="text-muted">Chưa có pet nao.</p>
                                    <?php endif; ?>
                                </div>
                    </div>

            <!-- Biểu đồ cột -->
            <div class="chart-container">
                <canvas id="registrationChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const monthlyData = <?= json_encode(array_values($monthlyData)); ?>;
        document.getElementById("toggleBtn").addEventListener("click", function () {
            document.getElementById("sidebar").classList.toggle("collapsed");
        });

    </script>
    <script src="../../../public/scripts/home.js"></script>
</body>
</html>
