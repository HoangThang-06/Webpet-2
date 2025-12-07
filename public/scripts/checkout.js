// Lấy phương thức thanh toán
document.querySelectorAll("input[name='payment']").forEach(item => {
    item.addEventListener("change", function() {
        document.getElementById("payment_method").value = this.value;
    });
});
// Lấy mô tả đơn hàng
document.querySelector("textarea").addEventListener("input", function() {
    document.getElementById("description").value = this.value;
});
// Bắt lỗi chưa chọn phương thức thanh toán
document.getElementById("orderForm").addEventListener("submit", function(e) {
    if (!document.getElementById("payment_method").value) {
        alert("Vui lòng chọn phương thức thanh toán!");
        e.preventDefault();
    }
});
