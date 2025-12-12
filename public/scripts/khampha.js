document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".filter-buttons button");
  const postList = document.getElementById("post-list");
  const loadMoreBtn = document.getElementById("load-more");
  let visibleCount = 8;

  let currentPosts = []; // ⭐ Lưu danh sách bài hiện tại

  function getPosts() {
    return Array.from(postList.querySelectorAll(".col"));
  }

  function showPosts(posts) {
    posts.forEach((post, index) => {
      post.style.display = index < visibleCount ? "" : "none";
    });
    loadMoreBtn.style.display = visibleCount >= posts.length ? "none" : "";
  }

  function filterPosts(category) {
    let posts = getPosts();

    if (category === "hot") {
      posts.sort((a, b) => {
        const clickA = parseInt(a.dataset.click) || 0;
        const clickB = parseInt(b.dataset.click) || 0;
        return clickB - clickA;
      });
      posts.forEach((post) => postList.appendChild(post)); // giữ nguyên logic
    } else if (category === "all") {
      posts = getPosts(); // giữ nguyên logic
    } else if (category !== "hot" && category !== "all") {
      posts = posts.filter((post) => post.dataset.category === category);
    }

    // Reset khi chọn filter mới
    visibleCount = 8;

    // Ẩn tất cả
    getPosts().forEach((p) => (p.style.display = "none"));

    // Lưu danh sách bài cho load more
    currentPosts = posts;

    showPosts(posts);
  }

  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      buttons.forEach((btn) => btn.classList.remove("active"));
      this.classList.add("active");
      filterPosts(this.dataset.value);
    });
  });

  // ⭐ Load More KHÔNG gọi filterPosts nữa
  loadMoreBtn.addEventListener("click", () => {
    visibleCount += 4;
    showPosts(currentPosts);
  });

  filterPosts("all");
});
