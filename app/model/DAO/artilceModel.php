<?php
class ArticleModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        $sql = "SELECT * FROM articles ORDER BY create_at DESC";
        return $this->conn->query($sql);
    }
}
