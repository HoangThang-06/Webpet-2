<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhân Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/manageProduct.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<?php
session_start();
?>
<body>
    <?php include("../layout/menuadmin.php"); ?>
    <div class="main-content">
        <h2>Danh Sách Sản Phẩm</h2><br>
        <div class="search-row">
            <input type="text" name="search" id="search" placeholder="Nhập tên sản phẩm" class="form-control ms-2">
            <button type="button" class="btn btn-primary ms-2">Tìm kiếm</button>
            <select id="filterCategory" class="form-select form-select-sm ms-2" style="width: 150px;">
                <option value="">Tất cả danh mục</option>
                <?php
                require_once __DIR__ . "/../../controller/Product_ctr.php";
                $productCtr = new ProductController();
                $products = $productCtr->getAllProducts();
                $categories = [];        
                foreach ($products as $prod) {
                    if (!in_array($prod['category'], $categories)) {
                        $categories[] = $prod['category'];
                        echo "<option value='{$prod['category']}'>{$prod['category']}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="product-list" id="productList">
            <?php
            require_once __DIR__ . "/../../controller/Product_ctr.php";
            $productCtr = new ProductController();
            $products = $productCtr->getAllProducts();
            if (empty($products)):
                echo "<p>Chưa có sản phẩm nào.</p>";
            endif;
            foreach ($products as $prod):
                $image = $prod["image"];
                ?>
                <div class="product-item" data-name="<?= htmlspecialchars($prod["name_product"]) ?>"
                    data-category="<?= htmlspecialchars($prod["category"]) ?>"
                    data-price="<?= htmlspecialchars($prod["price"]) ?>"
                    data-quantity="<?= htmlspecialchars($prod["quantity"]) ?>"
                    data-description="<?= htmlspecialchars($prod["description"]) ?>"
                    data-click="<?= htmlspecialchars($prod["click"]) ?>" data-image="<?= $image ?>">
                    <div class="product-left">
                        <img src="<?= $image ?>" class="product-image" alt="product">
                        <div class="product-info">
                            <strong><?= htmlspecialchars($prod["name_product"]) ?></strong><br>
                            Danh mục: <?= htmlspecialchars($prod["category"]) ?><br>
                            Giá: <?= htmlspecialchars($prod["price"]) ?><br>
                            Số lượng: <?= htmlspecialchars($prod["quantity"]) ?><br>
                            Click: <?= htmlspecialchars($prod["click"]) ?>
                        </div>
                    </div>
                    <div class="product-actions">
                        <button class="action-btn btn-view" data-name="<?= htmlspecialchars($prod["name_product"]) ?>"
                            data-category="<?= htmlspecialchars($prod["category"]) ?>"
                            data-price="<?= htmlspecialchars($prod["price"]) ?>"
                            data-quantity="<?= htmlspecialchars($prod["quantity"]) ?>"
                            data-description="<?= htmlspecialchars($prod["description"]) ?>"
                            data-click="<?= htmlspecialchars($prod["click"]) ?>"
                            data-create="<?= htmlspecialchars($prod["created_at"]) ?>" data-image="<?= $image ?>">
                            Xem
                        </button>
                        <button class="action-btn btn-edit" data-id_product="<?= $prod["id_product"] ?>"
                            data-name="<?= htmlspecialchars($prod["name_product"]) ?>"
                            data-category="<?= htmlspecialchars($prod["category"]) ?>"
                            data-price="<?= htmlspecialchars($prod["price"]) ?>"
                            data-quantity="<?= htmlspecialchars($prod["quantity"]) ?>"
                            data-description="<?= htmlspecialchars($prod["description"]) ?>"
                            data-click="<?= htmlspecialchars($prod["click"]) ?>"
                            data-image="<?= $prod["image"] ?>">
                            Sửa
                        </button>
                        <button class="action-btn btn-delete" data-id="<?= $prod["id_product"] ?>"
                            data-image="<?= $prod["image"] ?>">
                            Xóa
                        </button>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
    <div id="viewProductModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Thông tin chi tiết sản phẩm</h3>
            <div class="modal-body">
                <div class="modal-image">
                    <img id="modalImage" src="" alt="product">
                </div>
                <div class="modal-info">
                    <p id="modalName"></p>
                    <p id="modalCategory"></p>
                    <p id="modalPrice"></p>
                    <p id="modalQuantity"></p>
                    <p id="modalDescription"></p>
                    <p id="modalClick"></p>
                    <p id="modalCreate"></p>
                </div>
            </div>
        </div>
    </div>
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <span id="closeEdit" class="close">&times;</span>
            <h3>Sửa sản phẩm</h3>

            <form id="editProductForm" enctype="multipart/form-data">
                <input type="hidden" id="editId_product" name="id_product">

                <label>Tên sản phẩm</label>
                <input type="text" id="editName" class="form-control" name="name_product">

                <label>Danh mục</label>
                <select id="editCategory" class="form-control" name="category">
                    <?php foreach ($products as $cat) {
                        echo "<option value='{$cat['category']}'>{$cat['category']}</option>";
                    } ?>
                </select>

                <label>Giá</label>
                <input type="number" id="editPrice" class="form-control" name="price">

                <label>Số lượng</label>
                <input type="number" id="editQuantity" class="form-control" name="quantity">

                <label>Mô tả</label>
                <textarea id="editDescription" class="form-control" rows="4" name="description"></textarea>

                <label>Hình ảnh</label>
                <input type="file" id="editImage" name="image" class="form-control">

                <button type="submit" class="btn btn-primary mt-2">
                    Lưu thay đổi
                </button>
            </form>
        </div>
    </div>
    <div class="right-panel">
        <?php
        $categoryStats = [];
        foreach ($products as $p) {
            $cat = $p['category'];
            if (!isset($categoryStats[$cat])) {
                $categoryStats[$cat] = 0;
            }
            $categoryStats[$cat]++;
        }
        usort($products, function ($a, $b) {
            return $b['click'] <=> $a['click'];
        });
        $top3 = array_slice($products, 0, 3);
        $topNames = [];
        $topClicks = [];
        foreach ($top3 as $p) {
            $topNames[] = $p['name_product'];
            $topClicks[] = (int) $p['click'];
        }
        ?>
        <h4 style="margin-top:30px">Thống kê theo danh mục</h4>
        <canvas id="categoryChart" class="chart-container"></canvas>
        <h4 style="margin-top:30px">Top 3 sản phẩm click cao nhất</h4>
        <canvas id="topProductChart" class="chart-container"></canvas>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        window.categoryLabels = <?= json_encode(array_keys($categoryStats)) ?>;
        window.categoryCounts = <?= json_encode(array_values($categoryStats)) ?>;
        window.topProductNames = <?= json_encode($topNames) ?>;
        window.topProductClicks = <?= json_encode($topClicks) ?>;
    </script>
    <script src="../../../public/scripts/manageProduct.js"></script>
</body>
</html>