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
    const t = Date.now();
    const qrURL =
        `https://img.vietqr.io/image/${bankCode}-${accountNumber}-compact2.png` +
        `?amount=${encodeURIComponent(amount)}` +
        `&addInfo=${encodeURIComponent(message)}` +
        `&accountName=${encodeURIComponent(accountName)}` +
        `&t=${t}`;
    document.getElementById("qrImage").src = qrURL;
    document.getElementById("qrResult").style.display = "block";
    document.getElementById("uploadSection").style.display = "block";
    document.getElementById("hidden_amount").value = amount;
    document.getElementById("hidden_message").value = message;
    document.getElementById("amount").style.display = "none";
    document.getElementById("message").style.display = "none";
    document.getElementById("warning").style.display = "none";
    document.getElementById("generateBtn").style.display = "none"; 
}
function confirmTransaction() {
    let file = document.getElementById("receipt").files[0];
    if (!file) {
        alert("⚠️ Vui lòng tải ảnh biên lai lên!");
        return;
    }

    document.getElementById("donateForm").submit();
}
