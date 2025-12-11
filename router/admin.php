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
        (new CategoryController)->list();
    })(),

    'addcategory_add' => (function () {
        requireAdmin();
        (new CategoryController)->add();
    })(),

    'category_store' => (function () {
        requireAdmin();
        (new CategoryController)->store();
    })(),

    'category_edit' => (function () {
        requireAdmin();
        (new CategoryController)->edit($_GET['id'] ?? 0);
    })(),

    'category_update' => (function () {
        requireAdmin();
        (new CategoryController)->update();
    })(),

    'category_delete' => (function () {
        requireAdmin();
        (new CategoryController)->delete($_GET['id'] ?? 0);
    })(),
    'admintour' => (function () {
        requireAdmin();
        $ctrl = new AdminTourController();

        if (isset($_GET['tour_id'])) {
            // Chi tiết 1 tour
            $ctrl->showTourDetail($_GET['tour_id']);
        } elseif (isset($_GET['category_id'])) {
            // Danh sách tour theo danh mục
            $ctrl->showToursByCategory($_GET['category_id']);
        } else {
            // Danh sách tất cả tour
            $ctrl->ShowAdminTour();
        }
    })(),

    'admin_detail_tour' => (function () {
        requireAdmin();
        (new AdminTourController())->showTourDetailPHP($_GET['tour_id']);
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

    // list quản lý booking
    'bookinglist' => (function () {
        requireAdmin();
        echo (new BookingController)->ShowBooking();
    })(),

    // 'Cập nhật đặt cọc booking'
    'from_booking_update_deposit' => (function () {
        requireAdmin();
        echo (new BookingStatusController())->ShowFormUpdateDeposit($_GET['booking_id'] ?? null);
    })(),

    'updatedeposit' => (function () {
        requireAdmin();
        echo (new BookingStatusController)->UpdateDeposit($_GET['booking_id'] ?? null);
    })(),

    // update thanth toán
    'from_booking_update_payment' => (function () {
        requireAdmin();
        echo (new PaymentController)->ShowBookingUpdatePayment($_GET['booking_id'] ?? null);
    })(),

    'updatepayment' => (function () {
        requireAdmin();
        echo (new BookingStatusController)->UpdatePayment($_GET['booking_id'] ?? null);
    })(),

    // phân lịch trình cho hướng dẫn viên
    'guide_tour_schedule' => (function () {
        requireAdmin();
        echo (new GuideTourScheduleController)->ShowGuideTourSchedule($_GET['booking_id'] ?? null);
    })(),

    'createguideschedule' => (function () {
        requireAdmin();
        echo (new GuideTourScheduleController)->CreateGuideSchedule($_GET['booking_id'] ?? null);
    })(),

    // đánh dấu sắp diễn ra
    'markUpcoming' => (function () {
        requireAdmin();
        echo (new BookingStatusController)->MarkUpComing($_GET['booking_id'] ?? null);
    })(),


    // chiết boong
    'bookingdetail' => (function () {
        requireAdmin();
        echo (new BookingController)->ShowBookingDetail($_GET['booking_id'] ?? null);
        // echo (new BookingController)->ShowBooking();
    })(),
    'newBooking' => (function () {
        requireAdmin();
        echo (new BookingController)->ShowFromNewBooking(isset($_GET['tour_id']) ? $_GET['tour_id'] : "");
    })(),

    'createBooking' => (function () {
        requireAdmin();
        echo (new BookingController)->createBooking();
    })(),

    // chi tiết lịch trình booking
    'bookingscheduledetail' => (function () {
        requireAdmin();
        require_once "./views/Admin/bookingscheduledetail.php";
    })(),

    // call api js booking
    'getAllSchedulesByid' => (function () {
        $requestData = json_decode(file_get_contents("php://input"), true);
        requireAdmin();
        (new BookingController())->getAllSchedulesByid($requestData);
        exit;
    })(),
    // call api js booking
    'getsupplierPricesBySupplierId' => (function () {
        $requestData = json_decode(file_get_contents("php://input"), true);
        // echo json_encode(
        //     [
        //         'id' => $requestData['supplier_id']
        //     ]
        // );
        // exit;
        requireAdmin();
        (new BookingController())->getsupplierPricesBySupplierId($requestData);
        exit;
    })(),
    //thêm loại dịch vụ
    'add-supplier-type' => (function () {
        requireAdmin();
        (new AdminSupplierController)->addSupplierType();
    })(),
    //cập nhật loại dịch vụ
    'update-supplier-type' => (function () {
        requireAdmin();
        (new AdminSupplierController)->updateSupplierType();
    })(),
    //xóa dịch vụ
    'delete-supplier-type' => (function () {
        requireAdmin();
        (new AdminSupplierController)->deleteSupplierType();
    })(),
    //thêm nhà cung cấp
    'add-supplier' => (function () {
        requireAdmin();
        (new AdminSupplierController)->addSupplier();
    })(),


    // sửa nhà cung cấp
    'update-supplier' => (function () {
        requireAdmin();
        (new AdminSupplierController)->updateSupplier();
    })(),

    // xóa nhà cung cấp
    'delete-supplier' => (function () {
        requireAdmin();
        (new AdminSupplierController)->deleteSupplier();
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
        (new ReportController())->index();
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
    // Homeguide
    'homeguide' => (function () {
        requireGuide();
        (new GuideController())->homeGuide();
    })(),
    // Giới thiệu của HDV
    'aboutguide' => (function () {
        requireGuide();
        require_once "./views/Admin/aboutguide.php";
    })(),
    // thông báo guide
    'mesageguide' => (function () {
        requireGuide();
        require_once "./views/Admin/mesageguide.php";
    })(),
    'mesageguidedetail' => (function () {
        requireGuide();
        require_once "./views/Admin/mesageguidedetail.php";
    })(),
    // ScheduleGuide
    // Lịch trình của HDV
    'scheduleguide' => (function () {
        requireGuide();
        (new GuideController())->scheduleGuide();
    })(),
    'tourdetailguide' => (function () {
        requireGuide();
        (new GuideController())->showTourDetail($_GET['schedule_id'] ?? null);
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
    'editDiaryGuide' => (function () {
        requireGuide();
        (new GuideController())->editDiaryGuide();
    })(),
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

    // CheckGuide
    // Checkin và điểm danh của HDV 
    'checkguide' => (function () {
        requireGuide();

        $ctrl = new GuideController();
        $data = $ctrl->checkGuide();

        // GIẢI NÉN MẢNG DỮ LIỆU ĐỂ CÁC BIẾN CÓ THỂ ĐƯỢC SỬ DỤNG TRONG VIEW
        $todayTour = $data['todayTour'];
        $customers = $data['customers'];
        $activities = $data['activities'];
        $current_day_number = $data['current_day_number'];

        require "./views/Admin/checkguide.php";
    })(),

    // LƯU ĐIỂM DANH THEO CHẶNG (ACTIVITY)
    'saveAttendanceByActivity' => (function () {
        requireGuide();
        (new GuideController())->saveAttendanceByActivity(); // Gọi hàm lưu mới
        exit;
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
    // 
    'saveAttendance' => (function () {
        requireGuide();
        (new GuideController())->saveAttendance();
    })(),

    // //thêm loại dịch vụ
    // 'add-supplier-type' => (function () {
    //     requireAdmin();
    //     (new AdminSupplierController)->addSupplierType();
    // })(),
    // //cập nhật loại dịch vụ
    // 'update-supplier-type' => (function () {
    //     requireAdmin();
    //     (new AdminSupplierController)->updateSupplierType();
    // })(),
    // //xóa dịch vụ
    // 'delete-supplier-type' => (function () {
    //     requireAdmin();
    //     (new AdminSupplierController)->deleteSupplierType();
    // })(),
    // //thêm nhà cung cấp
    // 'add-supplier' => (function () {
    //     requireAdmin();
    //     (new AdminSupplierController)->addSupplier();
    // })(),


    // // sửa nhà cung cấp
    // 'update-supplier' => (function () {
    //     requireAdmin();
    //     (new AdminSupplierController)->updateSupplier();
    // })(),

    // // xóa nhà cung cấp
    // 'delete-supplier' => (function () {
    //     requireAdmin();
    //     (new AdminSupplierController)->deleteSupplier();
    // })(),

    // // sửa nhà cung cấp
    // 'update-supplier' => (function () {
    //     requireAdmin();
    //     (new AdminSupplierController)->updateSupplier();
    // })(),

    // // xóa nhà cung cấp
    // 'delete-supplier' => (function () {
    //     requireAdmin();
    //     (new AdminSupplierController)->deleteSupplier();
    // })(),

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