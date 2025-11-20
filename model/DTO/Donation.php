<?php

class Donation
{
    private $id_donation;
    private $user_id;
    private $amount;
    private $message;
    private $donation_at;

    // Constructor
    public function __construct($id_donation = null, $user_id = null, $amount = null,
                                $message = null, $donation_at = null)
    {
        $this->id_donation = $id_donation;
        $this->user_id = $user_id;
        $this->amount = $amount;
        $this->message = $message;
        $this->donation_at = $donation_at;
    }

    // Getters
    public function getIdDonation() {
        return $this->id_donation;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getDonationAt() {
        return $this->donation_at;
    }

    // Setters
    public function setIdDonation($id_donation) {
        $this->id_donation = $id_donation;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setDonationAt($donation_at) {
        $this->donation_at = $donation_at;
    }
}

?>
