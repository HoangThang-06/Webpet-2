<?php
header("Content-Type: application/json");

require_once __DIR__ . "/UserController.php";

$controller = new UserController();

$action = $_GET["action"] ?? null;

switch ($action) {
    case "delete":
        $controller->handleDeleteUserAPI();
        break;

    case "update":
        $controller->handleUpdateUserAPI();
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Invalid API action"
        ]);
}
