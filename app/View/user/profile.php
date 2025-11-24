<?php
include('../../controller/dbconnect.php');
//$idUser=$_GET['id_user'];
//test du lieu
$idUser=1;
$sql="SELECT * FROM users WHERE id=$idUser";
$result=$conn->query($sql);
$User=$result->fetch_assoc(); 
?>
<!DOCTYPE html>
<html class="light" lang="vi">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <title>Tài Khoản Người Dùng</title>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link href="https://fonts.googleapis.com" rel="preconnect"/>
        <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
        <style>
            .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24
            }
            a {
                text-decoration: none !important;
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
                },
                borderRadius: {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
                },
                },
            },
            }
        </script>
    </head>
    <body class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200">
        <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
            <div class="layout-container flex h-full grow flex-col">
            <?php include('../layout/menu.php'); ?>
                <main class="flex-1 w-full mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                    <aside class="md:col-span-3">
                        <div class="flex h-full min-h-[700px] flex-col justify-start bg-white dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-3 p-2">
                                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-12" 
                                        data-alt="User avatar" 
                                        style='background-image: url("<?php echo $User['avatar']; ?>");'>
                                    </div>
                                    <div class="flex flex-col">
                                            <h1 class="text-gray-900 dark:text-white text-base font-bold leading-normal"><?php echo $User['fullname']; ?></h1>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm font-normal leading-normal"><?php echo $User['email']; ?></p>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 mt-4">
                                    <div class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/20 cursor-pointer">
                                        <span class="material-symbols-outlined text-primary !font-light" style="font-variation-settings: 'FILL' 1;">person</span>
                                        <p class="text-primary text-sm font-bold leading-normal">Thông tin cá nhân</p>
                                    </div>
                                    <div class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer">
                                        <span class="material-symbols-outlined text-gray-600 dark:text-gray-400 !font-light">receipt_long</span>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Lịch sử đơn hàng</p>
                                    </div>
                                    <div class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer">
                                        <span class="material-symbols-outlined text-gray-600 dark:text-gray-400 !font-light">home</span>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Địa chỉ giao hàng</p>
                                    </div>
                                    <a href="logout.php" class="flex items-center gap-3 px-3 py-2 mt-8 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 cursor-pointer">
                                        <span class="material-symbols-outlined text-red-500 !font-light">logout</span>
                                        <p class="text-red-500 text-sm font-medium leading-normal">Đăng xuất</p>
                                    </a>
                            </div>
                            </div>
                        </div>
                    </aside>
                    <!-- Content Area -->
                    <div class="md:col-span-9 space-y-8">
                        <!-- Personal Information Section -->
                        <section class="bg-white dark:bg-gray-900/50 p-6 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        <!-- PageHeading -->
                        <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
                            <p class="text-gray-900 dark:text-white text-2xl font-bold tracking-tight">Thông tin cá nhân</p>
                            <!-- SingleButton -->
                            <a href="edit-profile.php?idUser=<?php echo $idUser; ?>" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white gap-2 pl-3 text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
                                <span class="material-symbols-outlined !text-xl">edit</span>
                                <span class="truncate">Chỉnh sửa</span>
                            </a>
                        </div>
                        <!-- DescriptionList -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                            <div class="flex flex-col gap-1 border-t border-solid border-gray-200 dark:border-gray-700 py-4 pr-2">
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-normal leading-normal">Họ và tên</p>
                                <p class="text-gray-800 dark:text-gray-200 text-base font-medium leading-normal"><?php echo $User['fullname']; ?></p>
                            </div>
                            <div class="flex flex-col gap-1 border-t border-solid border-gray-200 dark:border-gray-700 py-4 pl-0 md:pl-2">
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-normal leading-normal">Địa chỉ Email</p>
                                <p class="text-gray-800 dark:text-gray-200 text-base font-medium leading-normal"><?php echo $User['email']; ?></p>
                            </div>
                            <div class="flex flex-col gap-1 border-t border-solid border-gray-200 dark:border-gray-700 py-4 pr-2 col-span-1 md:col-span-2 md:pr-[50%]">
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-normal leading-normal">Địa chỉ </p>
                                <p class="text-gray-800 dark:text-gray-200 text-base font-medium leading-normal"><?php echo $User['address']; ?></p>
                            </div>
                        </div>
                        </section>
                    </div>
                </div>
                </main>
            </div>
        </div>
    </body>
</html>