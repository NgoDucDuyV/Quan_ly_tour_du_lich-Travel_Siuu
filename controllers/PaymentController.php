<?php
class PaymentController
{
    public function ShowBookingUpdatePayment($booking_id)
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
        require_once "./views/Admin/booking_update_payment.php";
    }
}
