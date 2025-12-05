<?php
session_start();
include '../controller/dbconnect.php';
header('Content-Type: application/json');
if(!isset($_SESSION['user'])){
    echo json_encode(['status'=>'error','message'=>'Bạn chưa đăng nhập']);
    exit;
}
if(!isset($_GET['id'])){
    echo json_encode(['status'=>'error','message'=>'Sản phẩm không hợp lệ']);
    exit;
}
$idProduct = intval($_GET['id']);
$idUser = $_SESSION['user']['id_user'];
$quantity = 1;
$checkSql = "SELECT * FROM cart WHERE user_id = $idUser AND product_id = $idProduct";
$checkRes = mysqli_query($conn, $checkSql);
if(mysqli_num_rows($checkRes) > 0){
    $row = mysqli_fetch_assoc($checkRes);
    $newQty = $row['quantity'] + 1;
    $updateSql = "UPDATE cart SET quantity = $newQty WHERE user_id = $idUser AND product_id = $idProduct";
    if(mysqli_query($conn, $updateSql)){
        echo json_encode(['status'=>'success']);
    } else {
        echo json_encode(['status'=>'error','message'=>'Cập nhật giỏ hàng thất bại']);
    }
    exit;
}
$sqlAddcart = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($idUser, $idProduct, $quantity)";
if(mysqli_query($conn, $sqlAddcart)){
    echo json_encode(['status'=>'success']);
} else {
    echo json_encode(['status'=>'error','message'=>'Thêm giỏ hàng thất bại']);
}
?>
