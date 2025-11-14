<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Navbar - Quản Trị Tour</title>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --dark: #1f2937;
            --hover: #4f46e5;
        }

        .text-dark {
            color: var(--dark, #1f2937);
        }
        .text-hover {
            color: var(--hover, #4f46e5);
        }
        
        .font-body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">

    <header class="bg-white font-body shadow-[0_1px_20px_rgba(0,0,0,0.08)] relative z-[1]">
        <nav class="">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex items-center space-x-8">
                        <button class="bg-[#0000] text-dark text-[20px] font-[100] flex items-center justify-center hover:text-hover">
                            <i class="fa-solid fa-bars"></i>
                        </button>

                        <div class="hidden text-dark md:flex space-x-8">
                            <a href="#" class="flex items-center text-gray-800 hover:text-hover ">
                                <i data-lucide="home" class="w-5 h-5 mr-2"></i>
                                <span>Trang Chủ</span>
                            </a>

                            <a href="#" class="flex items-center text-gray-800 hover:text-hover ">
                                <i data-lucide="file-text" class="w-5 h-5 mr-2"></i>
                                <span>Giới Thiệu</span>
                            </a>

                            <a href="#" class="flex items-center text-gray-800 hover:text-hover ">
                                <i data-lucide="book-open" class="w-5 h-5 mr-2"></i>
                                <span>Danh Mục</span>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <?php 
                        // SỬA LỖI: Kiểm tra xem biến session có tồn tại không trước khi truy cập
                        $is_logged_in = isset($_SESSION['admin_logged']);
                        $admin_data = $is_logged_in ? $_SESSION['admin_logged'] : null;

                        // Định nghĩa giá trị mặc định nếu không đăng nhập
                        $fullname = $admin_data['fullname'] ?? 'Khách';
                        $description = $admin_data['description'] ?? 'Chưa đăng nhập';
                        $avatar_path = $admin_data['avatar'] ?? 'default_avatar.jpg'; // Cần một ảnh mặc định
                        $base_url = defined('BASE_URL') ? BASE_URL : '/'; // Giả sử BASE_URL đã định nghĩa
                        ?>

                        <div class="relative">
                            <i data-lucide="bell" class="w-6 h-6 text-gray-500"></i>
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                1
                            </span>
                        </div>

                        <div class="relative group">
                            <div class="flex items-center space-x-3 cursor-pointer select-none">
                                <div class="flex flex-col justify-center text-right">
                                    <h1 class="text-lg m-0 font-bold text-slate-800"><?= $fullname ?></h1>
                                    <p class="text-xs m-0 text-slate-500 tracking-wide">(<?= $description ?>)</p>
                                </div>
                                <img
                                    class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm"
                                    src="<?= $base_url . $avatar_path ?>"
                                    alt="Ảnh đại diện">
                            </div>

                            <div
                                class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 ease-in-out z-50">
                                <ul class="py-2 text-sm text-gray-700 list-none">
                                    <?php if ($is_logged_in): ?>
                                    <li>
                                        <a href="<?= $base_url ?>?mode=admin&act=logout"
                                            onclick="return confirm('Bạn có chắc muốn đăng xuất?')"
                                            class="flex items-center px-4 py-2 hover:bg-gray-100 text-dark">
                                            <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Đăng Xuất
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex items-center px-4 py-2 hover:bg-gray-100 text-dark">
                                            <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Cài Đặt
                                        </a>
                                    </li>
                                    <?php else: ?>
                                    <li>
                                        <a href="<?= $base_url ?>?mode=admin&act=login"
                                            class="flex items-center px-4 py-2 hover:bg-gray-100 text-dark">
                                            <i data-lucide="log-in" class="w-4 h-4 mr-2"></i> Đăng Nhập
                                        </a>
                                    </li>
                                    <?php endif; ?>
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