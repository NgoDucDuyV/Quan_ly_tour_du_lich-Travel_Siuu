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
                8, // Đã hủy
                4, // Đã hoàn tiền
                $data['note'] ?? 'Hủy booking và hoàn tiền theo chính sách'
            );

            // Ghi log trạng thái
            (new BookingStatusModel())->insertBookingLog(
                $databooking['booking_id'],
                $databooking['status_type_code_master'],
                'CANCELED',
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
                5,
                $data['note'] ?? 'Thanh toán thêm một phần'
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
            $data['payment_status_type_id'] == 5 ||
            $data['payment_type_id'] == 2
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


    public function UpdateDeposit($booking_id)
    {
        // echo "<pre>";
        // var_dump($booking_id);
        // echo "</pre>";
        // die;
        $databooking = (new BookingModel())->getBookingById($booking_id);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['success_message'] = "Mời điền đầy đủ thông tin cập nhật cọc xác nhận booking!";
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_deposit&booking_id=" . $booking_id);
            exit;
        }

        // 1. Nhận dữ liệu POST + FILES
        $data = $_POST;
        $data['files'] = $_FILES;

        function isBlank($value): bool
        {
            if (is_array($value)) {
                if (count($value) === 0) return true;
                foreach ($value as $v) {
                    if (!isBlank($v)) return false;
                }
                return true;
            }
            if (!isset($value)) return true;
            return trim((string)$value) === '';
        }

        $errors = [];

        foreach ($data as $key => $value) {
            if (isBlank($value)) {
                $errors[$key] = "Trường $key không được để trống!";
            }
        }

        if (isset($_FILES['deposit_file'])) {
            if ($_FILES['deposit_file']['error'] === UPLOAD_ERR_NO_FILE) {
                $errors['deposit_file'] = "Vui lòng tải lên file!";
            }
        }

        if (!empty($errors)) {
            $_SESSION['error_message'] = "Vui lòng điền đầy đủ tất cả các trường!";
            $_SESSION['errors'] = $errors;
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_deposit&booking_id=" . $booking_id);
            exit;
        }

        if ($data['booking_status_type_id'] == 1 || $data['payment_status_type_id'] == 1) {
            $_SESSION['error_message'] = "chọn trạng thái đặt cọc/thanh toán hợp lệ!";
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_deposit&booking_id=" . $booking_id);
            exit;
        }
        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
        // die;
        $dataNewBookingStatusTypeById = (new BookingStatusModel())->getBookingStatusTypeById($data['booking_status_type_id']);
        $dataNewPaymentMethodsById = (new PaymentModel())->getPaymentMethodsById($data['payment_status_type_id']);
        // cập nhật trạng thái booking
        (new BookingStatusModel())->updateStatusByBookingId(
            $databooking['booking_id'],
            $data['booking_status_type_id'],
            $data['payment_status_type_id'],
            $data['note']
        );
        // lịch sử thay đổi booking
        (new BookingStatusModel())->insertBookingLog(
            $databooking['booking_id'],
            $databooking['status_type_code_master'],
            $dataNewBookingStatusTypeById['code'],
            $_SESSION['admin_logged']['id'],
            $data['note']
        );

        // thay đổi trạng thái cập nhật tiền booking
        (new PaymentModel())->updatePaidAmount($databooking['booking_id'], $data['amount']);
        // lưu lịch sử thanh toán
        $imagePayment = null;
        if (!empty($data['files']['payment_image'])) {
            $imagePayment = uploadImage("public/upload/imagePayment", $data['files']['payment_image']);
        }
        // echo $imagePayment;
        // die;

        (new PaymentModel())->insertPaymentLog(
            $databooking['booking_id'],
            $data['amount'],
            $data['payment_method_id'],
            $data['payment_type_id'],
            $data['payment_status_type_id'],
            $transaction_code = empty($data['transaction_code'])
                ? 'thanhtoantienmat'
                : $data['transaction_code'],
            $imagePayment,
            $data['note'],
            $_SESSION['admin_logged']['id']
        );
        $_SESSION['success_message'] = "Cập nhật thành công mã đặt cọc/thanh toán cho booking CODE: " . $databooking['booking_code'];
        header("Location: " . BASE_URL . "?mode=admin&act=bookinglist&booking_id=" . $booking_id);
        exit;
    }
}
