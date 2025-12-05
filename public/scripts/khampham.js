document.addEventListener("DOMContentLoaded", function () {
  const filterInput = document.getElementById("filter-select");
  const buttons = document.querySelectorAll(".filter-buttons button");
  const postList = document.getElementById("post-list");
  const loadMoreBtn = document.getElementById("load-more");
  let visibleCount = 8;

  function getPosts() {
    return Array.from(document.querySelectorAll("#post-list .col"));
  }

  function showPosts() {
    const posts = getPosts();
    posts.forEach((post, index) => {
      if (index < visibleCount) {
        post.style.display = "";
      } else {
        post.style.display = "none";
      }
    });

    if (visibleCount >= posts.length) {
      loadMoreBtn.style.display = "none";
    } else {
      loadMoreBtn.style.display = "";
    }
  }

  function filterPosts(category) {
    const posts = getPosts();
    posts.forEach((post) => {
      if (category === "all" || post.dataset.category === category) {
        post.style.display = "";
      } else {
        post.style.display = "none";
      }
    });
  }

  function sortByClick() {
    const posts = getPosts();

    // Sắp xếp giảm dần theo click
    posts.sort((a, b) => Number(b.dataset.click) - Number(a.dataset.click));

    // Append lại vào DOM
    posts.forEach((post) => postList.appendChild(post));

    // Hiển thị tất cả bài viết
    posts.forEach((post) => (post.style.display = ""));

    // Ẩn nút load more vì đã hiển thị tất cả
    loadMoreBtn.style.display = "none";
  }

  // Gán sự kiện cho các nút filter / nổi bật
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      buttons.forEach((btn) => btn.classList.remove("active"));
      this.classList.add("active");

      const selectedValue = this.getAttribute("data-value");
      filterInput.value = selectedValue;

      if (selectedValue === "nb") {
        sortByClick();
      } else {
        visibleCount = 8; // reset load more
        filterPosts(selectedValue);
        showPosts();
      }
    });
  });

  // Mặc định lọc theo "all"
  filterPosts(filterInput.value || "all");
  showPosts();
});
