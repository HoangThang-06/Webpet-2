<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sidebar Toggle</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

body {
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 240px;
    background: #000;
    min-height: 100vh;
    padding: 20px 15px;
    transition: width 0.3s ease, padding 0.3s ease;
    overflow: hidden;
    position: relative;
}

.sidebar.collapsed {
    width: 70px;
    padding: 20px 5px;
}

/* ===== TOGGLE BUTTON ===== */
.toggle-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    background: none;
    border: none;
    color: #fff;
    font-size: 22px;
    cursor: pointer;
    z-index: 10;
}

/* ===== MENU ===== */
.menu h4 {
    color: #fff;
    margin-bottom: 20px;
    font-size: 20px;
    font-weight: 600;
    transition: opacity 0.3s;
}

.sidebar.collapsed h4 {
    opacity: 0;
}

.menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu ul li {
    margin-bottom: 15px;
}

.menu ul li a {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    background: #7c74f1ff;
    color: #f5f4f4;
    text-decoration: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 500;
    transition: all 0.3s ease;
    overflow: hidden;
    white-space: nowrap;
}

.sidebar.collapsed ul li a {
    justify-content: center;
    padding: 12px 0;
}

.menu ul li a i {
    margin-right: 10px;
    font-size: 18px;
    min-width: 20px;
    text-align: center;
    transition: margin 0.3s;
}

.sidebar.collapsed ul li a i {
    margin: 0;
}

.menu ul li a span {
    transition: opacity 0.3s, width 0.3s;
}

.sidebar.collapsed ul li a span {
    opacity: 0;
    width: 0;
    display: inline-block;
}

.menu ul li a:hover {
    background: #4facfe;
    color: #fff;
    transform: translateX(6px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}
</style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <button class="toggle-btn" id="toggleBtn">☰</button>

    <div class="menu" id="menu">
        <h4>Chức Năng</h4>
        <ul>
            <li><a href="../admin/home.php"><i class="bi bi-pencil-square"></i><span>Trang chủ</span></a></li>
            <li><a href="../admin/manage.php"><i class="bi bi-person-plus-fill"></i><span>Quản lý người dùng</span></a></li>
            <li><a href="../admin/manageArticle.php"><i class="bi bi-pencil-square"></i><span>Quản lý bài báo</span></a></li>
            <li><a href="../admin/managePet.php"><i class="bi bi-pencil-square"></i><span>Quản lý Pet</span></a></li>
            <li><a href="../admin/manageProduct.php"><i class="bi bi-pencil-square"></i><span>Quản lý Product</span></a></li>
            <li><a href="../admin/addArticle.php"><i class="bi bi-trash3-fill"></i><span>Thêm bài báo</span></a></li>
            <li><a href="../admin/addProduct.php"><i class="bi bi-trash3-fill"></i><span>Thêm sản phẩm</span></a></li>
            <li><a href="../admin/addPet.php"><i class="bi bi-trash3-fill"></i><span>Thêm Pet</span></a></li>
            <li><a href="../admin/acc.php"><i class="bi bi-bar-chart-line-fill"></i><span>Tài khoản</span></a></li>
        </ul>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$("#toggleBtn").click(function () {
    $("#sidebar").toggleClass("collapsed");
});
</script>

</body>
</html>
