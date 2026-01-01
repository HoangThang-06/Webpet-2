<?php
require_once __DIR__ . '/../model/DTO/Article.php';
require_once __DIR__ . '/../model/DAO/ArticleDAO.php';
require_once __DIR__ . '/DBConnection.php';
class ArticleController{

    private $ArticleDAO;

    public function __construct(){
        $conn=(new DBConnection())->getConnection();
        $this->ArticleDAO = new ArticleDAO($conn);
    }

   public function addArticle(){

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        return "Invalid request!";
    }

    $title    = trim($_POST["title"]);
    $category = $_POST["category"];
    $click    = 0;

    if ($this->ArticleDAO->isTitleExists($title)) {
        return " Tiêu đề bài báo đã tồn tại!";
    }

    // KIỂM TRA FILE TXT
    if(!isset($_FILES["conten"]) || $_FILES["conten"]["error"] !== 0){
        return "Lỗi upload file txt!";
    }

    $txtExt = strtolower(pathinfo($_FILES["conten"]["name"], PATHINFO_EXTENSION));
    if($txtExt != "txt"){
        return "Chỉ chấp nhận file TXT";
    }

    // UPLOAD FILE TXT
    $contentFolder = "/public/article/";
    $serverContentFolder = __DIR__ . "/../../public/article/";

    if(!is_dir($serverContentFolder)){
        mkdir($serverContentFolder, 0777, true);
    }

    $contentFileName = time() . "_" . $_FILES["conten"]["name"];
    $contentFullPath = $serverContentFolder . $contentFileName;
    $contentDbPath   = $contentFolder . $contentFileName;

    if(!move_uploaded_file($_FILES["conten"]["tmp_name"], $contentFullPath)){
        return "Không thể lưu file TXT!";
    }

    $imageDbPath = "";

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
        $imageFullPath = $serverImgFolder . $imageFileName;
        $imageDbPath   = $imgFolder . $imageFileName;

        if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imageFullPath)){
            return "Không thể lưu ảnh!";
        }
    }

    $article = new ArticleDTO();
    $article->setTitle($title);
    $article->setContent($contentDbPath);
    $article->setImage($imageDbPath);
    $article->setClick($click);
    $article->setCategory($category);

    if ($this->ArticleDAO->addArticle($article)) {
        return "✅ Thêm bài báo thành công";
    } else {
        return "❌ Lỗi thêm bài báo vào database";
    }
}


    // Hàm lấy tất cả bài báo
    public function getAllArticles() {
        return $this->ArticleDAO->getAllArticles();
    }

    public function getArticleById($id) {
    // Tăng lượt click
    $this->ArticleDAO->increaseClick($id);

    // Lấy bài viết
    $article = $this->ArticleDAO->getArticleById($id);
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
    $article=$this->ArticleDAO->getOtherArticles($id);
    return $article;
    }
    
    public function getTopArticle(){
        return $this->ArticleDAO->getTopArticle();
    }

    public function deleteArticle($id) {
    return $this->ArticleDAO->deleteArticle($id);
    }

    public function updateArticle($data) {
    return $this->ArticleDAO->updateArticle($data);
    }
}
?>