<?php
session_start();
include('../../controller/dbconnect.php');
$amount  = $_POST['amount'] ?? 0;
$message = $_POST['message'] ?? '';
$userId  = $_SESSION['user']['id_user'] ?? null;
if (!$userId) {
    die("Bạn cần đăng nhập trước khi ủng hộ.");
}
if ($amount <= 0) {
    die("Số tiền không hợp lệ.");
}
$targetDir = "../../../public/img/receipts/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}
if (!isset($_FILES["receipt"]) || $_FILES["receipt"]["error"] !== 0) {
    die("Lỗi upload ảnh!");
}
$filename   = time() . "_" . basename($_FILES["receipt"]["name"]);
$targetFile = $targetDir . $filename;
move_uploaded_file($_FILES["receipt"]["tmp_name"], $targetFile);
$stmt = $conn->prepare("
    INSERT INTO donations (user_id, amount, message, receipt_path, status, created_at) 
    VALUES (?, ?, ?, ?, 'pending', NOW())
");
$stmt->bind_param("iiss", $userId, $amount, $message, $filename);
$stmt->execute();
header("Location: thankyou.php");
exit;
?>
