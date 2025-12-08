<?php
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
        $databooking = (new BookingModel())->getBookingById($booking_id);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = "Mời điền đầy đủ thông tin cập nhật cọc xác nhận booking!";
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
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
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
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
        if (
            $data['booking_status_type_id'] == '8' &&
            $data['payment_status_type_id'] == '4' &&
            $data['payment_type_id'] == '3'
        ) {
            (new PaymentModel())->updatePaidAmount($databooking['booking_id'], 0);
            $_SESSION['success_message'] = "Cập nhật Hủy Booking Hoàn tièn thành công!" . $databooking['booking_code'];
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
            exit;
        }
        if (
            $data['booking_status_type_id'] == '8' ||
            $data['payment_status_type_id'] == '4' ||
            $data['payment_type_id'] == '3'
        ) {
            $_SESSION['error_message'] = "Để hủy booking và hoàn tiền, bạn phải chọn đúng cả 3 mục:<br>
                • Trạng thái booking: <strong>Đã hủy</strong><br>
                • Trạng thái thanh toán: <strong>Đã hoàn tiền</strong><br>
                • Hình thức thanh toán: <strong>Thanh toán online</strong>";
            header("Location: " . BASE_URL . "?mode=admin&act=from_booking_update_payment&booking_id=" . $booking_id);
            exit;
        }
        if (
            $data['booking_status_type_id'] != 8
            || $data['payment_status_type_id'] != 4
            || $data['payment_type_id'] != 3
        ) {
            // thay đổi trạng thái cập nhật tiền booking
            (new PaymentModel())->updatePaidAmount($databooking['booking_id'], $data['amount']);
        }
        $_SESSION['success_message'] = "Cập nhật thành công mã đặt cọc/thanh toán cho booking CODE: " . $databooking['booking_code'];
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
