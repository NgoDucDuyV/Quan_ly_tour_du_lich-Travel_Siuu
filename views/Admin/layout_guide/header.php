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
                        <button
                            class="bg-[#0000] text-[20px] font-[100] flex items-center justify-center hover:text-indigo-700">
                            <i class="fa-solid fa-bars"></i>
                        </button>

                        <div class="hidden text-black md:flex space-x-8">
                            <a href="#" class="flex items-center text-gray-800 hover:text-indigo-700 ">
                                <i data-lucide="home" class="w-5 h-5 mr-2"></i>
                                <span>Trang Chủ</span>
                            </a>

                            <a href="#" class="flex items-center text-gray-800 hover:text-indigo-700 ">
                                <i data-lucide="file-text" class="w-5 h-5 mr-2"></i>
                                <span>Giới Thiệu</span>
                            </a>

                            <a href="#" class="flex items-center text-gray-800 hover:text-indigo-700 ">
                                <i data-lucide="book-open" class="w-5 h-5 mr-2"></i>
                                <span>Danh Mục</span>
                            </a>
                        </div>
                    </div>

                    <!-- Phải -->
                    <div class="flex items-center space-x-4">

                        <!-- Thông báo -->
                        <div class="relative">
                            <i data-lucide="bell" class="w-6 h-6 text-gray-500"></i>
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                1
                            </span>
                        </div>

                        <!-- Avatar + menu -->
                        <div class="relative group">
                            <div class="flex items-center space-x-3 cursor-pointer select-none">
                                <div class="">
                                    <p class="text-sm font-semibold text-gray-900">
                                        <?= $_SESSION['admin_logged']['username'] ?></p>
                                    <p class="text-xs text-gray-500">(<?= $_SESSION['admin_logged']['description'] ?>)
                                    </p>
                                </div>
                                <img class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm"
                                    src="https://via.placeholder.com/40/007bff/ffffff?text=NDD" alt="Ảnh đại diện">
                            </div>

                            <!-- Menu user -->
                            <div
                                class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 ease-in-out z-50">
                                <ul class="py-2 text-sm text-gray-700 list-none">
                                    <li>
                                        <a href="<?= BASE_URL ?>?mode=admin&act=logout"
                                            onclick="return confirm('Bạn có chắc muốn đăng xuất?')"
                                            class="flex items-center px-4 py-2 hover:bg-gray-100">
                                            <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Đăng Xuất
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
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