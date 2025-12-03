<?php
require_once __DIR__."/../DTO/Article.php";

class ArticleDAO{
    private $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }

    public function addArticle($article){
        $stmt=$this->conn->prepare("INSERT INTO article (title, content, image, click, category) VALUES (?, ?, ?, ?,?)");
        $title=$article->getTitle();
        $content=$article->getContent();
        $image=$article->getImage();
        $click=0;
        $category=$article->getCategory();
        $stmt->bind_param("sssds",$title,$content,$image,$click,$category);

        return $stmt->execute();
    }

    public function getAllArticles() {
    $sql = "SELECT * FROM article ORDER BY create_at DESC";
    $result = $this->conn->query($sql);

    $articles = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
    }
    return $articles;
    }

    public function getArticleById($id) {
    $sql = "SELECT * FROM article WHERE id_article = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
    }

    public function getOtherArticles($id) {
    $sql = "SELECT id_article, title, create_at, image 
            FROM article 
            WHERE id_article != ? 
            ORDER BY create_at DESC 
            LIMIT 3";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function increaseClick($id) {
    $sql = "UPDATE article SET click = click + 1 WHERE id_article = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
    }
}
?>