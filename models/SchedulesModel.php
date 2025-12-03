<?php
class SchedulesModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllSchedulesByTourId($tour_id)
    {
        $sql = "
        SELECT 
        sch.*
        FROM schedules sch
        WHERE sch.tour_id = :tour_id
        -- Chỉ lấy những lịch CHƯA bị Đoàn nào chiếm giữ
        AND NOT EXISTS (
            SELECT 1
            FROM bookings b
            INNER JOIN group_type gt ON b.group_type_id = gt.id
            WHERE b.tour_id = sch.tour_id
                AND gt.group_code = 'DOAN'
                AND b.start_date <= sch.end_date
                AND b.end_date   >= sch.start_date
        )
        ORDER BY sch.start_date ASC;
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tour_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSchedulesByid($schedules_id)
    {
        $sql = "
        SELECT 
            bs.*, 
            s.name AS supplier_name,
            s.supplier_types_id,
            s.contact_name,
            s.contact_phone,
            s.contact_email,
            s.address,
            s.description
        FROM schedules sc
        JOIN booking_services bs ON bs.booking_id = sc.booking_id
        LEFT JOIN suppliers s ON bs.supplier_id = s.id
        WHERE sc.id = :schedules_id
        ORDER BY bs.id;
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':schedules_id', $schedules_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
