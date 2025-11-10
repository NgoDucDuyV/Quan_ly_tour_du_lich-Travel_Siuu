<?php
class AuthModel
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
        $stmt = $this->conn->prepare("
        SELECT 
        users.id,
        users.username,
        users.email,
        users.password,
        roles.name as role,
        users.created_at,
        users.updated_at,
        roles.description
        FROM users LEFT JOIN roles ON users.role_id = roles.id WHERE email = :email AND password = :password
        ");
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
}
