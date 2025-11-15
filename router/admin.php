<?php
$act = isset($_GET['act']) ? $_GET['act'] : 'showformSigninAdmin';
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

function checkSignin()
{
    if (isset($_SESSION['admin_logged'])) {
        header("Location: " . BASE_URL . "?mode=admin&act=dashboard");
        exit;
    }
}
ob_start();

echo match ($act) {
    '/' => (function () {
            header("Location: " . BASE_URL . "?mode=admin&act=showformSigninAdmin");
            exit;
        })(),
    'showformSigninAdmin' => (function () {
            checkSignin();
            (new AuthController)->showformSigninAdmin();
        })(),
    'signin' => (function () {
            $requestData = json_decode(file_get_contents("php://input"), true);
            (new AuthController())->signin($requestData);
            exit;
        })(),

    'dashboard' => (function () {
            switch ($_SESSION['admin_role']) {
                case 'admin': {
                    header("Location: " . BASE_URL . "?mode=admin&act=home");
                    exit;
                    break;
                }
                case 'guide': {
                    header("Location: " . BASE_URL . "?mode=admin&act=homeguide");
                    exit;
                    break;
                }
                default:
                    break;
            }
        })(),
    'logout' => (function () {
        session_destroy();
        header("Location: " . BASE_URL . "?mode=admin&act=showformSigninAdmin");
        exit;
    })(),

    // chứa năng thanh siderbar admin quản lý điều hành tour
    'home' => (function () {
        requireAdmin();
        require_once "./views/Admin/home.php";
    })(),
    'categoriestour' => (function () {
        requireAdmin();
        (new CategoryController)->listCategories();
    })(),
    'admintour' => (function () {
        requireAdmin();
        if (!isset($_GET['tour_id'])) {
            (new AdminTourController)->ShowAdminTour();
        } else {
            (new AdminTourController())->showTourDetail($_GET['tour_id']);
            //  (new TourMedel())->TourDetailModel();
        }
    })(),
    'from_add_tour' => (function () {
        requireAdmin();
        (new AdminTourController)->showFromAddTour();
    })(),
    // quản lý nàh cung cấp
    'supplier-list' => (function () {
        requireAdmin();
        (new AdminSupplierController)->showSupplierList();
    })(),
    'supplier-list-types' => (function () {
        requireAdmin();
        (new AdminSupplierController)->showSupplierTypesList();
    })(),

    'booking' => (function () {
            requireAdmin();
            echo (new BookingController)->ShowBooking();
        })(),
    'newBooking' => (function () {
        requireAdmin();
        echo (new BookingController)->ShowFromNewBooking();
    })(),

    // quản lý tải khoản
    'listclient' => (function () {
        requireAdmin();
        echo (new AccountManagementController)->showClientList();
    })(),

    'liststaff' => (function () {
        requireAdmin();
        echo (new AccountManagementController)->showStaffList();
    })(),

    // show trang lỗi
    '404' => (function () {
            require_once "./views/Admin/common/404.php";
        })(),



    // Hướng dẫn viên
    'homeguide' => (function () {
            requireGuide();
            require_once "./views/Admin/homegiude.php";
        })(),
    default => (function () {
            header("Location: " . BASE_URL . "?mode=admin&act=404");
            exit;
        })(),
};
$content_views = ob_get_clean();

// Xác định layout theo role
$layoutController = null;
if (isset($_SESSION['admin_logged'])) {
    if ($_SESSION['admin_role'] === 'admin') {
        $layoutController = new AdminLayoutController();
    } else if ($_SESSION['admin_role'] === 'guide') {
        $layoutController = new GuideLayoutController();
    }
}
// chuyển hướng đến trang 404
if ($act == '/' || $act == 'showformSigninAdmin' || $act == '404') {
    echo $content_views;
    return;
}

?>
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