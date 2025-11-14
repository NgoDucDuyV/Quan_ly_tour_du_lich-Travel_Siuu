<?php
class AdminModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllUser()
    {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // trả về mảng, không cần public properties
    }

    public function signin($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1");
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // trả về mảng
    }

    public function getAdminById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // trả về mảng
    }

    // Lấy hướng dẫn viên (role_id = 2)
    public function getGuides()
    {
        $sql = "SELECT * FROM users WHERE role_id = 2";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy hướng dẫn viên (role_id = 3)
    public function getClients()
    {
        $sql = "SELECT * FROM users WHERE role_id = 3";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
