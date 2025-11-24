<?php
class GuideLayoutController
{
    public function Header()
    {
        require_once "./views/Admin/layout_guide/header.php";
    }
    public function Sidebar()
    {
        require_once "./views/Admin/layout_guide/sidebar.php";
    }
    public function Footer()
    {
        require_once "./views/Admin/layout_guide/footer.php";
    }
    public function listGuide()
    {
        // Hàm tìm kiếm khách hàng theo từ khóa
        $keyword = $_GET['keyword'] ?? '';

        $bookings = (new BookingModel())->getBookings($keyword);

        require "./views/Admin/listguide.php";
    }
    public function diaryGuide()
    {
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
        die(); // dừng tại đây để xem session
    }
    public function checkGuide()
    {
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
        // $guide_id = $_SESSION['admin_id'] ?? null;

        // // Nếu chưa đăng nhập HDV
        // if (!$guide_id) {
        //     $todayTour = null;
        //     $customers = [];
        //     require "./views/Admin/checkguide.php";
        //     return;
        // }

        // $model = new TourModel();

        // // Lấy tour hôm nay
        // $todayTour = $model->getTodayTour($guide_id);

        // // Mặc định danh sách rỗng
        // $customers = [];

        // // Nếu có tour thì lấy danh sách khách
        // if ($todayTour) {
        //     $customers = $model->getCustomersBySchedule($todayTour['schedule_id']);
        // }

        // require "./views/Admin/checkguide.php";
    }
}
