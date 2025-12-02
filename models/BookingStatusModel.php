<?php
class BookingStatusModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getBookingStatusType()
    {
        $sql = "SELECT * FROM status_type";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookinglogsbyid($booking_id)
    {
        $sql = "SELECT * FROM booking_logs WHERE booking_id = :booking_id ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaymentTypes()
    {
        $sql = "SELECT * FROM payment_type ORDER BY id ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
