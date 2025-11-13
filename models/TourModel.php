<?php
class TourMedel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getall()
    {
        $stmt = $this->conn->query("SELECT * FROM tours");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

