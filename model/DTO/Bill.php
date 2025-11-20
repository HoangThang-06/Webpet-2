<?php

class Bill
{
    private $id_bill;
    private $user_id;
    private $product_id;
    private $quantity;
    private $total;
    private $created_at;

    // Constructor
    public function __construct($id_bill = null, $user_id = null, $product_id = null,
                                $quantity = null, $total = null, $created_at = null)
    {
        $this->id_bill = $id_bill;
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
        $this->total = $total;
        $this->created_at = $created_at;
    }

    // Getters
    public function getIdBill() {
        return $this->id_bill;
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

    public function getTotal() {
        return $this->total;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    // Setters
    public function setIdBill($id_bill) {
        $this->id_bill = $id_bill;
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

    public function setTotal($total) {
        $this->total = $total;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
}

?>
