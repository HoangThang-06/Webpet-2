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
    <div class="right-panel">
        <?php
        $sqlDonate = "
            SELECT 
                SUM(CASE WHEN status = 'approved' THEN amount ELSE 0 END) AS approved_money,
                SUM(CASE WHEN status = 'pending' THEN amount ELSE 0 END)  AS pending_money,
                SUM(CASE WHEN status = 'rejected' THEN amount ELSE 0 END) AS rejected_money
            FROM donations
        ";
        $resDonate = $conn->query($sqlDonate)->fetch_assoc();
        $approvedMoney = $resDonate['approved_money'] ?? 0;
        $pendingMoney  = $resDonate['pending_money'] ?? 0;
        $rejectedMoney = $resDonate['rejected_money'] ?? 0;
        $sqlTop = "
            SELECT u.fullname, SUM(d.amount) AS total_amount
            FROM donations d
            JOIN users u ON d.user_id = u.id_user
            WHERE d.status = 'approved'
            GROUP BY d.user_id
            ORDER BY total_amount DESC
            LIMIT 3
        ";
        $resTop = $conn->query($sqlTop);
        $topUsers = [];
        $topAmounts = [];
        while ($row = $resTop->fetch_assoc()) {
            $topUsers[] = $row['fullname'];
            $topAmounts[] = $row['total_amount'];
        }
        ?>
        <h4 style="margin-top:30px;">Thống Kê Ủng Hộ</h4>
        <canvas id="donationPieChart" class="chart-container"></canvas>
        <h4 style="margin-top:30px;">Top 3 Người Đóng Góp Nổi Bật</h4>
        <canvas id="topDonorChart" class="chart-container"></canvas>
    </div>
    <div class="popup-overlay" id="popup">
        <div class="popup-box">
            <img id="popup-img" src="">
            <br>
            <button class="close-btn" onclick="closePopup()">Đóng</button>
        </div>
    </div>
    <script src="../../../public/scripts/manage_donations.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    new Chart(document.getElementById('donationPieChart'), {
    type: 'pie',
    data: {
        labels: ['Đã duyệt', 'Chưa duyệt', 'Bị từ chối'],
        datasets: [{
            data: [
                <?= $approvedMoney ?>,
                <?= $pendingMoney ?>,
                <?= $rejectedMoney ?>
            ],
            backgroundColor: ['#4CAF50', '#FFC107', '#F44336']
        }]
    }
});
    new Chart(document.getElementById('topDonorChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($topUsers) ?>,
            datasets: [{
                label: 'Tổng tiền ủng hộ (VNĐ)',
                data: <?= json_encode($topAmounts) ?>,
                backgroundColor: ['#2196F3', '#03A9F4', '#00BCD4']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>
</html>
