<?php
require_once __DIR__."/../model/DTO/Article.php";
require_once __DIR__."/../model/DAO/ArticleDAO.php";
require_once __DIR__."/DBConnection.php";
class ArticleController{

    public function addArticle(){

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        return "Invalid request!";
    }

    $title = $_POST["title"];
    $click = 0;
    $category=$_POST["category"];

    if(!isset($_FILES["conten"]) || $_FILES["conten"]["error"] !== 0){
        return "Lỗi upload file txt!";
    }

    $txtExt = strtolower(pathinfo($_FILES["conten"]["name"], PATHINFO_EXTENSION));
    if($txtExt != "txt"){
        return "Chỉ chấp nhận file TXT";
    }

    // Thư mục PUBLIC (để client truy cập được)
    $contentFolder = "/public/article/";
    $serverContentFolder = __DIR__ . "/../../public/article/";

    if(!is_dir($serverContentFolder)){
        mkdir($serverContentFolder, 0777, true);
    }

    // Tên file
    $contentFileName = time() . "_" . $_FILES["conten"]["name"];

    // Đường dẫn server (real path)
    $contentFullPath = $serverContentFolder . $contentFileName;

    // Đường dẫn lưu vào DB (đường dẫn web)
    $contentDbPath = $contentFolder . $contentFileName;

    if(!move_uploaded_file($_FILES["conten"]["tmp_name"], $contentFullPath)){
        return "Không thể lưu file TXT!";
    }

    $imageDbPath = "";  // đường dẫn lưu vào DB

    if(isset($_FILES["image"]) && $_FILES["image"]["error"] === 0){

        $imgExt = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $allowedImg = ["jpg", "jpeg", "png", "webp"];

        if(!in_array($imgExt, $allowedImg)){
            return "Chỉ cho phép ảnh JPG, PNG, JPEG, WEBP";
        }

        $imgFolder = "/public/img/article/";
        $serverImgFolder = __DIR__ . "/../../public/img/article/";

        if(!is_dir($serverImgFolder)){
            mkdir($serverImgFolder, 0777, true);
        }

        $imageFileName = time() . "_" . $_FILES["image"]["name"];

        $imageFullPath = $serverImgFolder . $imageFileName;   // Lưu vào ổ đĩa
        $imageDbPath   = $imgFolder . $imageFileName;         // Lưu vào database

        if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imageFullPath)){
            return "Không thể lưu ảnh!";
        }
    }

    $article = new ArticleDTO();
    $article->setTitle($title);
    $article->setContent($contentDbPath); // dùng URL để hiển thị
    $article->setImage($imageDbPath);     // dùng URL để hiển thị
    $article->setClick($click);
    $article->setCategory($category);

    $conn = (new DBConnection())->getConnection();
    $dao = new ArticleDAO($conn);

    if ($dao->addArticle($article)) {
        return "Thêm bài báo thành công";
    } else {
        return "Lỗi thêm bài báo vào database";
    }
    }

    // Hàm lấy tất cả bài báo
    public function getAllArticles() {
        $conn = (new DBConnection())->getConnection();
        $dao = new ArticleDAO($conn);

        return $dao->getAllArticles();
    }

    public function getArticleById($id) {
    $conn = (new DBConnection())->getConnection();
    $dao = new ArticleDAO($conn);

    // Tăng lượt click
    $dao->increaseClick($id);

    // Lấy bài viết
    $article = $dao->getArticleById($id);
    if (!$article) return null;

    // Đọc nội dung file TXT
    $contentFile = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($article['content'], '/');
    if (file_exists($contentFile)) {
        $raw = file_get_contents($contentFile);
        $article['content_text'] = nl2br(htmlspecialchars($raw));
    } else {
        $article['content_text'] = "<i>Không tìm thấy nội dung bài viết!</i>";
    }

    return $article;
    }

    public function getOtherArticles($id) {
    $conn = (new DBConnection())->getConnection();
    $dao = new ArticleDAO($conn);
    $article=$dao->getOtherArticles($id);
    return $article;
    }

}
?>