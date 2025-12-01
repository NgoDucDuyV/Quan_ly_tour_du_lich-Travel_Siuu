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

    public function getAllSchedulesByid($supplier_id)
    {
        $sql = "
        SELECT 
            s.id AS schedule_id,
            s.tour_id,
            s.guide_id,
            s.start_date,
            s.end_date,
            s.meeting_point,
            s.vehicle,
            s.hotel AS schedule_hotel,
            s.restaurant AS schedule_restaurant,
            s.flight_info,
            s.status AS schedule_status,
            s.guide_notes,
            s.guide_status,
            b.id AS booking_id,
            b.booking_code,
            b.customer_name,
            b.customer_phone,
            b.customer_email,
            b.group_type,
            b.number_of_people,
            b.total_price AS booking_total_price,
            b.deposit_amount,
            b.paid_amount,
            bs.id AS booking_supplier_id,
            bs.service_description,
            bs.price AS service_price,
            sup.id AS supplier_id,
            sup.name AS supplier_name,
            sup.contact_name,
            sup.contact_phone,
            sup.contact_email,
            sup.address AS supplier_address
        FROM schedules s
        LEFT JOIN bookings b 
            ON s.tour_id = b.tour_id 
            AND s.start_date = b.start_date 
            AND s.end_date = b.end_date
            AND b.group_type = 'doan'
        LEFT JOIN booking_suppliers bs
            ON b.id = bs.booking_id
        LEFT JOIN suppliers sup
            ON bs.supplier_id = sup.id
        WHERE s.id = :supplier_id   -- <--- Thay số 1 bằng ID bạn muốn tìm
        ORDER BY b.id, bs.id;
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':supplier_id', $supplier_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
