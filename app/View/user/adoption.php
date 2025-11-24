<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nhận nuôi</title>
  <link rel="stylesheet" href="../../../public/css/adoption.css" />
  <style>
    
        
  </style>
</head>
<body>
  <?php include('../layout/menu.php'); ?>  
  <section class="content">
    <img src="../../../public/img/cm16.png" alt="tieu de" class="baner" />
  </section>
  <div class="adoption-wrapper">
    <div class="adoption-process">
      <h2 class="adoption-title">Quy Trình Nhận Nuôi Chó Mèo</h2>
      <p class="adoption-intro">
        Việc nhận nuôi một chú chó hoặc mèo không chỉ là việc mang về một
        người bạn mới, mà còn là một trách nhiệm lớn để đảm bảo sự chăm sóc và
        yêu thương lâu dài cho chúng. Dưới đây là quy trình nhận nuôi chó mèo
        từ chúng tôi:
      </p>
      <div class="adoption-step"><h3 class="step-title">1. Tìm Hiểu Các Chú Chó, Mèo Có Sẵn Để Nhận Nuôi</h3></div>
      <div class="adoption-step"><h3 class="step-title">2. Điền Đơn Đăng Ký Nhận Nuôi</h3></div>
      <div class="adoption-step"><h3 class="step-title">3. Phỏng Vấn và Đánh Giá</h3></div>
      <div class="adoption-step"><h3 class="step-title">4. Kiểm Tra Cơ Sở Vật Chất và Môi Trường Sống</h3></div>
      <div class="adoption-step"><h3 class="step-title">5. Chăm Sóc và Điều Kiện Nhận Nuôi</h3></div>
      <div class="adoption-step"><h3 class="step-title">6. Ký Thỏa Thuận Nhận Nuôi</h3></div>
      <div class="adoption-step"><h3 class="step-title">7. Hỗ Trợ Sau Khi Nhận Nuôi</h3></div>
      <p class="adoption-note" style="color: red"><strong>Lưu Ý:</strong> Việc nhận nuôi chó mèo là một quyết định quan trọng và đòi hỏi cam kết lâu dài. Chúng tôi hy vọng bạn sẽ là người bạn đồng hành tuyệt vời cho các chú chó và mèo đang cần một mái ấm mới. Hãy chuẩn bị tâm lý và điều kiện chăm sóc để mang lại cuộc sống tốt đẹp nhất cho thú cưng của bạn!</p>
    </div>

    <div class="adoption-sidebar">
      <div class="adoption-conditions">
        <h3>Điều Kiện Nhận Nuôi</h3>
        <ul>
          <li>🐾 Tài chính tự chủ và ổn định.</li>
          <li>🐾 Chỗ ở cố định.</li>
          <li>🐾 Cam kết tiêm phòng và triệt sản.</li>
        </ul>
      </div>
    </div>
  </div>

  <section class="filter-pets">
    <h2>TÌM THÚ CƯNG</h2>
    <form id="filterForm" class="d-flex flex-wrap justify-content-center gap-2 mb-3">
    <button type="button" data-type="all" class="filter-btn active">Tất cả</button>
    <button type="button" data-type="dog" class="filter-btn">Chó</button>
    <button type="button" data-type="cat" class="filter-btn">Mèo</button>
    <button type="button" data-type="other" class="filter-btn">Khác</button>

    <input type="text" name="search" placeholder="Nhập tên Pet..." class="form-control ms-2" style="max-width:250px;">
    <button type="submit" class="btn btn-primary ms-2">Tìm kiếm</button>
  </form>

    <div id="pets-container">
    </div>
  </section>
  <?php include('../layout/footer.php'); ?>
  <script src="../../../public/scripts/adoption.js"></script>
</body>
</html>
