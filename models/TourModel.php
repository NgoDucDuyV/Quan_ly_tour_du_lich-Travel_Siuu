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

    public function getByName($tour_name)
    {
        $stmt = $this->conn->prepare("
        SELECT 
        tours.*,
        categories.name as categoriesname,
        categories.description as categoriesdescription
        FROM tours
        LEFT JOIN categories on tours.category_id = categories.id
        WHERE REPLACE(LOWER(tours.name), ' ', '') LIKE :tour_name
        AND status = 'active'
        ORDER BY created_at DESC
    ");

        $search = '%' . str_replace(' ', '', strtolower($tour_name)) . '%';
        $stmt->bindParam(':tour_name', $search, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // trả về tất cả kết quả
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
            st.*
        FROM tours t
        JOIN tour_suppliers_types tst ON t.id = tst.tour_id
        JOIN supplier_types st ON tst.supplier_types_id = st.id
        WHERE t.id = :tour_id
        ORDER BY t.id, tst.id;
        ");
        $stmt->bindParam(":tour_id", $tour_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy chính sách tour
    public function TourPoliciesModel($tour_id)
    {
        $stmt = $this->conn->prepare("
        SELECT *
        FROM tour_policies
        WHERE tour_id = :tour_id
        ORDER BY id ASC
        ");
        $stmt->bindParam(":tour_id", $tour_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy hình ảnh tour
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

    public function TourVersionsModel($tour_id)
    {
        $stmt = $this->conn->prepare("
        SELECT * FROM tour_versions
        WHERE tour_id = :tour_id
        ");
        $stmt->bindParam(":tour_id", $tour_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // function getToursByCategory($category_id, $pdo)
    // {
    //     $stmt = $pdo->prepare("
    //     SELECT * FROM tours WHERE category_id = :category_id ORDER BY created_at DESC");
    //     $stmt->execute(['category_id' => $category_id]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function CreateTourModel($datatour)
    {
        // echo "<pre>";
        // var_dump($datatour);
        // echo "<pre>";
        $sql = "INSERT INTO tours
        (category_id, name, code, days, nights, description, itinerary, images, price, policy, status, created_at, updated_at)
        VALUES
        (:category_id, :name, :code, :days, :nights, :description, :itinerary, :images, :price, :policy, :status, :created_at, :updated_at)";
        $stmt = $this->conn->prepare($sql);
        $data = [
            ':category_id' => $datatour['category_id'],
            ':name'        => $datatour['name'],
            ':code'        => $datatour['code'],
            ':days'        => $datatour['days'],
            ':nights'      => $datatour['nights'],
            // ':duration'    => $datatour['days'] . ' ngày ' . $datatour['nights'] . ' đêm', // Ví dụ nối days + nights
            ':description' => $datatour['description'],
            ':itinerary'   => $datatour['itinerary'], // Nếu chưa có dữ liệu chi tiết hành trình
            ':images'      => $datatour['image'], // đường dẫn ảnh upload
            ':price'       => $datatour['price'],
            ':policy'      => $datatour['policy'],
            ':status'      => $datatour['status'],
            ':created_at'  => date('Y-m-d H:i:s'),
            ':updated_at'  => date('Y-m-d H:i:s')
        ];
        if ($stmt->execute($data)) {
            return $this->conn->lastInsertId();
        } else {
            print_r($stmt->errorInfo());
        }
    }

    public function CreateTourItineraries($datatouritineraries, $tour_id)
    {
        $sql = "INSERT INTO tour_itineraries 
                (tour_id, day_number, title, description, created_at, updated_at)
                VALUES 
                (:tour_id, :day_number, :title, :description, :created_at, :updated_at)";

        $stmt = $this->conn->prepare($sql);

        // Chuẩn bị dữ liệu bind
        $data = [
            ':tour_id'     => $tour_id,
            ':day_number'  => $datatouritineraries['day'],
            ':title'       => $datatouritineraries['title'],
            ':description' => $datatouritineraries['desc'],
            ':created_at'  => date('Y-m-d H:i:s'),
            ':updated_at'  => date('Y-m-d H:i:s')
        ];

        if ($stmt->execute($data)) {
            return $this->conn->lastInsertId();
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
    }

    public function CreateTourActivities($datatouractivities, $tour_itineraries_id)
    {
        // echo "<pre>";
        // var_dump($datatouractivities);
        // var_dump($tour_itineraries_id);
        // echo "</pre>";
        // die;
        $sql = "INSERT INTO tour_activities 
            (itinerary_id, time, activity, location, description, created_at, updated_at)
            VALUES 
            (:itinerary_id, :time, :activity, :location, :description, :created_at, :updated_at)";

        $stmt = $this->conn->prepare($sql);
        $data = [
            ':itinerary_id' => $tour_itineraries_id,
            ':time'         => $datatouractivities['time'] ?? '',
            ':activity'     => $datatouractivities['name'] ?? '',
            ':location'     => $datatouractivities['location'] ?? '',
            ':description'  => $datatouractivities['description'] ?? '',
            ':created_at'   => date('Y-m-d H:i:s'),
            ':updated_at'   => date('Y-m-d H:i:s')
        ];

        if ($stmt->execute($data)) {
            return $this->conn->lastInsertId();
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
    }

    public function CreateTourImages($datatourimages, $tour_id = null, $itinerary_id = null, $activity_id = null)
    {
        // echo "<pre>";
        // echo "Dữ liệu ảnh: ";
        // var_dump($datatourimages, "idtour$tour_id");
        // echo "<pre>";
        // die;

        $sql = "INSERT INTO tour_images
        (tour_id, activity_id, itinerary_id, image_url, description, created_at, updated_at)
        VALUES
        (:tour_id, :activity_id, :itinerary_id, :image_url, :description, :created_at, :updated_at)";

        $stmt = $this->conn->prepare($sql);

        $data = [
            ':tour_id'      => $tour_id,
            ':activity_id'  => $activity_id,
            ':itinerary_id' => $itinerary_id,
            ':image_url'    => $datatourimages['image'] ?? '',
            ':description'  => $datatourimages['desc'] ?? '',
            ':created_at'   => date('Y-m-d H:i:s'),
            ':updated_at'   => date('Y-m-d H:i:s')
        ];

        if ($stmt->execute($data)) {
            return $this->conn->lastInsertId();
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
    }

    public function CreateTourSuppliersTypes($datasupplierstype, $tour_id = null)
    {
        // echo "<pre>";
        // echo "Dữ liệu ảnh: ";
        // var_dump($datasupplierstype, "idtour$tour_id");
        // echo "<pre>";
        // die;

        $sql = "INSERT INTO tour_suppliers_types
            (tour_id, supplier_types_id, notes, created_at, updated_at)
            VALUES
            (:tour_id, :supplier_types_id, :notes, :created_at, :updated_at)";

        $stmt = $this->conn->prepare($sql);

        $data = [
            ':tour_id' => $tour_id,
            ':supplier_types_id' => $datasupplierstype['supplier_types_id'] ?? null,
            ':notes' => $datasupplierstype['note'] ?? '',
            ':created_at' => date('Y-m-d H:i:s'),
            ':updated_at' => date('Y-m-d H:i:s')
        ];

        if ($stmt->execute($data)) {
            return $this->conn->lastInsertId();
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
    }



    public function CreateTourVersions($datatourversions, $tour_id = null)
    {
        // echo "<pre>";
        // echo "Dữ liệu ảnh: ";
        // var_dump($datatourversions, "idtour : $tour_id");
        // echo "<pre>";
        // die;
        $sql = "INSERT INTO tour_versions
        (tour_id, name, season, price, start_date, end_date, status, created_at, updated_at)
        VALUES
        (:tour_id, :name, :season, :price, :start_date, :end_date, :status, :created_at, :updated_at)";

        $stmt = $this->conn->prepare($sql);

        $data = [
            ':tour_id'    => $tour_id,
            ':name'       => $datatourversions['name'] ?? '',
            ':season'     => $datatourversions['season'] ?? '',
            ':price'      => $datatourversions['price'] ?? 0,
            ':start_date' => $datatourversions['start_date'] ?? null,
            ':end_date'   => $datatourversions['end_date'] ?? null,
            ':status'     => $datatourversions['status'] ?? 1,
            ':created_at' => date('Y-m-d H:i:s'),
            ':updated_at' => date('Y-m-d H:i:s')
        ];

        if ($stmt->execute($data)) {
            return $this->conn->lastInsertId();
        } else {
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";
            return false;
        }
    }

    public function CreateTourPolicies($datatourpolicies, $tour_id = null)
    {
        // echo "<pre>";
        // var_dump($datatourpolicies, "idtour : $tour_id");
        // echo "</pre>";
        // die;

        $sql = "INSERT INTO tour_policies
        (tour_id, policy_type, description, created_at, updated_at)
        VALUES
        (:tour_id, :policy_type, :description, :created_at, :updated_at)";

        $stmt = $this->conn->prepare($sql);

        $data = [
            ':tour_id'      => $tour_id,
            ':policy_type'  => $datatourpolicies['type'] ?? '',
            ':description'  => $datatourpolicies['description'] ?? '',
            ':created_at'   => date('Y-m-d H:i:s'),
            ':updated_at'   => date('Y-m-d H:i:s')
        ];

        if ($stmt->execute($data)) {
            return $this->conn->lastInsertId();
        } else {
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";
            return false;
        }
    }




    public function DeleteTourModel($tour_id)
    {
        // echo "<pre>";
        // var_dump($tour_id);
        // echo "<pre>";
        // die;
        $stmt = $this->conn->prepare("
        DELETE FROM `tours` WHERE tours.id = :tour_id
        ");
        $stmt->bindParam(':tour_id', $tour_id, PDO::PARAM_INT);
        $stmt->execute();
    }

}
