    <?php
    session_start();
    require_once __DIR__ . '/commons/env.php';
    require_once __DIR__ . '/commons/function.php';

    // admin model
    require_once __DIR__ . '/models/AdminModel.php';
    require_once __DIR__ . '/models/AuthModel.php';
    require_once __DIR__ . '/models/CategoryModel.php';
    require_once __DIR__ . '/models/TourModel.php';
    require_once __DIR__ . '/models/BookingModel.php';

    // admin Controller
    require_once __DIR__ . '/controllers//AuthController.php';
    require_once __DIR__ . '/controllers/BookingController.php';
    require_once __DIR__ . '/controllers/CategoryController.php';

    require_once __DIR__ . '/controllers/AdminLayoutController.php';
    require_once __DIR__ . '/controllers/GuideLayoutController.php';
    require_once __DIR__ . '/controllers/TourController.php';



    $mode = isset($_GET['mode']) ? $_GET['mode'] : 'admin';
    ob_start();
    switch ($mode) {
        case 'client': {
                require_once Views_Router . "client.php";
                break;
            }
        case 'admin': {
                require_once Views_Router . "admin.php";
                break;
            }
        default:
            require_once Views_Router . "client.php";
            break;
    }
    $content_views =  ob_get_clean();
    ?>
    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>:Quản lý tour du lịch - Travel_Siuu</title>
        <!-- Fonts + Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&family=Open+Sans:wght@400;500&display=swap" rel="stylesheet" />
        <link href='https://cdn.boxicons.com/3.0.3/fonts/basic/boxicons.min.css' rel='stylesheet'>
        <link href='https://cdn.boxicons.com/3.0.3/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>

        <!-- CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="./assets/Css/style.css" />

        <!-- icon  -->
        <script src="https://unpkg.com/lucide@latest"></script>
        <!-- JS Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            tailwind = {
                config: {
                    corePlugins: {
                        preflight: false, // Không reset CSS mặc định
                    },
                    theme: {
                        extend: {
                            fontFamily: {
                                title: ['"Poppins"', 'Segoe UI', 'Roboto', 'sans-serif'],
                                body: ['Roboto, sans-serif'],
                            },
                            colors: {
                                color: "#ffffff", // chữ trắng
                                main: "#1f55ad", // màu chính chủ đạo
                                dark: "#0f2b57", // màu đậm, dùng cho header, sidebar, text nổi bật
                                accent: "#5288e0", // màu điểm nhấn nhẹ hơn, button, link
                                light: "#a8c4f0", // nền nhẹ, background section/card
                                hover: "#0f2b90", // màu hover, nút nhấn, link
                                thea: "#37d4d9", // nhấn đặc biệt, badges, highlights
                            },


                            backgroundImage: {
                                hero: "url('img/banner-bg-1.png')",
                                mau: "linear-gradient(to bottom, #ffa726, #29b6f6)",
                                thudan: "linear-gradient(to bottom, #ff7e5f, #feb47b)",
                                toxanh: "linear-gradient(to bottom, #ffa726, #29b6f6)",
                                song: "repeating-linear-gradient(45deg, #ff9800, #ff9800 20px, #ffffff 20px, #ffffff 40px)",
                            },
                            boxShadow: {
                                soft: "0 0 20px #00000029",
                                strong: "0 4px 12px rgba(0, 0, 0, 0.2)",
                                main: "1px 1px 15px #000",
                            },
                            transitionProperty: {
                                smooth: "all",
                            },
                            transitionTimingFunction: {
                                smooth: "ease",
                            },
                            transitionDuration: {
                                normal: "400ms",
                            },
                            maxWidth: {
                                screen: "1500px",
                            },
                        },
                    },
                },
            };
        </script>
        <script>
            lucide.createIcons();
            const BASE_URL = '<?= BASE_URL ?>';
        </script>
        <style>
            /* Ẩn scrollbar trên Chrome, Safari, Edge */
            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }

            /* Ẩn scrollbar trên IE, Edge cũ */
            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
                /* Firefox */
            }
        </style>

        <!-- tông màu chính -->
        <!-- #0f2b57 -->
        <!-- #1f55ad -->
        <!-- #5288e0 -->
        <!-- #a8c4f0 -->
    </head>

    <body class="bg-gray-100 flex flex-col w-[100wh] h-[100vh]">
        <?php echo $content_views; ?>
    </body>

    </html>