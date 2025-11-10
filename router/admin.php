<?php
$act = isset($_GET['act']) ? $_GET['act'] : '/';
function requireAdmin()
{
    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'admin') {
        header("Location: " . BASE_URL . "?mode=admin&act=404");
        exit;
    }
}

function requireGuide()
{
    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'guide') {
        header("Location: " . BASE_URL . "?mode=admin&act=404");
        exit;
    }
}
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
    'dashboard' => (function () {
        // kiểm tra session
        if (!isset($_SESSION['admin_logged'])) {
            header("Location: " . BASE_URL . "?mode=admin&act=/");
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
        exit;
    })(),
    'booking' => (function () {
        requireAdmin();
        echo (new BookingController)->BookingController();
    })(),
    '404' => (function () {
        require_once "./views/Admin/common/404.php";
    })(),
    // Hướng dẫn viên
    default => (function () {
        header("Location: " . BASE_URL . "?mode=admin&act=404");
        exit;
    })(),
};
$content_views = ob_get_clean();

if ($act == '/' || $act == 'showformSigninAdmin' || $act == '404') {
    echo $content_views;
    exit;
}

?>
<?= (new LayoutController())->HeaderController() ?>
<main class="contentAdmin flex flex-row relative md:p-0 z-[0]">
    <?= (new LayoutController())->SideberController() ?>
    <div class="flex-1">
        <?= $content_views; ?>
    </div>
</main>
<?= (new LayoutController())->FooterController() ?>

<?php if ($layoutController): ?>
    <?= $layoutController->Header() ?>
    <main class="contentAdmin flex flex-row relative md:p-0 z-[0]">
        <?= $layoutController->Sidebar() ?>
        <div class="flex-1">
            <?= $content_views ?>
        </div>
    </main>
    <?= $layoutController->Footer() ?>
<?php else: ?>
    <?= $content_views ?>
<?php endif; ?>