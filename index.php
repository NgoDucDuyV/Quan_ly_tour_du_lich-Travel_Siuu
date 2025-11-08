    <?php
    session_start();
    require_once __DIR__ . '/commons/env.php';
    require_once __DIR__ . '/commons/function.php';



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
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&family=Open+Sans:wght@400;500&display=swap" rel="stylesheet" />
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

        <!-- CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="./assets/Css/style.css" />

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
                        preflight: false, // Ngăn Tailwind reset CSS mặc định
                    },
                    theme: {
                        extend: {
                            fontFamily: {
                                title: ['"Poppins"', 'Segoe UI', 'Roboto', 'sans-serif'],
                                body: ['"Open Sans"', 'Segoe UI', 'Roboto', 'sans-serif'],
                            },
                        },
                    },
                },
            };
        </script>
    </head>

    <body class="bg-gray-100 min-h-screen">
        <?php echo $content_views; ?>
    </body>

    </html>