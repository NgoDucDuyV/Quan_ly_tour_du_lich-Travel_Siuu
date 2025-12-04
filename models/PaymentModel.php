<?php
class PaymentModel
{
    private $conn;
    protected $table = 'booking_payments';

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy danh sách phương thức thanh toán
    public function getPaymentMethods(): array
    {
        $sql = "SELECT * FROM `payment_methods` ORDER BY `id` ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin giá theo booking_id
    public function getBookingPricesByBookingId($booking_id): array
    {
        $sql = "SELECT * FROM `booking_prices`
            WHERE booking_id = :booking_id
            ORDER BY id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // lịch sử thanh toán theo booking_id
    public function getPaymentlogsbyid($booking_id)
    {
        $sql = "SELECT * FROM payments_logs WHERE booking_id = :booking_id ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy tất cả loại hình thanh toán
    public function getPaymentTypes()
    {
        $sql = "SELECT * FROM payment_type ORDER BY id ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả trạng thái thanh toán
    public function getPaymentStatusType()
    {
        $sql = "SELECT * FROM payment_status_type ORDER BY id ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
