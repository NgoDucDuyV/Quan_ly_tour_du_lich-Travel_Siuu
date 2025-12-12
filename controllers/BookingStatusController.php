<?php

use BcMath\Number;

class BookingStatusController
{

    // shor from cập nhất cọc tnah toán hoặc thanh toán
    public function ShowFormUpdateDeposit($booking_id)
    {
        // 1. Lấy thông tin booking
        $databooking = (new BookingModel())->getBookingById($booking_id);

        if (!$databooking) {
            header("Location: ?act=booking_list");
            exit;
        }

        // 2. Lấy danh sách loại trạng thái booking
        $bookingStatusTypes = (new BookingStatusModel())->getBookingStatusType();

        // 3. Lấy lịch sử booking
        $bookingLogs = (new BookingStatusModel())->getBookinglogsbyid($booking_id);

        // 4. Lấy phương thức thanh toán (Cash, Bank…)
        $paymentMethods = (new PaymentModel())->getPaymentMethods();

        // 5. Loại thanh toán (1 lần, cọc, trả trước…)
        $paymentTypes = (new PaymentModel())->getPaymentTypes();

        // 6. Trạng thái thanh toán (PAID, UNPAID, DEPOSIT…)
        $paymentStatusTypes = (new PaymentModel())->getPaymentStatusType();

        // 7. Lịch sử thanh toán
        $paymentLogs = (new PaymentModel())->getPaymentlogsbyid($booking_id);

        // 8. Giá booking
        $bookingPrices = (new PaymentModel())->getBookingPricesByBookingId($booking_id);

        // echo "<pre>";
        // var_dump($paymentStatusTypes);
        // echo "</pre>";
        // die;
        require_once "./views/Admin/booking_update_deposit.php";
    }


    // huy booking
    public function HuyBooking($booking_id)
    {
        $_SESSION['warning_message'] = "
            Để hủy booking, bạn cần cập nhật số tiền hoàn lại cho khách trước.
            Sau khi hoàn tiền xong, hãy tiến hành hủy booking.
        ";
        header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
        exit;
    }
    // khôi phục bôking
    public function RestoreBooking($booking_id)
    {

        $databooking   = (new BookingModel())->getBookingById($booking_id);

        // id trang thái mới
        $newIdBookingStatus = 1;
        $newBookingStatus = (new BookingStatusModel())->getBookingStatusTypeById($newIdBookingStatus);

        // Cập nhật trạng thái booking
        (new BookingStatusModel())->updateStatusByBookingId(
            $databooking['booking_id'],
            $newIdBookingStatus,
            1,
            'Khôi phục booking'
        );

        // Ghi log trạng thái
        (new BookingStatusModel())->insertBookingLog(
            $databooking['booking_id'],
            $databooking['status_type_code_master'],
            $newBookingStatus['code'],
            $_SESSION['admin_logged']['id'],
            "Khôi phục hoạt dộng booking!"
        );


        $_SESSION['success_message'] =
            "Khôi phục thành công! Booking <strong>#{$databooking['booking_code']}</strong> 
            đã được kích hoạt lại và có thể tiếp tục xử lý như bình thường.";

        header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
        exit;
    }



    // update thành toán cập nhật thanh toán
    public function UpdatePayment($booking_id)
    {
        $databooking   = (new BookingModel())->getBookingById($booking_id);
        $bookingPrices = (new PaymentModel())->getBookingPricesByBookingId($booking_id);

        // Nếu không phải POST → quay lại form
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = "Vui lòng gửi đầy đủ thông tin!";
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
            exit;
        }

        $data = $_POST;
        $file = $_FILES['payment_image'] ?? null;

        $required = [
            'amount'                  => 'Số tiền',
            'payment_method_id'       => 'Phương thức thanh toán',
            'payment_type_id'         => 'Loại thanh toán',
            'payment_status_type_id'  => 'Trạng thái thanh toán',
            'booking_status_type_id'  => 'Trạng thái booking',
        ];

