<?php
include('../../controller/dbconnect.php');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Bài viết không hợp lệ.");
}
$sql = "SELECT * FROM article WHERE id_article = $id LIMIT 1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $article = $result->fetch_assoc();
} else {
    die("Bài viết không tồn tại.");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../../public/css/article.css" />
    </head>
<body>
<?php include('../layout/menu.php'); ?>

<div class="page-wrap">
    <div class="content-left">
        <div class="bao">
            <h1 class="tt"><?= htmlspecialchars($article['title']); ?></h1>
            <p class="b">Ngày đăng: <?= date('d/m/Y', strtotime($article['create_at'])); ?></p>
            <div class="article-content">
            <?php
            $contentPath = dirname(__DIR__, 3) . $article['content'];
            if (file_exists($contentPath)) {
                echo nl2br(htmlspecialchars(file_get_contents($contentPath)));
            } else {
                echo "<i>Không tìm thấy nội dung bài viết.</i>";
            }
            ?>
            <br>

            <?php if (!empty($article['image'])): ?>
                <img style="width:100%;object-fit:cover"
                    src="<?= '/Webpet-2' . htmlspecialchars($article['image']) ?>"
                    alt="Ảnh bài viết">
            <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="content-right">
        <div class="ttkhac">
            <a href="discover.php" class="xt"><h3 class="xemthem">Xem Thêm</h3></a>
            <?php
            $sql_other = "SELECT id_article, title, create_at, image 
                        FROM article WHERE id_article != $id ORDER BY create_at DESC LIMIT 3";
            $res_other = $conn->query($sql_other);
            if ($res_other && $res_other->num_rows > 0) {
                while ($row = $res_other->fetch_assoc()) {
                    $link = "articles.php?id=" . $row['id_article'];
                     $imageUrl = '/Webpet-2' . $row['image'];
                    ?>
                    <div class="col">
                        <a href="<?= $link ?>" class="t1">
                            <div class="post-card">
                                <div>
                                    <div class="post-date"><?= date('d/m/Y', strtotime($row['create_at'])); ?></div>
                                    <div class="post-title"><?= htmlspecialchars($row['title']); ?></div>
                                    <span class="post-link">Đọc thêm</span>
                                </div>
                                <?php if($imageUrl): ?>
                                    <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($row['title']); ?>" class="post-img" />
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<?php include('../layout/footer.php'); ?>
</body>
</html>