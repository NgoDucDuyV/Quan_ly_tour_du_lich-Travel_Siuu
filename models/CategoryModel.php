<?php
class CategoryModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
        // Bật chế độ báo lỗi cho PDO (nếu chưa bật ở connectDB)
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Lấy tất cả danh mục + đếm số tour
    public function getAllCategories()
    {
        $sql = "
            SELECT c.*, COUNT(t.id) AS total_tours 
            FROM categories c 
            LEFT JOIN tours t ON c.id = t.category_id 
            GROUP BY c.id 
            ORDER BY c.id DESC
        ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 danh mục theo id
    public function getById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm danh mục
    public function create($name, $description = '')
    {
        // Nếu bảng categories có created_at / updated_at mà KHÔNG có default
        // thì thêm luôn 2 cột này cho chắc
        $sql = "
            INSERT INTO categories (name, description, created_at, updated_at)
            VALUES (:name, :description, NOW(), NOW())
        ";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':description' => $description,
        ]);
    }

    // Cập nhật danh mục
    public function update($id, $name, $description = '')
    {
        $sql = "
            UPDATE categories 
            SET name = :name,
                description = :description,
                updated_at = NOW()
            WHERE id = :id
        ";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':id' => $id,
        ]);
    }

    // Xóa danh mục
    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
