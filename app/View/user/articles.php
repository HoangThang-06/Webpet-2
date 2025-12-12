<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']); ?></title>
    <link rel="icon" type="image/png" href="../../../public/icon/pawprint.png"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../../public/css/artilce.css" />
    </head>
</head>
<body>
    <?php
    require_once __DIR__ . "/../../controller/Article_ctr.php";

    $controller = new ArticleController();

    // Lấy ID
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Bài chính
    $article = $controller->getArticleById($id);

    // Bài viết khác
    $otherArticles = $controller->getOtherArticles($id);

    if (!$article) {
        die("Bài viết không tồn tại!");
    }
    ?>

    <main class="container my-5">
        <div class="row">
            <article class="bao col-lg-8 col-md-12">

            <header class="article-header">
                <h1 class="article-title"><?= htmlspecialchars($article['title']); ?></h1>
                <p class="article-date">Ngày đăng: <?= date('d/m/Y', strtotime($article['create_at'])); ?></p>
            </header>

            <div class="article-content">

                <?= $article['content_text']; ?>

                    <br><br>

            <!-- Ảnh bài viết -->
            <?php if (!empty($article['image'])): ?>
                <img src="<?= htmlspecialchars($article['image']); ?>"
                    alt="Ảnh bài viết"
                    class="article-image img-fluid"
                    loading="lazy">
            <?php endif; ?>
        </div>

        <div class="mt-4">
            <button class="btn btn-outline-primary" onclick="shareArticle()">Chia sẻ bài viết</button>
        </div>

        </article>


            <!-- Bài viết khác -->
            <aside class="ttkhac col-lg-4 col-md-12">
                <div class="sidebar">
                    <a href="discover.php" class="view-more">
                        <h3 class="sidebar-title mb-0">Xem Thêm Bài Viết</h3>
                    </a>

                    <?php foreach ($otherArticles as $row): ?>
                        <?php $otherLink = "articles.php?id=" . $row['id_article']; ?>
                        <a href="<?= htmlspecialchars($otherLink); ?>" class="post-card">
                            <div class="flex-grow-1">
                                <div class="post-date"><?= date('d/m/Y', strtotime($row['create_at'])); ?></div>
                                <div class="post-title"><?= htmlspecialchars($row['title']); ?></div>
                                <span class="post-link">Đọc thêm →</span>
                            </div>
                            <?php if ($row['image']): ?>
                                <img src="<?= htmlspecialchars($row['image']); ?>" 
                                     alt="Ảnh bài viết: <?= htmlspecialchars($row['title']); ?>" 
                                     class="post-img" 
                                     loading="lazy">
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </aside>
        </div>
    </main>

    <?php include('../layout/footer.php'); ?>

    <!-- Bootstrap JS (giả định bạn đã include) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple share function (optional)
        function shareArticle() {
            if (navigator.share) {
                navigator.share({
                    title: '<?= htmlspecialchars($article['title']); ?>',
                    url: window.location.href
                });
            } else {
                alert('Chia sẻ: ' + window.location.href);
            }
        }
    </script>
</body>
</html>