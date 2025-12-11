<?php
class BookingServicesModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getServicesByBookingId(int $booking_id): array
    {
        $sql = "SELECT 
                bs.id,
                bs.booking_id,
                bs.supplier_id,
                bs.supplier_type_id,
                bs.service_name,
                bs.service_quantity,
                bs.service_price,
                bs.service_note,
                bs.created_at,
                bs.updated_at
            FROM booking_services bs
            WHERE bs.booking_id = :booking_id
            ORDER BY bs.id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':booking_id' => $booking_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
