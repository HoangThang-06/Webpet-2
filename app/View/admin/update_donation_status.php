<?php
include('../../controller/dbconnect.php');

$id = $_POST['id'] ?? 0;
$status = $_POST['status'] ?? '';

if (!in_array($status, ['approved', 'rejected'])) {
    echo "Trạng thái không hợp lệ!";
    exit();
}

$sql = "UPDATE donations SET status=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    echo "Cập nhật thành công!";
} else {
    echo "Lỗi cập nhật!";
}
