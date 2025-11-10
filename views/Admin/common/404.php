<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center min-h-screen">
    <div class="flex flex-col items-center text-center p-6 md:p-12 max-w-lg bg-white rounded-2xl shadow-lg">
        <!-- Số 404 -->
        <h1 class="text-6xl md:text-7xl font-extrabold text-orange-500 mb-4">404</h1>

        <!-- Tiêu đề -->
        <h2 class="text-2xl md:text-3xl font-semibold mb-2 text-gray-800">Trang không tồn tại</h2>

        <!-- Mô tả -->
        <p class="text-gray-600 mb-6 px-4 md:px-0">
            Rất tiếc, chúng tôi không tìm thấy trang bạn đang tìm kiếm trong hệ thống quản lý tour du lịch.
        </p>

        <!-- Nút quay về dashboard -->
        <a href="<?= BASE_URL ?>?mode=admin&act=dashboard"
            class="px-6 py-3 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition-all duration-200">
            Quay về Dashboard
        </a>

        <!-- Hình minh họa -->
        <div class="mt-6 w-full flex justify-center">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png"
                alt="404 icon"
                class="w-32 h-32 md:w-40 md:h-40 opacity-50">
        </div>
    </div>
</body>

</html>