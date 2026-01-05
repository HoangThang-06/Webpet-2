<?php
require_once __DIR__."/../../controller/DBConnection.php";
$conn=(new DBConnection())->getConnection();
$type = $_GET['type'] ?? 'all';
$search = $_GET['search'] ?? '';
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 8;
$start = ($currentPage - 1) * $limit;
$sqlCount = "SELECT COUNT(id_product) AS total FROM product WHERE 1=1";
$sql = "SELECT * FROM product WHERE 1=1";
if ($type != 'all') {
    $typeEsc = mysqli_real_escape_string($conn, $type);
    $sqlCount .= " AND category = '$typeEsc'";
    $sql .= " AND category = '$typeEsc'";
}
if ($search != '') {
    $searchEsc = mysqli_real_escape_string($conn, $search);
    $sqlCount .= " AND name LIKE '%$searchEsc%'";
    $sql .= " AND name LIKE '%$searchEsc%'";
}
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$total = $rowCount['total'];
$total_page = ceil($total / $limit);
if ($currentPage > $total_page) $currentPage = $total_page;
if ($currentPage < 1) $currentPage = 1;
$sql .= " LIMIT $start, $limit";
$resultProduct = $conn->query($sql);
?>
<div class="product-list">
<?php while($product = mysqli_fetch_assoc($resultProduct)) { ?>
    <div class="product-cardm">
        <a href="detail-product.php?id=<?= $product['id_product']; ?>">
            <img src="<?= $product['image']; ?>" alt="<?= htmlspecialchars($product['name_product']); ?>">
        </a>
        <a href="detail-product.php?id=<?= $product['id_product']; ?>" class="title">
            <?= htmlspecialchars($product['name_product']); ?>
        </a>
        <p class="price"><?= number_format($product['price'], 0, ',', '.'); ?>₫</p>
    </div>
<?php } ?>
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
