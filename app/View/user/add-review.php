<?php
session_start();
include '../../controller/dbconnect.php';
if(!isset($_SESSION['user'])){
    header('Location: login.php');
    exit;
}
$idUser = $_SESSION['user']['id_user'];
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
if($order_id == 0){
    echo "Đơn hàng không hợp lệ.";
    exit;
}
$orderItemsSql = "SELECT oi.product_id, p.name_product, p.image 
                  FROM order_items oi 
                  JOIN product p ON oi.product_id = p.id_product
                  WHERE oi.order_id = ?";
$stmt = $conn->prepare($orderItemsSql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$resultItems = $stmt->get_result();
$products = $resultItems->fetch_all(MYSQLI_ASSOC);
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $hasReview = false;
    foreach($products as $product){
        $productId = $product['product_id'];
        $rating = intval($_POST['rating_'.$productId] ?? 0);
        $content = trim($_POST['content_'.$productId] ?? '');

        if($rating > 0 && $content !== ''){
            $insertSql = "INSERT INTO comments (id_user, id_product, rating, content) 
                          VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("iiis", $idUser, $productId, $rating, $content);
            $insertStmt->execute();

            $hasReview = true;
        }
    }
    if($hasReview){
        echo "<script>alert('Đánh giá đã được gửi thành công!'); window.location.href='historyorder.php';</script>";
        exit;
    } else {
        echo "<script>alert('Vui lòng đánh giá ít nhất 1 sản phẩm!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh giá đơn hàng #<?= $order_id ?></title>
    <link rel="stylesheet" href="../../../public/css/add-review.css">
</head>
<body>
    <h1 style="text-align:center; margin-top:20px;">Đánh giá đơn hàng #<?= str_pad($order_id,4,'0',STR_PAD_LEFT) ?></h1>
<form method="post" class="review-form">
    <?php foreach($products as $product): ?>
        <div class="product-review-card">
            <div class="product-info">
                <img src="<?= $product['image']; ?>"alt="<?= htmlspecialchars($product['name_product']) ?>">
                <span class="product-name"><?= htmlspecialchars($product['name_product']) ?></span>
            </div>
            <div class="rating-select">
                <label for="rating_<?= $product['product_id'] ?>">Chọn số sao:</label>
                <select name="rating_<?= $product['product_id'] ?>" id="rating_<?= $product['product_id'] ?>">
                    <option value="0">-- Chọn --</option>
                    <option value="5">5 ★★★★★</option>
                    <option value="4">4 ★★★★☆</option>
                    <option value="3">3 ★★★☆☆</option>
                    <option value="2">2 ★★☆☆☆</option>
                    <option value="1">1 ★☆☆☆☆</option>
                </select>
            </div>
            <textarea name="content_<?= $product['product_id'] ?>" rows="3" placeholder="Viết đánh giá của bạn..."></textarea>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn-submit">Gửi đánh giá</button>
</form>

</body>
</html>
