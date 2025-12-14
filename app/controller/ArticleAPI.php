<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . "/Article_ctr.php";
$articleCtr = new ArticleController();

// Thư mục public
$contentFolder     = "/public/article/";
$serverContentFolder = __DIR__ . "/../../public/article/";
$imgFolder         = "/public/img/article/";
$serverImgFolder   = __DIR__ . "/../../public/img/article/";

// Lấy action từ AJAX
$action = $_POST['action'] ?? '';

if ($action === 'delete') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    if ($id <= 0) {
        echo json_encode(["success" => false, "message" => "Thiếu ID bài báo"]);
        exit;
    }

    // Lấy bài báo hiện tại
    $currentArticle = $articleCtr->getArticleById($id);
    if (!$currentArticle) {
        echo json_encode(["success" => false, "message" => "Bài báo không tồn tại"]);
        exit;
    }

    // Xóa file nội dung
    if (!empty($currentArticle['content'])) {
        $contentFile = $_SERVER['DOCUMENT_ROOT'] . $currentArticle['content'];
        if (file_exists($contentFile)) unlink($contentFile);
    }

    // Xóa file ảnh
    if (!empty($currentArticle['image'])) {
        $imageFile = $_SERVER['DOCUMENT_ROOT'] . $currentArticle['image'];
        if (file_exists($imageFile)) unlink($imageFile);
    }

    // Xóa bài báo trong database
    $result = $articleCtr->deleteArticle($id);

    echo json_encode([
        "success" => $result,
        "message" => $result ? "Xóa thành công" : "Xóa thất bại"
    ]);
    exit;
}

if ($action === 'update') {
    $id_article = isset($_POST['id_article']) ? intval($_POST['id_article']) : 0;
    $title      = $_POST['title'] ?? "";
    $category   = $_POST['category'] ?? "";

    if ($id_article <= 0) {
        echo json_encode(["success" => false, "message" => "Thiếu ID bài báo"]);
        exit;
    }

    $currentArticle = $articleCtr->getArticleById($id_article);
    if (!$currentArticle) {
        echo json_encode(["success" => false, "message" => "Bài báo không tồn tại"]);
        exit;
    }

    // --- Xử lý file nội dung
    $contentPath = $currentArticle['content'] ?? "";
    if (isset($_FILES['conten']) && $_FILES['conten']['error'] === 0) {
        $file = $_FILES['conten'];
        $fileName = time() . "_" . basename($file['name']);
        if (!is_dir($serverContentFolder)) mkdir($serverContentFolder, 0777, true);
        $targetPath = $serverContentFolder . $fileName;
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            if (!empty($currentArticle['content'])) {
                $oldContentServer = $_SERVER['DOCUMENT_ROOT'] . $currentArticle['content'];
                if (file_exists($oldContentServer)) unlink($oldContentServer);
            }
            $contentPath = $contentFolder . $fileName;
        } else {
            echo json_encode(["success" => false, "message" => "Không thể upload file nội dung"]);
            exit;
        }
    }

    // --- Xử lý ảnh
    $imagePath = $currentArticle['image'] ?? "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imgFile = $_FILES['image'];
        $imgName = time() . "_" . basename($imgFile['name']);
        if (!is_dir($serverImgFolder)) mkdir($serverImgFolder, 0777, true);
        $imgTarget = $serverImgFolder . $imgName;
        if (move_uploaded_file($imgFile['tmp_name'], $imgTarget)) {
            if (!empty($currentArticle['image'])) {
                $oldImgServer = $_SERVER['DOCUMENT_ROOT'] . $currentArticle['image'];
                if (file_exists($oldImgServer)) unlink($oldImgServer);
            }
            $imagePath = $imgFolder . $imgName;
        } 
    }

    // --- Gộp dữ liệu
    $articleData = [
        "id_article" => $id_article,
        "title"      => $title,
        "category"   => $category,
        "content"    => $contentPath,
        "image"      => $imagePath
    ];

    $update = $articleCtr->updateArticle($articleData);

    echo json_encode([
        "success" => $update,
        "message" => $update ? "Cập nhật bài báo thành công" : "Có lỗi xảy ra khi cập nhật bài báo"
    ]);
    exit;
}

// Nếu không có action hợp lệ
echo json_encode(["success" => false, "message" => "Hành động không hợp lệ"]);
