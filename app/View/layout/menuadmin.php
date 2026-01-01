<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Toggle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../public/css/sidebaradmin.css">
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="toggle-btn" id="toggleBtn">
                <i class="bi bi-list"></i>
            </button>
            <span class="title">Chức năng</span>
        </div>
        <div class="menu">
            <ul>
                <li>
                    <a href="../admin/home.php">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li>
                    <a href="../admin/manage.php">
                        <i class="bi bi-people-fill"></i>
                        <span>Quản lý người dùng</span>
                    </a>
                </li>
                <li class="menu-group">
                    <a href="javascript:void(0)">
                        <i class="bi bi-heart-fill"></i>
                        <span>Pet</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="../admin/managePet.php">Quản lý Pet</a></li>
                        <li><a href="../admin/addPet.php">Thêm Pet</a></li>
                    </ul>
                </li>
                <li class="menu-group">
                    <a href="javascript:void(0)">
                        <i class="bi bi-newspaper"></i>
                        <span>Bài báo</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="../admin/manageArticle.php">Quản lý bài báo</a></li>
                        <li><a href="../admin/addArticle.php">Thêm bài báo</a></li>
                    </ul>
                </li>
                <li class="menu-group">
                    <a href="javascript:void(0)">
                        <i class="bi bi-box-seam-fill"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="../admin/manageProduct.php">Quản lý sản phẩm</a></li>
                        <li><a href="../admin/addProduct.php">Thêm sản phẩm</a></li>
                    </ul>
                </li>

                <li>
                    <a href="../admin/manage_donations.php">
                        <i class="bi bi-cash-coin"></i>
                        <span>Ủng hộ</span>
                    </a>
                </li>

                <li>
                    <a href="../admin/acc.php">
                        <i class="bi bi-person-circle"></i>
                        <span>Tài khoản</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("toggleBtn");
    if (localStorage.getItem("sidebar-collapsed") === "true") {
        sidebar.classList.add("collapsed");
    }
    toggleBtn.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed");

        localStorage.setItem(
            "sidebar-collapsed",
            sidebar.classList.contains("collapsed")
        );
    });
    $(document).ready(function () {
        let currentPage = window.location.pathname.split("/").pop();

        // reset active
        $(".menu a").removeClass("active");

        $(".menu a[href]").each(function () {
            let href = $(this).attr("href");
            if (!href || href === "javascript:void(0)") return;

            let linkPage = href.split("/").pop();

            if (linkPage === currentPage) {
                // active menu con
                $(this).addClass("active");

                // active menu cha nếu có
                $(this).closest(".menu-group").children("a").addClass("active");
            }
        });
    });
</script>
</body>
</html>
