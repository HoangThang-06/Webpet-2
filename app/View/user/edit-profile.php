<?php
include('../../controller/dbconnect.php');
$idUser=$_GET['idUser'];
$sql = "SELECT * FROM users WHERE id = $idUser";
$result = $conn->query($sql);
$User = $result->fetch_assoc();

if(isset($_POST['update_profile'])) {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $avatar = $User['avatar']; // giữ mặc định nếu không upload
   if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0){
        $fileName = time().'_'.basename($_FILES['avatar']['name']);
        $targetFile = '../../public/img/avatars/' . $fileName;

        if(move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)){
            $avatar = '/public/img/avatars/' . $fileName;
        }
    }
    $sqlUpdate = "UPDATE users SET fullname='$fullname', email='$email', address='$address', avatar='$avatar' WHERE id=$idUser";
    if($conn->query($sqlUpdate)){
        header("Location: profile.php");
        exit;
    } else {
        $error = "Cập nhật thất bại: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="vi" class="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chỉnh sửa hồ sơ</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<style>
    body {
        background-image: url('../../../public/img/backfroundprofile.jpg');
        background-repeat: no-repeat;    
        background-size: cover;          
        background-position: center center;
        background-attachment: fixed; 
    }

    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24;
    }
</style>
<script>
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "primary": "#137fec",
        "background-light": "#f6f7f8",
        "background-dark": "#101922",
      },
      fontFamily: {
        "display": ["Manrope", "sans-serif"]
      }
    }
  }
}
function togglePassword() {
    const pw = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    if(pw.type === "password"){
        pw.type = "text";
        icon.textContent = "visibility_off";
    } else {
        pw.type = "password";
        icon.textContent = "visibility";
    }
}
</script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-display text-gray-800 dark:text-gray-200">
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
        <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Chỉnh sửa hồ sơ</h1>

        <form action="" method="post" enctype="multipart/form-data" class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-center gap-6">
                <div class="relative w-32 h-32 rounded-full overflow-hidden border-2 border-gray-300 dark:border-gray-600">
                    <img src="<?php echo $User['avatar']; ?>" alt="Avatar" class="w-full h-full object-cover">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Đổi ảnh đại diện</label>
                    <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-600 file:text-white
                        hover:file:bg-blue-700 cursor-pointer">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Họ và tên</label>
                <input type="text" name="fullname" value="<?php echo $User['fullname']; ?>" required
                       class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-200 shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>
            <div class="relative w-full">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                <input id="password" type="password" name="password" value="<?php echo $User['password']; ?>" required
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-200 shadow-sm px-4 py-2 pr-10 focus:ring-blue-500 focus:border-blue-500 transition-all">
                <button type="button" onclick="togglePassword()"
                        class="absolute right-2 top-1/2 transform -translate-y-1/6 text-gray-500 dark:text-gray-300">
                    <span class="material-symbols-outlined" id="toggleIcon">visibility</span>
                </button>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" name="email" value="<?php echo $User['email']; ?>" required
                       class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-200 shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Địa chỉ</label>
                <input type="text" name="address" value="<?php echo $User['address']; ?>" 
                       class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-200 shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>

            <div class="flex justify-end">
                <button type="submit" name="update_profile" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-md transition-all font-semibold">
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
