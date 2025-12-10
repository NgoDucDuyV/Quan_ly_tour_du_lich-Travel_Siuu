<?php
class ReportModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Lấy danh sách tour hoàn thành + giá tiền
    public function getCompletedTours()
{
    $sql = "SELECT id, name, price 
            FROM tours 
            WHERE status = 'completed'";

    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
