<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Pet</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/managePet.css" />    

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<?php session_start(); ?>

<body>
    <!-- SIDEBAR -->
        <?php include("../layout/menuadmin.php"); ?>
    <!-- MAIN CONTENT -->
    <div class="main-content d-flex" style="gap:20px;">
        <!-- DANH SÁCH PET -->
        <div class="pet-list-container" style="flex:2; display:flex; flex-direction:column;">
        <h2>Danh Sách Pet</h2>

                <!-- Tìm kiếm và lọc -->
        <div class="search-row">
            <input type="text" name="search" id="search" placeholder="Nhập tên Pet" class="form-control ms-2">
            <button type="button" class="btn btn-primary ms-2">Tìm kiếm</button>

            <select id="filterRole" class="form-select form-select-sm ms-2" style="width: 150px;">
                <option value="">Tất cả</option>
                <option value="available">Available</option>
                <option value="reserved">Reserved</option>
            </select>
        </div>

        <!-- WRAPPER CUỘN -->
        <div class="pet-list-wrapper">
            <div class="pet-list" id="petList">
                <?php
                    require_once __DIR__ . "/../../controller/Pet_ctr.php";
                    $petCtr = new PetController();
                    $pets = $petCtr->getAllPets();

                    if (!$pets):
                        echo "<p>Không có pet nào trên hệ thống.</p>";
                    endif;

                    foreach ($pets as $pet):

                    // BỎ QUA PET ĐÃ ĐƯỢC NHẬN NUÔI
                    if ($pet['state'] === 'adopted') {
                        continue;
                    }

                    $image = !empty($pet["image"])
                        ? $pet["image"]
                        : "/public/img/avatars/avtdefault.png";
                ?>
                <div class="pet-item d-flex align-items-center justify-content-between p-2 mb-2 border rounded"
                    data-state="<?= htmlspecialchars($pet['state']) ?>"
                    data-name="<?= htmlspecialchars($pet['name_pet']) ?>"
                    data-description="<?= htmlspecialchars($pet['description']) ?>">

                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= $image ?>" class="pet-avatar">
                        <div class="pet-info">
                            <h5 class="pet-name mb-1"><?= htmlspecialchars($pet["name_pet"]) ?></h5>
                            <p class="mb-0"><strong>Giới tính:</strong> <?= htmlspecialchars($pet["gender"]) ?></p>
                            <p class="mb-0"><strong>Trạng thái:</strong> <?= htmlspecialchars($pet["state"]) ?></p>
                            <p class="mb-0"><strong>Lượt xem:</strong> <?= htmlspecialchars($pet["click"]) ?></p>
                        </div>
                    </div>
                        <div class="pet-actions d-flex flex-column gap-1">
                        <button class="btn btn-sm btn-info btn-view">Xem</button>

                        <button class="btn btn-sm btn-warning btn-edit"
                            data-id="<?= $pet['id_pet'] ?>"
                            data-name="<?= htmlspecialchars($pet['name_pet']) ?>"
                            data-gender="<?= htmlspecialchars($pet['gender']) ?>"
                            data-state="<?= htmlspecialchars($pet['state']) ?>"
                            data-description="<?= htmlspecialchars($pet['description']) ?>"
                            data-image="<?= htmlspecialchars($pet['image']) ?>"
                        >Sửa</button>

                        <button
                        class="btn btn-sm btn-danger btn-delete"
                        data-id="<?= $pet['id_pet'] ?>"
                        data-image="<?= $pet['image'] ?>">
                        Xóa
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


        <!-- RIGHT PANEL - BIỂU ĐỒ PET -->
        <div class="right-panel">
        <?php
            $validPets = array_filter($pets, function ($pet) {
                return in_array($pet['state'], ['available', 'reserved']);
            });
            // ====== ĐẾM TRẠNG THÁI PET ======
            $availableCount = 0;
            $reservedCount = 0;

            foreach ($validPets as $pet) {
                if ($pet["state"] === "available") $availableCount++;
                else if ($pet["state"] === "reserved") $reservedCount++;
            }

            // ====== TOP 3 PET CÓ LƯỢT XEM (CLICK) CAO NHẤT ======
            usort($validPets, function ($a, $b) {
                return $b['click'] - $a['click'];
            });

            $topPets = array_slice($validPets, 0, 3);

            // Chuẩn bị dữ liệu cho ChartJS
            $topPetNames = [];
            $topPetClicks = [];

            foreach ($topPets as $pet) {
                $topPetNames[] = $pet['name_pet'];
                $topPetClicks[] = $pet['click'];
            }
        ?>
            <h4 style="margin-top: 30px;">Top 3 Pet Lượt Xem Cao Nhất</h4>
            <canvas id="topPetsChart" class="chart-container"></canvas>

            <h4 style="margin-top: 30px;">Trạng Thái Pet</h4>
            <canvas id="petStatusChart" class="chart-container"></canvas>
        </div>

</div>


    <!-- MODAL XEM PET -->
    <div id="viewPetModal" class="modal">
        <div class="modal-content">
            <span id="closeView" class="close">&times;</span>
            <h3 id="viewName"></h3>
            <p><strong>Giới tính:</strong> <span id="viewGender"></span></p>
            <p><strong>Trạng thái:</strong> <span id="viewState"></span></p>
            <p><strong>Lượt xem:</strong> <span id="viewClick"></span></p>
            <p><strong>Mô tả:</strong></p>
            <div id="viewDescription"></div>
            <img id="viewImage" src="" alt="Ảnh Pet" style="max-width:100%; margin-top:10px;">
        </div>
    </div>

    <!-- MODAL SỬA PET -->
    <div id="editPetModal" class="modal">
        <div class="modal-content">
            <span id="closeEditPet" class="close">&times;</span>
            <h4 class="mb-3"><i class="bi bi-pencil-square me-2"></i>Sửa Pet</h4>

            <form id="editPetForm" enctype="multipart/form-data">
                <input type="hidden" name="id_pet" id="editIdPet">

                <div class="mb-3">
                    <label for="editName" class="form-label">Tên Pet</label>
                    <input type="text" class="form-control" name="name_pet" id="editName" required>
                </div>

                <div class="mb-3">
                    <label for="editGender" class="form-label">Giới tính</label>
                    <select name="gender" id="editGender" class="form-select" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="editState" class="form-label">Trạng thái</label>
                    <select name="state" id="editState" class="form-select" required>
                        <option value="available">Available</option>
                        <option value="adopted">Adopted</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="editDescription" class="form-label">Mô tả</label>
                    <textarea class="form-control" name="description" id="editDescription" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="editPetImage" class="form-label">Hình ảnh</label>
                    <input type="file" class="form-control" name="image" id="editPetImage" accept="image/*">
                    <img id="currentImage" src="" style="max-width:100px; margin-top:10px;">
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        window.availableCount = <?= $availableCount ?>;
        window.reservedCount = <?= $reservedCount ?>;

        window.topPetNames = <?= json_encode($topPetNames) ?>;
        window.topPetClicks = <?= json_encode($topPetClicks) ?>;
    </script>
    <script src="../../../public/scripts/managePet.js"></script>
</body>
</html>
