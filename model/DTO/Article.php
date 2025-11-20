<?php

class Article
{
    private $id_article;
    private $title;
    private $content;
    private $image;
    private $create_at;
    private $click;

    // Constructor
    public function __construct($id_article = null, $title = null, $content = null,
                                $image = null, $create_at = null, $click = null)
    {
        $this->id_article = $id_article;
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
        $this->create_at = $create_at;
        $this->click = $click;
    }

    // Getters
    public function getIdArticle() {
        return $this->id_article;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getImage() {
        return $this->image;
    }

    public function getCreateAt() {
        return $this->create_at;
    }

    public function getClick() {
        return $this->click;
    }

    // Setters
    public function setIdArticle($id_article) {
        $this->id_article = $id_article;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setCreateAt($create_at) {
        $this->create_at = $create_at;
    }

    public function setClick($click) {
        $this->click = $click;
    }
}

?>
