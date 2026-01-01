<?php

class Product
{
    private $id_product;
    private $name_product;
    private $category;
    private $price;
    private $quantity;
    private $description;
    private $image;
    private $click;

    // Constructor
    public function __construct($id_product = null, $name_product = null, $category = null,
                                $price = null, $quantity = null, $description = null,
                                $image = null, $click = null) 
    {
        $this->id_product = $id_product;
        $this->name_product = $name_product;
        $this->category = $category;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->image = $image;
        $this->click = $click;
    }

    // Getters
    public function getIdProduct() {
        return $this->id_product;
    }

    public function getNameProduct() {
        return $this->name_product;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getImage() {
        return $this->image;
    }

    public function getClick() {
        return $this->click;
    }

    // Setters
    public function setIdProduct($id_product) {
        $this->id_product = $id_product;
    }

    public function setNameProduct($name_product) {
        $this->name_product = $name_product;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setClick($click) {
        $this->click = $click;
    }
}

?>
