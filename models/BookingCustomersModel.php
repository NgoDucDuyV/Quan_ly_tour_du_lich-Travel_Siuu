<?php
class BookingCustomersModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getCustomerTypes()
    {
        $sql = "SELECT * FROM customer_types";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomersByBookingId($booking_id)
    {
        $sql = "SELECT 
                bc.*, 
                ct.code AS customer_type_code,
                ct.name AS customer_type_name,
                ct.price_percentage
            FROM booking_customers AS bc
            LEFT JOIN customer_types AS ct 
                ON bc.customer_type_id = ct.id
            WHERE bc.booking_id = :booking_id
            ORDER BY bc.id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":booking_id", $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Insert multiple passengers
    public function insertPassengers(array $passengers)
    {
        if (empty($passengers)) return;

        $sql = "INSERT INTO booking_customers 
            (booking_id, full_name, birth_year, passport, note, customer_type_id)
            VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        foreach ($passengers as $p) {
            try {
                $stmt->execute([
                    $p['booking_id'],
                    $p['full_name'],
                    $p['birth_year'] ?? null,
                    $p['passport'] ?? null,
                    $p['note'] ?? null,
                    $p['customer_type_id'] ?? 1
                ]);
            } catch (\PDOException $e) {
                // Lưu lỗi vào log hoặc hiển thị debug
                echo "Lỗi insert passenger: " . $e->getMessage() . "<br>";
            }
        }

        return true;
    }
}
