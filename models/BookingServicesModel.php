<?php
class BookingServicesModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Insert multiple services
    public function insertServices(array $services)
    {
        if (empty($services)) return;

        $sql = "INSERT INTO booking_services 
            (booking_id, supplier_id, supplier_type_id, service_name, service_quantity, service_price, service_note, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        foreach ($services as $s) {
            try {
                $stmt->execute([
                    $s['booking_id'],
                    $s['supplier_id'] ?? null,
                    $s['supplier_type_id'] ?? null,
                    $s['service_name'] ?? '',
                    $s['service_quantity'] ?? 1,
                    $s['service_price'] ?? 0,
                    $s['service_note'] ?? null,
                    $s['created_at'],
                    $s['updated_at'],
                ]);
            } catch (\PDOException $e) {
                echo "Lỗi insert service: " . $e->getMessage() . "<br>";
            }
        }

        return true;
    }
}