        $errors = [];
        foreach ($required as $key => $label) {
            if (empty(trim($data[$key]))) {
                $errors[] = "$label không được để trống!";
            }
        }

        if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
            $errors[] = "Vui lòng tải lên ảnh minh chứng thanh toán!";
        }

        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>• ', $errors);
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
            exit;
        }

        $imagePayment = null;
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $imagePayment = uploadImage("public/upload/imagePayment", $file);
        }

        $amount = (float)str_replace(['.', ','], '', $data['amount']); // loại bỏ dấu chấm phẩy
        $currentPaid = (float)($bookingPrices[0]['paid_amount'] ?? 0);

        $newBookingStatus = (new BookingStatusModel())->getBookingStatusTypeById($data['booking_status_type_id']);
        // thanh toán hủy hàon tiền lưu 
        if (
            $data['booking_status_type_id'] == 8 &&
            $data['payment_status_type_id'] == 4 &&
            $data['payment_type_id'] == 3
        ) {
            $refundAmount = $amount;
            $newPaidAmount = $currentPaid - $refundAmount;

            // Cập nhật tiền đã thu (trừ đi tiền hoàn)
            (new PaymentModel())->updatePaidAmount($databooking['booking_id'], $newPaidAmount);

            // Cập nhật trạng thái booking
            (new BookingStatusModel())->updateStatusByBookingId(
                $databooking['booking_id'],
                $data['booking_status_type_id'],
                $data['payment_status_type_id'],
                $data['note'] ?? 'Hủy booking và hoàn tiền theo chính sách'
            );

            // Ghi log trạng thái
            (new BookingStatusModel())->insertBookingLog(
                $databooking['booking_id'],
                $databooking['status_type_code_master'],
                $newBookingStatus['code'],
                $_SESSION['admin_logged']['id'],
                "Hủy booking - Hoàn tiền: " . number_format($refundAmount) . "₫"
            );


            // Ghi log thanh toán (hoàn tiền)
            (new PaymentModel())->insertPaymentLog(
                $databooking['booking_id'],
                -$refundAmount, // số âm = hoàn tiền
                $data['payment_method_id'],
                $data['payment_type_id'],
                $data['payment_status_type_id'],
                $data['transaction_code'] ?? 'hoantien_' . time(),
                $imagePayment,
                $data['note'] ?? 'Hoàn tiền khi hủy booking',
                $_SESSION['admin_logged']['id']
            );

            $_SESSION['success_message'] = "Hủy booking và hoàn tiền thành công!<br>
            Đã hoàn: <strong>" . number_format($refundAmount) . "₫</strong><br>
            Số tiền còn lại trong hệ thống: <strong>" . number_format($newPaidAmount) . "₫</strong>";

            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
            exit;
        }

        // thanht toán một phần đúng điều kiện
        if (
            $data['payment_status_type_id'] == 5 && // Thanh toán một phần
            $data['payment_type_id'] == 2         // Thanh toán
        ) {
            $newPaidAmount = $currentPaid + $amount;

            (new PaymentModel())->updatePaidAmount($databooking['booking_id'], $newPaidAmount);

            (new BookingStatusModel())->updateStatusByBookingId(
                $databooking['booking_id'],
                $data['booking_status_type_id'],
                $data['payment_status_type_id'],
                $data['note'] ?? 'Thanh toán thêm một phần'
            );

            // Ghi log trạng thái
            (new BookingStatusModel())->insertBookingLog(
                $databooking['booking_id'],
                $databooking['status_type_code_master'],
                $newBookingStatus['code'],
                $_SESSION['admin_logged']['id'],
                "Thanh toán một phần - Thêm số tiền: " . number_format($amount) . "₫"
            );

            (new PaymentModel())->insertPaymentLog(
                $databooking['booking_id'],
                $amount,
                $data['payment_method_id'],
                $data['payment_type_id'],
                $data['payment_status_type_id'],
                $data['transaction_code'] ?? 'thanhtoan_' . time(),
                $imagePayment,
                $data['note'],
                $_SESSION['admin_logged']['id']
            );

            $_SESSION['success_message'] = "Cập nhật thanh toán một phần thành công!<br>
            Đã thu thêm: <strong>" . number_format($amount) . "₫</strong>";

            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
            exit;
        }

        // kiểm tra điều kiện để huyt báo lỗi
        if (
            $data['booking_status_type_id'] == 8 ||
            $data['payment_status_type_id'] == 4 ||
            $data['payment_type_id'] == 3
        ) {
            $_SESSION['error_message'] = "Không thể thực hiện!<br>
            Để <strong>hủy booking và hoàn tiền</strong>, bạn phải chọn đúng cả 3:<br>
            • Trạng thái booking: <strong>Đã hủy</strong><br>
            • Trạng thái thanh toán: <strong>Đã hoàn tiền</strong><br>
            • Loại thanh toán: <strong>Hoàn tiền</strong>";
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
            exit;
        }
        // kiểm tra hành toán option thanh toán một phần
        if (
            $data['payment_status_type_id'] == 5
            // $data['payment_type_id'] == 2
        ) {
            $_SESSION['error_message'] = "Không thể thực hiện!<br>
            Để <strong>thanh toán một phần</strong>, bạn phải chọn đúng cả 2:<br>
            • Trạng thái thanh toán: <strong>Thanh toán một phần</strong><br>
            • Loại thanh toán: <strong>Thanh toán</strong>";
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
            exit;
        }

        // cọc tiền bình thường
        $newPaidAmount = $currentPaid + $amount;

        // Cập nhật tiền đã thu
        (new PaymentModel())->updatePaidAmount($databooking['booking_id'], $newPaidAmount);

        // Cập nhật trạng thái booking
        (new BookingStatusModel())->updateStatusByBookingId(
            $databooking['booking_id'],
            $data['booking_status_type_id'],
            $data['payment_status_type_id'],
            $data['note']
        );

        //lịch sử trang thái bôking
        $newStatusCode = (new BookingStatusModel())->getBookingStatusTypeById($data['booking_status_type_id'])['code'];
        (new BookingStatusModel())->insertBookingLog(
            $databooking['booking_id'],
            $databooking['status_type_code_master'],
            $newStatusCode,
            $_SESSION['admin_logged']['id'],
            $data['note'] ?? 'Cập nhật thanh toán và trạng thái'
        );

        //lịch sửu thanh toán 
        (new PaymentModel())->insertPaymentLog(
            $databooking['booking_id'],
            $amount,
            $data['payment_method_id'],
            $data['payment_type_id'],
            $data['payment_status_type_id'],
            $data['transaction_code'] ?? null,
            $imagePayment,
            $data['note'],
            $_SESSION['admin_logged']['id']
        );

        $_SESSION['success_message'] = "Cập nhật thanh toán thành công!<br>
        Đã thu thêm: <strong>" . number_format($amount) . "₫</strong><br>
        Tổng đã thu: <strong>" . number_format($newPaidAmount) . "₫</strong>";

        header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
        exit;
    }


    // update cập nhật cọc thanh toán
    public function UpdateDeposit($booking_id)
    {
        $databooking   = (new BookingModel())->getBookingById($booking_id);
        $bookingPrices = (new PaymentModel())->getBookingPricesByBookingId($booking_id);
        $totalAmount   = (float)($databooking['total_price'] ?? 0);
        $currentPaid   = (float)($bookingPrices[0]['paid_amount'] ?? 0);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = "Vui lòng gửi đầy đủ thông tin!";
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_deposit&booking_id=" . $booking_id);
            exit;
        }

        $data = $_POST;
        $file = $_FILES['payment_image'] ?? null;

        $required = [
            'amount'                  => 'Số tiền',
            'payment_method_id'       => 'Phương thức thanh toán',
            'payment_type_id'         => 'Loại thanh toán',
            'payment_status_type_id'  => 'Trạng thái thanh toán',
            'booking_status_type_id'  => 'Trạng thái booking',
        ];

        $errors = [];
        foreach ($required as $key => $label) {
            if (empty(trim($data[$key] ?? ''))) {
                $errors[] = "$label không được để trống!";
            }
        }
        if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
            $errors[] = "Vui lòng tải lên ảnh minh chứng!";
        }
        if (!empty($errors)) {
            $_SESSION['error_message'] = implode('<br>• ', $errors);
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_deposit&booking_id=" . $booking_id);
            exit;
        }

        $amount = (float)str_replace(['.', ','], '', $data['amount']);

        if ($amount <= 0) {
            $_SESSION['error_message'] = "Số tiền phải lớn hơn 0!";
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_deposit&booking_id=" . $booking_id);
            exit;
        }

        // Upload ảnh
        $imagePayment = null;
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $imagePayment = uploadImage("public/upload/imagePayment", $file);
        }

        // Lấy code trạng thái booking mới để ghi log
        $newBookingStatus = (new BookingStatusModel())->getBookingStatusTypeById($data['booking_status_type_id']);

        // đạt cọc
        $isDeposit = (
            $data['booking_status_type_id'] == 2 && // ĐÃ ĐẶT CỌC
            $data['payment_status_type_id'] == 2 && // ĐÃ ĐẶT CỌC
            $data['payment_type_id'] == 1           // Đặt cọc
        );

        if ($isDeposit) {
            // Kiểm tra không cho cọc quá 70%
            if ($amount > $totalAmount * 0.7) {
                $_SESSION['error_message'] = "Số tiền cọc không được vượt quá 70% tổng tiền tour!<br>
                Tối đa cọc: <strong>" . number_format($totalAmount * 0.7) . "₫</strong>";
                header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_deposit&booking_id=" . $booking_id);
                exit;
            }

            $newPaid = $currentPaid + $amount;

            (new PaymentModel())->updatePaidAmount($databooking['booking_id'], $newPaid);

            (new BookingStatusModel())->updateStatusByBookingId(
                $databooking['booking_id'],
                2,
                2,
                $data['note']
            );

            (new BookingStatusModel())->insertBookingLog(
                $databooking['booking_id'],
                $databooking['status_type_code_master'],
                $newBookingStatus['code'],
                $_SESSION['admin_logged']['id'],
                "Đặt cọc: +" . number_format($amount) . "₫"
            );

            (new PaymentModel())->insertPaymentLog(
                $databooking['booking_id'],
                $amount,
                $data['payment_method_id'],
                $data['payment_type_id'],
                $data['payment_status_type_id'],
                $data['transaction_code'] ?? 'datcoc_' . time(),
                $imagePayment,
                $data['note'],
                $_SESSION['admin_logged']['id']
            );

            $_SESSION['success_message'] =
                "Xác nhận đặt cọc thành công!<br>
            Booking: <strong>#{$databooking['booking_code']}</strong><br>
            Đã thu: <strong>" . number_format($amount) . "₫</strong>";


            header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
            exit;
        }

        // thanh toán đủ
        $isFullPayment = (
            $data['booking_status_type_id'] == 2 &&
            $data['payment_status_type_id'] == 3 &&
            $data['payment_type_id'] == 2      // Thanh toán
        );

        if ($isFullPayment) {
            $remaining = $totalAmount - $currentPaid;

            if ($amount < $remaining) {
                $_SESSION['error_message'] = "Số tiền chưa đủ để thanh toán 100%!<br>
                Còn thiếu: <strong>" . number_format($remaining) . "₫</strong>";
                header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_deposit&booking_id=" . $booking_id);
                exit;
            }

            $newPaid = $totalAmount;

            (new PaymentModel())->updatePaidAmount($databooking['booking_id'], $newPaid);

            (new BookingStatusModel())->updateStatusByBookingId(
                $databooking['booking_id'],
                $data['booking_status_type_id'],
                3, // ĐÃ THANH TOÁN ĐỦ
                $data['note']
            );

            (new BookingStatusModel())->insertBookingLog(
                $databooking['booking_id'],
                $databooking['status_type_code_master'],
                $newBookingStatus['code'],
                $_SESSION['admin_logged']['id'],
                "Thanh toán đủ: +" . number_format($amount) . "₫"
            );

            (new PaymentModel())->insertPaymentLog(
                $databooking['booking_id'],
                $amount,
                $data['payment_method_id'],
                $data['payment_type_id'],
                $data['payment_status_type_id'],
                $data['transaction_code'] ?? 'thanhtoan_' . time(),
                $imagePayment,
                $data['note'],
                $_SESSION['admin_logged']['id']
            );

            $_SESSION['success_message'] =
                "Thanh toán đủ thành công!<br>
            Booking: <strong>#{$databooking['booking_code']}</strong><br>
            Đã thanh toán <strong>100%</strong>: <strong>" . number_format($totalAmount) . "₫</strong>";


            header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
            exit;
        }

        // chọn sai các trường báo lỗi
        $_SESSION['error_message'] = "Không thể thực hiện!<br>
        Vui lòng chọn đúng một trong hai:<br><br>
        <strong>1. Đặt cọc:</strong><br>
        • Trạng thái booking: <strong>ĐÃ ĐẶT CỌC</strong><br>
        • Trạng thái thanh toán: <strong>ĐÃ ĐẶT CỌC</strong><br>
        • Loại thanh toán: <strong>Đặt cọc</strong><br><br>
        <strong>2. Thanh toán đủ:</strong><br>
        • Trạng thái thanh toán: <strong>ĐÃ THANH TOÁN ĐỦ</strong><br>
        • Loại thanh toán: <strong>Thanh toán</strong>";

        header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_deposit&booking_id=" . $booking_id);
        exit;
    }

    public function MarkUpComing($booking_id)
    {
        if (!$booking_id || !is_numeric($booking_id)) {
            $_SESSION['error_message'] = "ID booking không hợp lệ!";
            header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
            exit;
        }

        $bookingPrices = (new PaymentModel())->getBookingPricesByBookingId($booking_id);

        $bookingModel = new BookingModel();
        $schedulesModel = new SchedulesModel();
        $schedulesStatusModel = new ScheduleStatusModel();

        $databooking = $bookingModel->getBookingById($booking_id);
        if (!$databooking) {
            $_SESSION['error_message'] = "Không tìm thấy booking!";
            header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
            exit;
        }
        $schedule = $schedulesModel->getSchedulesStatusByBookingId($booking_id);
        // echo '<pre>';
        // var_dump($schedule[0]['schedule_id']);
        // echo '<pre>';
        // die;
        // Trường hợp chưa có lịch trình (chưa phân HDV)
        if (!$schedule || empty($schedule)) {
            $_SESSION['error_message'] = "Booking #{$databooking['booking_code']} chưa được phân công hướng dẫn viên!";
            header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
            exit;
        }

        $schedule = $schedule[0];

        $guideStatusCode = strtoupper($schedule['guide_status_code'] ?? '');
        $scheduleStatusCode = strtoupper($schedule['schedule_status_code'] ?? '');

        if ($guideStatusCode === 'PENDING') {
            $_SESSION['error_message'] = "Không thể cập nhật! HDV <strong>" . ($schedule['guide_name'] ?? 'chưa rõ') .
                "</strong> vẫn đang <strong class='text-orange-600'>Chờ xác nhận</strong> tour Booking #{$databooking['booking_code']}";
            header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
            exit;
        }

        $allowedScheduleStatus = ['PLANNED', 'CONFIRMED'];
        if (!in_array($scheduleStatusCode, $allowedScheduleStatus)) {
            $_SESSION['error_message'] = "Không thể cập nhật! Lịch trình đang ở trạng thái <strong>{$schedule['schedule_status_name_vn']}</strong> – không thể chuyển sang 'Sắp diễn ra'";
            header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
            exit;
        }

        // kiểm tra thanh toán
        if (empty($bookingPrices)) {
            $_SESSION['error_message'] = "Chưa có thông tin thanh toán cho Booking #{$databooking['booking_code']}!";
            header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
            exit;
        }

        $priceInfo = $bookingPrices[0];
        $remaining = (float)$priceInfo['remaining_amount'];

        if ($remaining > 0) {
            $formattedRemaining = number_format($remaining) . ' ₫';
            $formattedTotal     = number_format($priceInfo['total_price']) . ' ₫';
            $formattedPaid      = number_format($priceInfo['paid_amount']) . ' ₫';

            $_SESSION['error_message'] = "
            <div class='text-lefht'>
                <strong>Booking " . $databooking['booking_code'] . ": Không thể đánh dấu 'Sắp diễn ra'</strong> vì khách <strong class='text-red-600'>chưa thanh toán đủ</strong>!<br><br>
                <div class='bg-red-50 border border-red-200 rounded p-3 text-sm'>
                    • Tổng tiền: <strong>{$formattedTotal}</strong><br>
                    • Đã thanh toán: <strong class='text-emerald-600'>{$formattedPaid}</strong><br>
                    • <strong class='text-red-600'>Còn nợ: {$formattedRemaining}</strong>
                </div>
            </div>
        ";
            header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
            exit;
        }

        // id trang thái mới
        $newIdBookingStatus = 4;
        $newBookingStatus = (new BookingStatusModel())->getBookingStatusTypeById($newIdBookingStatus);

        // Cập nhật trạng thái booking
        (new BookingStatusModel())->updateStatusByBookingId(
            $databooking['booking_id'],
            $newIdBookingStatus,
            $databooking['payment_type_id_master'],
            'Đánh dấu sác nhận sắp diễn ra'
        );

        // Ghi log trạng thái
        (new BookingStatusModel())->insertBookingLog(
            $databooking['booking_id'],
            $databooking['status_type_code_master'],
            $newBookingStatus['code'],
            $_SESSION['admin_logged']['id'],
            "Xác Nhận Cập nhật trạng thái Sắp diễn ra !"
        );

        $updateData = [
            'schedule_status_code' => 'in_progress',     // hoặc 'confirmed' tùy bạn muốn
            'guide_status_code'    => 'ON_ROUTE',        // HDV đang di chuyển đến điểm đón
            'updated_at'           => date('Y-m-d H:i:s')
        ];
        $result = (new ScheduleStatusModel())->updateScheduleStatusByScheduleId(
            $schedule['schedule_id'],
            1,
            3,
            'planned',
            'ASSIGNED',
            "Đã xác nhập cập nhật phần tour thành công hướng dẫn viên chuyển hướng chờ ngày khở hành !"
        );
        if ($result) {
            // Ghi log (tùy chọn)
            // (new LogModel())->add("Admin đánh dấu tour BK{$databooking['booking_code']} là sắp diễn ra");    
            $_SESSION['success_message'] = "Đã cập nhật thành công! Booking <strong>#{$databooking['booking_code']}</strong> đã được chuyển sang trạng thái <strong class='text-emerald-600'>Sắp diễn ra / Đang di chuyển</strong>. HDV sẽ nhận thông báo.";
        } else {
            $_SESSION['error_message'] = "Cập nhật thất bại! Vui lòng thử lại.";
        }

        header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
        exit;
    }
}
