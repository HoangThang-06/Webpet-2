<?php

class Category
{
    private $id_category;
    private $name_category;

    // Constructor
    public function __construct($id_category = null, $name_category = null)
    {
        $this->id_category = $id_category;
        $this->name_category = $name_category;
    }

    // Getters
    public function getIdCategory() {
        return $this->id_category;
    }

    public function getNameCategory() {
        return $name_category;
    }

    // Setters
    public function setIdCategory($id_category) {
        $this->id_category = $id_category;
    }

    public function setNameCategory($name_category) {
        $this->name_category = $name_category;
    }
}

?>
