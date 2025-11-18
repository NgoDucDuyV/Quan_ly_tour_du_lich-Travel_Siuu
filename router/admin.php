<?php
$act = isset($_GET['act']) ? $_GET['act'] : 'showformSigninAdmin';
$ajax = $_GET['ajax'] ?? "";

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
            case 'admin':
                header("Location: " . BASE_URL . "?mode=admin&act=home");
                exit;
            case 'guide':
                header("Location: " . BASE_URL . "?mode=admin&act=homeguide");
                exit;
        }
    })(),

    'logout' => (function () {
        session_destroy();
        header("Location: " . BASE_URL . "?mode=admin&act=showformSigninAdmin");
        exit;
    })(),

    // --- ADMIN ---
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
        if (isset($_GET['tour_id'])) {
            (new AdminTourController())->showTourDetail($_GET['tour_id']);
        } else {
            (new AdminTourController)->ShowAdminTour();
        }
    })(),

    'from_add_tour' => (function () {
        requireAdmin();
        (new AdminTourController)->showFromAddTour();
    })(),

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

    // quản lý tải khoản người dùng
    'managerguide' => (function () {
        requireAdmin();
        (new GuideLayoutController())->index();
    })(),

    'managerclient' => (function () {
        requireAdmin();
        (new GuideLayoutController())->clientList();
    })(),

    // Tài khoản
    'listclient' => (function () {
        requireAdmin();
        echo (new AccountManagementController)->showClientList();
    })(),

    'delete-client' => (function () {
        requireAdmin();
        (new AccountManagementController)->deleteClient();
    })(),

    'update-client' => (function () {
        requireAdmin();
        (new AccountManagementController)->updateClient();
        exit;
    })(),
    'create-client' => (function () {
        requireAdmin();
        (new AccountManagementController)->createClient();
        exit;
    })(),


    'liststaff' => (function () {
        requireAdmin();
        echo (new AccountManagementController)->showStaffList();
    })(),


   //quản lý nhân viên
    'create-staff' => (function () {
        requireAdmin();
        (new AccountManagementController)->createStaff();
        exit;
    })(),

 
    'update-staff' => (function () {
        requireAdmin();
        (new AccountManagementController)->updateStaff();
        exit;
    })(),

    'delete-staff' => (function () {
        requireAdmin();
        (new AccountManagementController)->deleteStaff();
        exit;
    })(),

    // show trang lỗi
    '404' => (function () {
        require_once "./views/Admin/common/404.php";
    })(),

    // --- GUIDE ---
    'homeguide' => (function () {
        requireGuide();
        require_once "./views/Admin/homegiude.php";
    })(),

    'scheduleguide' => (function () {
        requireGuide();
        require_once "./views/Admin/scheduleguide.php";
    })(),

    'listguide' => (function () {
        requireGuide();
        require_once "./views/Admin/listguide.php";
    })(),

    'diaryguide' => (function () {
        requireGuide();
        require_once "./views/Admin/diaryguide.php";
    })(),

    'checkguide' => (function () {
        requireGuide();
        require_once "./views/Admin/checkguide.php";
    })(),

    'requestguide' => (function () {
        requireGuide();
        require_once "./views/Admin/requestguide.php";
    })(),

    default => (function () {
        header("Location: " . BASE_URL . "?mode=admin&act=404");
        exit;
    })(),
};

$content_views = ob_get_clean();


// Layout
$layoutController = null;
if (isset($_SESSION['admin_logged'])) {
    if ($_SESSION['admin_role'] === 'admin') {
        $layoutController = new AdminLayoutController();
    } else if ($_SESSION['admin_role'] === 'guide') {
        $layoutController = new GuideLayoutController();
    }
}

if ($act == '/' || $act == 'showformSigninAdmin' || $act == '404') {
    echo $content_views;
    return;
}

?>
<?php if ($layoutController): ?>
    <?= $layoutController->Header() ?>
    <main id="contentAdmin" class="contentAdmin flex flex-row relative md:p-0 z-[0]">
        <?= $layoutController->Sidebar() ?>
        <div id="adminContent" class="w-full overflow-x-hidden">
            <?= $content_views ?>
        </div>
    </main>
    <?= $layoutController->Footer() ?>
<?php else: ?>
    <?= $content_views ?>
<?php endif; ?>
