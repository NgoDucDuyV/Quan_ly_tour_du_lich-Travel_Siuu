<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
</head>

<body>
    <div class=" p-8 md:p-10 max-w-md w-full text-center m-auto">

        <div class="flex justify-center mb-6">
            <img
                src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png"
                alt="404 icon"
                class="w-28 h-28 md:w-36 md:h-36 opacity-70">
        </div>
        <h1 class="text-6xl md:text-7xl font-extrabold text-main mb-2">404</h1>
        <h2 class="text-2xl md:text-3xl font-semibold mb-3 text-gray-800 font-title">
            Trang không tồn tại
        </h2>
        <p class="text-gray-600 mb-8 leading-relaxed">
            Rất tiếc, chúng tôi không tìm thấy trang bạn đang truy cập trong hệ thống quản lý tour du lịch.
        </p>
        <a href="<?= BASE_URL ?>?mode=admin&act=/"
            class="inline-block px-6 py-3 rounded-lg bg-main text-white font-semibold shadow-md hover:bg-hover transition duration-200">
            Quay về Dashboard
        </a>

    </div>
</body>

</html>