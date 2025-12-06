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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUserById(int $user_id)
    {
        $sql = "SELECT * FROM users WHERE id = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // trả về 1 user
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
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAdminById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // cập nhật khách hàng
    public function update($id, $data)
    {
        $sql = "UPDATE users SET 
                fullname = ?,  
                email = ?, 
                username = ?, 
                updated_at = NOW() 
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['fullname'],
            $data['email'],
            $data['username'],
            $id
        ]);
    }

    // tạo mới khách hàng
    public function create($data)
    {
        $sql = "INSERT INTO users (fullname, email, username, password, role_id, created_at, updated_at) 
                VALUES (?, ?, ?, ?, 3, NOW(), NOW())";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['fullname'],
            $data['email'],
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }

    // kiểm tra email hoặc username đã tồn tại
    public function exists($email, $username)
    {
        $sql = "SELECT id FROM users WHERE email = ? OR username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email, $username]);
        return $stmt->fetch() !== false;
    }

    // tạo nhân viên (admin hoặc guide) - có role_id
    public function createStaff($fullname, $email, $username, $password, $role_id)
    {
        $sql = "INSERT INTO users (fullname, email, username, password, role_id, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$fullname, $email, $username, $password, $role_id]);
    }

    // cập nhật nhân viên - có role_id
    public function updateStaff($id, $data)
    {
        $sql = "UPDATE users SET 
                fullname = ?, 
                email = ?, 
                username = ?, 
                role_id = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['fullname'],
            $data['email'],
            $data['username'],
            $data['role_id'],
            $id
        ]);
    }
}
