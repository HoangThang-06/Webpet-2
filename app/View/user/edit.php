<!DOCTYPE html>

<html class="light" lang="vi"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Chỉnh Sửa Hồ Sơ</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#137fec",
              "background-light": "#f6f7f8",
              "background-dark": "#101922",
              "custom-primary": "#005A9C",
              "custom-secondary": "#F8F9FA",
              "custom-text-primary": "#343A40",
              "custom-text-secondary": "#6C757D",
              "custom-success": "#28A745",
              "custom-danger": "#DC3545",
              "custom-border": "#dee2e6"
            },
            fontFamily: {
              "display": ["Manrope", "sans-serif"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
          },
        },
      }
    </script>
<style>
      .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-custom-border bg-white dark:bg-background-dark dark:border-gray-700 px-4 sm:px-6 lg:px-8 py-3">
<div class="flex items-center gap-8">
<div class="flex items-center gap-3 text-custom-text-primary dark:text-white">
<span class="material-symbols-outlined text-custom-primary text-3xl"> local_mall </span>
<h2 class="text-xl font-bold tracking-tight">E-Commerce</h2>
</div>
</div>
<div class="flex flex-1 justify-end items-center gap-4 sm:gap-6">
<nav class="hidden md:flex items-center gap-6">
<a class="text-custom-text-primary dark:text-gray-300 hover:text-custom-primary dark:hover:text-white text-sm font-medium" href="#">Trang chủ</a>
<a class="text-custom-text-primary dark:text-gray-300 hover:text-custom-primary dark:hover:text-white text-sm font-medium" href="#">Sản phẩm</a>
<a class="text-custom-text-primary dark:text-gray-300 hover:text-custom-primary dark:hover:text-white text-sm font-medium" href="#">Khuyến mãi</a>
</nav>
<div class="flex items-center gap-3">
<button class="flex cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 w-10 bg-custom-secondary dark:bg-gray-800 text-custom-text-primary dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">
<span class="material-symbols-outlined text-xl"> favorite </span>
</button>
<button class="flex cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 w-10 bg-custom-secondary dark:bg-gray-800 text-custom-text-primary dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">
<span class="material-symbols-outlined text-xl"> shopping_cart </span>
</button>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" data-alt="User avatar" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCUPWQ86LMqOMcdqxHgPUBs6nslTACKi7fj_lAGyNhlaXkh2P9TSkHCPsAjMqCUCVM7CpS61fmP_ArJJBT7gSoTBFcoPcKbsSOyiGbTLyo91Vi_f6PNC_I8Gv4GGMpNlXd6d-JfuvuUnINPynnVoW75JJxdgwa3zBJXfFkLSSp9AKzWneUhzV0Pw2D0ttq8IOF81vz_pkkv4bR9lbhYBcbBnmyj33Ok-C3Qr8GMCScJR3i2O20V-yNQxVoqLLKikInHJ0bVUep_jMI");'></div>
</div>
</div>
</header>
<main class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<div class="flex flex-col md:flex-row gap-8">
<aside class="w-full md:w-1/4 lg:w-1/5">
<div class="flex h-full flex-col justify-between bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
<div class="flex flex-col gap-4">
<div class="flex items-center gap-3 pb-4 border-b border-custom-border dark:border-gray-700">
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-12" data-alt="User avatar" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAMhj84j3bgUGEMFFsaqoZk2RYl9qjqkLiLme4l1-w9K1x_pBT8Styp8MlrwFtoFz4uKyvFKeFg0ahTmze5BblGmBKp6aKr06jELwvs88zkmNPidlLjnqi4yTI0GEeSBa1rQZ_D2dFVnUf6kIY1W1L_M3-LN43qSdC8I5bTKhRNl0C7cqE3Nn1O5X4_jnh7db-r6crPPueHOD8cMMu6mZKPandS1QsJCXx3rx0HMKTek6TmVR-rF7sDdlKhsCAKM8E9kDDmiXjInoA");'></div>
<div class="flex flex-col">
<h1 class="text-custom-text-primary dark:text-white text-base font-bold leading-normal">Minh Anh</h1>
<p class="text-custom-text-secondary dark:text-gray-400 text-sm font-normal leading-normal">minhanh@email.com</p>
</div>
</div>
<div class="flex flex-col gap-1">
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-custom-primary/10 dark:bg-custom-primary/20 text-custom-primary dark:text-white" href="#">
<span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;"> person </span>
<p class="text-sm font-semibold">Thông tin cá nhân</p>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-custom-text-primary dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" href="#">
<span class="material-symbols-outlined text-xl"> location_on </span>
<p class="text-sm font-medium">Địa chỉ giao hàng</p>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-custom-text-primary dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" href="#">
<span class="material-symbols-outlined text-xl"> lock </span>
<p class="text-sm font-medium">Đổi mật khẩu</p>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-custom-text-primary dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" href="#">
<span class="material-symbols-outlined text-xl"> receipt_long </span>
<p class="text-sm font-medium">Lịch sử đơn hàng</p>
</a>
</div>
</div>
<div class="flex flex-col gap-1 pt-4 mt-4 border-t border-custom-border dark:border-gray-700">
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-custom-text-primary dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" href="#">
<span class="material-symbols-outlined text-xl"> settings </span>
<p class="text-sm font-medium">Cài đặt</p>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-custom-danger hover:bg-custom-danger/10" href="#">
<span class="material-symbols-outlined text-xl"> logout </span>
<p class="text-sm font-medium">Đăng xuất</p>
</a>
</div>
</div>
</aside>
<div class="w-full md:w-3/4 lg:w-4/5">
<div class="flex flex-col gap-8">
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
<div class="flex flex-wrap justify-between items-start gap-3 pb-6 border-b border-custom-border dark:border-gray-700">
<div class="flex min-w-72 flex-col gap-2">
<p class="text-custom-text-primary dark:text-white text-2xl font-bold leading-tight tracking-tight">Chỉnh Sửa Hồ Sơ</p>
<p class="text-custom-text-secondary dark:text-gray-400 text-base font-normal leading-normal">Cập nhật và quản lý chi tiết tài khoản của bạn.</p>
</div>
</div>
<div class="flex flex-col gap-6 pt-6">
<div class="flex w-full flex-col gap-4 sm:flex-row sm:items-center">
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-24 w-24 shrink-0" data-alt="User avatar" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDg2e4oZy_LTe6lJ0E6EFEYkPbMRqFSVf7J0EdgLKUGpsIdOmq7zoBNIDtQrvgiWtB-3dWEGEDVjWQQqOdg0xLTCsLazcH3Zkip2S0u0iO2-yYBtUkEb2thvlFSF7Vvayvw0bHGMasjjWdBjJhvzblE6-rtOnt1roslgHZX58Oq0RsPJEd9Amn69K9b0Mv8lcV_SbrS0PgoKfPXTMWD3ILYMsCZhdj12N7GZL3f0hbPM0y0JsyyH6ai_T3m03ut7JNy3mw-o3M8eU0");'></div>
<div class="flex flex-col">
<p class="text-custom-text-primary dark:text-white text-lg font-bold">Tải ảnh đại diện mới</p>
<p class="text-custom-text-secondary dark:text-gray-400 text-sm">Kích thước đề xuất: 300x300px. Hỗ trợ PNG, JPG.</p>
</div>
<button class="flex sm:ml-auto w-full sm:w-auto items-center justify-center rounded-lg h-10 px-5 bg-custom-secondary dark:bg-gray-700 text-custom-text-primary dark:text-white text-sm font-bold hover:bg-gray-200 dark:hover:bg-gray-600">
<span>Thay đổi</span>
</button>
</div>
<form class="space-y-6">
<div>
<h3 class="text-custom-text-primary dark:text-white text-lg font-bold leading-tight tracking-tight pb-4">Thông tin cơ bản</h3>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
<div>
<label class="block text-sm font-medium text-custom-text-primary dark:text-gray-300 mb-1.5" for="fullName">Họ và tên</label>
<input class="form-input w-full rounded-lg border-custom-border dark:border-gray-600 bg-white dark:bg-gray-700 text-custom-text-primary dark:text-white placeholder:text-gray-400 focus:ring-custom-primary focus:border-custom-primary" id="fullName" placeholder="Nhập họ và tên của bạn" type="text" value="Minh Anh"/>
</div>
<div>
<label class="block text-sm font-medium text-custom-text-primary dark:text-gray-300 mb-1.5" for="username">Tên đăng nhập</label>
<input class="form-input w-full rounded-lg border-custom-border dark:border-gray-600 bg-custom-secondary dark:bg-gray-900/50 text-custom-text-secondary dark:text-gray-400 placeholder:text-gray-400 cursor-not-allowed" disabled="" id="username" type="text" value="minhanh_user"/>
</div>
<div>
<label class="block text-sm font-medium text-custom-text-primary dark:text-gray-300 mb-1.5" for="email">Email</label>
<input class="form-input w-full rounded-lg border-custom-border dark:border-gray-600 bg-white dark:bg-gray-700 text-custom-text-primary dark:text-white placeholder:text-gray-400 focus:ring-custom-primary focus:border-custom-primary" id="email" placeholder="your@email.com" type="email" value="minhanh@email.com"/>
</div>
<div>
<label class="block text-sm font-medium text-custom-text-primary dark:text-gray-300 mb-1.5" for="phone">Số điện thoại</label>
<input class="form-input w-full rounded-lg border-custom-border dark:border-gray-600 bg-white dark:bg-gray-700 text-custom-text-primary dark:text-white placeholder:text-gray-400 focus:ring-custom-primary focus:border-custom-primary" id="phone" placeholder="0123 456 789" type="tel" value="0987 654 321"/>
</div>
</div>
</div>
<div class="flex justify-end gap-3 pt-4 border-t border-custom-border dark:border-gray-700">
<button class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-5 bg-custom-secondary dark:bg-gray-700 text-custom-text-primary dark:text-white text-sm font-bold hover:bg-gray-200 dark:hover:bg-gray-600" type="button">
<span>Hủy</span>
</button>
<button class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-5 bg-custom-primary text-white text-sm font-bold hover:bg-custom-primary/90" type="submit">
<span>Lưu thay đổi</span>
</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</main>
</div>
</body></html>