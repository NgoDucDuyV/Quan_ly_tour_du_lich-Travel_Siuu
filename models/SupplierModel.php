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
}
