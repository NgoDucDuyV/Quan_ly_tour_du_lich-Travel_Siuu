<?php
class BookingCustomers
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
}
