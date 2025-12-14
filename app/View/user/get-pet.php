<?php
session_start();
require '../../controller/dbconnect.php';

$petId = intval($_GET['id'] ?? 0);

if ($petId <= 0) {
    die("ID thú cưng không hợp lệ!");
}
$stmtClick = $conn->prepare("UPDATE pets SET click = click + 1 WHERE id = ?");
$stmtClick->bind_param("i", $petId);
$stmtClick->execute();
$stmtClick->close();
$stmt = $conn->prepare("SELECT * FROM pets WHERE id = ?");
$stmt->bind_param("i", $petId);
$stmt->execute();
$result = $stmt->get_result();
$pet = $result->fetch_assoc();

if (!$pet) {
    die("Không tìm thấy thú cưng này!");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết thú cưng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; margin:0; padding:0; }
        .container { max-width: 900px; margin: 50px auto; background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 6px 25px rgba(0,0,0,0.1); }
        .pet-image { width: 100%; max-height: 450px; object-fit: cover; border-radius: 20px; margin-bottom: 20px; }
        .pet-info { padding: 10px 0; }
        .pet-name { font-size: 36px; font-weight: 700; margin-bottom: 15px; color: #333; }
        .pet-details { font-size: 18px; margin-bottom: 10px; color: #555; }
        .pet-description { font-size: 16px; color: #666; line-height: 1.6; margin-bottom: 25px; }
        .btn { padding: 14px 30px; border: none; border-radius: 12px; cursor: pointer; font-size: 18px; text-decoration: none; display: inline-block; transition: 0.3s; }
        .btn-success { background: #28a745; color: #fff; }
        .btn-success:hover { background: #218838; }
        .back-btn { display: inline-block; margin-bottom: 25px; text-decoration: none; color: #555; font-size: 16px; }
        .back-btn i { margin-right: 8px; }
        @media(max-width:600px){
            .pet-name{font-size:28px;}
            .btn{font-size:16px;padding:12px 25px;}
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="adoption.php" class="back-btn"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
        <img src="<?= htmlspecialchars($pet['image']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>" class="pet-image">
        <div class="pet-info">
            <div class="pet-name"><?= htmlspecialchars($pet['name']) ?></div>
            <div class="pet-details"><strong>Tuổi:</strong> <?= htmlspecialchars($pet['age']) ?> năm</div>
            <div class="pet-description"><?= nl2br(htmlspecialchars($pet['description'])) ?></div>
            <a href="form-adoption.php?id=<?= $pet['id'] ?>" class="btn btn-success">Nhận nuôi</a>
        </div>
    </div>
</body>
</html>
