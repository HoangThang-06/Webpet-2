<?php

class Pet
{
    private $id_pet;
    private $name_pet;
    private $gender;
    private $description;
    private $state;
    private $image;
    private $click;

    // Constructor
    public function __construct($id_pet = null, $name_pet = null, $gender = null,
                                $description = null, $state = null,
                                $image = null, $click = null) 
    {
        $this->id_pet = $id_pet;
        $this->name_pet = $name_pet;
        $this->gender = $gender;
        $this->description = $description;
        $this->state = $state;
        $this->image = $image;
        $this->click = $click;
    }

    // Getters
    public function getIdPet() {
        return $this->id_pet;
    }

    public function getNamePet() {
        return $this->name_pet;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getState() {
        return $this->state;
    }

    public function getImage() {
        return $this->image;
    }

    public function getClick() {
        return $this->click;
    }

    // Setters
    public function setIdPet($id_pet) {
        $this->id_pet = $id_pet;
    }

    public function setNamePet($name_pet) {
        $this->name_pet = $name_pet;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setClick($click) {
        $this->click = $click;
    }
}

?>
