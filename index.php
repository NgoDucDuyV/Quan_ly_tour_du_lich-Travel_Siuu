    <?php
    session_start();
    require_once __DIR__ . '/commons/env.php';
    require_once __DIR__ . '/commons/function.php';



    $mode = isset($_GET['mode']) ? $_GET['mode'] : 'client';
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
        <!-- CSS gốc của bạn (luôn load TRƯỚC Tailwind) -->
        <link rel="stylesheet" href="./assets/css/css.css" />

        <!-- Cấu hình Tailwind (tắt reset để không ảnh hưởng CSS gốc) -->
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
        <script src="https://cdn.tailwindcss.com"></script>

    </head>

    <body class="font-body text-[16px] bg-white text-gray-800">
        <?php echo $content_views; ?>
    </body>

    </html>