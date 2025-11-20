<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nhận nuôi</title>
    <link rel="stylesheet" href="css/stylenhannuoi.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="trangchu.html">
          <img
            src="imgkhampha/logo.png"
            class="logo"
            style="width: 40px; height: 40px; margin-right: 10px"
          />
          <span class="text-dark fw-bold">PetRescue Hub</span>
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse justify-content-end"
          id="navbarNav"
        >
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="trangchu.html">Trang Chủ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="nhannuoi.html">Nhận Nuôi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="khampha.html">Khám Phá</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="donate.html">Donate</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="content">
      <img src="imgkhampha/cm16.png" alt="tieu de" class="baner" />
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
        <div class="adoption-step">
          <h3 class="step-title">
            1. Tìm Hiểu Các Chú Chó, Mèo Có Sẵn Để Nhận Nuôi
          </h3>
        </div>
        <div class="adoption-step">
          <h3 class="step-title">2. Điền Đơn Đăng Ký Nhận Nuôi</h3>
        </div>
        <div class="adoption-step">
          <h3 class="step-title">3. Phỏng Vấn và Đánh Giá</h3>
        </div>
        <div class="adoption-step">
          <h3 class="step-title">
            4. Kiểm Tra Cơ Sở Vật Chất và Môi Trường Sống
          </h3>
        </div>
        <div class="adoption-step">
          <h3 class="step-title">5. Chăm Sóc và Điều Kiện Nhận Nuôi</h3>
        </div>
        <div class="adoption-step">
          <h3 class="step-title">6. Ký Thỏa Thuận Nhận Nuôi</h3>
        </div>
        <div class="adoption-step">
          <h3 class="step-title">7. Hỗ Trợ Sau Khi Nhận Nuôi</h3>
        </div>
        <p class="adoption-note" style="color: red">
          <strong>Lưu Ý:</strong> Việc nhận nuôi chó mèo là một quyết định quan
          trọng và đòi hỏi cam kết lâu dài. Chúng tôi hy vọng bạn sẽ là người
          bạn đồng hành tuyệt vời cho các chú chó và mèo đang cần một mái ấm
          mới. Hãy chuẩn bị tâm lý và điều kiện chăm sóc để mang lại cuộc sống
          tốt đẹp nhất cho thú cưng của bạn!
        </p>
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
      <!-- Các nút lọc -->
      <button class="filter-btn active" data-tab="1">Tất cả</button>
      <button class="filter-btn" data-tab="2">Chó</button>
      <button class="filter-btn" data-tab="3">Mèo</button>
      <button class="filter-btn" data-tab="4">Khác</button>
      <br>
      <input
        type="text"
        id="search-input"
        placeholder="Nhập tên thú cưng..."
        autocomplete="off"
      />
      <div id="pets-container"></div>
      <div class="d-flex justify-content-center">
        <div class="pagination">
          <button class="page-btn" onclick="changePage('prev')">&lt;</button>
          <button class="page-btn active" onclick="changePage(1)">1</button>
          <button class="page-btn" onclick="changePage(2)">2</button>
          <button class="page-btn" onclick="changePage(3)">3</button>
          <button class="page-btn" onclick="changePage('next')">&gt;</button>
        </div>
      </div>
    </section>
    <footer class="footer">
      <div class="footer-container">
        <div class="footer-content">
          <h3 style="text-align: center">Liên hệ với chúng tôi</h3>
          <div class="footer-columns">
            <div class="contact-info">
              <h4>Tuyên Trương</h4>
              <a href="https://www.facebook.com/tentrangcuaban" target="_blank">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/facebook-new.png"
                  alt="Facebook"
                />
                Facebook
              </a>
              <a href="tel:0123456789">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/phone.png"
                  alt="Phone"
                />
                +84 975 475 243
              </a>
              <a href="mailto:emailcuaban@gmail.com">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/email.png"
                  alt="Email"
                />
                tuyentv.24itb@vku.udn.vn
              </a>
            </div>
            <div class="contact-info">
              <h4>Thắng Hoàng</h4>
              <a href="https://www.facebook.com/tentrangcuaban" target="_blank">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/facebook-new.png"
                  alt="Facebook"
                />
                Facebook
              </a>
              <a href="tel:0123456789">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/phone.png"
                  alt="Phone"
                />
                0123 456 789
              </a>
              <a href="mailto:emailcuaban@gmail.com">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/email.png"
                  alt="Email"
                />
                thanght.24itb@vku.udn.vn
              </a>
            </div>
            <div class="contact-info">
              <h4>Mai Thanh Hoàng</h4>
              <a href="https://www.facebook.com/tentrangcuaban" target="_blank">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/facebook-new.png"
                  alt="Facebook"
                />
                Facebook
              </a>
              <a href="tel:0123456789">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/phone.png"
                  alt="Phone"
                />
                0123 456 789
              </a>
              <a href="mailto:emailcuaban@gmail.com">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/email.png"
                  alt="Email"
                />
                mthoang.24itb@vku.udn.vn
              </a>
            </div>
            <div class="contact-info">
              <h4>Mai Thanh Hoàng</h4>
              <a href="https://www.facebook.com/tentrangcuaban" target="_blank">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/facebook-new.png"
                  alt="Facebook"
                />
                Facebook
              </a>
              <a href="tel:0123456789">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/phone.png"
                  alt="Phone"
                />
                0123 456 789
              </a>
              <a href="mailto:emailcuaban@gmail.com">
                <img
                  src="https://img.icons8.com/ios-filled/30/ffffff/email.png"
                  alt="Email"
                />
                ntdo.24it@vku.udn.vn
              </a>
            </div>
            <div class="footer-address">
              <h4>Trung Tâm Cứu Hộ & Nhận Nuôi Động Vật</h4>
              <p>&copy; 2025</p>
              <p>Địa chỉ: 287 Huỳnh Văn Nghệ, Hòa Hải, Ngũ Hành Sơn, Đà Nẵng</p>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <script src="scripts/adoption.js"></script>
  </body>
</html>
