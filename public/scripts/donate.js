function showForm(formId) {
  closeForms();
  document.getElementById("overlay").classList.remove("hidden");
  document.getElementById(formId).classList.remove("hidden");
}
function closeForms() {
  document.getElementById("donateForm").classList.add("hidden");   
  document.getElementById("volunteerForm").classList.add("hidden"); 
  document.getElementById("contactForm").classList.add("hidden"); 
  document.getElementById("overlay").classList.add("hidden");      
}
function submitForm(event, formId) {
  event.preventDefault();
  alert("Đăng ký thành công! Chúng tôi sẽ liên hệ lại với bạn.");
  document.getElementById(formId).querySelector("form").reset();
  closeForms();
}
function copyToClipboard(elementId) {
  var copyText = document.getElementById(elementId); 
  var tempInput = document.createElement("input");
  document.body.appendChild(tempInput);
  tempInput.value = copyText.textContent || copyText.innerText;
  tempInput.select();
  document.execCommand("copy");
  document.body.removeChild(tempInput);
  alert("Số tài khoản đã được sao chép: " + tempInput.value);
}
document.addEventListener("DOMContentLoaded", function () {
  let currentPage = window.location.pathname.split("/").pop();
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
