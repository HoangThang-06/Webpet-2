<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . "/../../controller/Article_ctr.php";
$articleCtr = new ArticleController();

// Thư mục public
$contentFolder = "/public/article/";   // URL public
$serverContentFolder = __DIR__ . "/../../../public/article/"; // server path
$imgFolder     = "/public/img/article/"; 
$serverImgFolder = __DIR__ . "/../../../public/img/article/";

// Lấy dữ liệu form gửi lên
$id_article = isset($_POST['id_article']) ? intval($_POST['id_article']) : 0;
$title      = $_POST['title'] ?? "";
$category   = $_POST['category'] ?? "";

// Kiểm tra ID
if ($id_article <= 0) {
    echo json_encode(["success" => false, "message" => "Thiếu ID bài báo"]);
    exit;
}

// Lấy bài báo hiện tại
$currentArticle = $articleCtr->getArticleById($id_article);
if (!$currentArticle) {
    echo json_encode(["success" => false, "message" => "Bài báo không tồn tại"]);
    exit;
}

// --- Xử lý file nội dung (.txt)
$contentPath = $currentArticle['content']; // giữ URL public cũ
if (isset($_FILES['conten']) && $_FILES['conten']['error'] == 0) {
    $file = $_FILES['conten'];
    $fileName = time() . "_" . basename($file['name']);

    if (!is_dir($serverContentFolder)) mkdir($serverContentFolder, 0777, true);
    $targetPath = $serverContentFolder . $fileName; // server path

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Xóa file cũ nếu tồn tại
        if (!empty($currentArticle['content'])) {
            $oldContentServer = $_SERVER['DOCUMENT_ROOT'] . $currentArticle['content'];
            if (file_exists($oldContentServer)) unlink($oldContentServer);
        }

        $contentPath = $contentFolder . $fileName; // URL public mới
    } else {
        echo json_encode(["success" => false, "message" => "Không thể upload file nội dung"]);
        exit;
    }
}

// --- Xử lý ảnh
$imagePath = $currentArticle['image'] ?? "";
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $imgFile = $_FILES['image'];
    $imgName = time() . "_" . basename($imgFile['name']);

    if (!is_dir($serverImgFolder)) mkdir($serverImgFolder, 0777, true);
    $imgTarget = $serverImgFolder . $imgName;

    if (move_uploaded_file($imgFile['tmp_name'], $imgTarget)) {
        // Xóa ảnh cũ nếu tồn tại
        if (!empty($currentArticle['image'])) {
            $oldImgServer = $_SERVER['DOCUMENT_ROOT'] . $currentArticle['image'];
            if (file_exists($oldImgServer)) unlink($oldImgServer);
        }

        $imagePath = $imgFolder . $imgName; // URL public mới
    } else {
        echo json_encode(["success" => false, "message" => "Không thể upload ảnh"]);
        exit;
    }
}

// --- Gộp dữ liệu cập nhật
$articleData = [
    "id_article" => $id_article,
    "title"      => $title,
    "content"    => $contentPath,
    "image"      => $imagePath,
    "category"   => $category
];

if (!$articleCtr->updateArticle($articleData)) {
    error_log(print_r($articleData, true));
    error_log($articleCtr->getLastError()); // nếu có hàm getLastError
}

// --- Cập nhật DB
$update = $articleCtr->updateArticle($articleData);

echo json_encode([
    "success" => $update,
    "message" => $update ? "Cập nhật bài báo thành công" : "Có lỗi xảy ra khi cập nhật bài bá kkko"
]);
