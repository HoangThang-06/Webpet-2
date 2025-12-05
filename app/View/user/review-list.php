<?php
include '../../controller/dbconnect.php';
$productId = isset($_GET['product']) ? intval($_GET['product']) : 0;
$star = isset($_GET['star']) ? intval($_GET['star']) : 0;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = 5;
$offset = ($page - 1) * $perPage;

if($productId == 0){
    echo '<p>Sản phẩm không hợp lệ.</p>';
    exit;
}
$where = "c.id_product = $productId";
if($star > 0){
    $where .= " AND c.rating = $star";
}
$sql = "SELECT c.*, u.fullname 
        FROM comments c
        JOIN users u ON c.id_user = u.id_user
        WHERE $where
        ORDER BY c.create_at DESC
        LIMIT $offset, $perPage";
$resultReview = mysqli_query($conn, $sql);
if(mysqli_num_rows($resultReview) > 0){
    while($row = mysqli_fetch_assoc($resultReview)){
        echo '<div class="review-item">';
        echo '<div class="review-user">'.htmlspecialchars($row['fullname']).'</div>';
        echo '<div class="review-meta">';
        echo '<span class="stars">'.str_repeat('★',$row['rating']).str_repeat('☆',5-$row['rating']).'</span>';
        echo '<span class="date">'.$row['create_at'].'</span>';
        echo '</div>';
        echo '<div class="review-text">'.htmlspecialchars($row['content']).'</div>';
        echo '</div>';
    }
} else {
    echo '<p>Chưa có đánh giá nào.</p>';
}
$totalSql = "SELECT COUNT(*) as total FROM comments c WHERE $where";
$totalRes = mysqli_query($conn, $totalSql);
$totalRow = mysqli_fetch_assoc($totalRes);
$totalPages = ceil($totalRow['total'] / $perPage);

if($totalPages > 1){
    echo '<div class="pagination">';
    for($i=1;$i<=$totalPages;$i++){
        $active = $i == $page ? 'active' : '';
        echo "<a href='#' class='page-link $active' data-page='$i'>$i</a> ";
    }
    echo '</div>';
}
?>
