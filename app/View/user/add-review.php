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
$orderItemsSql = "SELECT oi.product_id, p.name, p.image 
                  FROM order_items oi 
                  JOIN products p ON oi.product_id = p.id
                  WHERE oi.order_id = ?";
$stmt = $conn->prepare($orderItemsSql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$resultItems = $stmt->get_result();
$products = $resultItems->fetch_all(MYSQLI_ASSOC);
if($_SERVER['REQUEST_METHOD'] === 'POST'){
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
        }
    }
    echo "<script>alert('Đánh giá đã được gửi thành công!'); window.location.href='historyorder.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh giá đơn hàng #<?= $order_id ?></title>
    <link rel="stylesheet" href="../../../public/css/ho.css">
    <style>
        .review-form {
    max-width: 700px;
    margin: 30px auto;
    font-family: Arial, sans-serif;
}

.product-review-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 20px;
    margin-bottom: 25px;
    transition: transform 0.2s;
}
.product-review-card:hover {
    transform: translateY(-3px);
}

.product-info {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}
.product-info img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 15px;
}
.product-name {
    font-weight: bold;
    font-size: 1.1rem;
}

.rating-select {
    margin-bottom: 10px;
}
.rating-select label {
    font-weight: bold;
    margin-right: 10px;
}
.rating-select select {
    padding: 6px 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 0.95rem;
    background-color: #f9f9f9;
    cursor: pointer;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.rating-select select:focus {
    border-color: #ff4757;
    box-shadow: 0 0 5px rgba(255,71,87,0.3);
    outline: none;
}

textarea {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
    resize: none;
    font-size: 0.95rem;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
    transition: border-color 0.2s, box-shadow 0.2s;
}
textarea:focus {
    border-color: #ff4757;
    box-shadow: 0 0 6px rgba(255,71,87,0.2);
    outline: none;
}

.btn-submit {
    display: block;
    width: 100%;
    padding: 14px;
    font-size: 1rem;
    color: #fff;
    background: linear-gradient(90deg, #ff6b81, #ff4757);
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    margin-top: 10px;
}
.btn-submit:hover {
    background: linear-gradient(90deg, #ff4757, #ff6b81);
    transform: translateY(-2px);
}

        
    </style>
</head>
<body>
    <h1 style="text-align:center; margin-top:20px;">Đánh giá đơn hàng #<?= str_pad($order_id,4,'0',STR_PAD_LEFT) ?></h1>
<form method="post" class="review-form">
    <?php foreach($products as $product): ?>
        <div class="product-review-card">
            <div class="product-info">
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <span class="product-name"><?= htmlspecialchars($product['name']) ?></span>
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
