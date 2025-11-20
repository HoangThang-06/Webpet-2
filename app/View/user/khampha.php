<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="css/stylekhampha.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
  </head>
  <body>
    <div>
      <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
          <a
            class="navbar-brand d-flex align-items-center"
            href="trangchu.html"
          >
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
      <div id="demo" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicators/dots -->
        <div class="carousel-indicators">
          <button
            type="button"
            data-bs-target="#demo"
            data-bs-slide-to="0"
            class="active"
          ></button>
          <button
            type="button"
            data-bs-target="#demo"
            data-bs-slide-to="1"
          ></button>
          <button
            type="button"
            data-bs-target="#demo"
            data-bs-slide-to="2"
          ></button>
        </div>

        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="imgkhampha/chomeo4.png" class="w-100 h-auto" alt="Ảnh" />
          </div>
          <div class="carousel-item">
            <img src="imgkhampha/cm15.png" class="w-100 h-auto" alt="Ảnh" />
          </div>
          <div class="carousel-item">
            <img src="imgkhampha/cm17.png" class="w-100 h-auto" alt="Ảnh" />
          </div>
        </div>

        <!-- Left and right controls/icons -->
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#demo"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#demo"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>

      <div class="container">
        <div class="gioithieu py-5 m-5">
          <h1 class="ttc">Khám Phá</h1>
          <p class="gtc">
            Chào mừng bạn đến với mục Khám Phá – nơi bắt đầu hành trình yêu
            thương! Hãy cùng chúng tôi tìm hiểu về những người bạn bốn chân đang
            chờ một mái ấm mới. Mỗi câu chuyện, mỗi ánh mắt đều chứa đựng hy
            vọng được yêu thương và chăm sóc. Khám phá để kết nối, để cảm nhận
            và để mở lòng với những sinh linh đang cần một gia đình.
          </p>
        </div>

        <div class="filter-buttons">
          <button type="button" data-value="all" class="active">Tất cả</button>
          <button type="button" data-value="nb">Nổi Bật</button>
          <button type="button" data-value="cm">Chó và Mèo</button>
          <button type="button" data-value="k">Khác</button>
        </div>

        <input type="hidden" id="filter-select" value="all" />

        <hr class="custom-hr" />

        <!--pham tin tuc-->
        <div class="row row-cols-1 row-cols-md-2 g-4" id="post-list">
          <!-- Bài viết 1 -->
          <div class="col" data-category="nb">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 25 tháng 4 năm 2025</div>
                  <div class="post-title">
                    Người Mỹ nuông chiều thú cưng quá mức
                  </div>
                  <a href="bao.html" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm6.png" alt="Ảnh 1" class="post-img" />
              </div>
            </a>
          </div>

          <!-- Bài viết 2 -->
          <div class="col" data-category="cm">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 24 tháng 4 năm 2025</div>
                  <div class="post-title">
                    Nghiên cứu mới về cách giúp chó và mèo thân nhau
                  </div>
                  <a href="#" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm7.png" alt="Ảnh 2" class="post-img" />
              </div>
            </a>
          </div>

          <!-- Bài viết 3 -->
          <div class="col" data-category="nb">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 23 tháng 4 năm 2025</div>
                  <div class="post-title">
                    Thức ăn thú cưng bán chạy hơn sữa trẻ em ở Hàn Quốc
                  </div>
                  <a href="#" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm8.png" alt="Ảnh 3" class="post-img" />
              </div>
            </a>
          </div>

          <!-- Bài viết 4 -->
          <div class="col" data-category="nb">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 23 tháng 4 năm 2025</div>
                  <div class="post-title">
                    Những trạm cứu hộ chó mèo bị xua đuổi
                  </div>
                  <a href="#" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm9.png" alt="Ảnh 4" class="post-img" />
              </div>
            </a>
          </div>

          <!-- Bài viết 1 -->
          <div class="col" data-category="cm">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 25 tháng 4 năm 2025</div>
                  <div class="post-title">
                    Mâu thuẫn vì hàng xóm nuôi gần 20 con chó ở chung cư
                  </div>
                  <a href="#" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm10.png" alt="Ảnh 1" class="post-img" />
              </div>
            </a>
          </div>

          <!-- Bài viết 2 -->
          <div class="col" data-category="nb">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 24 tháng 4 năm 2025</div>
                  <div class="post-title">
                    Bất lực vì khó xử lý chó thả rông, phóng uế
                  </div>
                  <a href="#" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm11.png" alt="Ảnh 2" class="post-img" />
              </div>
            </a>
          </div>

          <!-- Bài viết 3 -->
          <div class="col" data-category="cm">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 23 tháng 4 năm 2025</div>
                  <div class="post-title">
                    Khu phố 'bấn loạn' vì hàng xóm nuôi gần 100 con chó
                  </div>
                  <a href="#" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm12.png" alt="Ảnh 3" class="post-img" />
              </div>
            </a>
          </div>

          <!-- Bài viết 4 -->
          <div class="col" data-category="nb">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 23 tháng 4 năm 2025</div>
                  <div class="post-title">
                    Tranh cãi tiền phúng viếng cho thú cưng
                  </div>
                  <a href="#" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm13.png" alt="Ảnh 4" class="post-img" />
              </div>
            </a>
          </div>

          <!-- Bài viết 1 -->
          <div class="col" data-category="k">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 25 tháng 4 năm 2025</div>
                  <div class="post-title">
                    Những loài động vật này có đôi mắt to nhất thế giới
                  </div>
                  <a href="#" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm7.png" alt="Ảnh 1" class="post-img" />
              </div>
            </a>
          </div>

          <!-- Bài viết 2 -->
          <div class="col" data-category="k">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 24 tháng 4 năm 2025</div>
                  <div class="post-title">
                    15 loài động vật đã phục hồi sau khi bị đe dọa
                  </div>
                  <a href="#" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm7.png" alt="Ảnh 2" class="post-img" />
              </div>
            </a>
          </div>

          <!-- Bài viết 3 -->
          <div class="col" data-category="k">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 23 tháng 4 năm 2025</div>
                  <div class="post-title">
                    Tại sao chúng ta nên bảo vệ động vật có nguy cơ tuyệt chủng?
                  </div>
                  <a href="#" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm7.png" alt="Ảnh 3" class="post-img" />
              </div>
            </a>
          </div>

          <!-- Bài viết 4 -->
          <div class="col" data-category="k">
            <a href="bao.html" class="t1">
              <div class="post-card">
                <div>
                  <div class="post-date">Ngày 23 tháng 4 năm 2025</div>
                  <div class="post-title">
                    Những chú mèo báo con được giải cứu trở về với tự nhiên
                  </div>
                  <a href="#" class="post-link">Đọc thêm</a>
                </div>
                <img src="imgkhampha/cm7.png" alt="Ảnh 4" class="post-img" />
              </div>
            </a>
          </div>
        </div>

        <!-- NÚT HIỂN THỊ THÊM -->
        <div class="load-more-wrapper pb-5">
          <button id="load-more" class="load-more-btn">
            <span class="plus-icon">+</span> Hiển thị thêm
          </button>
        </div>
      </div>
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
    </div>
    <script src="scripts/khampham.js"></script>
  </body>
</html>
