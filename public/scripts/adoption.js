// Ánh xạ data-tab sang category dùng trong backend
const categoryMapping = {
  1: "", // Tất cả
  2: "dog", // Chó
  3: "cat", // Mèo
  4: "other", // Khác
};

// Biến toàn cục lưu trạng thái hiện tại
let currentPage = 1;
let currentCategory = "";
let currentSearchTerm = "";

// Hàm load dữ liệu thú cưng (category, page, searchTerm)
function loadPets(category, page = 1, searchTerm = "") {
  currentPage = page;
  currentCategory = category;
  currentSearchTerm = searchTerm;

  // Tạo URL API với các tham số category và searchTerm
  let url = "https://petrescuehub.id.vn/controller/severtest.php?page=" + page;
  if (category) {
    url += "&category=" + encodeURIComponent(category);
  }
  if (searchTerm) {
    url += "&search=" + encodeURIComponent(searchTerm);
  }

  fetch(url)
    .then((response) => {
      if (!response.ok) throw new Error("HTTP status " + response.status);
      return response.text();
    })
    .then((html) => {
      document.getElementById("pets-container").innerHTML = html;

      // Cập nhật active cho nút phân trang (nếu có)
      document.querySelectorAll(".page-btn").forEach((btn) => {
        const pageValue = btn.innerText.trim();
        btn.classList.remove("active");
        if (!isNaN(pageValue) && parseInt(pageValue) === currentPage) {
          btn.classList.add("active");
        }
      });
    })
    .catch((error) => {
      console.error("Chi tiết lỗi:", error);
      document.getElementById("pets-container").innerHTML =
        "<p>Lỗi tải dữ liệu thú cưng.</p>";
    });
}

// Gán sự kiện click cho các nút filter
document.querySelectorAll(".filter-btn").forEach((btn) => {
  btn.addEventListener("click", function () {
    // Cập nhật UI filter active
    document
      .querySelectorAll(".filter-btn")
      .forEach((b) => b.classList.remove("active"));
    this.classList.add("active");

    // Lấy category từ data-tab
    const tab = this.getAttribute("data-tab");
    const category = categoryMapping[tab] || "";

    // Khi đổi category thì reset searchTerm về rỗng, cập nhật input tìm kiếm UI
    currentSearchTerm = "";
    const searchInput = document.getElementById("search-input");
    if (searchInput) searchInput.value = "";

    // Load thú cưng theo category (trang 1)
    loadPets(category, 1, currentSearchTerm);
  });
});

// Thêm sự kiện input cho ô tìm kiếm với debounce
const searchInput = document.getElementById("search-input");
if (searchInput) {
  let debounceTimeout = null;
  searchInput.addEventListener("input", function () {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
      const term = this.value.trim();
      currentSearchTerm = term;
      // Khi tìm kiếm thay đổi, reset trang về 1, giữ nguyên category hiện tại
      loadPets(currentCategory, 1, currentSearchTerm);
    }, 300); // Trì hoãn 300ms trước khi gọi API
  });
}

// Hàm phân trang
function changePage(page) {
  if (page === "prev") {
    if (currentPage > 1) {
      loadPets(currentCategory, currentPage - 1, currentSearchTerm);
    }
  } else if (page === "next") {
    loadPets(currentCategory, currentPage + 1, currentSearchTerm);
  } else if (typeof page === "number") {
    loadPets(currentCategory, page, currentSearchTerm);
  }
}

// Load tất cả thú cưng ban đầu khi trang được tải
window.onload = function () {
  loadPets("", 1, "");
};

// Giữ giá trị pet_id nếu có trên URL
const params = new URLSearchParams(window.location.search);
const petId = params.get("pet_id");
if (petId) {
  const petInput = document.getElementById("pet_id_input");
  if (petInput) petInput.value = petId;
}
