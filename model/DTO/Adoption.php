<?php

class Adoption
{
    private $id;
    private $user_id;
    private $pet_id;
    private $adoption_date;
    private $state; // 'pending', 'approved', 'rejected'

    // Constructor
    public function __construct($id = null, $user_id = null, $pet_id = null,
                                $adoption_date = null, $state = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->pet_id = $pet_id;
        $this->adoption_date = $adoption_date;
        $this->state = $state;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getPetId() {
        return $this->pet_id;
    }

    public function getAdoptionDate() {
        return $this->adoption_date;
    }

    public function getState() {
        return $this->state;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setPetId($pet_id) {
        $this->pet_id = $pet_id;
    }

    public function setAdoptionDate($adoption_date) {
        $this->adoption_date = $adoption_date;
    }

    public function setState($state) {
        $this->state = $state;
    }
}

?>
