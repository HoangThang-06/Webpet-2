document.addEventListener("DOMContentLoaded", function () {
  let currentPage = window.location.pathname.split("/").pop();

  // Nếu mở từ file trực tiếp hoặc đường dẫn gốc (""), thì mặc định là trang chủ
  if (!currentPage || currentPage === "index.html") {
    currentPage = "trangchu.html";
  }

  document.querySelectorAll(".navbar-nav .nav-link").forEach(function (link) {
    const href = link.getAttribute("href");
    if (href === currentPage) {
      link.classList.add("active");
    } else {
      link.classList.remove("active");
    }
  });
});

const posts = document.querySelectorAll("#post-list .col");
const loadMoreBtn = document.getElementById("load-more");
let visibleCount = 8;

function showPosts() {
  for (let i = 0; i < visibleCount && i < posts.length; i++) {
    posts[i].classList.add("visible");
  }

  if (visibleCount >= posts.length) {
    loadMoreBtn.style.display = "none";
  }
}

showPosts();

loadMoreBtn.addEventListener("click", () => {
  visibleCount += 4; // Hiện thêm 4 bài mỗi lần nhấn
  showPosts();
});

document.addEventListener("DOMContentLoaded", function () {
  const filterInput = document.getElementById("filter-select");
  const buttons = document.querySelectorAll(".filter-buttons button");
  const posts = document.querySelectorAll("#post-list .col");

  // Hàm lọc bài viết
  function filterPosts(category) {
    posts.forEach((post) => {
      const postCategory = post.getAttribute("data-category");
      if (category === "all" || postCategory === category) {
        post.style.display = ""; // Hiện
      } else {
        post.style.display = "none"; // Ẩn
      }
    });
  }

  // Gán sự kiện click cho các nút
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      // Cập nhật class active
      buttons.forEach((btn) => btn.classList.remove("active"));
      this.classList.add("active");

      // Cập nhật giá trị cho input ẩn
      const selectedValue = this.getAttribute("data-value");
      filterInput.value = selectedValue;

      // Gọi hàm lọc
      filterPosts(selectedValue);
    });
  });

  // Mặc định lọc theo "all"
  filterPosts(filterInput.value || "all");
});
