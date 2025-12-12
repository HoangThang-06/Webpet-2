<?php
require_once __DIR__."/../../controller/DBConnection.php";
$conn=(new DBConnection())->getConnection();
$sql = "SELECT * FROM article ORDER BY create_at DESC LIMIT 3";
$resultartilce = mysqli_query($conn, $sql);
if(!$resultartilce){
    die("Query lỗi: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang chủ</title>
  <link rel="stylesheet" href="../../../public/css/index.css?v=<?php echo time(); ?>">
</head>
<body>
  <?php include('../layout/menu.php'); ?>
    <img class="hero" src="../../../public/img/cm18.png">
  <h1 class="tieude">Tìm người bạn thú cưng mới của bạn</h1>
  <section class="categories">
    <a href="#" class="category-box">
      <div class="category">
        <img src="https://img.icons8.com/ios/100/dog.png" alt="Chó">
        <p>Chó</p>
      </div>
    </a>
    <a href="#" class="category-box">
      <div class="category">
        <img src="https://img.icons8.com/ios/100/cat.png" alt="Mèo">
        <p>Mèo</p>
      </div>
    </a>
    <a href="#" class="category-box">
      <div class="category">
        <img src="https://img.icons8.com/?size=160&id=TmsOBmFBJsOW&format=png" alt="Khác">
        <p>Các loài động vật khác</p>
      </div>
    </a>
    <a href="#" class="category-box">
      <div class="category">
        <img src="https://img.icons8.com/?size=128&id=XKFHfgAsrGtk&format=gif" alt="Cứu hộ">
        <p>Nhận nuôi & Cứu hộ</p>
      </div>
    </a>
  </section>
  <section class="services">
    <div class="services-content">
      <div class="services-text">
        <h1>Nhận nuôi thú cưng</h1>
        <p>
          Chúng tôi là một nhóm trẻ gồm tình nguyện viên Việt Nam và một số
            bạn nước ngoài, cùng hoạt động vì tình yêu chó mèo. Tôn chỉ hoạt
            động của chúng tôi là không từ bỏ nỗ lực với bất kỳ con vật nào, dù
            bé có ốm yếu hay tàn tật tới đâu, bởi mỗi thú cưng đều cần có cơ hội
            hi vọng vào một tương lai tốt đẹp. Chúng tôi cố gắng chăm sóc tốt
            nhất có thể, phần nào bù đắp lại những tổn thương cho các bé được
            cứu hộ về dù là hoang, lạc, bị bỏ rơi hay bạo hành. Ngoài ra, chúng
            tôi cũng luôn nỗ lực tìm mái ấm yêu thương các bé trọn đời. Và cuối
            cùng, chúng tôi giúp nâng cao nhận thức về trách nhiệm của chủ nuôi
            thông qua mạng xã hội và các hoạt động thiện nguyện.
        </p>
      </div>
      <div class="services-img">
        <img src="https://img.freepik.com/premium-photo/boy-dog-are-sitting-umbrella-rain_899870-48880.jpg" alt="Nhận nuôi">
      </div>
    </div>

    <div class="service-card">
      <img src="https://th.bing.com/th/id/OIP.Z_opTxugUPg4auba4eMl7AHaHN?cb=iwp1&rs=1&pid=ImgDetMain" alt="Ủng hộ">
      <h3>ỦNG HỘ</h3>
      <p>Giúp duy trì hoạt động của HPA qua hình thức quyên góp tiền hoặc nhu yếu phẩm.</p>
      <a href="products.php">TÌM HIỂU THÊM</a>
    </div>

    <div class="service-card">
      <img src="https://th.bing.com/th/id/OIP.LKdJUFpF3Omt19kuliVSlwHaF0?cb=iwp1&rs=1&pid=ImgDetMain" alt="Khám phá">
      <h3>KHÁM PHÁ</h3>
      <p>Hành động để thay đổi cuộc sống của chó, mèo và thú cưng khác.</p>
      <a href="discover.php">TÌM HIỂU THÊM</a>
    </div>

    <div class="service-card">
      <img src="https://th.bing.com/th/id/R.2b67520efd6d7befdbd038d979639859?rik=xz1%2bx9lAtSfgDA&riu=http%3a%2f%2fcityzoo.vn%2fimg_data%2fimages%2f1(10).jpg&ehk=UlcImz8kQv2zFSZHuq0%2f%2f%2feSGmkEdfc9h3SAYKu%2fHOc%3d&risl=&pid=ImgRaw&r=0" alt="Nhận nuôi">
      <h3>NHẬN NUÔI</h3>
      <p>Hãy nhận nuôi, cứu mạng, đừng xua đuổi và yêu thương loài động vật bị bỏ rơi.</p>
      <a href="adoption.php">TÌM HIỂU THÊM</a>
    </div>
  </section>
  <section class="adoption-process">
    <h2>QUY TRÌNH NHẬN NUÔI THÚ CƯNG</h2>
    <div class="steps">
      <div class="step">
        <img src="https://cdn-icons-png.flaticon.com/512/2950/2950661.png" alt="Đăng ký">
        <h3>1. Đăng ký nhận nuôi</h3>
        <p>Điền vào mẫu đơn trực tuyến với đầy đủ thông tin và điều kiện nuôi thú cưng.</p>
      </div>
      <div class="step">
        <img src="https://cdn-icons-png.flaticon.com/512/2098/2098402.png" alt="Phỏng vấn">
        <h3>2. Phỏng vấn & đánh giá</h3>
        <p>Nhân viên cứu hộ sẽ liên hệ để xác minh môi trường sống và khả năng chăm sóc.</p>
      </div>
      <div class="step">
        <img src="https://cdn-icons-png.flaticon.com/512/3062/3062634.png" alt="Nhận thú cưng">
        <h3>3. Nhận thú cưng</h3>
        <p>Sau khi được duyệt, bạn có thể đến trung tâm để gặp và đón thú cưng về nhà.</p>
      </div>
    </div>
    </section>
    <section class="stats-section">
    <div class="stat">
      <img src="../../../public/icon/kitten.png" alt="Ca cứu hộ">
      <h2 class="counter" data-target="79">0</h2>
      <p>Ca Cứu Hộ</p>
    </div>
    <div class="stat">
      <img src="https://img.icons8.com/?size=100&id=uKlTjfKow8jE&format=png&color=000000" alt="Đã có chủ">
      <h2 class="counter" data-target="99">0</h2>
      <p>Đã Có Chủ</p>
    </div>
    <div class="stat">
      <img src="https://img.icons8.com/?size=100&id=124062&format=png&color=000000" alt="Chờ tìm chủ">
      <h2 class="counter" data-target="56">0</h2>
      <p>Chờ Tìm Chủ</p>
    </div>
    <div class="stat">
      <img src="https://img.icons8.com/?size=100&id=gUBBddhPeeby&format=png&color=000000" alt="Chưa sẵn sàng">
      <h2 class="counter" data-target="15">0</h2>
      <p>Chưa Sẵn Sàng Tìm Chủ</p>
    </div>
  </section>
    <section class="news-section">
      <div class="container">
          <h2 class="section-title">TIN TỨC</h2>
          <div class="news-grid">
              <?php while($article = mysqli_fetch_assoc($resultartilce)): 
                  $date = date("d", strtotime($article['create_at']));
                  $month = date("m", strtotime($article['create_at']));
              ?>
              <div class="news-card">
                  <img src="<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                  <div class="news-content">
                      <div class="news-date"><?= $date ?><br><small>T<?= $month ?></small></div>
                      <h3><a href="articles.php?id=<?php echo $article['id_article']; ?>"><?= htmlspecialchars($article['title']) ?></a></h3>
                      <p><?= htmlspecialchars(substr($article['content'], 0, 100)) ?>...</p>
                  </div>
              </div>
              <?php endwhile; ?>
          </div>
          <div class="read-more">
              <a href="discover.php">ĐỌC THÊM</a>
          </div>
      </div>
  </section>
    <script src="../../../public/scripts/main.js"></script>
  <?php include('../layout/footer.php'); ?>
</body>
</html>
