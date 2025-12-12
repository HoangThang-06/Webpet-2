<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhận nuôi</title>
    <link rel="icon" type="image/png" href="../../../public/icon/pawprint.png">  
    <link rel="stylesheet" href="../../../public/css/adoption.css">    
</head>
<body>
    <?php include("../layout/menu.php"); ?>
    <div class="image-box">
        <img src="../../../public/img/petlist.png" alt="banner">
    </div>
    <div class="container-text">
        <div class="adoption-step">
            <h2 class="adoption-title">Quy Trình Nhận Nuôi</h2>
            <p class="adoption-intro">Trước khi quyết định nhận nuôi bé chó hay mèo nào,
                bạn hãy tự hỏi bản thân rằng mình đã sẵn sàng để chịu trách nhiệm cả đời 
                cho bé chưa, cả về tài chính, nơi ở cũng như tinh thần. Việc nhận nuôi cần
                được sự đồng thuận lớn từ bản thân bạn cũng như gia đình và những người liên
                quan. Xin cân nhắc kỹ trước khi liên hệ với HPA về việc nhận nuôi.
            </p>
            <p class="adoption-intro">Bạn đã sẵn sàng? Hãy thực hiện các bước sau đây nhé:</p>
            <div class="step"><img class="icon" src="../../../public/icon/one.png">.<span class="a-step">Tìm Hiểu Các Chú Chó, Mèo Có Sẵn Để Nhận Nuôi</span></div>
            <div class="step"><img class="icon" src="../../../public/icon/two.png">.<span class="a-step">Điền Đơn Đăng Ký Nhận Nuôi</span></div>
            <div class="step"><img class="icon" src="../../../public/icon/three.png">.<span class="a-step"> Phỏng Vấn và Đánh Giá</span></div>
            <div class="step"><img class="icon" src="../../../public/icon/four.png">.<span class="a-step">Kiểm Tra Cơ Sở Vật Chất và Môi Trường Sống</span></div>
            <div class="step"><img class="icon" src="../../../public/icon/five.png">.<span class="a-step">Chăm Sóc và Điều Kiện Nhận Nuôi</span></div>
            <div class="step"><img class="icon" src="../../../public/icon/six.png">.<span class="a-step">Ký Thỏa Thuận Nhận Nuôi</span></div>
            <div class="step"><img class="icon" src="../../../public/icon/seven.png">.<span class="a-step">Hỗ Trợ Sau Khi Nhận Nuôi</span></div>
            <p class="adoption-note"><strong>Lưu Ý:</strong> Việc nhận nuôi chó mèo là một quyết định quan trọng và đòi hỏi cam kết lâu dài. Chúng tôi hy vọng bạn sẽ là người bạn đồng hành tuyệt vời cho các chú chó và mèo đang cần một mái ấm mới. Hãy chuẩn bị tâm lý và điều kiện chăm sóc để mang lại cuộc sống tốt đẹp nhất cho thú cưng của bạn!</p>
        </div>
        <div class="adoption-condition">
            <h3>Điều kiện nhận nuôi</h3>
            <ul class="s-list">
                <li>Tài chính tự chủ và ổn định.</li>
                <li>Chỗ ở cố định.</li>
                <li>Cam kết tiêm phòng và triệt sản.</li>
            </ul>
        </div>
    </div>
    <div class="banner-list">
        <img src="../../../public/img/cm19.png" alt="Banner">
        <div class="overlay"></div>
        <div class="banner-text">
            <h1>Nhận nuôi</h1>
            <p>Tìm hiểu tất cả các pet đang được cứu hộ tại trạm.</p>
        </div>
    </div>
    <section class="filter-pets">
        <h2>TÌM THÚ CƯNG</h2>
        <form id="filterForm" class="d-flex flex-wrap justify-content-center gap-2 mb-3">
            <div class=filter-row>
                <button type="button" data-type="all" class="filter-btn active">Tất cả</button>
                <button type="button" data-type="dog" class="filter-btn">Chó</button>
                <button type="button" data-type="cat" class="filter-btn">Mèo</button>
                <button type="button" data-type="other" class="filter-btn">Khác</button>
            </div>
            <div class="saerch-row">
                <input type="text" name="search" placeholder="Nhập tên Pet..." class="form-control ms-2" style="max-width:250px;">
                <button type="submit" class="btn btn-primary ms-2">Tìm kiếm</button>
            </div>
        </form>
        <div id="pets-container">
        </div>
    </section>
    <div class="banner-list">
        <img src="../../../public/img/cm20.png" alt="Pet">
        <div class="overlay"></div>
        <div class="banner-text">
            <h1>Bạn Chưa Đủ Điều Kiện Mang Boss Về Nhà? Tham gia chương trình Nhận Nuôi Ảo nhé.</h1>
            <a href="virtual.php">
                Tìm hiểu thêm
            </a>
        </div>
    </div>
    <?php include('../layout/footer.php'); ?>
    <script src="../../../public/scripts/adoption.js"></script>
</body>
</html>