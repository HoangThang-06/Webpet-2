document.addEventListener("DOMContentLoaded", function () {
  function filterProducts() {
    const keyword = document
      .getElementById("search")
      .value.toLowerCase()
      .trim();
    const category = document.getElementById("filterCategory").value;

    document.querySelectorAll(".product-item").forEach((item) => {
      const name = item.dataset.name.toLowerCase();
      const itemCategory = item.dataset.category;

      const matchName = name.includes(keyword);
      const matchCategory = category === "" || itemCategory === category;

      item.style.display = matchName && matchCategory ? "flex" : "none";
    });
  }

  document.getElementById("search").addEventListener("input", filterProducts);
  document
    .getElementById("filterCategory")
    .addEventListener("change", filterProducts);

  /* ===== BIỂU ĐỒ TRÒN CATEGORY ===== */
  const categoryCanvas = document.getElementById("categoryChart");

  if (categoryCanvas) {
    const ctx = categoryCanvas.getContext("2d");

    const labels = window.categoryLabels || [];
    const data = window.categoryCounts || [];

    new Chart(ctx, {
      type: "pie",
      data: {
        labels: labels,
        datasets: [
          {
            data: data,
            backgroundColor: [
              "rgba(75, 192, 192, 0.6)",
              "rgba(255, 159, 64, 0.6)",
              "rgba(153, 102, 255, 0.6)",
              "rgba(255, 99, 132, 0.6)",
            ],
            borderWidth: 1,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: "bottom" },
        },
      },
    });
  }

  /* ===== BIỂU ĐỒ CỘT TOP 3 PRODUCT ===== */
  const topProductCanvas = document.getElementById("topProductChart");

  if (topProductCanvas) {
    const ctx = topProductCanvas.getContext("2d");

    const names = window.topProductNames || [];
    const clicks = window.topProductClicks || [];

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: names,
        datasets: [
          {
            label: "Lượt click",
            data: clicks,
            backgroundColor: "rgba(54, 162, 235, 0.6)",
            borderWidth: 1,
          },
        ],
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true },
        },
        plugins: {
          legend: { display: false },
        },
      },
    });
  }

  // VIEW PRODUCT MODAL
  const viewModal = document.getElementById("viewProductModal");
  const viewClose = viewModal.querySelector(".close");

  document
    .getElementById("productList")
    .addEventListener("click", function (e) {
      const btn = e.target.closest(".btn-view");
      if (!btn) return;

      document.getElementById("modalImage").src = btn.dataset.image;
      document.getElementById("modalName").textContent =
        "Tên sản phẩm: " + btn.dataset.name;
      document.getElementById("modalCategory").textContent =
        "Danh mục: " + btn.dataset.category;
      document.getElementById("modalPrice").textContent =
        "Giá: " + btn.dataset.price;
      document.getElementById("modalQuantity").textContent =
        "Số lượng: " + btn.dataset.quantity;
      document.getElementById("modalDescription").textContent =
        "Mô tả: " + btn.dataset.description;
      document.getElementById("modalClick").textContent =
        "Click: " + btn.dataset.click;
      document.getElementById("modalCreate").textContent =
        "Ngày tạo: " + btn.dataset.create;

      viewModal.style.display = "block";
    });

  viewClose.onclick = () => (viewModal.style.display = "none");
  window.onclick = (e) => {
    if (e.target === viewModal) viewModal.style.display = "none";
  };

  //EDIT PRODUCT MODAL
  const editModal = document.getElementById("editProductModal");
  const closeEdit = document.getElementById("closeEdit");

  let currentProduct = {};

  document
    .getElementById("productList")
    .addEventListener("click", function (e) {
      const btn = e.target.closest(".btn-edit");
      if (!btn) return;

      currentProduct = {
        id_product: btn.dataset.id_product,
        name: btn.dataset.name,
        category: btn.dataset.category,
        price: btn.dataset.price,
        quantity: btn.dataset.quantity,
        description: btn.dataset.description,
        image: btn.dataset.image,
      };

      document.getElementById("editId_product").value =
        currentProduct.id_product;
      document.getElementById("editName").value = currentProduct.name;
      document.getElementById("editCategory").value = currentProduct.category;
      document.getElementById("editPrice").value = currentProduct.price;
      document.getElementById("editQuantity").value = currentProduct.quantity;
      document.getElementById("editDescription").value =
        currentProduct.description;

      editModal.style.display = "block";
    });

  closeEdit.onclick = () => (editModal.style.display = "none");

  //SUBMIT EDIT PRODUCT
  document
    .getElementById("editProductForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData();
      formData.append("id_product", currentProduct.id_product);
      formData.append(
        "name_product",
        document.getElementById("editName").value
      );
      formData.append(
        "category",
        document.getElementById("editCategory").value
      );
      formData.append("price", document.getElementById("editPrice").value);
      formData.append(
        "quantity",
        document.getElementById("editQuantity").value
      );
      formData.append(
        "description",
        document.getElementById("editDescription").value
      );

      const imageFile = document.getElementById("editImage").files[0];

      // luôn gửi ảnh cũ
      formData.append("image_old", currentProduct.image);

      if (imageFile) {
        formData.append("image", imageFile);
      }

      fetch("/Webpet-2/app/controller/ProductAPI.php?action=update", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success) {
            alert("Cập nhật thành công");
            location.reload();
          } else {
            alert(res.message);
          }
        })
        .catch((err) => {
          console.error(err);
          alert("Có lỗi xảy ra");
        });
    });

  //DELETE PRODUCT
  document
    .getElementById("productList")
    .addEventListener("click", function (e) {
      const btn = e.target.closest(".btn-delete");
      if (!btn) return;

      if (!confirm("Bạn có chắc muốn xóa sản phẩm này?")) return;

      const id = btn.dataset.id;
      const image = btn.dataset.image || "";

      fetch("/Webpet-2/app/controller/ProductAPI.php?action=delete", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id_product=${encodeURIComponent(id)}&image=${encodeURIComponent(
          image
        )}`,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success) {
            alert("Xóa thành công");
            location.reload();
          } else {
            alert(res.message);
          }
        })
        .catch((err) => {
          console.error(err);
          alert("Lỗi khi xóa");
        });
    });
});
