function openPopup(filename) {
    let imgPath = "../../../public/img/receipts/" + filename;
    document.getElementById("popup-img").src = imgPath;
    document.getElementById("popup").style.display = "flex";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}

function updateStatus(id, status) {
    let actionText="";
    if(status=="approved"){
        actionText="Duyệt";
    }else if(status=="rejected"){
        actionText="Từ chối";
    }
    if(!confirm("Bạn có chắc chắn muốn " + actionText + " giao dịch này?")) return;

    fetch('update_donation_status.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: "id=" + id + "&status=" + status
    })
    .then(res => res.text())
    .then(data => {
        alert(data);
        location.reload();
    });
}