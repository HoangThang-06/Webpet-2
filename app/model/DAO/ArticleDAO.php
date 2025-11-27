<?php
require_once __DIR__."/../DTO/Article.php";

class ArticleDAO{
    private $conn;

    public function __construct($conn){
        $this->conn=$conn;
    }

    public function addArticle($article){
        $stmt=$this->conn->prepare("INSERT INTO article (title, content, image, click) VALUES (?, ?, ?, ?)");
        $title=$article->getTitle();
        $content=$article->getContent();
        $image=$article->getImage();
        $click=0;
        $stmt->bind_param("sssd",$title,$content,$image,$click);

        return $stmt->execute();
    }
}
?>