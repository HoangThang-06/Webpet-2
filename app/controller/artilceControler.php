<?php
include('../../controller/dbconnect.php');
include('../model/articleModel.php');

class ArticleController {
    private $model;

    public function __construct($conn) {
        $this->model = new ArticleModel($conn);
    }

    public function getAllArticles() {
        return $this->model->getAll();
    }
}
