<?php
include('../../controller/dbconnect.php');
$selected_year = $_GET['year'] ?? date('Y');
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;
/* lay du lieu theo nam,thang*/
$sql = "SELECT MONTH(created_at) AS month, SUM(amount) AS total_amount
        FROM donations
        WHERE status='approved' AND YEAR(created_at) = ?
        GROUP BY month
        ORDER BY month";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $selected_year);
$stmt->execute();
$result = $stmt->get_result();
$amounts = [];
while($row = $result->fetch_assoc()) {
    $amounts[$row['month']] = $row['total_amount'];
}
$month_labels = range(1,12);
$month_data = [];
foreach($month_labels as $m){
    $month_data[] = $amounts[$m] ?? 0;
}
/*tong so dong */
$sql_count = "SELECT COUNT(*) AS total FROM donations WHERE status='approved' AND YEAR(created_at) = ?";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("i", $selected_year);
$stmt_count->execute();
$total_rows = $stmt_count->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $per_page);
/* lay ds ungho*/
$sql_donations = "SELECT d.id, u.fullname, d.amount, d.message, d.created_at
                  FROM donations d
                  JOIN users u ON d.user_id = u.id_user
                  WHERE d.status='approved' AND YEAR(d.created_at) = ?
                  ORDER BY d.created_at DESC
                  LIMIT ?, ?";
$stmt_donations = $conn->prepare($sql_donations);
$stmt_donations->bind_param("iii", $selected_year, $offset, $per_page);
$stmt_donations->execute();
$result_donations = $stmt_donations->get_result();
$conn->close();
?>
<div class="chart-container">
    <h3 class="chart-title">Số tiền ủng hộ theo từng tháng của năm <?php echo $selected_year; ?></h3>
    <canvas id="chartMonth"
        data-labels='<?php echo json_encode($month_labels); ?>'
        data-values='<?php echo json_encode($month_data); ?>'>
    </canvas>
</div>
<div style="width:100%; margin:auto; margin-top:30px;">
    <h3 class="chart-title">Sao kê tất cả đơn ủng hộ năm <?php echo $selected_year; ?></h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Người ủng hộ</th>
                <th>Số tiền (VND)</th>
                <th>Lời nhắn</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($result_donations as $donation): ?>
            <tr>
                <td><?php echo $donation['id']; ?></td>
                <td><?php echo htmlspecialchars($donation['fullname']); ?></td>
                <td><?php echo number_format($donation['amount']); ?></td>
                <td><?php echo htmlspecialchars($donation['message']); ?></td>
                <td><?php echo $donation['created_at']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php for($p=1; $p <= $total_pages; $p++): ?>
            <a href="#" class="page-link <?php echo $p==$page?'active':''; ?>" data-page="<?php echo $p; ?>">
                <?php echo $p; ?>
            </a>
        <?php endfor; ?>
    </div>
</div>
