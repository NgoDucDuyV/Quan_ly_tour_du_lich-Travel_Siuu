<?php
class UserModel
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
        users.*,
        roles.name as role,
        roles.description
        FROM users 
        LEFT JOIN roles ON users.role_id = roles.id 
        WHERE email = :email AND password = :password
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



    public function getUsersByRoles(array $roles)
    {
        $placeholders = implode(',', array_fill(0, count($roles), '?'));
        $sql = "
        SELECT 
        users.*, 
        roles.name AS rolename
        FROM users
        LEFT JOIN roles ON users.role_id = roles.id
        WHERE roles.name IN ($placeholders)
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($roles);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
