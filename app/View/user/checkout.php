<?php
session_start();
include ('../../controller/dbconnect.php');
if (!isset($_SESSION['user'])) {
    header("Location: ../login/login.php");
    exit;
}
$idUser = $_SESSION['user']['id_user'];
$sqlUser = "SELECT fullname, phone, address, email FROM users WHERE id_user = $idUser";
$resultUser = $conn->query($sqlUser);
$user = mysqli_fetch_assoc($resultUser);
$cartItems = [];
$total = 0;
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $sqlProduct = "SELECT id AS product_id, name, price, image FROM products WHERE id = $productId";
    $resultProduct = $conn->query($sqlProduct);
    $product = mysqli_fetch_assoc($resultProduct);
    if ($product) {
        $product['quantity'] = 1;
        $cartItems[] = $product;
        $total = $product['price'];
    }
}
else {

    $sqlCart = "
        SELECT 
            c.id AS cart_id,
            c.quantity,
            p.id AS product_id,
            p.name,
            p.price,
            p.image
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = $idUser
    ";
    $resultCart = $conn->query($sqlCart);

    while ($row = mysqli_fetch_assoc($resultCart)) {
        $cartItems[] = $row;
        $total += $row['price'] * $row['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/checkout.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thanh toán đơn hàng</h1>
            <p>Vui lòng kiểm tra lại đơn hàng và hoàn tất thanh toán<p>
        </div>
        <div class="content">
            <div class="left-content">
                <div class="content-top">
                    <h2>Chọn phương thức thanh toán:</h2>
                    <label class="pay-option">
                        <input type="radio" name="payment" value="COD">
                        <div class="pay_box">
                            <div>
                                <h3>Thanh toán khi nhận hàng (COD)</h3>
                                <p>Thanh toán trực tiếp khi nhận hàng</p>
                            </div>
                            <i class="fa-solid fa-box-open pay_icon"></i>
                        </div>
                    </label>
                    <label class="pay-option">
                        <input type="radio" name="payment" value="Banking">
                        <div class="pay_box">
                            <div>
                                <h3>Chuyển khoản ngân hàng (Banking)</h3>
                                <p>Chuyển khoản trực tiếp qua app ngân hàng</p>
                            </div>
                            <i class="fa-solid fa-building-columns pay_icon"></i>
                        </div>
                    </label>
                </div>
                <div class="content-bot">
                    <h2>Thông tin nhận hàng</h2>
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" value="<?php echo $user['fullname']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" value="<?php echo $user['phone']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" value="<?php echo $user['address']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" value="<?php echo $user['email']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea placeholder="Ghi chú đơn hàng (không bắt buộc)"></textarea>
                    </div>
                </div>
            </div>
            <div class="right-content">
                 <h2>Tóm tắt đơn hàng</h2>
                <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <img src="<?= $item['image'] ?>" alt="">
                    <div class="cart-info">
                        <h3><?= $item['name'] ?></h3>
                        <p>Số lượng: <?= $item['quantity'] ?></p>
                        <p>Giá: <?= number_format($item['price']) ?>đ</p>
                    </div>
                </div>
                <hr>
                <?php endforeach; ?>
                <div class="total-box">
                    <h3>Tổng cộng:</h3>
                    <span class="sum"><?= number_format($total) ?>đ</span>
                </div>
            </div>
        </div>
        <form action="order_success.php" method="POST" id="orderForm">
            <a href="products.php" class="back-link">← Quay lại mua hàng</a>

            <input type="hidden" name="total" value="<?= $total ?>">
            <input type="hidden" name="payment_method" id="payment_method">
            <input type="hidden" name="description" id="description">

            <?php if(isset($_GET['id'])): ?>
                <input type="hidden" name="direct_product" value="<?= $_GET['id'] ?>">
            <?php endif; ?>

            <button class="btn-submit" type="submit">
                Đặt hàng: <?= number_format($total) ?>đ
            </button>
        </form>
        <div class="secure-note">
            <i class="fa-solid fa-lock secure-icon"></i>
            <span>Giao dịch của bạn sẽ được bảo mật</span>
        </div>
    </div>
    <script src="../../../public/scripts/checkout.js"></script>
</body>
</html>
