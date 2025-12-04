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
        $sql = "SELECT c.*, COUNT(t.id) AS total_tours 
                FROM categories c 
                LEFT JOIN tours t ON c.id = t.category_id 
                GROUP BY c.id 
                ORDER BY c.id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $description = '')
    {
        $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $description]);
    }

    public function update($id, $name, $description = '')
    {
        $sql = "UPDATE categories SET name = ?, description = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $description, $id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}