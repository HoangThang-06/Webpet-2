<?php

class Cart
{
    private $id_cart;
    private $user_id;
    private $product_id;
    private $quantity;
    private $added_at;

    // Constructor
    public function __construct($id_cart = null, $user_id = null, $product_id = null,
                                $quantity = null, $added_at = null)
    {
        $this->id_cart = $id_cart;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
        $this->added_at = $added_at;
    }
    // Getters
    public function getIdCart() {
        return $this->id_cart;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getAddedAt() {
        return $this->added_at;
    }

    // Setters
    public function setIdCart($id_cart) {
        $this->id_cart = $id_cart;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setProductId($product_id) {
        $this->product_id = $product_id;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setAddedAt($added_at) {
        $this->added_at = $added_at;
    }
}

?>
