<?php
session_start();
include ('../../controller/dbconnect.php');

if (!isset($_SESSION['user']['id_user'])) {
    die("Bạn chưa đăng nhập!");
}

$idUser = $_SESSION['user']['id_user'];
$sql = "SELECT * FROM users WHERE id_user=$idUser";
$result = $conn->query($sql);
$user = mysqli_fetch_assoc($result);    
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hoạt động</title>
    <link rel="icon" type="image/png" href="../../../public/icon/pawprint.png"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/ho.css">
    <link rel="stylesheet" href="../../../public/css/cart.css">
    <link rel="stylesheet" href="../../../public/css/notification.css">
</head>
<body>
    <button class="menu-toggle" onclick="toggleMenu()">
        <i class="fas fa-bars"></i>
    </button>
    <div class="main-container">
        <!-- Sidebar -->
        <?php include ('../layout/sidebar.php'); ?>
        <main class="main-content">
            <h2>Quản lý hoạt động của bạn</h2>
            <div class="activity-box">
                <h3>Danh sách yêu cầu nhận nuôi</h3>
                <?php
                $sqlPending = "SELECT a.id, a.status, a.created_at, p.name, p.image FROM adoption a JOIN pets p ON a.id_pet = p.id WHERE a.id_user=? AND a.status='pending' ORDER BY a.created_at DESC";
                $stmt = $conn->prepare($sqlPending);
                $stmt->bind_param("i", $idUser);
                $stmt->execute();
                $pending = $stmt->get_result();

                if ($pending->num_rows == 0) {
                    echo "<p class='empty-message'>Không có yêu cầu nhận nuôi nào đang chờ xử lý.</p>";
                } else {
                    echo "<table>
                            <tr>
                                <th>Ảnh</th>
                                <th>Pet</th>
                                <th>Ngày gửi</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>";
                    while ($row = $pending->fetch_assoc()) {
                        $img = $row['image'];
                        echo "<tr>
                                <td><img src='$img' style='width:70px;height:70px;border-radius:8px;object-fit:cover;'></td>
                                <td>{$row['name']}</td>
                                <td>{$row['created_at']}</td>
                                <td><span class='status pending'>Đang chờ</span></td>
                                <td><a href='cancel_action.php?type=adoption&id={$row['id']}' class='btn-cancel'>Hủy</a></td>
                              </tr>";
                    }
                    echo "</table>";
                }
                ?>
            </div>
            <div class="activity-box">
                <h3>Lịch sử nhận nuôi đã được phê duyệt</h3>
                <?php
                $sqlApproved = "SELECT a.id, a.status, a.created_at, a.updated_at, p.name, p.image FROM adoption a JOIN pets p ON a.id_pet = p.id WHERE a.id_user=? AND a.status='approved' ORDER BY a.updated_at DESC";
                $stmt2 = $conn->prepare($sqlApproved);
                $stmt2->bind_param("i", $idUser);
                $stmt2->execute();
                $approved = $stmt2->get_result();
                if ($approved->num_rows == 0) {
                    echo "<p class='empty-message'>Bạn chưa có yêu cầu nhận nuôi nào được phê duyệt.</p>";
                } else {
                    echo "<table>
                            <tr>
                                <th>Ảnh</th>
                                <th>Pet</th>
                                <th>Ngày gửi</th>
                                <th>Ngày phê duyệt</th>
                                <th>Trạng thái</th>
                            </tr>";
                    while ($row = $approved->fetch_assoc()) {
                        $img = $row['image'];
                        echo "<tr>
                                <td><img src='$img' style='width:70px;height:70px;border-radius:8px;object-fit:cover;'></td>
                                <td>{$row['name']}</td>
                                <td>{$row['created_at']}</td>
                                <td>{$row['updated_at']}</td>
                                <td><span class='status approved'>Đã duyệt</span></td>
                              </tr>";
                    }
                    echo "</table>";
                }
                ?>
            </div>

        </main>
    </div>
    <script src="../../../public/scripts/ho.js"></script>
</body>
</html>
