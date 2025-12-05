<?php
include('../../controller/dbconnect.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$result = $conn->query("SELECT * FROM pets WHERE id = $id");
$pet = $result->fetch_assoc();

if(!$pet){
    echo "<p>Không tìm thấy thú cưng!</p>";
    exit;
}
?>

<div class="pet-detail">
    <h2><?= htmlspecialchars($pet['name']) ?></h2>
    <img src="<?= htmlspecialchars($pet['image']) ?>" style="width:200px;border-radius:10px;margin:10px 0;">
    <p><strong>Tuổi:</strong> <?= htmlspecialchars($pet['age']) ?> tuổi</p>
    <p><strong>Giới tính:</strong> <?= htmlspecialchars($pet['gender']) ?></p>
    <p><strong>Miêu tả:</strong></p>
    <p><?= nl2br(htmlspecialchars($pet['description'])) ?></p>
    <a href="form-adoption.php?id=<?= $pet['id'] ?>" class="btn btn-success">Nhận nuôi</a>
</div>
