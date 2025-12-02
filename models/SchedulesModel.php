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
        SELECT sch.*
        FROM schedules sch
        JOIN bookings b 
        ON sch.tour_id = b.tour_id 
        AND sch.start_date <= b.start_date 
        AND sch.end_date >= b.end_date
        WHERE sch.tour_id = :tour_id AND b.group_type = 'doan'
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
