<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhân Viên</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/manage.css" />    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<?php
session_start();
?>
<body>
    <!-- SIDEBAR -->
        <?php include("../layout/menuadmin.php"); ?>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <h2>Danh Sách Người Dùng</h2><br>
        <!-- Tìm kiếm và lọc -->
        <div class="search-row">
            <input type="text" name="search" id="search" placeholder="Nhập tên người dùng" class="form-control ms-2">
            <button type="button" class="btn btn-primary ms-2">Tìm kiếm</button>

            <select id="filterRole" class="form-select form-select-sm ms-2" style="width: 150px;">
                <option value="">Tất cả vai trò</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

        </div>

        <div class="employee-list" id="employeeList">
            <?php
                require_once __DIR__ . "/../../controller/Usercontroller/Usercontroller.php";
                $userctr = new UserController();
                $user=$_SESSION["user"];
                $id_user=$user["id_user"];
                $employees = $userctr->getUsersExceptCurrent($id_user);

                if ($employees == 0):
                    echo "<p>Không có người dùng nào khác.</p>";
                endif;

                foreach ($employees as $emp):
                    $avatar = !empty($emp["avatar"]) 
                        ? "../../public/avatar/" . $emp["avatar"] 
                        : "../../../public/img/avatars/avtdefault.png"; // ảnh mặc định
            ?>
            
            <div class="employee-item"
                data-username="<?= htmlspecialchars($emp["username"]) ?>"
                data-role="<?= htmlspecialchars($emp["role"]) ?>">
                            <!-- LEFT: Avatar + Info -->
                <div class="employee-left">
                    <img src="<?= $avatar ?>" class="employee-avatar" alt="avatar">

                    <div class="employee-info">
                        <strong><?= htmlspecialchars($emp["username"]) ?></strong><br>
                        Họ tên: <?= htmlspecialchars($emp["fullname"] ?? "Chưa cập nhật") ?><br>
                        Giới tính: <?= htmlspecialchars($emp["gender"] ?? "Không rõ") ?><br>
                        Quyền: <?= htmlspecialchars($emp["role"]) ?><br>
                        Trạng thái: <?= htmlspecialchars($emp["status"] ?? "Không rõ") ?>
                    </div>
                </div>

                <!-- RIGHT: Action Buttons -->
                <div class="employee-actions">
                    <button class="action-btn btn-view"
                        data-username="<?= htmlspecialchars($emp["username"]) ?>"
                        data-fullname="<?= htmlspecialchars($emp["fullname"] ?? "Chưa cập nhật") ?>"
                        data-phone="<?= htmlspecialchars($emp["phone"] ?? "Chưa cập nhật") ?>"
                        data-birthday="<?= htmlspecialchars($emp["birthday"] ?? "Chưa cập nhật") ?>"
                        data-gender="<?= htmlspecialchars($emp["gender"] ?? "Không rõ") ?>"
                        data-address="<?= htmlspecialchars($emp["address"] ?? "Chưa cập nhật") ?>"
                        data-email="<?= htmlspecialchars($emp["email"]) ?>"
                        data-role="<?= htmlspecialchars($emp["role"]) ?>"
                        data-status="<?= htmlspecialchars($emp["status"] ?? "Không rõ") ?>"
                        data-createdat="<?= htmlspecialchars($emp["created_at"]) ?>"
                        data-avatar="<?= $avatar ?>">
                        Xem
                    </button>
                   <button class="action-btn btn-edit"
                        data-id_user="<?= $emp["id_user"] ?>"
                        data-username="<?= htmlspecialchars($emp["username"]) ?>"
                        data-fullname="<?= htmlspecialchars($emp["fullname"] ?? '') ?>"
                        data-phone="<?= htmlspecialchars($emp["phone"] ?? '') ?>"
                        data-birthday="<?= htmlspecialchars($emp["birthday"] ?? '') ?>"
                        data-gender="<?= htmlspecialchars($emp["gender"] ?? '') ?>"
                        data-address="<?= htmlspecialchars($emp["address"] ?? '') ?>"
                        data-email="<?= htmlspecialchars($emp["email"]) ?>"
                        data-role="<?= htmlspecialchars($emp["role"]) ?>"
                        data-status="<?= htmlspecialchars($emp["status"] ?? '') ?>"
                        data-avatar="<?= htmlspecialchars($emp["avatar"] ?? '') ?>"
                        data-password="<?= htmlspecialchars($emp["password"] ?? '') ?>">
                        Sửa
                    </button>

                    <button class="action-btn btn-delete" data-id="<?= $emp["id_user"] ?>">Xóa</button>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
    </div>
    <!-- Modal Xem Người Dùng -->
    <div id="viewUserModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Thông tin chi tiết người dùng</h3>
            <div class="modal-body">
                <div class="modal-avatar">
                    <img id="modalAvatar" src="" alt="avatar">
                </div>
                <div class="modal-info">
                    <p id="modalUsername"></p>
                    <p id="modalFullname"></p>
                    <p id="modalPhone"></p>
                    <p id="modalBirthday"></p>
                    <p id="modalGender"></p>
                    <p id="modalAddress"></p>
                    <p id="modalEmail"></p>
                    <p id="modalRole"></p>
                    <p id="modalCreatedAt"></p>
                    <p id="modalStatus"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Sửa người dùng -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span id="closeEdit" class="close">&times;</span>
            <h3>Sửa thông tin người dùng</h3>

            <form id="editUserForm" enctype="multipart/form-data">

                <input type="hidden" id="editId_user">

                <!-- Avatar cũ (ẩn) -->
                <input type="hidden" id="avatar_old">

                <!-- Password cũ (ẩn) -->
                <input type="hidden" id="password_old">

                <label>Username</label>
                <input type="text" id="editUsername" class="form-control">

                <label>Họ tên</label>
                <input type="text" id="editFullname" class="form-control">

                <label>Số điện thoại</label>
                <input type="text" id="editPhone" class="form-control">

                <label>Ngày sinh</label>
                <input type="date" id="editBirthday" class="form-control">

                <label>Giới tính</label>
                <select id="editGender" class="form-control">
                    <option value="">-- Chọn --</option>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                    <option value="Khác">Khác</option>
                </select>

                <label>Địa chỉ</label>
                <input type="text" id="editAddress" class="form-control">

                <label>Email</label>
                <input type="email" id="editEmail" class="form-control">

                <label>Mật khẩu (nếu muốn đổi)</label>
                <input type="password" id="editPassword" class="form-control" placeholder="Để trống nếu giữ mật khẩu cũ">

                <label>Avatar</label>
                <input type="file" id="editAvatar" name="avatar" class="form-control">

                <label>Quyền</label>
                <select id="editRole" class="form-control">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>

                <label>Trạng thái</label>
                <select id="editStatus" class="form-control">
                    <option value="approved">approved</option>
                    <option value="disapproved">disapproved</option>
                </select>

                <button type="submit" class="btn btn-primary" style="margin-top:10px;">
                    Lưu thay đổi
                </button>
            </form>
        </div>
    </div>
    <!-- RIGHT PANEL - BIỂU ĐỒ -->
    <div class="right-panel">
        <?php
            // Đếm số lượng user/admin
            $adminCount = 0;
            $userCount = 0;
            $approvedCount = 0;
            $disapprovedCount = 0;

            foreach ($employees as $emp) {
                if ($emp["role"] === "admin") $adminCount++;
                else if ($emp["role"] === "user") $userCount++;
            }

            foreach ($employees as $emp) {
                if (($emp["status"] ?? "") === "approved") $approvedCount++;
                else if (($emp["status"] ?? "") === "disapproved") $disapprovedCount++;
            }
        ?>

        <h4 style="margin-top: 30px;">Biểu Đồ Nhân Viên</h4>
        <canvas id="employeeChart" class="chart-container"></canvas>

        <h4 style="margin-top: 30px;">Trạng Thái Người Dùng</h4>
        <canvas id="statusChart" class="chart-container"></canvas>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        window.adminCount = <?= $adminCount ?>;
        window.userCount = <?= $userCount ?>;
        window.approvedCount = <?= $approvedCount ?>;
        window.disapprovedCount = <?= $disapprovedCount ?>;
    </script>
    <script src="../../../public/scripts/manage.js"></script>
</body>
</html>
