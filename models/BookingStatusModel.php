<?php
class BookingStatusModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getBookingStatusByIdBooking($booking_id)
    {
        $sql = "SELECT * FROM `booking_status`
            WHERE booking_status.id = :booking_id
            ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingStatusType()
    {
        $sql = "SELECT * FROM booking_status_type ORDER BY id ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingStatusTypeById($booking_status_type_id)
    {
        $sql = "SELECT * 
            FROM booking_status_type 
            WHERE id = :booking_status_type_id  
            ORDER BY id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['booking_status_type_id' => $booking_status_type_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);  // trả 1 dòng
    }


    // lịch sử booking 
    public function getBookinglogsbyid($booking_id)
    {
        $sql = "SELECT * FROM booking_logs WHERE booking_id = :booking_id ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // lch ử thay đỏi trang thái booking
    public function insertBookingLog(int $booking_id, string $old_status, string $new_status, int $updated_by, ?string $description = null): bool
    {
        $sqlLog = "INSERT INTO booking_logs
                (booking_id, old_status, new_status, description, updated_by, created_at)
                VALUES (:booking_id, :old_status, :new_status, :description, :updated_by, NOW())";
        $stmtLog = $this->conn->prepare($sqlLog);
        return $stmtLog->execute([
            ':booking_id' => $booking_id,
            ':old_status' => $old_status,
            ':new_status' => $new_status,
            ':description' => $description,
            ':updated_by' => $updated_by
        ]);
    }

    public function insertBookingStatusDefault($bookingId)
    {
        $bookingStatusTypeId  = 1;
        $paymentStatusTypeId  = 1;
        $bookingStatusCode    = 'PENDING';
        $paymentStatusCode    = 'UNPAID';
        $description          = 'Khởi tạo trạng thái đặt chỗ mặc định';

        $sql = "INSERT INTO booking_status
            (booking_id, booking_status_type_id, payment_status_type_id, booking_status_type_code, payment_status_type_code, description)
            VALUES (?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                $bookingId,
                $bookingStatusTypeId,
                $paymentStatusTypeId,
                $bookingStatusCode,
                $paymentStatusCode,
                $description
            ]);
            return $this->conn->lastInsertId();
        } catch (\PDOException $e) {
            echo "Lỗi insert booking_status: " . $e->getMessage();
            return false;
        }
    }


    // update trạng thái booking và payment theo booking_id
    public function updateStatusByBookingId(
        int $booking_id,
        int $booking_status_type_id,
        int $payment_status_type_id,
        ?string $description = null
    ): bool {

        // Lấy code từ bảng liên quan
        $sqlCode = "SELECT 
                        bst.code AS booking_status_code,
                        pst.code AS payment_status_code
                    FROM booking_status_type bst
                    JOIN payment_status_type pst
                    WHERE bst.id = :bst_id AND pst.id = :pst_id
                    LIMIT 1";
        $stmtCode = $this->conn->prepare($sqlCode);
        $stmtCode->execute([
            ':bst_id' => $booking_status_type_id,
            ':pst_id' => $payment_status_type_id
        ]);
        $codes = $stmtCode->fetch(PDO::FETCH_ASSOC);
        if (!$codes) {
            return false; // Nếu không tìm thấy code, dừng
        }

        // Cập nhật booking_status
        $sqlUpdate = "UPDATE booking_status
                        SET booking_status_type_id = :booking_status_type_id,
                            payment_status_type_id = :payment_status_type_id,
                            booking_status_type_code = :booking_status_type_code,
                            payment_status_type_code = :payment_status_type_code,
                            description = :description
                        WHERE booking_id = :booking_id";
        $stmtUpdate = $this->conn->prepare($sqlUpdate);
        return $stmtUpdate->execute([
            ':booking_status_type_id' => $booking_status_type_id,
            ':payment_status_type_id' => $payment_status_type_id,
            ':booking_status_type_code' => $codes['booking_status_code'],
            ':payment_status_type_code' => $codes['payment_status_code'],
            ':description' => $description,
            ':booking_id' => $booking_id
        ]);
    }
}
