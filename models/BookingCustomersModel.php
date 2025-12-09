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
