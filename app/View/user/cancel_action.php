<?php
session_start();
include('../../controller/dbconnect.php');

if (!isset($_SESSION['user']['id_user'])) {
    die("Bạn chưa đăng nhập!");
}

$idUser = $_SESSION['user']['id_user'];
$id = $_GET['id'] ?? 0;

if (!$id) {
    die("Thiếu tham số!");
}

// Chỉ xóa từ bảng adoption
$sql = "DELETE FROM adoption WHERE id=? AND id_user=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $idUser);

if ($stmt->execute()) {
    header("Location: notification.php");
    exit;
} else {
    echo "Lỗi khi hủy!";
}
?>
