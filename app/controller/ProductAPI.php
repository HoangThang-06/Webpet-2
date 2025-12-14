<?php
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/Product_ctr.php";

$controller = new ProductController();

$action = $_GET["action"] ?? null;

switch ($action) {

    case "delete":
        $controller->handleDeleteProductAPI();
        break;

    case "update":
        $controller->handleUpdateProductAPI();
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Invalid API action"
        ]);
        break;
}
