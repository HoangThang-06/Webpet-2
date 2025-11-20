<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Content-Type: text/html; charset=utf-8");

$servername = "localhost";
$username = "hff81ef291_demo";
$password = "8ka4M2QLz5wwm2d26AAE";
$database = "hff81ef291_demo";

$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    http_response_code(500);
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý đăng ký nhận nuôi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $address = $_POST["address"] ?? "";
    $income = $_POST["income"] ?? 0;
    $agree_terms = (isset($_POST["agree"]) && $_POST["agree"] === "true") ? 1 : 0;
    $pet_id = isset($_POST["pet_id"]) ? (int)$_POST["pet_id"] : null;

    $sql = "INSERT INTO adopters (name, email, phone, address, income, agree_terms, pet_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        die("Lỗi prepare: " . $conn->error);
    }
    $stmt->bind_param("sssdsii", $name, $email, $phone, $address, $income, $agree_terms, $pet_id);
    if ($stmt->execute()) {
        echo "Đăng ký nhận nuôi thành công!";
    } else {
        http_response_code(500);
        echo "Lỗi khi lưu dữ liệu: " . $stmt->error;
    }
    $stmt->close();
}
else {
    // Xử lý GET danh sách thú cưng có lọc và phân trang + tìm kiếm
    $category = $_GET['category'] ?? '';
    $search = $_GET['search'] ?? '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Xây dựng câu truy vấn động dựa trên category và search
    $params = [];
    $types = "";
    $sql = "SELECT id, name, gender, age, category, image_url FROM pets";

    $conditions = [];
    if (!empty($category)) {
        $conditions[] = "category = ?";
        $types .= "s";
        $params[] = $category;
    }
    if (!empty($search)) {
    $conditions[] = "name LIKE ?";
    $types .= "s";
    $params[] = $search . "%"; 
    }
    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $sql .= " LIMIT ? OFFSET ?";

    $types .= "ii";
    $params[] = $limit;
    $params[] = $offset;

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        die("Lỗi prepare: " . $conn->error);
    }

    // Sử dụng call_user_func_array để bind param động
    // Vì bind_param yêu cầu tham số truyền theo tham chiếu, ta làm thế này:
    $bind_names[] = $types;
    for ($i=0; $i<count($params); $i++) {
        $bind_name = 'bind' . $i;
        $$bind_name = $params[$i];
        $bind_names[] = &$$bind_name;
    }
    call_user_func_array([$stmt, 'bind_param'], $bind_names);

    $stmt->execute();
    $result = $stmt->get_result();

    echo '<div class="pets-list page-' . $page . '">';
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = htmlspecialchars($row["id"]);
            $name = htmlspecialchars($row["name"]);
            $gender = htmlspecialchars($row["gender"]);
            $age = htmlspecialchars($row["age"]);
            $category = htmlspecialchars($row["category"]);
            $image_url = htmlspecialchars($row["image_url"]);

            echo '<div class="pet-item ' . $category . '">';
            echo '<img src="' . $image_url . '" alt="' . $name . '" />';
            echo '<div class="info">';
            echo '<strong>' . $name . '</strong><br />';
            echo 'Giới tính: ' . $gender . '<br />';
            echo 'Tuổi: ' . $age . '<br />';
            echo '<a href="form-adoption.html?pet_id=' . $id . '" class="adopt-btn" target="_blank">Nhận nuôi</a>';
            echo '</div></div>';
        }
    } else {
        echo '<p>Không có thú cưng nào phù hợp.</p>';
    }
    echo '</div>';

    $stmt->close();
}

$conn->close();
?>
