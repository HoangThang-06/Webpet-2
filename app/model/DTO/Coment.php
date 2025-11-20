<?php

class Comment
{
    private $id_comment;
    private $user_id;
    private $product_id;
    private $content;
    private $create_at;

    // Constructor
    public function __construct($id_comment = null, $user_id = null, $product_id = null,
                                $content = null, $create_at = null)
    {
        $this->id_comment = $id_comment;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->content = $content;
        $this->create_at = $create_at;
    }

    // Getters
    public function getIdComment() {
        return $this->id_comment;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCreateAt() {
        return $this->create_at;
    }

    // Setters
    public function setIdComment($id_comment) {
        $this->id_comment = $id_comment;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setProductId($product_id) {
        $this->product_id = $product_id;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setCreateAt($create_at) {
        $this->create_at = $create_at;
    }
}

?>
