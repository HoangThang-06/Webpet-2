<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        body {
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
        }

        .toggle-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            background: none;
            border: none;
            color: #fff;
            font-size: 22px;
            cursor: pointer;
        }

        .menu {
            width: 230px;
            background: #000;
            height: 100vh;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .menu.hidden {
            display: none;
        }

        .menu h4 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
            padding-left: 20px;
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
        }

        .menu ul li a i {
            margin-right: 10px;
            font-size: 18px;
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

    <button class="toggle-btn" id="toggleBtn">☰</button>

    <div class="menu" id="menu">
        <h4>Chức Năng</h4>
        <ul>
            <li><a href="../admin/home.php"><i class="bi bi-pencil-square"></i>Trang chủ</a></li>
            <li><a href="../admin/manage.php"><i class="bi bi-person-plus-fill"></i>Quản lý người dùng </a></li>
            <li><a href="../admin/manageArticle.php"><i class="bi bi-pencil-square"></i>Quản lý bài báo</a></li>
            <li><a href="../admin/managePet.php"><i class="bi bi-pencil-square"></i>Quản lý Pet</a></li>
            <li><a href="../admin/addArticle.php"><i class="bi bi-trash3-fill"></i>Thêm bài báo</a></li>
            <li><a href="../admin/addPet.php"><i class="bi bi-trash3-fill"></i>Thêm Pet</a></li>
            <li><a href="../admin/acc.php"><i class="bi bi-bar-chart-line-fill"></i>Tài khoản</a></li>
        </ul>
    </div>

    <script>
        document.getElementById("toggleBtn").addEventListener("click", function () {
            document.getElementById("menu").classList.toggle("hidden");
        });
    </script>

</body>
</html>
