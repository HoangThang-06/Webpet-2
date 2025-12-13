<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thú cưng</title>

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- BOOTSTRAP ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../../public/css/addPet.css" /> 
</head>

<body>

<?php
require_once __DIR__."/../../controller/Pet_ctr.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ctr = new PetController();
    $message = $ctr->addPet();
}
?>

<div class="conten">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <?php include("../layout/menuadmin.php"); ?>
    </div>

    <div class="container row g-3">

        <!-- Bên trái: Form nhập dữ liệu -->
        <div class="col-md-6">
            <div class="card">

                <div class="card-header">
                    <h4 class="mb-0"><i class="bi bi-plus-circle-fill me-2"></i>Thêm thú cưng</h4>
                </div>

                <div class="card-body">

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?= $message['status'] === 'success' ? 'success' : 'danger' ?> text-center">
                            <i class="bi bi-info-circle-fill me-2"></i><?= $message['message'] ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post" enctype="multipart/form-data">

                        <!-- Tên Pet -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-paw me-1"></i>Tên thú cưng
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-type"></i></span>
                                <input type="text" class="form-control" name="name_pet"
                                       placeholder="Nhập tên thú cưng" required>
                            </div>
                        </div>

                        <!-- Giới tính -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-gender-ambiguous me-1"></i>Giới tính
                            </label>
                            <select name="gender" class="form-select" required>
                                <option value="">-- Chọn giới tính --</option>
                                <option value="male">Đực</option>
                                <option value="female">Cái</option>
                            </select>
                        </div>

                        <!-- Mô tả -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-card-text me-1"></i>Mô tả
                            </label>
                            <textarea name="description" class="form-control"
                                      rows="4" placeholder="Nhập mô tả về thú cưng"></textarea>
                        </div>

                        <!-- STATE (ENUM) -->
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-clipboard-check me-1"></i>Tình trạng</label>
                            <input type="text" class="form-control" value="available" disabled>
                            <input type="hidden" name="state" value="available">
                            <div class="form-text">
                                Mặc định: <strong>available</strong> (Thú cưng mới thêm luôn trong trạng thái sẵn sàng).
                            </div>
                        </div>

                        <!-- Hình ảnh -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-image me-1"></i>Hình ảnh thú cưng
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-camera"></i></span>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>
                            <div class="form-text">Chấp nhận: JPG, PNG, GIF...</div>
                        </div>

                        <!-- Click -->
                        <input type="hidden" name="click" value="0">

                        <!-- Submit -->
                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send-fill me-2"></i>Thêm thú cưng
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- Bên phải: Hình ảnh + Mô tả -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <img src="\public\img\Adorable Golden Retriever Puppies.jpg"
                         alt="Upload Pet Illustration"
                         class="intro-image">

                    <h5 class="text-center mb-3">Chức năng thêm thú cưng</h5>

                    <p class="intro-text">
                        Trang này hỗ trợ Admin thêm mới thú cưng vào hệ thống với đầy đủ thông tin như:
                        tên, giới tính, mô tả, tình trạng và hình ảnh.
                    </p>

                    <ul class="feature-list text-start mt-3">
                        <li><i class="bi bi-check-circle-fill"></i>Nhập tên thú cưng.</li>
                        <li><i class="bi bi-check-circle-fill"></i>Chọn giới tính.</li>
                        <li><i class="bi bi-check-circle-fill"></i>Nhập mô tả chi tiết.</li>
                        <li><i class="bi bi-check-circle-fill"></i>Tải lên hình ảnh minh họa.</li>
                    </ul>

                    <p class="intro-text mt-3">
                        Sau khi hoàn tất, hệ thống sẽ lưu lại và hiển thị pet trên trang quản lý.
                    </p>

                </div>
            </div>
        </div>

    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById("toggleBtn").addEventListener("click", function () {
    document.getElementById("sidebar").classList.toggle("collapsed");
});
</script>

</body>
</html>
