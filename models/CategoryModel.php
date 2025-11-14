<?php
class CategoryModel
{
    
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllCategories() 
    {
        $stmt = $this->conn->query("SELECT * FROM categories"); 
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }
}
?>