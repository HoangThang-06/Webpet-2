<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="../../../public/css/discover.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap"rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap"rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap"rel="stylesheet"/>
  </head>
  <body>
    <div>
      <?php include ('../layout/menu.php'); ?>
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
            <img src="../../../public/img/chomeo4.png" class="w-100 h-auto" alt="Ảnh" />
          </div>
          <div class="carousel-item">
            <img src="../../../public/img/cm15.png" class="w-100 h-auto" alt="Ảnh" />
          </div>
          <div class="carousel-item">
            <img src="../../../public/img/cm17.png" class="w-100 h-auto" alt="Ảnh" />
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
          <button type="button" data-value="hot">Nổi Bật</button>
          <button type="button" data-value="cm">Chó và Mèo</button>
          <button type="button" data-value="k">Khác</button>
        </div>

        <input type="hidden" id="filter-select" value="all" />

        <hr class="custom-hr" />

        <!--pham tin tuc-->
          <div class="row row-cols-1 row-cols-md-2 g-4" id="post-list">
          <?php 
              require_once __DIR__. '/../../controller/Article_ctr.php';

              $articleCtr = new ArticleController();
              $articles = $articleCtr->getAllArticles();

              if (!empty($articles)) {
                  foreach ($articles as $row) {

                      $id_article = $row['id_article'];
                      $title = htmlspecialchars($row['title']);
                      $date_post = date('d/m/Y', strtotime($row['create_at']));
                      $image = htmlspecialchars($row['image']);
                      $category = htmlspecialchars($row['category']);
                      $click=$row["click"];
                      $link = "articles.php?id=" . $id_article;
                      ?>
                      
                      <div class="col" data-category="<?= $category ?>" data-click="<?= $click ?>">
                          <a href="<?= $link ?>" class="t1 text-decoration-none">
                              <div class="post-card">
                                  <div>
                                      <div class="post-date"><?= $date_post ?></div>
                                      <div class="post-title"><?= $title ?></div>
                                  </div>
                                  <img src="<?= $image ?>" alt="Ảnh bài viết" class="post-img" />
                              </div>
                          </a>
                      </div>

                      <?php
                  }
              } else {
                  echo "<p>Chưa có bài viết nào.</p>";
              }
          ?>
        </div>
        <!-- NÚT HIỂN THỊ THÊM -->
        <div class="load-more-wrapper pb-5">
          <button id="load-more" class="load-more-btn">
            <span class="plus-icon">+</span> Hiển thị thêm
          </button>
        </div>
      </div>
  <?php include('../layout/footer.php'); ?>
    </div>
    <script src="../../../public/scripts/khampha.js"></script>
  </body>
</html>


