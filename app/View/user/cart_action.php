<?php
session_start();
include('../../controller/dbconnect.php');
header('Content-Type: application/json');

if(!isset($_SESSION['user'])){
    echo json_encode(['status'=>'error','message'=>'Bạn chưa đăng nhập!']);
    exit;
}

$idUser = $_SESSION['user']['id_user'];
if(!isset($_GET['action']) || !isset($_GET['id'])){
    echo json_encode(['status'=>'error','message'=>'Thiếu thông tin sản phẩm!']);
    exit;
}

$action = $_GET['action'];
$cart_id = intval($_GET['id']);

if($action==='delete'){
    $stmt = $conn->prepare("DELETE FROM cart WHERE id=? AND user_id=?");
    $stmt->bind_param("ii",$cart_id,$idUser);
    $stmt->execute();
    echo json_encode(['status'=>'success','message'=>'Xóa sản phẩm thành công','newQty'=>0]);
    exit;
}

// Lấy thông tin giỏ hàng
$stmt = $conn->prepare("SELECT c.quantity AS cart_qty, p.quantity AS stock, p.price FROM cart c JOIN product p ON c.product_id=p.id_product WHERE c.id=? AND c.user_id=?");
$stmt->bind_param("ii",$cart_id,$idUser);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if(!$item){
    echo json_encode(['status'=>'error','message'=>'Sản phẩm không tồn tại!']);
    exit;
}

$currentQty = $item['cart_qty'];
$stock = $item['stock'];
$newQty = $currentQty;

switch($action){
    case 'plus':
        $newQty = min($currentQty+1,$stock);
        $message = ($newQty==$currentQty)?'Đã đạt tối đa tồn kho':'Tăng số lượng thành công';
        $status = ($newQty==$currentQty)?'info':'success';
        break;
    case 'minus':
        $newQty = max($currentQty-1,1);
        $message = ($newQty==$currentQty)?'Số lượng tối thiểu là 1':'Giảm số lượng thành công';
        $status = ($newQty==$currentQty)?'info':'success';
        break;
    case 'save':
        if(isset($_POST['quantity'])){
            $inputQty = intval($_POST['quantity']);
            if($inputQty<1){ $newQty=1; $message='Số lượng tối thiểu là 1'; $status='info'; }
            elseif($inputQty>$stock){ $newQty=$stock; $message='Đã đạt tối đa tồn kho'; $status='info'; }
            else{ $newQty=$inputQty; $message='Cập nhật số lượng thành công'; $status='success'; }
        }
        break;

    default:
        echo json_encode(['status'=>'error','message'=>'Action không hợp lệ!']);
        exit;
}

// Cập nhật CSĐL
$update = $conn->prepare("UPDATE cart SET quantity=? WHERE id=? AND user_id=?");
$update->bind_param("iii",$newQty,$cart_id,$idUser);
$update->execute();

echo json_encode(['status'=>$status,'message'=>$message,'newQty'=>$newQty]);
exit;
