document.addEventListener("DOMContentLoaded", function () {
  $(document).ready(function () {
    function filterArticles() {
      let cate = $("#filterCategory").val();

      $(".employee-item").each(function () {
        let itemCate = $(this).data("category");

        let matchCate = cate === "" || itemCate === cate;

        $(this).toggle(matchCate);
      });
    }

    $("#filterCategory").on("change", filterArticles);
  });

  /* ===== BIỂU ĐỒ CỘT ROLE ===== */
  const ctx = document.getElementById("clickChart");

  new Chart(ctx, {
    type: "bar",
    data: {
      labels: clickLabels, // 1 → 12
      datasets: [
        {
          label: "Lượt click theo tháng",
          data: clickData,
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        x: {
          title: { display: true, text: "Tháng" },
        },
        y: {
          beginAtZero: true,
          title: { display: true, text: "Số lượt click" },
        },
      },
    },
  });

  /* ===== BIỂU ĐỒ TRÒN STATUS ===== */
  const ctxPie = document.getElementById("categoryChart");

  new Chart(ctxPie, {
    type: "pie",
    data: {
      labels: ["Chó và mèo", "Khác"],
      datasets: [
        {
          data: [cmCount, kCount],
          backgroundColor: ["#0d6efd", "#dc3545"],
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: "bottom",
        },
      },
    },
  });

  // Xử lý nút Xóa bài báo
  $(document).on("click", ".btn-delete", function () {
    if (!confirm("Bạn có chắc chắn muốn xóa bài báo này không?")) return;

    var articleId = $(this).data("id");

    $.post(
      "/app/controller/ArticleAPI.php",
      { action: "delete", id: articleId },
      function (response) {
        alert(response.message);
        if (response.success) {
          $(`.btn-delete[data-id='${articleId}']`)
            .closest(".employee-item")
            .remove();
        }
      },
      "json"
    );
  });
  //xem bai bao
  $(document).on("click", ".btn-view", function () {
    var parent = $(this).closest(".employee-item");

    var title = parent.find(".article-title").text();
    var date = parent.find(".info-item").eq(0).text();
    var category = parent.find(".info-item").eq(1).text();
    var click = parent.find(".info-item").eq(2).text();
    var content = parent.data("content");
    var image = parent.find("img.employee-avatar").attr("src");

    $("#viewTitle").text(title);
    $("#viewDate").text(date);
    $("#viewCategory").text(category);
    $("#viewClick").text(click);
    $("#viewImage").attr("src", image);

    // Kiểm tra nếu content là file .txt hoặc .html
    if (content.match(/\.(txt|html)$/i)) {
      // hiện nút đọc file
      $("#readFileBtn").show().attr("href", content);
      $("#viewContent").html(
        "<em>Nội dung bài báo được lưu trong file. Nhấn 'Đọc file' để xem.</em>"
      );
    } else {
      $("#readFileBtn").hide();
      $("#viewContent").html(content); // hiển thị trực tiếp
    }

    $("#viewArticleModal").show();
  });

  // Đóng modal
  $("#closeView").click(function () {
    $("#viewArticleModal").hide();
    $("#viewContent").html("");
    $("#readFileBtn").hide();
  });

  var currentArticleData = {};

  // Khi click nút Sửa
  $(document).on("click", ".btn-edit", function () {
    var parent = $(this).closest(".employee-item");

    currentArticleData = {
      id_article: $(this).data("id"),
      title: parent.find(".article-title").data("title"),
      category: parent.data("category"),
      image: parent.find("img.employee-avatar").attr("src"), // public URL hiện tại
    };

    console.log("========== CLICK EDIT DEBUG ==========");
    console.log(currentArticleData);

    $("#editIdArticle").val(currentArticleData.id_article);
    $("#editTitle").val(currentArticleData.title);
    $("#editCategory").val(
      currentArticleData.category === "Chó mèo" ? "cm" : "k"
    );
    $("#currentImage").attr("src", currentArticleData.image);

    $("#editArticleModal").show();
  });

  // Đóng modal
  $("#closeEditArticle").click(function () {
    $("#editArticleModal").hide();
  });

  // Submit form
  $("#editArticleForm").submit(function (e) {
    e.preventDefault();

    var formData = new FormData();

    // Lấy dữ liệu mới từ form, nếu rỗng thì giữ dữ liệu cũ
    var newTitle = $("#editTitle").val();
    var newCategory = $("#editCategory").val();

    formData.append("id_article", currentArticleData.id_article);
    formData.append(
      "title",
      newTitle !== "" ? newTitle : currentArticleData.title
    );
    formData.append(
      "category",
      newCategory !== "" ? newCategory : currentArticleData.category
    );

    // Nếu user chọn file mới thì thêm vào FormData, nếu không thì giữ file cũ
    var newFile = $("#editConten")[0].files[0];
    if (newFile) formData.append("conten", newFile);

    var newImage = $("#editImage")[0].files[0];
    if (newImage) formData.append("image", newImage);
    else formData.append("image_old", currentArticleData.image); // gửi image cũ nếu không đổi
    formData.append("action", "update");

    $.ajax({
      url: "/app/controller/ArticleAPI.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        alert(response.message);
        if (response.success) location.reload();
      },
    });
  });
});
