<?php
header("Content-Type: application/json");

require_once __DIR__ . "/Pet_ctr.php";

$controller = new PetController();

$action = $_GET["action"] ?? null;

switch ($action) {

    case "delete":
        $controller->handleDeletePetAPI();
        break;

    case "update":
        $controller->handleUpdatePetAPI();
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Invalid API action"
        ]);
        break;
}
