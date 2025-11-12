<?php
class TourModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB(); 
    }

    // Lấy dữ liệu cho dropdowns
    public function getAllCategories() 
    {
        $stmt = $this->conn->query("SELECT id, name AS title FROM categories ORDER BY name ASC"); 
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    public function getAllGuides()
    {
        $stmt = $this->conn->query("SELECT id, name FROM guides WHERE status = 'available' ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }
    
    // Hàm INSERT dữ liệu tour mới
    public function insertNewTour($data)
    {
        $sql = "INSERT INTO tour 
                (category_id, name, code, duration, description, images, price, policy, supplier, status, created_at, updated_at) 
                VALUES (:category_id, :name, :code, :duration, :description, :images, :price, :policy, :supplier, 'active', NOW(), NOW())";
                
        $stmt = $this->conn->prepare($sql);
        
        return $stmt->execute([
            ':category_id' => $data['category_id'],
            ':name'        => $data['name'],
            ':code'        => $data['code'],
            ':duration'    => $data['duration'],
            ':description' => $data['description'],
            ':images'      => $data['images'],
            ':price'       => $data['price'],
            ':policy'      => $data['policy'],
            ':supplier'    => $data['supplier'],
        ]);
    }
}