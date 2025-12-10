<?php
class GuideTourScheduleController
{
    public function ShowGuideTourSchedule($booking_id)
    {
        $databooking = (new BookingModel())->getBookingById($booking_id);

        $tourDetail = (new TourModel)->getOne($databooking['tour_id']);

        $dataguide = (new GuideTourModel())->getAllGuides();


        // echo "<pre>";

        // echo "===== \$databooking =====\n";
        // print_r($databooking);

        // echo "\n===== \$tourDetail =====\n";
        // print_r($tourDetail);

        // echo "\n===== \$dataguide =====\n";
        // print_r($dataguide);

        // echo "</pre>";
        // die;
        // $dataguidelichtrinh = (new SchedulesModel())->getSchedulesByGuideId(1);
        // echo "<pre>";
        // var_dump($dataguidelichtrinh);
        // echo "<pre>";
        // die;
        require_once "./views/Admin/guide_tour_schedule.php";
    }

    public function CreateGuideSchedule($booking_id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = "
            Lỗi lưu vui lòng thử lại !";
            header("Location: " . BASE_URL . "?mode=admin&act=guide_tour_schedule&booking_id=" . $booking_id);
            exit;
        }

        $guide_id   = $_POST['guide_id'] ?? null;
        $booking_id = $_POST['booking_id'] ?? null;

        if (empty($guide_id) || empty($booking_id)) {
            $_SESSION['error_message'] = "
            Lỗi mạng hoặc không thấy id booking or id guide";
            header("Location: " . BASE_URL . "?mode=admin&act=guide_tour_schedule&booking_id=" . $booking_id);
            exit;
        }
        $databooking = (new BookingModel())->getBookingById($booking_id);

        $dataTour = (new TourModel())->getOne($databooking['tour_id']);
        // echo '<pre>';
        // var_dump($databooking['payment_type_id_master']);
        // // var_dump($idScheduleStatus);
        // echo '<pre>';
        // die;
        $idSchedules = (new SchedulesModel())->createSchedule(
            $databooking['booking_id'],
            $databooking['tour_id'],
            $guide_id,
            $databooking['start_date'],
            $databooking['end_date'],
            "Chưa có cụt thể !"
        );

        // khơi tào trn thái
        $idScheduleStatus = (new ScheduleStatusModel())->createScheduleStatus(
            $idSchedules,
            1,
            1,
            'planned',
            'PENDING',
            'Khởi Tạo  trạng thái lịch trình chờ hướng dẫn viên sác nhận'
        );

        // cập nhật trạng thái của booking
        // lấy trang thái mới booking]
        $idBookingStatusGuide = 3;
        $newBookingStatus = (new BookingStatusModel())->getBookingStatusTypeById($idBookingStatusGuide);

        (new BookingStatusModel())->updateStatusByBookingId(
            $databooking['booking_id'],
            $idBookingStatusGuide,
            $databooking['payment_type_id_master'],
            $data['note'] ?? 'Thanh toán thêm một phần'
        );

        // Ghi log trạng thái
        (new BookingStatusModel())->insertBookingLog(
            $databooking['booking_id'],
            $databooking['status_type_code_master'],
            $newBookingStatus['code'],
            $_SESSION['admin_logged']['id'],
            "Cập nhật trạng thái phân hường dẫn viên ( đang chờ xác nhận)"
        );

        // echo '<pre>';
        // var_dump($idSchedules);
        // var_dump($idScheduleStatus);
        // echo '<pre>';
        // die;
        // ✔ Thành công
        $_SESSION['success_message'] = "Phân Hướng dẫn viên thành côgn đang chờ xác nhận! (Mã Booking: " . ($databooking['booking_code'] ?? '') . ")";
        header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
        exit;
    }
}
