<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ủng hộ</title>
  <link rel="stylesheet" href="../../../public/css/donate.css?v=<?php echo time(); ?>">
</head>
<div id="donatePopup" class="popup-overlay">
    <div class="popup-box">

        <form id="donateForm" action="upload_receipt.php" method="POST" enctype="multipart/form-data">
            <h2>Ủng hộ ngay</h2>
            <label>Số tiền (VND)</label>
            <input type="number" id="amount" placeholder="Ví dụ: 50000">
            <label>Lời nhắn</label>
            <input type="text" id="message" placeholder="Ví dụ: Ung ho cac be">
            <p class="warning">
                ⚠️ Vui lòng chuyển khoản <b>chính xác số tiền</b> và <b>nội dung</b> bên dưới.
                Sau khi chuyển khoản, vui lòng chụp ảnh biên lai và tải lên.
            </p>
            <button type="button" class="btn-generate" onclick="generateQR()">Tạo mã QR</button>
            <div id="qrResult" class="qr-area" style="display:none;">
                <h3>Mã QR thanh toán</h3>
                <img id="qrImage" src="">
            </div>
            <div class="upload-area" id="uploadSection" style="display:none;">
                <label>Tải ảnh biên lai lên:</label>
                <input type="file" name="receipt" id="receipt" accept="image/*">

                <input type="hidden" name="amount" id="hidden_amount">
                <input type="hidden" name="message" id="hidden_message">

                <button type="button" class="btn-confirm" onclick="confirmTransaction()">
                    Xác nhận giao dịch
                </button>
            </div>

        </form>
        <button class="btn-close" onclick="closePopup()">Đóng</button>
    </div>
</div>


<body>
  <?php include('../layout/menu.php'); ?>
  <img class="img-banner" src="../../../public/img/donate.png" alt="Donate">
  <section class="donate-section">
    <div class="donate-container">
        <div class="donate-text">
            <h2>Tôi Muốn Ủng Hộ</h2>
            <p>Mọi hoạt động cứu hộ của PetRescueHub hoàn toàn dựa trên các khoản quyên góp từ cộng đồng. Chi phí hàng tháng của nhóm bao gồm tiền thuê nhà, tiền viện phí, thức ăn, điện, nước, thuốc men và đồ dùng, bỉm tã, lương hỗ trợ các bạn tnv dọn dẹp... Nhóm rất cần sự giúp đỡ của các bạn để có thể duy trì nhà chung cũng như đội cứu hộ. Chỉ cần cố định 50k - 100k hàng tháng là các bạn đã giúp đỡ được cho nhóm và cách bé rất nhiều!</p>
            <p>Chi phí sẽ được chia đều cho các bé khác còn nằm viện và gây dựng nhà chung. Ngoài ra Nhóm cũng tiếp nhận quyên góp bằng hiện vật như quần áo cũ (để lót chuồng), bỉm, găng tay y tế, thức ăn, cát vệ sinh v.v...</p>
            <p>*Lưu ý: nhóm không dùng zalo và KHÔNG BAO GIỜ yêu cầu Mạnh Thường Quân cung cấp thông tin thẻ hoặc mã OTP</p>
            <p>Tài khoản nhận quyên góp của nhóm. Chi phí sẽ được chia đều cho các bé khác còn nằm viện và gây dựng nhà chung.</p>
            <p>🏦 MB BANK: ***********<br>Chủ tài khoản: PetRescueHub</p>
            <p style="color:red;">Mọi thắc mắc vui lòng liên hệ với chúng tôi để được giải đáp!</p>
        </div>
        <div class="donate-image">
            <img src="../../../public/img/qrdonate.png" alt="Donate">
        </div>
    </div>
  </section>
  <div class="donate-button-wrapper">
    <button onclick="openPopup()">Ủng hộ ngay</button>
  </div>
 <div class="other-donate">
    <h1>Các phương thức ủng hộ khác</h1>
    <div class="donate-icons">
        <div class="donate-item">
            <img src="../../../public/icon/diaper.png" alt="Bỉm">
            <p>Bỉm</p>
        </div>
        <div class="donate-item">
            <img src="../../../public/icon/male-clothes.png" alt="Quần áo">
            <p>Quần áo</p>
        </div>
        <div class="donate-item">
            <img src="../../../public/icon/pet-food.png" alt="Thức ăn">
            <p>Thức ăn</p>
        </div>
    </div>
  </div>
  <footer>
    <?php include('../layout/footer.php'); ?>
  </footer>
  <script src="../../../public/scripts/donate.js"></script>
</body>
</html>