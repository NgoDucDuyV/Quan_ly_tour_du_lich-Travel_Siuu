<?php
class ReportModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public function getCompletedBookings() //lấy các tour đã hoàn thành
    {
        $today = today();
        $sql = "
            SELECT 
                b.id AS booking_id,
                b.booking_code,
                t.name AS tour_name,
                b.total_price AS price,
                b.start_date,
                b.end_date,
                b.customer_name
            FROM bookings b
            JOIN tours t ON b.tour_id = t.id
            WHERE b.end_date < :today          
            ORDER BY b.end_date DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'today' => $today
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getTotalRevenueCompleted() //tính tổng doanh thu các tour có trạng thái thành công
    {
        $sql = "
            SELECT COALESCE(SUM(b.total_price), 0)
            FROM bookings b
            WHERE b.end_date < CURDATE()
        ";

        $stmt = $this->conn->query($sql);
        return (int)$stmt->fetchColumn();
    }


    public function countCompletedBookings() //tính số bk đã hoàn thành
    {
        $sql = "
            SELECT COUNT(*)
            FROM bookings b
            WHERE b.end_date < CURDATE()
        ";

        $stmt = $this->conn->query($sql);
        return (int)$stmt->fetchColumn();
    }
}
