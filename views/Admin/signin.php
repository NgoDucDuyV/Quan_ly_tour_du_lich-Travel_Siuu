<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signin</title>
</head>

<body class="bg-gray-100 flex items-center justify-center">
    <section
        class="sm:w-auto w-full sm:h-auto min-h-[600px] h-full max-w-5xl shadow-2xl rounded-xl overflow-y-auto bg-white flex flex-col m-auto md:flex-row">
        <!-- Left panel -->
        <div
            class="flex-1 flex-col min-w-[400px] bg-main p-6 md:p-12 text-white overflow-hidden rounded-xl relative md:flex hidden">
            <h1 class="relative text-3xl md:text-5xl text-white font-bold mb-4 md:mb-6 font-[800] z-[1]">Chào mừng</h1>
            <p class="relative text-sm md:text-lg leading-relaxed mb-6 text-shadow-xl md:mb-8 z-[1]">
                đến với <strong>Quản lý tour du lịch Travel_Siuu</strong> – hệ thống quản trị du lịch thông minh và mã
                nguồn mở. Hỗ trợ quản lý tour, khách hàng, lịch trình và điểm đến ở một nơi duy nhất, <strong>nhanh
                    chóng và dễ dàng</strong>.
            </p>
            <div class="mt-auto flex justify-center absolute bottom-0 left-0 right-0 md:justify-start">
                <img src="https://vinno.vn/sites/default/files/inline/images/1_1.png" alt="Travel illustration"
                    class="w-full md:max-w-full max-w-[300px] h-auto object-contain">
            </div>
        </div>

        <!-- Right panel -->
        <div
            class="md:flex-2 w-full sm:max-w-[550px] sm:min-h-[600px] h-full m-auto p-6 sm:p-12 flex flex-col items-center justify-center ">
            <div class="logo mb-6 md:mb-8 text-center">
                <img src="<?= BASE_URL ?>assets/Img/logo_adminBlack.png" alt="adminVIVU Logo"
                    class="max-w-45 w-full  mx-auto">
            </div>

            <div id="errorsignin" class="w-full" role="alert">
                <?php if (isset($_SESSION['success'])): ?>
                    <p
                        class="font-medium text-sm bg-lime-100 border border-lime-400 text-lime-800 px-4 py-3 rounded relative mb-6">
                        <?= htmlspecialchars($_SESSION['success']) ?>
                    </p>
                <?php endif ?>
            </div>
            <form id="fromsignin" action="<?= BASE_URL ?>?mode=admin&act=signin" method="POST" class="space-y-6 w-full">

                <div>
                    <label for="signin_email" class="block text-sm font-normal text-gray-700 mb-1">
                        Email<span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="signin_email" name="username" required
                        class="appearance-none relative block w-full px-3 py-2.5 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 **bg-blue-50/70** text-base transition duration-150" />
                </div>

                <div>
                    <label for="signin_password" class="block text-sm font-normal text-gray-700 mb-1">
                        Password<span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="signin_password" name="password" required
                        class="appearance-none relative block w-full px-3 py-2.5 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 **bg-blue-50/70** text-base transition duration-150" />
                </div>

                <div class="flex flex-row flex-wrap justify-between items-center 
                [&>:first-child]:mr-[10px] [&>:first-child]:mb-[10px] sm:[&>:first-child]:mr-[0px]">
                    <div class="flex items-center justify-between *:mr-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember_me" name="remember_me"
                                class="h-4 w-4 text-main focus:ring-orange-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                                Remember me
                            </label>
                        </div>
                        <a href="<?= BASE_URL ?>?mode=client&act=resetPassword"
                            class="text-sm font-[600] text-gray-600 hover:text-hover hover:underline hover:bg-[#0000]">
                            Forgot Password ?
                        </a>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="remember_medky" name="remember_me"
                            class="checkpasswrod h-4 w-4 text-main focus:ring-hover border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">check password</label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent text-base font-medium rounded-md text-white bg-main hover:bg-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-150 ease-in-out uppercase"
                        data-page="auth" data-action="signin">
                        LOG IN
                    </button>
                </div>

                <div class="mt-6 text-center text-sm text-gray-600">
                    Don't have an account?
                    <a href="<?= BASE_URL ?>?mode=client&act=showformsigin"
                        class="text-gray-600 font-[800] hover:text-hover hover:bg-[#0000]">
                        Sign up
                    </a>
                </div>

                <div class="optionsignin">
                </div>
            </form>
        </div>
    </section>
    <script src="<?= BASE_URL ?>assets/Js/admin/signin.js"></script>
</body>

</html>