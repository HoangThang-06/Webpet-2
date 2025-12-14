<?php
require_once __DIR__."/../../controller/DBConnection.php";
$conn=(new DBConnection())->getConnection();
$sql = "SELECT d.*, u.fullname 
        FROM donations d 
        JOIN users u ON d.user_id = u.id_user
        WHERE d.status = 'pending'
        ORDER BY d.created_at DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý giao dịch ủng hộ</title>
<link rel="stylesheet" href="../../../public/css/manage_donations.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('../layout/menuadmin.php') ;?>
    <div class="main-content">
        <h2>Quản lý giao dịch ủng hộ</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Người ủng hộ</th>
                <th>Số tiền</th>
                <th>Lời nhắn</th>
                <th>Ảnh biên lai</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['fullname']) ?></td>
                <td><?= number_format($row['amount']) ?> VND</td>
                <td><?= htmlspecialchars($row['message']) ?></td>
                <td>
                    <button class="btn view-btn" onclick="openPopup('<?= $row['receipt_path'] ?>')">
                        Xem
                    </button>
                </td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <button class="btn approve" onclick="updateStatus(<?= $row['id'] ?>, 'approved')">Duyệt</button>
                    <button class="btn reject" onclick="updateStatus(<?= $row['id'] ?>, 'rejected')">Từ chối</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
    <div class="popup-overlay" id="popup">
        <div class="popup-box">
            <img id="popup-img" src="">
            <br>
            <button class="close-btn" onclick="closePopup()">Đóng</button>
        </div>
    </div>
    <script src="../../../public/scripts/manage_donations.js"></script>
</body>
</html>
