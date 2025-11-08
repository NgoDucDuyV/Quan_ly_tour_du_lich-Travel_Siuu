<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

    <style>
        .font-anton {
            font-family: 'Anton', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <section class="w-full max-w-5xl shadow-2xl rounded-xl overflow-hidden bg-white flex flex-col md:flex-row">
        <!-- Left panel -->
        <div class="md:flex-1 bg-orange-500 p-6 md:p-12 text-white flex flex-col md:justify-between rounded-2xl relative min-h-[300px]">
            <h1 class="relative text-3xl md:text-5xl font-bold mb-4 md:mb-6 font-[800] z-[1]">Chào mừng</h1>
            <p class="relative text-sm md:text-lg leading-relaxed mb-6 text-shadow-lg md:mb-8 z-[1]">
                đến với <strong>Quản lý tour du lịch Travel_Siuu</strong> – hệ thống quản trị du lịch thông minh và mã nguồn mở. Hỗ trợ quản lý tour, khách hàng, lịch trình và điểm đến ở một nơi duy nhất, <strong>nhanh chóng và dễ dàng</strong>.
            </p>
            <div class="mt-auto flex justify-center md:justify-start">
                <img src="<?= BASE_URL ?>/assets/Img/imgelogin.png" alt="Travel illustration" class="w-full md:max-w-full max-w-[300px] h-auto object-contain">
            </div>
        </div>

        <!-- Right panel -->
        <div class="md:flex-1 p-6 md:p-12 flex flex-col items-center justify-center ">
            <div class="logo mb-6 md:mb-8 text-center">
                <img src="<?= BASE_URL ?>/assets/Img/logo_black.png" alt="adminVIVU Logo" class="max-w-50 w-full  mx-auto">
            </div>

            <div class="error">
                <?php
                if (isset($_SESSION['error_loginAdmin'])) {
                    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 w-full" role="alert">
                    <strong class="font-bold">Lỗi!</strong>
                    <span class="block sm:inline">' . $_SESSION['error_loginAdmin'] . '</span>
                    </div>';
                    unset($_SESSION['error_loginAdmin']);
                }
                ?>
            </div>
            <form action="#" method="post" class="w-full *:mb-5">
                <div class="mb-6 md:mb-10">
                    <label for="useremail" class="block text-gray-700 text-sm font-bold mb-2">* Email</label>
                    <input type="email" name="useremail" placeholder="Email Đăng Nhập"
                        class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-blue-50 border-blue-200">
                </div>

                <div class="mb-4 md:mb-8">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">* Password</label>
                    <input type="password" name="password" placeholder="Password Đăng Nhập"
                        class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-blue-50 border-blue-200">
                </div>

                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded w-full transition duration-300">
                    Signin
                </button>
            </form>
        </div>
    </section>
</body>

</html>