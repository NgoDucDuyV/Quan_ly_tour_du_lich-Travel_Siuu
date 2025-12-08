<?php

use BcMath\Number;

class BookingStatusController
{

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

        // Ghi log trạng thái
        (new BookingStatusModel())->insertBookingLog(
            $databooking['booking_id'],
            $databooking['status_type_code_master'],
            $newBookingStatus['code'],
            $_SESSION['admin_logged']['id'],
            "Đặt cọc: +" . number_format($amount) . "₫"
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

            $_SESSION['success_message'] = "Xác nhận đặt cọc thành công!<br>
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

            $_SESSION['success_message'] = "Thanh toán đủ thành công!<br>
            Booking đã được thanh toán <strong>100%</strong>: <strong>" . number_format($totalAmount) . "₫</strong>";

            header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
            exit;
        }

        // ==================================================================
        // 3. BÁO LỖI NẾU CHỌN SAI
        // ==================================================================
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
}
