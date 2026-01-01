<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bài báo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/manageArticle.css" />    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<?php session_start();?>
<body>
        <?php include("../layout/menuadmin.php"); ?>
    <div class="main-content">
        <h2>Danh Sách Bài Báo</h2>
        <div class="search-row" style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
            <select id="filterCategory" class="form-select form-select-sm" style="width:150px;">
                <option value="">Tất cả danh mục</option>
                <option value="cm">Chó mèo</option>
                <option value="k">Khác</option>
            </select>
        </div>
        <div class="employee-list" id="employeeList">
            <?php
                require_once __DIR__ . "/../../controller/Article_ctr.php";
                $article = new ArticleController();
                $query = $article->getAllArticles();
                if ($query == 0):
                    echo "<p>Không có bài báo nào trên hệ thống.</p>";
                endif;
                foreach ($query as $emp):
                   $image ="/Webpet-2" . $emp["image"]
            ?>           
            <div class="employee-item"
            data-category="<?= htmlspecialchars($emp['category']) ?>"
            data-content="<?= htmlspecialchars($emp['content']) ?>">
                <div class="employee-top">
                    <img src="<?= $image ?>" class="employee-avatar">
                    <div class="employee-info">
                        <h4 class="article-title">
                            <i class="bi bi-newspaper"></i> <?= htmlspecialchars($emp["title"]) ?>
                        </h4>
                        <p class="info-item">
                            <i class="bi bi-calendar3"></i>
                            <?= htmlspecialchars($emp["create_at"]) ?>
                        </p>
                        <p class="info-item">
                            <i class="bi bi-tags-fill"></i>
                            <?php
                            if($emp["category"]=="cm") $ctgr="Chó mèo";
                            else $ctgr="Khác";
                            ?>
                            <?= htmlspecialchars($ctgr) ?>
                        </p>
                        <p class="info-item">
                            <i class="bi bi-bar-chart-fill"></i>
                            <?= htmlspecialchars($emp["click"]) ?> lượt xem
                        </p>
                    </div>
                </div>
                <div class="employee-actions">
                    <button class="action-btn btn-view">Xem</button>
                    <button class="action-btn btn-edit" data-id="<?= $emp['id_article'] ?>">Sửa</button>
                    <button class="action-btn btn-delete" data-id="<?= $emp['id_article'] ?>">Xóa</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- BIỂU ĐỒ -->
    <div class="right-panel">
        <?php
            $cmCount = 0;
            $kCount = 0;
            $monthClick = array_fill(1, 12, 0);
            foreach ($query as $a) {
                if (!empty($a["create_at"])) {
                    $month = intval(date("m", strtotime($a["create_at"])));
                    $monthClick[$month] += intval($a["click"]);
                }
            }
            foreach ($query as $emp) {
                if (($emp["category"] ?? "") === "cm") $cmCount++;
                else if (($emp["category"] ?? "") === "k") $kCount++;
            }
        ?>
        <h4 style="margin-top: 30px;">Tỷ Lệ Bài Viết Theo Danh Mục</h4>
        <canvas id="categoryChart" class="chart-container"></canvas>
        <h4 style="margin-top: 30px;">Số Lượt Click Theo Thời Gian</h4>
        <canvas id="clickChart" class="chart-container"></canvas>
    </div>
    <!-- Modal Xem bài báo -->
    <div id="viewArticleModal" class="modal">
        <div class="modal-content">
            <span id="closeView" class="close">&times;</span>
            <h3 id="viewTitle"></h3>
            <p><strong>Ngày tạo:</strong> <span id="viewDate"></span></p>
            <p><strong>Danh mục:</strong> <span id="viewCategory"></span></p>
            <p><strong>Lượt xem:</strong> <span id="viewClick"></span></p>
            <p><strong>Nội dung:</strong></p>
            <div id="viewContent"></div>
            <img id="viewImage" src="" alt="Ảnh bài báo" style="max-width:100%; margin-top:10px;">
            <a href="#" target="_blank" id="readFileBtn" style="display:none; margin-top:10px;" class="btn btn-primary">Đọc file</a>
        </div>
    </div>
    <!-- Modal Sửa bài báo -->
    <div id="editArticleModal" class="modal">
        <div class="modal-content">
            <span id="closeEditArticle" class="close">&times;</span>
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Sửa bài báo</h4>
            <form id="editArticleForm" enctype="multipart/form-data">
                <input type="hidden" name="id_article" id="editIdArticle">
                <!-- Tiêu đề -->
                <div class="mb-3">
                    <label for="editTitle" class="form-label">
                        <i class="bi bi-pencil-square me-1"></i>Tiêu đề
                    </label>
                    <input type="text" class="form-control" name="title" id="editTitle" required>
                </div>
                <!-- Nội dung TXT -->
                <div class="mb-3">
                    <label for="editConten" class="form-label">
                        <i class="bi bi-file-earmark-text me-1"></i>Nội dung (.txt)
                    </label>
                    <input type="file" class="form-control" name="conten" id="editConten" accept=".txt">
                    <div class="form-text">Nếu muốn thay đổi nội dung, chọn file mới. Để giữ nguyên, bỏ trống.</div>
                </div>
                <!-- Hình ảnh -->
                <div class="mb-3">
                    <label for="editImage" class="form-label">
                        <i class="bi bi-image me-1"></i>Hình ảnh
                    </label>
                    <input type="file" class="form-control" name="image" id="editImage" accept="image/*">
                    <div class="form-text">Nếu muốn thay đổi ảnh, chọn file mới. Để giữ nguyên, bỏ trống.</div>
                    <img id="currentImage" src="" style="max-width: 100px; margin-top:10px;">
                </div>
                <!-- CATEGORY -->
                <div class="mb-3">
                    <label for="editCategory" class="form-label">
                        <i class="bi bi-tags me-1"></i>Danh mục bài viết
                    </label>
                    <select name="category" id="editCategory" class="form-select" required>
                        <option value="">-- Chọn danh mục --</option>
                        <option value="cm">Chó và Mèo</option>
                        <option value="k">Khác</option>
                    </select>
                </div>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-fill me-2"></i>Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let clickLabels = <?= json_encode(array_keys($monthClick)) ?>; 
        let clickData   = <?= json_encode(array_values($monthClick)) ?>;
        window.cmCount = <?= $cmCount ?>;
        window.kCount = <?= $kCount ?>;
    </script>
    <script src="../../../public/scripts/manageArticle.js"></script>
</body>
</html>
