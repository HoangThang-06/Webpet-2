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
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', sans-serif;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 100%;
        }
        .card-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            text-align: center;
            padding: 1.5rem 1rem;
        }
        .card-header h4 {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .card-body {
            padding: 1.5rem;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }
        .form-control:focus {
            border-color: #4facfe;
            box-shadow: 0 0 0 0.15rem rgba(79, 172, 254, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
            transition: transform 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px 0 0 8px;
            font-size: 0.9rem;
        }
        .alert {
            border-radius: 8px;
            font-size: 0.9rem;
        }
        .form-label {
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .form-text {
            font-size: 0.8rem;
        }
        .intro-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .intro-text {
            font-size: 0.95rem;
            line-height: 1.5;
            color: #555;
        }
        .feature-list {
            list-style: none;
            padding: 0;
            font-size: 0.9rem;
        }
        .feature-list li {
            margin-bottom: 0.5rem;
        }
        .feature-list li i {
            color: #4facfe;
            margin-right: 0.5rem;
        }
        .feature-list strong {
            font-weight: 500;
        }
        h5 {
            font-size: 1.1rem;
            font-weight: 600;
        }
    </style>
</head>

<body>

<?php
require_once __DIR__."/../../controller/Article_ctr.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ctr = new ArticleController();
    $message = $ctr->addArticle();
}
?>

<div class="container">
    <div class="row g-3">
        <!-- Bên trái: Form nhập dữ liệu -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="bi bi-plus-circle-fill me-2"></i>Thêm bài báo</h4>
                </div>

                <div class="card-body">
                    <?php if (!empty($message)): ?>
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle-fill me-2"></i><?= $message ?>
                    </div>
                    <?php endif; ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label"><i class="bi bi-pencil-square me-1"></i>Tiêu đề</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-type"></i></span>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Nhập tiêu đề bài báo" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="conten" class="form-label"><i class="bi bi-file-earmark-text me-1"></i>Nội dung (.txt)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-upload"></i></span>
                                <input type="file" class="form-control" name="conten" id="conten" accept=".txt" required>
                            </div>
                            <div class="form-text">Chỉ chấp nhận file .txt</div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label"><i class="bi bi-image me-1"></i>Hình ảnh</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-camera"></i></span>
                                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                            </div>
                            <div class="form-text">Tùy chọn: JPG, PNG, GIF, v.v.</div>
                        </div>

                        <input type="hidden" name="click" value="0">

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send-fill me-2"></i>Đăng bài
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
                    <img src="D:\year2\Projectweb\public\img\image.png" alt="Upload Article Illustration" class="intro-image">
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