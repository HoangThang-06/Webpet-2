<?php
include('../../controller/dbconnect.php');
$type = $_GET['type'] ?? 'all';
$search = $_GET['search'] ?? '';
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 12;
$start = ($currentPage - 1) * $limit;

$sqlCount = "SELECT COUNT(id) AS total FROM pets WHERE 1=1";
$sql = "SELECT * FROM pets WHERE 1=1";

if ($type != 'all') {
    $sqlCount .= " AND species = '".mysqli_real_escape_string($conn, $type)."'";
    $sql .= " AND species = '".mysqli_real_escape_string($conn, $type)."'";
}

if ($search != '') {
    $sqlCount .= " AND name LIKE '%".mysqli_real_escape_string($conn, $search)."%'";
    $sql .= " AND name LIKE '%".mysqli_real_escape_string($conn, $search)."%'";
}

$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$total = $rowCount['total'];
$total_page = ceil($total / $limit);
if($currentPage > $total_page) $currentPage = $total_page;
if($currentPage < 1) $currentPage = 1;

$sql .= " LIMIT $start, $limit";
$result = $conn->query($sql);
?>
<div class="pets-list">
<?php 
if($result->num_rows>0){
while($pet = $result->fetch_assoc()): ?>
  <div class="pet-item">
    <img src="<?= $pet['image'] ?>" alt="<?= htmlspecialchars($pet['name']) ?>">
    <div class="info">
      <p><?= htmlspecialchars($pet['name']) ?></p>
      <span><strong>Tuổi: </strong><?= htmlspecialchars($pet['age']) ?> tuổi</span><br>
      <span><strong>Giới tính: </strong><?= htmlspecialchars($pet['gender']) ?></span><br>
      <a href="form-adoption.php?id=<?= $pet['id'] ?>" class="btn btn-success">Nhận nuôi</a>
      <a href="get-pet.php?id=<?= $pet['id'] ?>" class="btn btn-info view-detail" style="margin:10px 0px">Xem chi tiết</a>
    </div>
  </div>
<?php endwhile;}
else{
    echo '<p>Không có pet nào</p>';
} ?>
</div>
<div class="pagination">
<?php
if ($currentPage > 1 && $total_page > 1) {
    echo '<a class="page-link" data-page="'.($currentPage-1).'" href="#"><-</a>';
}
for ($i = 1; $i <= $total_page; $i++) {
    if ($i == $currentPage) {
        echo '<span class="page-link active">'.$i.'</span>';
    } else {
        echo '<a class="page-link" data-page="'.$i.'" href="#">'.$i.'</a>';
    }
}
if ($currentPage < $total_page && $total_page > 1) {
    echo '<a class="page-link" data-page="'.($currentPage+1).'" href="#">-></a>';
}
?>
</div>
