<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../../controller/Article_ctr.php";

$articleCtr = new ArticleController();

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "Thiếu ID bài báo"]);
    exit;
}

// Gọi controller xóa bài báo
$result = $articleCtr->deleteArticle($id);

echo json_encode([
    "success" => $result,
    "message" => $result ? "Xóa thành công" : "Xóa thất bại"
]);
