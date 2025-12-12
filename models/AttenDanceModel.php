<?php
class AttenDanceModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }
}
