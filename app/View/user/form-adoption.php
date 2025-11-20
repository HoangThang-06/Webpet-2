<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Đăng ký nhận nuôi</title>
    <style>
      body {
        background-image: url("https://thumbs.dreamstime.com/b/hand-drawn-cute-spotty-puppy-dog-paw-pink-seamless-vector-pattern-wild-animal-pad-background-fun-joyful-trail-kids-all-175222760.jpg");
      }
      .custom-form {
        background-color: #f3e5f5;
        border-radius: 20px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      }
      .form-label {
        font-weight: bold;
      }
      input[type="range"] {
        accent-color: #6a1b9a;
      }

      input[type="range"]::-webkit-slider-thumb {
        background-color: #6a1b9a;
      }

      input[type="range"]::-webkit-slider-runnable-track {
        background: #d1c4e9;
        height: 6px;
        border-radius: 3px;
      }
      .terms {
        font-size: 1.25rem;
        color: #4a148c;
        font-weight: 500;
        background-color: rgba(255, 255, 255, 0.9);
        padding-left: 40px;
        padding: 30px;
        border-radius: 15px;
      }
    </style>
  </head>
  <body>
    <div class="container my-5">
      <div class="row">
        <div class="col-md-6">
          <div class="p-5 m-4">
            <h2 class="text-danger" style="font-size: 1.8rem; color: #d50000">
              Điều khoản nhận nuôi
            </h2>
            <ul class="mt-3 terms">
              <li>Bạn phải từ 18 tuổi trở lên để được đăng ký nhận nuôi.</li>
              <li>
                Cam kết chăm sóc, nuôi dưỡng động vật trong môi trường an toàn
                và phù hợp.
              </li>
              <li>
                Không sử dụng động vật vào mục đích thương mại, thí nghiệm, hoặc
                vi phạm đạo đức.
              </li>
              <li>
                Cho phép tổ chức đến thăm định kỳ để kiểm tra tình hình chăm sóc
                động vật.
              </li>
              <li>
                Nếu không còn khả năng chăm sóc, bạn cần liên hệ lại với trung
                tâm cứu hộ để được hỗ trợ.
              </li>
            </ul>
            <p class="mt-3 p-3 text-secondary terms">
              Khi bạn tích vào ô "Tôi đồng ý điều khoản đăng ký nhận nuôi", bạn
              đã đọc và đồng ý với các quy định trên.
            </p>
          </div>
        </div>

        <div class="col-md-6">
          <div class="container custom-form p-5 m-4 was-validated">
            <h1 class="text-center text-primary mb-4">Đăng ký nhận nuôi</h1>
            <p class="text-center text-dark">
              Vui lòng điền đầy đủ thông tin để hoàn tất đăng ký nhận nuôi.
            </p>
            <form id="registerForm" class="needs-validation" novalidate>
              <div class="mb-3">
                <label for="name" class="form-label">Tên:</label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Nhập tên"
                  id="name"
                  name="name"
                  required
                />
                <div class="invalid-feedback">Vui lòng nhập tên.</div>
              </div>

              <label for="email" class="form-label"
                >Email (chỉ nhập phần trước @gmail.com):</label
              >
              <div class="input-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="Nhập phần trước email"
                  pattern="^[^@]+$"
                  required
                />
                <span class="input-group-text">@gmail.com</span>
                <div class="invalid-feedback">
                  Vui lòng nhập phần trước email hợp lệ (không chứa @).
                </div>
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại:</label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Nhập số điện thoại"
                  id="phone"
                  name="phone"
                  required
                />
                <div class="invalid-feedback">Vui lòng nhập số điện thoại.</div>
              </div>

              <div class="mb-3">
                <label for="sl" class="form-label">Địa chỉ:</label>
                <select class="form-select" id="sl" name="address" required>
                  <option value="">Chọn địa chỉ...</option>
                  <option>Quận Ngũ Hành Sơn</option>
                  <option>Quận Hải Châu</option>
                  <option>Quận Thanh Khê</option>
                  <option>Quận Sơn Trà</option>
                  <option>Quận Liên Chiểu</option>
                  <option>Quận Cẩm Lệ</option>
                  <option>Huyện Hòa Vang</option>
                  <option>Huyện đảo Hoàng Sa</option>
                </select>
                <div class="invalid-feedback">Vui lòng chọn địa chỉ.</div>
              </div>
              <input type="hidden" id="pet_id_input" name="pet_id" />
              <p>Pet ID: <span id="debug_pet_id"></span></p>
              <div class="mb-4">
                <label for="yearold" class="form-label"
                  >Thu nhập trung bình: <span id="ageValue">1</span> triệu đồng
                </label>
                <input
                  type="range"
                  id="yearold"
                  name="income"
                  step="0.5"
                  min="1"
                  max="100"
                  class="form-range"
                  value="1"
                  required
                  oninput="updateAge(this.value)"
                />
              </div>

              <div class="form-check mb-4">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="myCheck"
                  name="agreeTerms"
                  required
                />
                <label class="form-check-label" for="myCheck"
                  >Tôi đồng ý điều khoản đăng ký nhận nuôi.</label
                >
                <div class="invalid-feedback">Bạn phải đồng ý để tiếp tục.</div>
              </div>

              <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-lg px-5">
                  Đăng ký
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script>
      function updateAge(value) {
        document.getElementById("ageValue").innerText = value;
      }

      const form = document.querySelector("form");

      form.addEventListener("submit", function (e) {
        e.preventDefault();

        form.classList.remove("was-validated");

        if (!form.checkValidity()) {
          form.classList.add("was-validated");
          console.log("Form không hợp lệ, dừng gửi.");
          return;
        }

        const formData = new FormData();
        formData.append("name", document.getElementById("name").value);
        formData.append(
          "email",
          document.getElementById("email").value + "@gmail.com"
        );
        formData.append("phone", document.getElementById("phone").value);
        formData.append("address", document.getElementById("sl").value);
        formData.append("income", document.getElementById("yearold").value);
        formData.append(
          "agree",
          document.getElementById("myCheck").checked ? "true" : ""
        );
        formData.append(
          "pet_id",
          document.getElementById("pet_id_input").value
        );
        console.log("Gửi dữ liệu:", Object.fromEntries(formData.entries()));

        fetch("https://petrescuehub.id.vn/controller/severtest.php", {
          method: "POST",
          body: formData,
        }) //fetch,api,http ,method
          .then((res) => {
            if (!res.ok) {
              throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.text();
          })
          .then((msg) => {
            alert(msg);
            form.reset();
            document.getElementById("ageValue").innerText = "1";
            form.classList.remove("was-validated");
          })
          .catch((err) => {
            alert("Có lỗi xảy ra, vui lòng thử lại.");
            console.error("Lỗi fetch:", err);
          });
      });

      const urlParams = new URLSearchParams(window.location.search);
      const petId = urlParams.get("pet_id");
      document.getElementById("pet_id_input").value = petId;
      console.log("pet_id:", document.getElementById("pet_id_input").value);
    </script>
  </body>
</html>
