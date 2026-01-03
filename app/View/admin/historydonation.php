<?php
require_once __DIR__ . "/../../controller/dbconnect.php";
$selected_year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page = 10;
$offset = ($page - 1) * $per_page;
$sql_count = "
    SELECT COUNT(*) AS total
    FROM donations
    WHERE status = 'approved'
      AND YEAR(created_at) = ?
";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("i", $selected_year);
$stmt_count->execute();
$total_rows = $stmt_count->get_result()->fetch_assoc()['total'] ?? 0;
$total_pages = ceil($total_rows / $per_page);
$sql_donations = "
    SELECT d.id, u.fullname, d.amount, d.message, d.created_at
    FROM donations d
    JOIN users u ON d.user_id = u.id_user
    WHERE d.status = 'approved'
      AND YEAR(d.created_at) = ?
    ORDER BY d.created_at DESC
    LIMIT $offset, $per_page
";
$stmt = $conn->prepare($sql_donations);
$stmt->bind_param("i", $selected_year);
$stmt->execute();
$result = $stmt->get_result();
?>
<div style="width:100%; margin-top:30px;">
    <h3 class="chart-title">
        Sao kê tất cả đơn ủng hộ năm <?= $selected_year ?>
    </h3>
    <div class="table-wrapper">
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
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['fullname']) ?></td>
                            <td><?= number_format($row['amount']) ?></td>
                            <td><?= htmlspecialchars($row['message']) ?></td>
                            <td><?= $row['created_at'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">
                            Không có dữ liệu
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                <a href="#"
                   class="page-link <?= ($p == $page) ? 'active' : '' ?>"
                   data-page="<?= $p ?>">
                    <?= $p ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>
<?php $conn->close(); ?>
