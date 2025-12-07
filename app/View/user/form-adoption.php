<?php
session_start();
include('../../controller/dbconnect.php');
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Vui lòng đăng nhập để nhận nuôi!'); window.location.href='../login/login.php';</script>";
    exit;
}
$idUser = $_SESSION['user']['id_user'];
$idPet = $_GET['id'] ?? null;
if ($idPet === null) {
    echo "<script>alert('Không xác định được thú cưng!'); window.history.back();</script>";
    exit;
}
$stmtCheck = $conn->prepare("SELECT * FROM adoption WHERE id_user = ? AND id_pet = ?");
$stmtCheck->bind_param("ii", $idUser, $idPet);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();
if ($resultCheck->num_rows > 0) {
    echo "<script>alert('Bạn đã gửi yêu cầu nhận nuôi cho thú cưng này trước đó!'); window.history.back();</script>";
    exit;
}
$stmt = $conn->prepare("INSERT INTO adoption (id_user, id_pet) VALUES (?, ?)");
$stmt->bind_param("ii", $idUser, $idPet);
if ($stmt->execute()) {
    echo "<script>alert('Yêu cầu của bạn đã được gửi thành công!'); window.history.back();</script>";
} else {
    echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại.'); window.history.back();</script>";
}
