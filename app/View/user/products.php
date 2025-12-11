<?php
include ('../../controller/dbconnect.php');
$sqlProductTop = "SELECT * FROM products ORDER BY created_at DESC LIMIT 4";
$resultProductTop=$conn->query($sqlProductTop);
$sqlProduct = "SELECT * FROM products";
$resultProduct=$conn->query($sqlProduct);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>
    <link rel="stylesheet" href="../../../public/css/products.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include ('../layout/menu.php'); ?>
    <div class="imgheader">
            <img src="../../../public/img/Header-product.jpg">
        </div>
    <div class="container">
        <div class="image-stack">
            <img src="../../../public/img/small1.jpg" class="item small">
            <img src="../../../public/img/midleimg1.jpg" class="item medium">
            <img src="../../../public/img/bigimg.jpg" class="item large">
            <img src="../../../public/img/midleimg2.jpg" class="item medium">
            <img src="../../../public/img/small2.jpg" class="item small">
        </div>  
        <div class="cardnew">
            <h2>Sản phẩm mới:</h2>
            <div class="product-list">
                <?php while($productTop = mysqli_fetch_assoc($resultProductTop)){ ?>
                <div class="product-card">
                    <span class="new-badge">NEW</span>
                    <a href="detail-product.php?id=<?php echo $productTop['id']; ?>">
                        <img src="<?php echo $productTop['image']; ?>" alt="<?php echo $productTop['name']; ?>">
                    </a>
                    <div class="info">
                        <a href="detail-product.php?id=<?php echo $productTop['id']; ?>" class="title"><?php echo $productTop['name']; ?></a>
                        <span class="cheap-badge">Flash Sale</span>
                        <p class="price"><?php echo number_format($productTop['price'], 0, ',', '.'); ?>₫</p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <section class="filter-products">
        <h2>TÌM SẢN PHẨM</h2>
        <form id="filterForm" class="d-flex flex-wrap justify-content-center gap-2 mb-3">
            <div class="filter-row">
                <button type="button" data-type="all" class="filter-btn active">Tất cả</button>
                <button type="button" data-type="Food" class="filter-btn">Thức ăn</button>
                <button type="button" data-type="Toy" class="filter-btn">Đồ chơi</button>
                <button type="button" data-type="Accessory" class="filter-btn">Phụ kiện</button>
                <button type="button" data-type="Health" class="filter-btn">Sức khỏe</button>
            </div>
            <div class="search-row">
                <input type="text" name="search" id="search" placeholder="Nhập tên sản phẩm..." class="form-control ms-2" style="max-width:250px;">
                <button type="submit" class="btn btn-primary ms-2">Tìm kiếm</button>
            </div>
        </form>
        <div id="products-container"></div>
    </section>
    <div class="rescue-banner">
            <h2>Mua Hàng Vì Những Người Bạn Bốn Chân</h2>
            <p>
                Toàn bộ lợi nhuận được đưa vào <strong>Quỹ Nuôi Dưỡng & Cứu Hộ Pet</strong>.<br>
                Khi bạn mua sản phẩm, bạn không chỉ nhận được món đồ mình muốn mà còn góp phần giúp
                một bé thú cưng được bảo vệ và chăm sóc tốt hơn.
            </p>
        </div>
    </div>
    <div class="banner-list">
        <img src="../../../public/img/backgrounddonate.jpg" alt="Pet">
        <div class="overlay"></div>
        <div class="banner-text">
            <h1>Bạn muốn ủng hộ trực tiếp thay vì mua sản phẩm?</h1>
            <a href="donate.php">
                Ủng hộ ngay
            </a>
        </div>
    </div>
    <footer>
        <?php include ('../layout/footer.php'); ?>       
    </footer>
    <script src="../../../public/scripts/product.js"></script>     
</body>
</html>