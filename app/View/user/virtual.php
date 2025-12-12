<?php 
include('../../controller/dbconnect.php'); 

$sqlPets = "SELECT * FROM pets ORDER BY RAND() LIMIT 6";
$resultPets = $conn->query($sqlPets);
if (!$resultPets) {
    die("Lỗi SQL pets: " . $conn->error);
}

$sqlArticle = "SELECT * FROM articles ORDER BY RAND() LIMIT 3";
$resultArticle = $conn->query($sqlArticle);
if (!$resultArticle) {
    die("Lỗi SQL articles: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhận Nuôi</title>
    <link rel="icon" type="image/png" href="../../../public/icon/pawprint.png"> 
    <link rel="stylesheet" href="../../../public/css/virtual.css">
</head>
<body>
    <?php include("../layout/menu.php"); ?>
    <div class="banner-list">
        <img src="../../../public/img/cm20.png" alt="Pet">
        <div class="overlay"></div>
        <div class="banner-text">
            <h1>Nhận Nuôi Online</h1>
        </div>
    </div>
    <div class="container-text">
        <div class="adoption-condition">
            <h3>Các bước nhận nuôi ảo:</h3>
            <ul class="s-list">
                <li>Nghiên cứu danh sách các bé của nhóm</li>
                <li>Bấm nút Nhận đỡ đầu trên trang thông tin của bé và điền form</li>
                <li>Chờ xác nhận từ Admin</li>
            </ul>
        </div>
        <div class="adoption-step">
            <h2 class="adoption-title">Quy Trình Nhận Nuôi Ảo</h2>
            <p class="adoption-intro">Nếu bạn là người yêu động vật 
            nhưng chưa đủ điều kiện nhận một bé về nuôi, bạn có thể 
            giúp các bé bằng cách tham gia chương trình Nhận nuôi Ảo.
             Thay vì nhận một bé về nhà chăm, bạn có thể chọn một bé 
             để tài trợ tiền nuôi dưỡng bé.
            </p>
            <p class="adoption-intro">Chương trình này xuất phát từ thực tế là dù Nhóm đã nỗ lực tìm chủ, có nhiều bé đã ở Nhà chung với HPA nhiều năm nay và khó có khả năng tìm được mái ấm yêu thương. Các bé cần được tiêm phòng hàng năm, tiền thức ăn, bỉm cát, chưa kể chi phí chữa bệnh nếu phát sinh. Chi phí trung bình hàng năm cho một bé mèo hay chó khoảng 7 triệu đồng. Bằng cách làm Ba Mẹ đỡ đầu, bạn đã giúp bé cũng như chúng tôi trang trải chi phí chăm sóc bé.
            </p>
            <p class="adoption-intro">Bạn có thể lựa chọn hình thức ủng hộ 1 lần cho cả năm hoặc ủng hộ định kỳ hàng tháng.
            </p>
            <p class="adoption-intro">Với những Mạnh Thường Quân ủng hộ 1 lần cả năm hoặc 12 tháng liên tục, PetRescueHub xin gửi một phần quà nhỏ nhằm ghi nhận những nỗ lực của bạn trong việc chung tay cứu giúp chó mèo, thú cưng bị bỏ rơi. Bạn có thể lựa chọn một trong hai hình thức nhận quà sau:
            </p>
            <p class="adoption-intro">📧 Bản điện tử có thể in được:</p>
            <p class="adoption-intro">Đây là phương án tri ân dễ dàng nhất đối với những Mạnh Thường Quân ở xa hoặc không có điều kiện nhận quà trực tiếp. Bạn có thể tự in các giấy tờ chứng nhận làm kỷ niệm. Đồng thời, cách này cũng giúp chúng tôi tiết kiệm chi phí để dành cho việc chăm sóc các bé.
            - Giấy chứng nhận tham gia chương trình Nhận nuôi Ảo (bản PDF)
            - Cập nhật tình hình cũng như các khoản thu chi của bé qua email.</p>
            <p class="adoption-intro">📦 Bản cứng qua bưu điện hoặc dịch vụ giao nhận:</p>
            <p class="adoption-intro">Phần quà của bạn sẽ được gửi tới địa chỉ riêng qua bưu điện hoặc dịch vụ giao nhận.
            - Giấy chứng nhận tham gia chương trình Nhận nuôi Ảo
            - Quà lưu niệm từ nhà tài trợ (nếu có)
            - Cập nhật tình hình cũng như các khoản thu chi của bé qua email.</p>
            <p class="adoption-note"><strong>Lưu Ý:</strong>Trường hợp bé được nhận nuôi, phần tiền quyên góp còn lại của bé sẽ được chuyển vào quỹ chung để lo cho các bé khác.</p>
        </div>
    </div>
    <div class="content">
        <h1 class="title">Bé ngoan trong tuần</h1>
        <img class="icontitle" src="../../../public/icon/dog.png">
        <div class="pet-slider">
            <button class="btn-prev">&#8249;</button>
            <div class="pet-wrapper">
                <div class="pet-track">
                    <?php while($pet = mysqli_fetch_assoc($resultPets)){ ?>
                        <div class="pet-item">
                            <img src="<?= $pet['image'] ?>" alt="<?= htmlspecialchars($pet['name']) ?>">
                            <div class="info">
                                <p><?= htmlspecialchars($pet['name']) ?></p>
                                <span><strong>Tuổi:</strong> <?= htmlspecialchars($pet['age']) ?> tuổi</span><br>
                                <span><strong>Giới tính:</strong> <?= htmlspecialchars($pet['gender']) ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <button class="btn-next">&#8250;</button>
        </div>
        <a class="a-content" href="adoption.php">Nhận Nuôi</a>
    </div>
    <div class="banner-donate">
        <h1>Bạn đã sẵn sàng giúp đỡ ?</h1>
        <a href="donate.php">Ủng hộ ngay</a>
    </div>
    <div class="content">
        <h1 class="title">Tin Tức</h1>
        <div class="articles-wrapper">
            <?php while($article = mysqli_fetch_assoc($resultArticle)){ ?>
                <div class="article-item">
                    <img src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                    <div class="info-article">
                        <p><?= htmlspecialchars($article['create_at']) ?></p>
                        <a href="articles.php?id=<?php echo $article['id_article']; ?>"><?= htmlspecialchars($article['title']) ?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <a class="a-content" href="discover.php">Đọc Thêm</a>
    </div>
    <?php include('../layout/footer.php'); ?>
    <script src="../../../public/scripts/virtual.js"></script>
</body>
</html>