<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm bài báo</title>
    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- BOOTSTRAP ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/addArticle.css" /> 
</head>

<body>

<?php
require_once __DIR__."/../../controller/Product_ctr.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ctr = new ProductController();
    $result = $ctr->addProduct();
    $message=$result["message"];
}
?>

<div class="conten">
    <!-- SIDEBAR -->
        <?php include("../layout/menuadmin.php"); ?>
    <div class="container row g-3">
        <!-- Bên trái: Form nhập dữ liệu -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="bi bi-plus-circle-fill me-2"></i>Thêm Sản Phẩm</h4>
                </div>

                <div class="card-body">
                    <?php if (!empty($message)): ?>
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle-fill me-2"></i><?= $message ?>
                    </div>
                    <?php endif; ?>

                   <form action="" method="post" enctype="multipart/form-data">
                    <!-- Tên sản phẩm -->
                    <div class="mb-3">
                        <label for="name_product" class="form-label">
                            <i class="bi bi-pencil-square me-1"></i>Tên sản phẩm
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-type"></i></span>
                            <input type="text" class="form-control" name="name_product" id="name_product"
                                placeholder="Nhập tên sản phẩm" required>
                        </div>
                    </div>

                    <!-- Danh mục -->
                    <div class="mb-3">
                        <label for="category" class="form-label">
                            <i class="bi bi-tags me-1"></i>Danh mục sản phẩm
                        </label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="">-- Chọn danh mục --</option>
                            <option value="food">Food</option>
                            <option value="toy">Toy</option>
                            <option value="accessory">Accessory</option>
                            <option value="health">Health</option>
                        </select>
                    </div>

                    <!-- Giá -->
                    <div class="mb-3">
                        <label for="price" class="form-label">
                            <i class="bi bi-cash-stack me-1"></i>Giá
                        </label>
                        <input type="number" class="form-control" name="price" id="price" placeholder="Nhập giá sản phẩm" required>
                    </div>

                    <!-- Số lượng -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">
                            <i class="bi bi-box-seam me-1"></i>Số lượng
                        </label>
                        <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Nhập số lượng" required>
                    </div>

                    <!-- Mô tả -->
                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="bi bi-card-text me-1"></i>Mô tả
                        </label>
                        <textarea class="form-control" name="description" id="description" rows="4"
                                placeholder="Nhập mô tả sản phẩm" required></textarea>
                    </div>

                    <!-- Hình ảnh -->
                    <div class="mb-3">
                        <label for="imge" class="form-label">
                            <i class="bi bi-image me-1"></i>Hình ảnh
                        </label>
                        <input type="file" class="form-control" name="imge" id="imge" accept="image/*">
                        <div class="form-text">Tùy chọn: JPG, PNG, GIF...</div>
                    </div>

                    <!-- Click mặc định -->
                    <input type="hidden" name="click" value="0">

                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle-fill me-2"></i>Thêm sản phẩm
                        </button>
                    </div>
                </form>

                </div>
            </div>
        </div>

        <!-- Bên phải: Hình ảnh và giới thiệu -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center">
                    <img src="\public\img\image.png" alt="Upload Article Illustration" class="intro-image">
                    <h5 class="text-center mb-3">Chức năng Upload Bài Báo cho Admin</h5>
                    <p class="intro-text">
                        Chức năng này được thiết kế dành riêng cho quản trị viên (Admin) để tải lên các bài báo mới một cách dễ dàng và hiệu quả. Bạn có thể quản lý nội dung trang web bằng cách thêm các bài viết chất lượng.
                    </p>
                    <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill"></i><strong>Nhập tiêu đề:</strong> Tạo tiêu đề hấp dẫn cho bài báo.</li>
                        <li><i class="bi bi-check-circle-fill"></i><strong>Tải nội dung:</strong> Chọn file .txt chứa nội dung bài viết.</li>
                        <li><i class="bi bi-check-circle-fill"></i><strong>Thêm hình ảnh:</strong> Tùy chọn tải lên hình minh họa để bài báo sinh động hơn.</li>
                        <li><i class="bi bi-check-circle-fill"></i><strong>Đăng bài nhanh chóng:</strong> Nhấn "Đăng bài" để lưu và xuất bản ngay lập tức.</li>
                    </ul>
                    <p class="intro-text mt-3">
                        Với giao diện thân thiện, bạn có thể thực hiện mọi thao tác chỉ trong vài bước. Hãy bắt đầu tải lên bài báo đầu tiên của bạn!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>