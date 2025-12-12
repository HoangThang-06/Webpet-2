<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ủng hộ</title>
    <link rel="stylesheet" href="css/donate.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <?php include ('../layout/menu.php'); ?>
    <h1
      style="
        text-align: center;
        font-family: 'Quicksand', sans-serif;
      text-transform: uppercase;
        margin-top: 100px;
        font-size: 3.5em;
        color: #20c997;
      "
    >
      Trở thành anh hùng theo cách của bạn
    </h1>
    <div class="main-buttons">
      <button
        class="btn btn-primary pulsing-button"
        onclick="showForm('donateForm')"
      >
        Đăng ký quyên góp
      </button>
      <button
        class="btn btn-success pulsing-button"
        onclick="showForm('volunteerForm')"
      >
        Đăng ký tình nguyện viên
      </button>
      <button
        class="btn btn-info pulsing-button"
        onclick="showForm('contactForm')"
      >
        Liên hệ
      </button>
    </div>
    <div id="overlay" class="overlay hidden" onclick="closeForms()"></div>
    <div id="donateForm" class="form-container hidden">
      <h2>Đăng ký quyên góp</h2>
      <form onsubmit="submitForm(event, 'donateForm')">
        <div class="mb-3">
          <label for="donorName">Họ tên:</label>
          <input type="text" class="form-control" id="donorName" required />
        </div>
        <div class="mb-3">
          <label for="donorEmail">Email:</label>
          <input type="email" class="form-control" id="donorEmail" required />
        </div>
        <div class="mb-3">
          <label for="donateType" class="form-label">Loại quyên góp:</label>
          <select class="form-select" id="donateType" required>
            <option value="">-- Chọn loại --</option>
            <option>Tiền mặt</option>
            <option>Đồ ăn cho thú cưng</option>
            <option>Vật phẩm khác</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="amount" class="form-label"
            >Số tiền / Mô tả vật phẩm:</label
          >
          <input type="text" class="form-control" id="amount" required />
        </div>
        <div class="mb-3">
          <label for="donorName" class="form-label">Tên người ủng hộ:</label>
          <input type="text" class="form-control" id="donorName" required />
        </div>
        <div class="d-flex justify-content-between">
          <button type="submit" class="btn btn-primary">Gửi</button>
          <button
            type="button"
            class="btn btn-secondary"
            onclick="closeForms()"
          >
            Đóng
          </button>
        </div>
        <p class="pt-3">Nếu có gì thắc mắc vui vòng bấm vào mục liên hệ!</p>
      </form>
    </div>
    <div id="volunteerForm" class="form-container hidden">
      <h2>Đăng ký tình nguyện viên</h2>
      <form onsubmit="submitForm(event, 'volunteerForm')">
        <div class="mb-3">
          <label for="volunteerName">Họ tên:</label>
          <input type="text" class="form-control" id="volunteerName" required />
        </div>
        <div class="mb-3">
          <label for="volunteerPhone">Số điện thoại:</label>
          <input
            type="text"
            class="form-control"
            id="volunteerPhone"
            required
          />
        </div>
        <div class="mb-3">
          <label for="volEmail" class="form-label">Email:</label>
          <input type="email" class="form-control" id="volEmail" required />
        </div>
        <div class="mb-3">
          <label for="volTime" class="form-label"
            >Khung giờ có thể hỗ trợ:</label
          >
          <input type="text" class="form-control" id="volTime" required />
        </div>
        <div class="mb-3">
          <label for="volunteerSkill">Kỹ năng / Mong muốn đóng góp:</label>
          <textarea
            class="form-control"
            id="volunteerSkill"
            rows="3"
            required
          ></textarea>
        </div>
        <div class="d-flex justify-content-between">
          <button type="submit" class="btn btn-success">Gửi</button>
          <button
            type="button"
            class="btn btn-secondary"
            onclick="closeForms()"
          >
            Đóng
          </button>
        </div>
        <p class="pt-3">Nếu có gì thắc mắc vui vòng bấm vào mục liên hệ!</p>
      </form>
    </div>
    <!-- Form Đăng ký liên hệ -->
    <div id="contactForm" class="form-container hidden">
      <h2>Thông tin liên hệ</h2>
      <div class="contact-info-container">
        <div class="contact-item">
          <h3>Liên hệ 1</h3>
          <p><strong>Tên:</strong> Trương Văn Tuyên</p>
          <p><strong>Email:</strong> tuyentv.24itb@vku.udn.vn</p>
          <p><strong>Số điện thoại:</strong> +84 23456789</p>
          <p><strong>Tên ngân hàng:</strong> Demo Bank</p>
          <p>
            <strong>Số tài khoản ngân hàng:</strong>
            <span id="accountNumber1">123456789</span>
            <button
              class="copy-btn"
              onclick="copyToClipboard('accountNumber1')"
            >
              <i class="fas fa-copy"></i>
            </button>
          </p>
        </div>
        <div class="contact-item">
          <h3>Liên hệ 2</h3>
          <p><strong>Tên:</strong> Hoàng Trọng Thắng</p>
          <p><strong>Email:</strong> thanght.24itb@vku.udn.vn</p>
          <p><strong>Số điện thoại:</strong> +84 987654321</p>
          <p><strong>Tên ngân hàng:</strong> Demo Bank</p>
          <p>
            <strong>Số tài khoản ngân hàng:</strong>
            <span id="accountNumber2">987654321</span>
            <button
              class="copy-btn"
              onclick="copyToClipboard('accountNumber2')"
            >
              <i class="fas fa-copy"></i>
            </button>
          </p>
        </div>
      </div>
      <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" onclick="closeForms()">
          Đóng
        </button>
      </div>
    </div>

    <script src="scripts/donate.js"></script>
  </body>
</html>
