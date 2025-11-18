<?php
class BookingController
{
    
    public function ShowBooking()
    {
        
        $bookingModel = new BookingModel();
        $bookings = $bookingModel->getAllBookings(); 

      
        require_once "./views/Admin/booking.php";
    }


    public function ShowFromNewBooking()
    {
        
        $tourModel = new TourModel();
        $tours = $tourModel->getall();

        // Lấy danh sách version tour nếu cần (tùy bạn có bảng tour_versions không)
        // $versions = (new TourVersionModel())->getAll();

        require_once "./views/Admin/newBooking.php";
    }

 
    public function createBooking()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        //check quyền chỉ admin mới thao tác
        if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'admin') {
            $_SESSION['error'] = "bạn không có quyền!";
            header("Location: ?mode=admin&act=booking");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?mode=admin&act=booking");
            exit;
        }

        $data = [
            'tour_id'          => (int)($_POST['tour_id'] ?? 0),
            'tour_version_id'  => (int)($_POST['tour_version_id'] ?? 0),
            'customer_name'    => trim($_POST['customer_name'] ?? ''),
            'customer_phone'   => trim($_POST['customer_phone'] ?? ''),
            'customer_email'   => trim($_POST['customer_email'] ?? ''),
            'group_type'       => $_POST['group_type'] ?? 'le', // le hoặc doan
            'number_of_people' => (int)($_POST['number_of_people'] ?? 1),
            'note'             => trim($_POST['note'] ?? ''),
            'status'           => $_POST['status'] ?? 'cho_xac_nhan', // mặc định chờ xác nhận
        ];

        // check validate
        if (empty($data['tour_id']) || empty($data['customer_name']) || empty($data['customer_phone']) || empty($data['customer_email'])) {
            $_SESSION['error'] = "vui lòng điền đầy đủ các trường bắt buộc!";
            header("Location: ?mode=admin&act=newBooking");
            exit;
        }

        $bookingModel = new BookingModel();
        if ($bookingModel->create($data)) {
            $_SESSION['success'] = "Tạo booking thành công!";
        } else {
            $_SESSION['error'] = "Tạo booking thất bại, vui lòng thử lại!";
        }

        header("Location: ?mode=admin&act=booking");
        exit;
    }
}