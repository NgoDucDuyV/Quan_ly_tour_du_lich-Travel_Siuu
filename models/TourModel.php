<?php
class TourModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAll()
    {
        $stmt = $this->conn->query("
        SELECT 
        tours.*,
        categories.name as categoriesname,
        categories.description as categoriesdescription
        FROM tours 
        LEFT JOIN categories on tours.category_id = categories.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($tour_id)
    {
        $stmt = $this->conn->prepare("
        SELECT 
        *
        FROM tours t
        WHERE t.id = :tour_id;
        ");
        $stmt->bindParam(":tour_id", $tour_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function TourDetailItineraryModel($tour_id)
    {
        $stmt = $this->conn->prepare("
        SELECT 
            t.id AS tour_id,
            t.name AS tour_name,
            t.code AS tour_code,
            t.duration,
            t.price,
            t.status,
            
            i.id AS itinerary_id,
            i.day_number,
            i.title AS itinerary_title,
            i.description AS itinerary_description,
            
            a.id AS activity_id,
            a.time AS activity_time,
            a.activity,
            a.location,
            a.description AS activity_description

        FROM tours t
        LEFT JOIN tour_itineraries i
            ON t.id = i.tour_id
        LEFT JOIN tour_activities a
            ON i.id = a.itinerary_id
        WHERE t.id = :tour_id
        ORDER BY i.day_number, a.time;
        ");
        $stmt->bindParam(":tour_id", $tour_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function TourSuppliersModel($tour_id)
    {
        $stmt = $this->conn->prepare("
        SELECT 
            t.id AS tour_id,
            t.name AS tour_name,
            s.id AS supplier_id,
            s.name AS supplier_name,
            ts.role,
            ts.notes
        FROM tours t
        JOIN tour_suppliers ts ON t.id = ts.tour_id
        JOIN suppliers s ON ts.supplier_id = s.id
        WHERE t.id = :tour_id
        ORDER BY t.id, s.id;

        ");
        $stmt->bindParam(":tour_id", $tour_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function TourImagesModel($tour_id)
    {
        $stmt = $this->conn->prepare("
        SELECT tour_images.* 
        FROM tours 
        LEFT JOIN tour_images ON tours.id = tour_images.tour_id
        WHERE tours.id = :tour_id
        ");
        $stmt->bindParam(":tour_id", $tour_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
