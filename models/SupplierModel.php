<?php
class SupplierModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy danh sách nhà cung cấp (có tên loại dịch vụ)
    public function getallSupplier()
    {
        $stmt = $this->conn->query("
        SELECT 
            s.id AS supplier_id,
            s.name AS supplier_name,
            s.contact_name,
            s.contact_phone,
            s.contact_email,
            s.address,
            s.description AS supplier_description,
            s.created_at AS supplier_created_at,
            s.updated_at AS supplier_updated_at,
            st.id AS type_id,
            st.name AS type_name,
            st.description AS type_description,
            st.stars AS type_stars,
            st.quality AS type_quality,
            st.created_at AS type_created_at,
            st.updated_at AS type_updated_at
        FROM suppliers s
        LEFT JOIN supplier_types st ON s.supplier_types_id = st.id;
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getallsupplier_types()
    {
        $stmt = $this->conn->query("
        SELECT 
            st.id, 
            st.name, 
            IFNULL(st.description,'Không có mô tả') AS description,
            st.stars, 
            st.quality, 
            st.created_at, 
            st.updated_at,
            COUNT(s.id) AS total_suppliers,
            COUNT(tst.supplier_types_id) AS total_tour
        FROM supplier_types st
        LEFT JOIN suppliers s ON s.supplier_types_id = st.id
        LEFT JOIN tour_suppliers_types tst ON st.id = tst.supplier_types_id
        GROUP BY st.id
        ORDER BY total_suppliers DESC;
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getallTour_supplier_types($tour_id)
    {
        $sql = "
        SELECT 
            tst.id AS tour_supplier_type_id,
            tst.tour_id,
            st.id AS supplier_type_id,
            st.name AS supplier_type_name,
            st.description,
            st.stars,
            st.quality,
            tst.notes,
            tst.created_at,
            tst.updated_at
        FROM tour_suppliers_types AS tst
        JOIN supplier_types AS st 
            ON tst.supplier_types_id = st.id
        WHERE tst.tour_id = :tour_id
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tour_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSuppliersByType($supplier_type_id)
    {
        $sql = "
            SELECT s.*
            FROM supplier_has_types sht
            JOIN suppliers s 
                ON s.id = sht.supplier_id
            WHERE sht.supplier_type_id = :supplier_type_id
            ORDER BY s.id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['supplier_type_id' => $supplier_type_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getsupplierPricesBySupplierId($supplier_id)
    {
        $sql = "
            SELECT * FROM supplier_prices 
            WHERE supplier_prices.supplier_type_id = :supplier_id
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['supplier_id' => $supplier_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function supplier_types()
    {
        $stmt = $this->conn->query("
        SELECT * FROM `supplier_types` 
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy loại dịch vụ theo id
    public function getSupplierTypeById($id)
    {
        $sql = "SELECT * FROM supplier_types WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm mới loại dịch vụ 
    public function addSupplierType($name, $description = '', $stars = 3, $quality = 'Tốt')
    {
        $name        = addslashes($name);
        $description = addslashes($description);
        $now = date('Y-m-d H:i:s');

        $sql = "INSERT INTO supplier_types 
                (name, description, stars, quality, created_at, updated_at) 
                VALUES 
                ('$name', '$description', '$stars', '$quality', '$now', '$now')";

        return $this->conn->query($sql);
    }

    // Sửa loại dịch vụ 
    public function updateSupplierType($id, $name, $description = '', $stars = 3, $quality = 'Tốt')
    {
        $id          = (int)$id;
        $name        = addslashes($name);
        $description = addslashes($description);
        $now         = date('Y-m-d H:i:s');

        $sql = "UPDATE supplier_types SET
                name        = '$name',
                description = '$description',
                stars       = '$stars',
                quality     = '$quality',
                updated_at  = '$now'
                WHERE id = $id";

        return $this->conn->query($sql);
    }

    public function deleteSupplierType($id)
    {
        try {
            $check = $this->conn->prepare("SELECT COUNT(*) FROM suppliers WHERE supplier_types_id = ?");
            $check->execute([$id]);
            if ($check->fetchColumn() > 0) {
                return false;
            }

            $sql = "DELETE FROM supplier_types WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Lấy thông tin 1 nhà cung cấp theo ID (dùng cho Edit)
    public function getSupplierById($id)
    {
        $sql = "SELECT s.*, st.name AS type_name 
                FROM suppliers s 
                LEFT JOIN supplier_types st ON s.supplier_types_id = st.id 
                WHERE s.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm nhà cung cấp
    public function addSupplier($data)
    {
        $sql = "INSERT INTO suppliers 
                (name, supplier_types_id, contact_name, contact_email, contact_phone, address, description, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['supplier_types_id'],
            $data['contact_name'] ?? null,
            $data['contact_email'] ?? null,
            $data['contact_phone'] ?? null,
            $data['address'] ?? null,
            $data['description'] ?? null
        ]);
    }

    // Sửa nhà cung cấp
    public function updateSupplier($id, $data)
    {
        $sql = "UPDATE suppliers SET 
                name = ?, supplier_types_id = ?, contact_name = ?, contact_email = ?, 
                contact_phone = ?, address = ?, description = ?, updated_at = NOW()
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['supplier_types_id'],
            $data['contact_name'] ?? null,
            $data['contact_email'] ?? null,
            $data['contact_phone'] ?? null,
            $data['address'] ?? null,
            $data['description'] ?? null,
            $id
        ]);
    }

    // Xóa nhà cung cấp
    public function deleteSupplier($id)
    {
        $sql = "DELETE FROM suppliers WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>