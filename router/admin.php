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
        switch (isset($_SESSION['admin_role']) ? $_SESSION['admin_role'] : "") {
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
                require_once "./views/Admin/common/404.php";
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
        if (isset($_GET['tour_id'])) {
            (new AdminTourController())->showTourDetail($_GET['tour_id']);
        } else {
            (new AdminTourController)->ShowAdminTour();
        }
    })(),
    'admin_detail_tour' => (function () {
        requireAdmin();
    })(),
    'admin_createTourfrom' => (function () {
        requireAdmin();
        (new AdminTourController)->showFromCreateTour();
    })(),
    'admin_createTour' => (function () {
        requireAdmin();
        (new AdminTourController)->CreateTour();
    })(),
    'admin_deleteTour' => (function () {
        requireAdmin();
        (new AdminTourController)->DeleteTourController($_GET['tour_id']);
    })(),
    'admin_searchtour' => (function () {
        $requestData = json_decode(file_get_contents("php://input"), true);
        requireAdmin();
        (new AdminTourController)->getByNameController($requestData);
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
    'bookingdetail' => (function () {
        requireAdmin();
        require_once "./views/Admin/bookingdetail.php";
        // echo (new BookingController)->ShowBooking();
    })(),
    'newBooking' => (function () {
        requireAdmin();
        echo (new BookingController)->ShowFromNewBooking(isset($_GET['tour_id']) ? $_GET['tour_id'] : null);
    })(),

    // quản lý tải khoản người dùng
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

    'dashboarthongke' => (function () {
        requireAdmin();
        echo "bao cao thong ke";
        require_once "./views/Admin/dashboard.php";
        exit;
    })(),

    // show trang lỗi
    '404' => (function () {
        require_once "./views/Admin/common/404.php";
    })(),



    // Hướng dẫn viên
    'guide' => (function () {
        requireGuide();
        require_once "./views/Admin/homeguide.php";
    })(),
    // Trang chủ của HDV
    'homeguide' => (function () {
        requireGuide();
        (new GuideController())->homeGuide();
    })(),

    'aboutguide' => (function () {
        requireGuide();
        require_once "./views/Admin/aboutguide.php";
    })(),


    // ScheduleGuide
    // Lịch trình của HDV
    'scheduleguide' => (function () {
        requireGuide();
        (new GuideController())->scheduleGuide();
    })(),

    // ListGuide
    // Danh sách khách của HDV
    'listguide' => (function () {
        requireGuide();

        $ctrl = new GuideController();
        $ctrl->listGuide();
    })(),

    // DiaryGuide
    // Nhật ký ghi lại của HDV
    'diaryguide' => (function () {
        requireGuide();
        $ctrl = new GuideController();
        $data = $ctrl->diaryGuide();

        $diary = $data['diary'];
        $tours = $data['tours'];

        require "./views/Admin/diaryguide.php";
    })(),
    // XÓA NHẬT KÝ
    'deleteDiaryGuide' => (function () {
        requireGuide();
        (new GuideController())->deleteDiaryGuide();
    })(),
    // Sửa nhật ký (hiển thị form)
    // 'editDiaryGuide' => (function () {
    //     requireGuide();
    //     (new GuideLayoutController())->editDiaryGuide();
    // })(),
    // Update nhật ký sau khi sửa
    'updateDiaryGuide' => (function () {
        requireGuide();
        (new GuideController())->updateDiaryGuide();
    })(),
    // Nhật ký lưu lại của HDV
    'saveDiaryGuide' => (function () {
        requireGuide();
        (new GuideController())->saveDiaryGuide();
    })(),


    // Checkin và điểm danh của HDV 
    'checkguide' => (function () {
        requireGuide();

        $ctrl = new GuideController();
        $data = $ctrl->checkGuide();

        $todayTour = $data['todayTour'];
        $customers = $data['customers'];

        require "./views/Admin/checkguide.php";
    })(),

    // RequestGuide
    // Gửi yêu cầu của HDV
    'requestguide' => (function () {
        requireGuide();
        (new GuideController())->requestGuide();
    })(),
    // Lưu yêu cầu của HDV
    'saveRequestGuide' => (function () {
        requireGuide();
        (new GuideController())->saveRequestGuide();
    })(),
    // Sửa yêu cầu của HDV (hiển thị form)
    'editRequestGuide' => (function () {
        requireGuide();
        (new GuideController())->editRequestGuide();
    })(),
    // Cập nhật yêu cầu của HDV sau khi sửa
    'updateRequestGuide' => (function () {
        requireGuide();
        (new GuideController())->updateRequestGuide();
    })(),
    // Xóa yêu cầu của HDV
    'deleteRequestGuide' => (function () {
        requireGuide();
        (new GuideController())->deleteRequestGuide();
    })(),


    default => (function () {
        header("Location: " . BASE_URL . "?mode=admin&act=404");
        exit;
    })(),
};
$content_views = ob_get_clean();

if ($ajax == 1) {
    echo $content_views;
    exit;
}

// xác định layout theo role
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
    <main id="contentAdmin" class="contentAdmin flex flex-row relative md:p-0 z-[0]">
        <?= $layoutController->Sidebar() ?>
        <div id="adminContent" class="w-full overflow-x-clip">
            <?= $content_views ?>
        </div>
    </main>
    <?= $layoutController->Footer() ?>
<?php else: ?>
    <?= $content_views ?>
<?php endif; ?>