<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Navbar - Quản Trị Tour</title>
</head>

<body class="bg-gray-100">

    <header class="bg-white font-body shadow-[0_1px_20px_rgba(0,0,0,0.08)] relative z-[1]">
        <nav class="">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Trái -->
                    <div class="flex items-center space-x-8">
                        <button id="toggleButtonId" onclick="toggleSidebar('sidebarHDV')" class="bg-[#0000] text-dark text-[20px] font-[100] flex items-center justify-center hover:text-hover scale-[1.2] active:scale-[1] transition-all duration-200 ease-out ">
                            <i class="fa-solid fa-bars"></i>
                        </button>

                        <div class="hidden text-black md:flex space-x-8
                        [$_a]:text-dark">
                            <a href="?mode=admin&act=homeguide" class="flex items-center text-gray-800 hover:text-hover ">
                                <i data-lucide="home" class="w-5 h-5 mr-2"></i>
                                <span>Trang Chủ</span>
                            </a>

                            <a href="?mode=admin&act=aboutguide" class="flex items-center text-gray-800 hover:text-hover ">
                                <i data-lucide="file-text" class="w-5 h-5 mr-2"></i>
                                <span>Giới Thiệu</span>
                            </a>

                            <a href="?mode=admin&act=scheduleguide" class="flex items-center text-gray-800 hover:text-hover ">
                                <i data-lucide="book-open" class="w-5 h-5 mr-2"></i>
                                <span>Danh Mục</span>
                            </a>
                        </div>
                    </div>

                    <?php
                    $dataguide = (new GuideTourModel)->getGuideUserid($_SESSION['admin_logged']['id'] ?? 0);

                    // Bảo vệ: nếu không có dữ liệu HDV thì ẩn nút hoặc không link
                    $guideId = $dataguide['id'] ?? 0;
                    $hasNotification = true; // Bạn có thể thay bằng logic đếm tin nhắn chưa đọc
                    $notificationCount = 1;  // Có thể lấy từ DB: số tin nhắn chưa đọc
                    ?>
                    <!-- Phải -->
                    <div class="flex items-center space-x-4">
                        <!-- Nút chuông thông báo – đẹp, bấm được, badge nổi bật -->
                        <div class="relative">
                            <a href="?mode=admin&act=mesageguide&guide_id=<?= $dataguide['id'] ?>"
                                class="relative flex items-center justify-center size-12 rounded-xl bg-gray-100 hover:bg-gray-200 hover:shadow-md transition-all duration-200 group focus:outline-none focus:ring-4 focus:ring-blue-100">
                                <i data-lucide="bell" class="w-6 h-6 text-gray-700 group-hover:text-gray-900 transition"></i>
                                <span class="absolute -top-1 -right-1 flex items-center justify-center size-6 text-xs font-bold text-white bg-red-600 rounded-full ring-4 ring-white shadow-lg animate-pulse">
                                    1
                                </span>
                            </a>
                        </div>

                        <!-- Avatar + menu -->
                        <div class="relative group">
                            <div class="flex items-center space-x-3 cursor-pointer select-none">
                                <div class="flex flex-col justify-center">
                                    <h1 class="text-lg m-0 font-bold text-slate-800"><?= $_SESSION['admin_logged']['fullname'] ?></h1>
                                    <p class="text-xs m-0 text-slate-500 tracking-wide">(<?= $_SESSION['admin_logged']['description'] ?>)</p>
                                </div>
                                <img
                                    class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm"
                                    src="<?= BASE_URL . $_SESSION['admin_logged']['avatar'] ?>"
                                    alt="Ảnh đại diện">
                            </div>

                            <!-- Menu user -->
                            <div
                                class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 ease-in-out z-50">
                                <ul class="py-2 text-sm text-gray-700 list-none
                                [&_li_a]:text-dark">
                                    <li>
                                        <a href="<?= BASE_URL ?>?mode=admin&act=logout"
                                            onclick="return confirm('Bạn có chắc muốn đăng xuất?')"
                                            class="flex items-center px-4 py-2 hover:bg-gray-100">
                                            <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Đăng Xuất
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center px-4 py-2 hover:bg-gray-100">
                                            <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Cài Đặt
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </nav>
    </header>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>