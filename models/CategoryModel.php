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
        $stmt = $this->conn->query(
            "
        SELECT 
        categories.*,
        COUNT(tours.id) AS total_tours
        FROM categories
        LEFT JOIN tours ON categories.id = tours.category_id
        GROUP BY categories.id, categories.name
        ORDER BY total_tours DESC;
        "
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
