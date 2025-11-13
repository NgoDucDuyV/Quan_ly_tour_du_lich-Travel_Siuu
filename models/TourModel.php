<?php
class TourModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB(); 
    }
    
    public function getAllGuides()
    {
        $stmt = $this->conn->query("SELECT id, name FROM guides WHERE status = 'available' ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }
    
    public function getAllTour(){
        $sql="SELECT
        t.id,
        t.name,
        t.description,
        t.updated_at
            FROM tours AS t
            ORDER BY t.updated_at DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
        
    }
 
    public function insertNewTour($data)
    {
        $sql = "INSERT INTO tours 
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