<?php
$act = isset($_GET['act']) ? $_GET['act'] : '/';
ob_start();
echo match ($act) {
    '/' => (function () {
        require_once "./views/Admin/signin.php";
    })(),
    'showformSigninAdmin' => (function () {
        require_once "./views/Admin/signin.php";
    })(),
    'signin' => (function () {
        $requestData = json_decode(file_get_contents("php://input"), true);
        (new AdminController())->signin($requestData);
        exit;
    })(),
    'dashboard' => function () {
        // kiểm tra session
        if (!isset($_SESSION['admin_logged'])) {
            header("Location: index.php?mode=admin&act=/");
            exit;
        }

        // tùy role hiển thị dashboard
        if ($_SESSION['admin_role'] === 'admin') {
            require_once "./views/Admin/dashboard.php";
        } elseif ($_SESSION['admin_role'] === 'guide') {
            require_once "./views/Admin/guide_dashboard.php";
        } else {
            echo "Không có quyền truy cập!";
        }
    },
    'demo' => (function () {
        echo 'anh yeu em';
    })(),
    default => 'admin',

    'booking' => (function () {
        echo (new BookingController)->BookingController();
    })(),
};
$content_views = ob_get_clean();

if ($act == '/' || $act == 'showformSigninAdmin') {
    echo $content_views;
    exit;
}
?>
<?= (new LayoutController())->HeaderController() ?>
<main class="contentAdmin flex flex-row relative md:p-0 ">
    <?= (new LayoutController())->SideberController() ?>
    <div class="md:p-0 pl-[50px]">
        <?= $content_views; ?>
    </div>
</main>
<?= (new LayoutController())->FooterController() ?>
<?php exit; ?>
?>