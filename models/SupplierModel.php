<?php
class SupplierModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }


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

    public function supplier_types()
    {
        $stmt = $this->conn->query("
        SELECT * FROM `supplier_types` 
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Lấy 1 nhà cung cấp theo id (dùng cho form edit)
    public function getSupplierById($id)
    {
        $sql = "
            SELECT 
                s.*,
                st.name AS supplier_type_name
            FROM suppliers s
            LEFT JOIN supplier_types st ON s.supplier_types_id = st.id
            WHERE s.id = :id
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm nhà cung cấp
    public function createSupplier($data)
    {
        $sql = "
            INSERT INTO suppliers 
                (name, supplier_types_id, contact_name, contact_phone, contact_email, address, description)
            VALUES
                (:name, :supplier_types_id, :contact_name, :contact_phone, :contact_email, :address, :description)
        ";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':supplier_types_id' => $data['supplier_types_id'] !== '' ? $data['supplier_types_id'] : null,
            ':contact_name' => $data['contact_name'] ?? null,
            ':contact_phone' => $data['contact_phone'] ?? null,
            ':contact_email' => $data['contact_email'] ?? null,
            ':address' => $data['address'] ?? null,
            ':description' => $data['description'] ?? null,
        ]);
    }

    // Cập nhật nhà cung cấp
    public function updateSupplier($id, $data)
    {
        $sql = "
            UPDATE suppliers SET
                name              = :name,
                supplier_types_id = :supplier_types_id,
                contact_name      = :contact_name,
                contact_phone     = :contact_phone,
                contact_email     = :contact_email,
                address           = :address,
                description       = :description
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':supplier_types_id' => $data['supplier_types_id'] !== '' ? $data['supplier_types_id'] : null,
            ':contact_name' => $data['contact_name'] ?? null,
            ':contact_phone' => $data['contact_phone'] ?? null,
            ':contact_email' => $data['contact_email'] ?? null,
            ':address' => $data['address'] ?? null,
            ':description' => $data['description'] ?? null,
            ':id' => $id,
        ]);
    }

    // Kiểm tra có thể xoá supplier không (có booking_suppliers tham chiếu không)
    public function canDeleteSupplier($id)
    {
        // nếu trong DB có bảng booking_suppliers thì check, không có thì bạn có thể bỏ hàm này
        $sql = "SELECT COUNT(*) FROM booking_suppliers WHERE supplier_id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            $count = $stmt->fetchColumn();
            return $count == 0;
        } catch (PDOException $e) {
            // Nếu bảng không tồn tại thì coi như cho xoá
            return true;
        }
    }

    // Xoá nhà cung cấp
    public function deleteSupplier($id)
    {
        if (!$this->canDeleteSupplier($id)) {
            return false;
        }

        $sql = "DELETE FROM suppliers WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // ================== CODE MỚI THÊM – CRUD SUPPLIER_TYPES ==================

    // Lấy 1 loại dịch vụ theo id
    public function getSupplierTypeById($id)
    {
        $sql = "SELECT * FROM supplier_types WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm loại dịch vụ
    public function createSupplierType($data)
    {
        $sql = "
            INSERT INTO supplier_types
                (name, description, stars, quality)
            VALUES
                (:name, :description, :stars, :quality)
        ";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'] ?? null,
            ':stars' => (int) ($data['stars'] ?? 0),
            ':quality' => $data['quality'] ?? 'Tốt',
        ]);
    }

    // Cập nhật loại dịch vụ
    public function updateSupplierType($id, $data)
    {
        $sql = "
            UPDATE supplier_types SET
                name        = :name,
                description = :description,
                stars       = :stars,
                quality     = :quality
            WHERE id = :id
        ";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'] ?? null,
            ':stars' => (int) ($data['stars'] ?? 0),
            ':quality' => $data['quality'] ?? 'Tốt',
            ':id' => $id,
        ]);
    }

    // Kiểm tra có thể xoá loại dịch vụ không
    public function canDeleteSupplierType($id)
    {
        // 1. Đã có supplier dùng loại này chưa?
        $sql1 = "SELECT COUNT(*) FROM suppliers WHERE supplier_types_id = :id";
        $stmt1 = $this->conn->prepare($sql1);
        $stmt1->execute([':id' => $id]);
        $countSup = $stmt1->fetchColumn();

        // 2. Đã có tour_suppliers_types tham chiếu chưa?
        $sql2 = "SELECT COUNT(*) FROM tour_suppliers_types WHERE supplier_types_id = :id";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->execute([':id' => $id]);
        $countTour = $stmt2->fetchColumn();

        return ($countSup + $countTour) == 0;
    }

    // Xoá loại dịch vụ
    public function deleteSupplierType($id)
    {
        if (!$this->canDeleteSupplierType($id)) {
            return false;
        }

        $sql = "DELETE FROM supplier_types WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
