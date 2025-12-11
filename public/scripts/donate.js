
function openPopup() {
    document.getElementById("donatePopup").style.display = "flex";
}

function closePopup() {
    document.getElementById("donatePopup").style.display = "none";
}

function generateQR() {
    const amount = document.getElementById("amount").value;
    let message = document.getElementById("message").value || "Ung ho cac be";

    if (amount <= 0) {
        alert("Vui lòng nhập số tiền hợp lệ!");
        return;
    }

    const bankCode = "MB";
    const accountNumber = "0001992546284";
    const accountName = "PetRescueHub";

    const qrURL =
        `https://img.vietqr.io/image/${bankCode}-${accountNumber}-compact2.png` +
        `?amount=${encodeURIComponent(amount)}` +
        `&addInfo=${encodeURIComponent(message)}` +
        `&accountName=${encodeURIComponent(accountName)}`;

    document.getElementById("qrImage").src = qrURL;

    // Hiện QR
    document.getElementById("qrResult").style.display = "block";

    // Hiện phần upload ảnh
    document.getElementById("uploadSection").style.display = "block";

    // Gắn dữ liệu vào input ẩn để gửi sang PHP
    document.getElementById("hidden_amount").value = amount;
    document.getElementById("hidden_message").value = message;
}

function confirmTransaction() {
    let file = document.getElementById("receipt").files[0];
    if (!file) {
        alert("⚠️ Vui lòng tải ảnh biên lai lên!");
        return;
    }

    document.getElementById("donateForm").submit();
}
