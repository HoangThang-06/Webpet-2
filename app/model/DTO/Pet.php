<?php

class Pet
{
    private $id;
    private $name;
    private $species;
    private $age;
    private $gender;
    private $description;
    private $status;
    private $image;
    private $click;

    public function __construct(
        $id = null, $name = null, $species = null, $age = null, $gender = null,
        $description = null, $status = null, $image = null, $click = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->species = $species;
        $this->age = $age;
        $this->gender = $gender;
        $this->description = $description;
        $this->status = $status;
        $this->image = $image;
        $this->click = $click;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getSpecies() { return $this->species; }
    public function getAge() { return $this->age; }
    public function getGender() { return $this->gender; }
    public function getDescription() { return $this->description; }
    public function getStatus() { return $this->status; }
    public function getImage() { return $this->image; }
    public function getClick() { return $this->click; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setSpecies($species) { $this->species = $species; }
    public function setAge($age) { $this->age = $age; }
    public function setGender($gender) { $this->gender = $gender; }
    public function setDescription($description) { $this->description = $description; }
    public function setStatus($status) { $this->status = $status; }
    public function setImage($image) { $this->image = $image; }
    public function setClick($click) { $this->click = $click; }
}

?>
