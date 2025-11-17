<?php
class BookingModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy toàn bộ booking (đúng như ảnh bạn chụp)
    public function getAllBookings()
    {
        $sql = "SELECT * FROM bookings ORDER BY created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tạo booking mới
    public function create($data)
    {
        $sql = "INSERT INTO bookings 
                (tour_id, tour_version_id, customer_name, customer_phone, customer_email, 
                 group_type, number_of_people, note, status, created_at, updated_at) 
                VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['tour_id'],
            $data['tour_version_id'],
            $data['customer_name'],
            $data['customer_phone'],
            $data['customer_email'],
            $data['group_type'],
            $data['number_of_people'],
            $data['note'],
            $data['status']
        ]);
    }
}