document.addEventListener("DOMContentLoaded", function () {
  function filterPets() {
    let keyword = document.getElementById("search").value.toLowerCase().trim();
    let stateFilter = document.getElementById("filterRole").value.toLowerCase();

    document.querySelectorAll(".pet-item").forEach((item) => {
      let petName = item.querySelector(".pet-name").textContent.toLowerCase();
      let petState = item.dataset.state.toLowerCase();

      let matchKeyword = petName.includes(keyword);
      let matchState = stateFilter === "" || petState === stateFilter;

      item.classList.toggle("pet-hidden", !(matchKeyword && matchState));
    });
  }

  document.getElementById("search").addEventListener("input", filterPets);
  document.getElementById("filterRole").addEventListener("change", filterPets);

  /* ===== BIỂU ĐỒ TRÒN PET STATUS ===== */
  const petStatusCanvas = document.getElementById("petStatusChart");

  if (petStatusCanvas) {
    const ctxPet = petStatusCanvas.getContext("2d");

    const availableCount = window.availableCount || 0;
    const reservedCount = window.reservedCount || 0;

    new Chart(ctxPet, {
      type: "pie",
      data: {
        labels: ["Available", "Reserved"],
        datasets: [
          {
            data: [availableCount, reservedCount],
            backgroundColor: [
              "rgba(75, 192, 192, 0.6)",
              "rgba(255, 159, 64, 0.6)",
            ],
            borderColor: ["rgba(75, 192, 192, 1)", "rgba(255, 159, 64, 1)"],
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

  /* ===== BIỂU ĐỒ TOP 3 PET ===== */
  const topPetsCanvas = document.getElementById("topPetsChart");

  if (topPetsCanvas) {
    const ctxTop = topPetsCanvas.getContext("2d");

    const topPetNames = window.topPetNames || [];
    const topPetClicks = window.topPetClicks || [];

    new Chart(ctxTop, {
      type: "bar",
      data: {
        labels: topPetNames,
        datasets: [
          {
            label: "Lượt xem",
            data: topPetClicks,
            backgroundColor: "rgba(54, 162, 235, 0.5)",
            borderColor: "rgba(54, 162, 235, 1)",
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
          legend: {
            display: false,
          },
        },
      },
    });
  }

  // ===== Lọc theo select =====
  $("#filterState").on("change", function () {
    const state = $(this).val();
    renderPetStatusChart(state);
    renderTopPetsChart(state);
  });

  /* ===== TOGGLE SIDEBAR ===== */
  $("#toggleBtn").click(function () {
    $("#sidebar").toggleClass("collapsed");
  });

  /* ===== XEM CHI TIẾT PET ===== */
  const petList = document.getElementById("petList");
  const petModal = document.getElementById("viewPetModal");
  const closePetModal = document.getElementById("closeView");

  petList.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-view");
    if (!btn) return;

    const petItem = btn.closest(".pet-item");

    // Lấy dữ liệu từ DOM
    const name = petItem.querySelector(".pet-name").textContent;
    const gender = petItem
      .querySelector(".pet-info p:nth-child(2)")
      .textContent.replace("Giới tính:", "")
      .trim();
    const state = petItem
      .querySelector(".pet-info p:nth-child(3)")
      .textContent.replace("Trạng thái:", "")
      .trim();
    const click = petItem
      .querySelector(".pet-info p:nth-child(4)")
      .textContent.replace("Lượt xem:", "")
      .trim();

    const description = petItem.dataset.description || "Không có mô tả";
    const image = petItem.querySelector("img").src;

    // Gán dữ liệu vào modal
    document.getElementById("viewName").textContent = name;
    document.getElementById("viewGender").textContent = gender;
    document.getElementById("viewState").textContent = state;
    document.getElementById("viewClick").textContent = click;
    document.getElementById("viewDescription").textContent = description;
    document.getElementById("viewImage").src = image;

    petModal.style.display = "block";
  });

  // Đóng modal khi click X
  closePetModal.onclick = function () {
    petModal.style.display = "none";
  };

  // Đóng modal khi click ra ngoài
  window.onclick = function (event) {
    if (event.target === petModal) {
      petModal.style.display = "none";
    }
  };

  // XÓA PET
  $(document).on("click", ".btn-delete", function () {
    if (!confirm("Bạn có chắc muốn xóa pet này?")) return;

    let id = $(this).data("id");
    let image = $(this).data("image"); // đường dẫn ảnh

    $.ajax({
      url: "/app/controller/PetAPI.php?action=delete",
      type: "POST",
      dataType: "json",
      data: {
        id: id,
        image: image,
      },
      success: function (res) {
        if (res.success) {
          alert("Xóa pet thành công!");
          location.reload();
        } else {
          alert(res.message);
        }
      },
      error: function (xhr) {
        console.log("AJAX ERROR:", xhr.responseText);
        alert("Có lỗi xảy ra!");
      },
    });
  });

  var currentPet = {};

  $(document).on("click", ".btn-edit", function () {
    currentPet = {
      id_pet: $(this).data("id"),
      name_pet: $(this).data("name"),
      gender: $(this).data("gender"),
      state: $(this).data("state"),
      description: $(this).data("description"),
      image: $(this).data("image"),
    };

    // GÁN DỮ LIỆU CŨ
    $("#editIdPet").val(currentPet.id_pet);
    $("#editName").val(currentPet.name_pet);
    $("#editGender").val(currentPet.gender);
    $("#editState").val(currentPet.state);
    $("#editDescription").val(currentPet.description);

    $("#currentImage").attr("src", currentPet.image);

    $("#editPetModal").show();
  });

  // Đóng modal
  $("#closeEditPet").click(function () {
    $("#editPetModal").hide();
  });

  // SUBMIT
  $("#editPetForm").submit(function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    // gửi ảnh cũ để controller biết mà xóa
    formData.append("image_old", currentPet.image);

    $.ajax({
      url: "/app/controller/PetAPI.php?action=update",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",

      success: function (res) {
        if (res.success) {
          alert("Cập nhật pet thành công!");
          location.reload();
        } else {
          alert(res.message || "Cập nhật thất bại!");
        }
      },

      error: function (xhr) {
        console.log(xhr.responseText);
        alert("Có lỗi xảy ra!");
      },
    });
  });
});
