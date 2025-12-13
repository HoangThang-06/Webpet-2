document.addEventListener("DOMContentLoaded", function () {
  function filterUsers() {
    let keyword = document.getElementById("search").value.toLowerCase().trim();

    let roleFilter = document.getElementById("filterRole").value;

    document.querySelectorAll(".employee-item").forEach((item) => {
      let username = item.dataset.username.toLowerCase();
      let role = item.dataset.role;

      let matchKeyword = username.includes(keyword);
      let matchRole = roleFilter === "" || role === roleFilter;

      item.style.display = matchKeyword && matchRole ? "flex" : "none";
    });
  }

  document.getElementById("search").addEventListener("input", filterUsers);
  document.getElementById("filterRole").addEventListener("change", filterUsers);

  /* ===== BIỂU ĐỒ CỘT ROLE ===== */
  const ctx = document.getElementById("employeeChart").getContext("2d");
  const adminCount = window.adminCount || 0;
  const userCount = window.userCount || 0;

  new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Admin", "User"],
      datasets: [
        {
          label: "Số lượng",
          data: [adminCount, userCount],
          backgroundColor: [
            "rgba(255, 99, 132, 0.5)",
            "rgba(54, 162, 235, 0.5)",
          ],
          borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)"],
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true },
      },
    },
  });
  /* ===== BIỂU ĐỒ TRÒN STATUS ===== */
  const ctx2 = document.getElementById("statusChart").getContext("2d");
  const approvedCount = window.approvedCount || 0;
  const disapprovedCount = window.disapprovedCount || 0;

  new Chart(ctx2, {
    type: "pie",
    data: {
      labels: ["Approved", "Disapproved"],
      datasets: [
        {
          data: [approvedCount, disapprovedCount],
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

  /* ===== TOGGLE SIDEBAR ===== */
  $("#toggleBtn").click(function () {
    $("#sidebar").toggleClass("collapsed");
  });

  /* ===== XEM CHI TIẾT NGƯỜI DÙNG ===== */
  const employeeList = document.getElementById("employeeList");
  const modal = document.getElementById("viewUserModal");
  const spanClose = modal.querySelector(".close");

  employeeList.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-view");
    if (!btn) return;

    document.getElementById("modalUsername").textContent =
      "Username: " + btn.dataset.username;
    document.getElementById("modalFullname").textContent =
      "Họ tên: " + btn.dataset.fullname;
    document.getElementById("modalPhone").textContent =
      "Số điện thoại: " + btn.dataset.phone;
    document.getElementById("modalBirthday").textContent =
      "Ngày sinh: " + btn.dataset.birthday;
    document.getElementById("modalGender").textContent =
      "Giới tính: " + btn.dataset.gender;
    document.getElementById("modalAddress").textContent =
      "Địa chỉ: " + btn.dataset.address;
    document.getElementById("modalEmail").textContent =
      "Email: " + btn.dataset.email;
    document.getElementById("modalRole").textContent =
      "Quyền: " + btn.dataset.role;
    document.getElementById("modalCreatedAt").textContent =
      "Ngày tạo: " + btn.dataset.createdat;
    document.getElementById("modalStatus").textContent =
      "Trạng thái: " + btn.dataset.status;
    document.getElementById("modalAvatar").src = btn.dataset.avatar;

    modal.style.display = "block";
  });

  window.onclick = function (event) {
    if (event.target == modal) modal.style.display = "none";
  };

  // Đóng modal
  spanClose.onclick = function () {
    modal.style.display = "none";
  };

  // Xóa người dùng
  $(document).on("click", ".btn-delete", function () {
    if (!confirm("Bạn có chắc muốn xóa người dùng này?")) return;

    let id = $(this).data("id");

    $.post(
      "/app/controller/Usercontroller/UserAPI.php?action=delete",
      { id: id },
      function (response) {
        if (response.success) {
          alert("Xóa thành công!");
          location.reload();
        } else {
          alert(response.message);
        }
      },
      "json"
    ).fail(function (xhr) {
      console.log("AJAX ERROR:", xhr.responseText);
    });
  });

  //  update nguoi dung
  var currentData = {};

  $(document).on("click", ".btn-edit", function () {
    currentData = {
      id_user: $(this).data("id_user"),
      username: $(this).data("username"),
      fullname: $(this).data("fullname"),
      phone: $(this).data("phone"),
      birthday: $(this).data("birthday"),
      gender: $(this).data("gender"),
      address: $(this).data("address"),
      email: $(this).data("email"),
      role: $(this).data("role"),
      status: $(this).data("status"),
      avatar: $(this).data("avatar"), // GIỮ avatar cũ nếu không chọn file mới
      password: $(this).data("password") || "",
    };

    // Gán dữ liệu lên form
    $("#editId_user").val(currentData.id_user);
    $("#editUsername").val(currentData.username);
    $("#editFullname").val(currentData.fullname);
    $("#editPhone").val(currentData.phone);
    $("#editBirthday").val(currentData.birthday);
    $("#editGender").val(currentData.gender);
    $("#editAddress").val(currentData.address);
    $("#editEmail").val(currentData.email);
    $("#editRole").val(currentData.role);
    $("#editStatus").val(currentData.status);
    $("#avatar_old").val(currentData.avatar);
    $("#password_old").val(currentData.password);

    $("#editUserModal").show();
  });

  // Đóng modal
  $("#closeEdit").click(function () {
    $("#editUserModal").hide();
  });

  // ==========================
  //   GỬI FORM UPDATE
  // ==========================
  $("#editUserForm").submit(function (e) {
    e.preventDefault();

    let formData = new FormData();

    // Duyệt qua toàn bộ giá trị cũ, nếu trường nào trong form nhập mới thì update
    Object.keys(currentData).forEach((key) => {
      let fieldId = "#edit" + key.charAt(0).toUpperCase() + key.slice(1);

      // Nếu có input tương ứng trong form → lấy giá trị mới
      if ($(fieldId).length && $(fieldId).val() !== "") {
        formData.append(key, $(fieldId).val());
      } else {
        // Không nhập → giữ nguyên giá trị cũ
        formData.append(key, currentData[key]);
      }
    });

    // ==========================
    //  Avatar – giữ avatar cũ nếu không chọn file
    // ==========================
    let avatarFile = $("#editAvatar")[0].files[0];
    if (avatarFile) {
      formData.append("avatar", avatarFile);
    } else {
      formData.append("avatar_old", currentData.avatar); // gửi avatar cũ
    }

    // ==========================
    //  Password – chỉ gửi nếu user nhập password mới
    // ==========================
    let newPass = $("#editPassword").val();
    if (newPass !== "") {
      formData.append("password", newPass);
    }
    // nếu password rỗng → KHÔNG gửi → server giữ password cũ

    // GỬI AJAX TỚI API
    $.ajax({
      url: "/app/controller/Usercontroller/UserAPI.php?action=update",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",

      success: function (res) {
        if (res.success) {
          alert("Cập nhật thành công!");
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
});
