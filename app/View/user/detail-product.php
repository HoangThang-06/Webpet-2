<?php
include ('../../controller/dbconnect.php');
$idProduct = $_GET['id'] ?? 0;
//lay thong tin sp theo id
$sqlDetail = "SELECT * FROM product WHERE id = $idProduct";
$resultDetail = $conn->query($sqlDetail);
$productDetail = mysqli_fetch_assoc($resultDetail);
//lay so danh gia cua sp
$sqlRating = "SELECT COUNT(*) AS total_reviews,AVG(rating) AS avg_rating FROM comments WHERE id_product = $idProduct";
$resultRating = $conn->query($sqlRating);
$ratingData = mysqli_fetch_assoc($resultRating);
$totalReviews = $ratingData['total_reviews'];
$avgRating = $ratingData['avg_rating'] ? number_format($ratingData['avg_rating'], 1) : 0;
$fullStars = floor($avgRating);
$emptyStars = 5 - $fullStars;
$starHTML = str_repeat("⭐", $fullStars) . str_repeat("☆", $emptyStars);
//lay cac sp lien quan
$category = $productDetail['category'];
$sqlRelated = "SELECT * FROM product 
               WHERE category = '$category' AND id != $idProduct
               LIMIT 4";
$resultRelated = $conn->query($sqlRelated);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="icon" type="image/png" href="../../../public/icon/pawprint.png"> 
    <link rel="stylesheet" href="../../../public/css/detail-product.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include ('../layout/menu.php'); ?>
    <div class="container">
        <div class="left-content">
            <div class="product-box">
                <div class="left-image">
                    <img src="<?php echo $productDetail['image']; ?>" alt="Product Image">
                </div>
                <div class="right-info">
                    <div class="product-name"><?php echo $productDetail['name']; ?></div>
                    <div class="rating-box">
                        <div class="rating-stars"><?php echo $starHTML; ?></div>
                        <div class="rating-text">(<?php echo $totalReviews; ?> đánh giá – <?php echo $avgRating; ?>/5)</div>
                    </div>
                    <div>Danh mục: <?php echo $productDetail['category']; ?></div>
                    <div class="price"><?php echo number_format($productDetail['price']); ?> đ</div>
                    <div>Số lượng còn: <?php echo $productDetail['quantity']; ?></div>
                    <div class="actions">
                        <a href="#" class="btn add-cart" data-id="<?php echo $idProduct; ?>">Thêm vào giỏ</a>
                        <a class="btn buy-now" href="checkout.php?id=<?php echo $idProduct; ?>">Mua ngay</a>
                    </div>
                </div>
            </div>
            <div class="detail-description">
                <h2>Mô tả sản phẩm:</h2>
                <p><?php echo nl2br($productDetail['description']); ?></p>
            </div>
            <div class="review-box" data-product="<?php echo $idProduct; ?>">
                <h2>Đánh giá:</h2>
                <div class="review-summary">
                    <div class="average-rating">
                        <p>(<?php echo $totalReviews; ?> lượt đánh giá)</p>
                        <span class="score" id="avgRating"><?php echo $avgRating; ?></span> / 5
                    </div>
                    <div class="rating-stars" id="starHTML"><?php echo $starHTML; ?></div>
                    <div class="filters">
                        <button class="filter-btn active" data-star="0">Tất Cả</button>
                        <button class="filter-btn" data-star="5">5 Sao</button>
                        <button class="filter-btn" data-star="4">4 Sao</button>
                        <button class="filter-btn" data-star="3">3 Sao</button>
                        <button class="filter-btn" data-star="2">2 Sao</button>
                        <button class="filter-btn" data-star="1">1 Sao</button>
                    </div>
                </div>
                <div class="review-list" id="reviewList">
                </div>
            </div>
        </div>
        <div class="right-related">
            <div class="related-title">Sản phẩm liên quan</div>
            <?php while($row = mysqli_fetch_assoc($resultRelated)) { ?>
                <div class="related-item">
                    <a href="detail-product.php?id=<?php echo $row['id']; ?>">
                        <img src="<?php echo $row['image']; ?>" alt="">
                    </a>
                    <div>
                        <a href="detail-product.php?id=<?php echo $row['id']; ?>">
                            <p><?php echo $row['name']; ?></p>
                        </a>
                        <strong><?php echo number_format($row['price']); ?> đ</strong>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <footer>
        <?php include ('../layout/footer.php'); ?>
    </footer>
    <script src="../../../public/scripts/review.js"></script>
</body>
</html>
