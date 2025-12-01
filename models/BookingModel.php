<?php
class BookingModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy toàn bộ booking
    public function getAllBookings()
    {

        $sql = "SELECT * FROM bookings ORDER BY created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingById($booking_id)
    {
        $booking_id = (int) $booking_id;

        $sql = "SELECT * FROM bookings WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $booking_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $booking = $stmt->fetch(PDO::FETCH_ASSOC);
            return $booking !== false ? $booking : null;
        }

        return null;
    }

    public function getAllBookingsByTourId($tour_id)
    {
        $sql = "SELECT * FROM bookings 
            WHERE bookings.tour_id = :tour_id  
            ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tour_id' => $tour_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả loại khách hàng
    public function getAlCustomerTypes()
    {
        // Không tìm kiếm → lấy tất cả
        $sql = "SELECT * FROM customer_types ";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAlGroupType()
    {
        // Không tìm kiếm → lấy tất cả
        $sql = "SELECT * FROM group_type ";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookings($keyword = '')
    {
        if ($keyword !== '') {
            $sql = "SELECT * FROM bookings 
                WHERE customer_name LIKE :keyword
                ORDER BY created_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':keyword' => "%$keyword%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Không tìm kiếm → lấy tất cả
        $sql = "SELECT * FROM bookings ORDER BY created_at DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingServicesWithSuppliers($booking_id)
    {
        $sql = "SELECT 
                bs.*, 
                s.name AS supplier_name, 
                s.supplier_types_id, 
                s.contact_name, 
                s.contact_phone, 
                s.contact_email, 
                s.address, 
                s.description AS supplier_description
            FROM booking_services bs
            LEFT JOIN suppliers s ON bs.supplier_id = s.id
            WHERE bs.booking_id = :booking_id
            ORDER BY bs.id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBookingLog(array $data)
    {
        // Kiểm tra dữ liệu bắt buộc
        if (empty($data['booking_id']) || empty($data['new_status'])) {
            throw new InvalidArgumentException("booking_id và new_status là bắt buộc");
        }

        $sql = "INSERT INTO booking_logs 
        (booking_id, old_status, new_status, description, updated_by, created_at)
        VALUES 
        (:booking_id, :old_status, :new_status, :description, :updated_by, :created_at)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':booking_id', (int)$data['booking_id'], PDO::PARAM_INT);
        $stmt->bindValue(':old_status', $data['old_status'] ?? '', PDO::PARAM_STR);
        $stmt->bindValue(':new_status', $data['new_status'], PDO::PARAM_STR);
        $stmt->bindValue(':description', $data['description'] ?? '', PDO::PARAM_STR);
        $stmt->bindValue(':updated_by', $data['updated_by'] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(':created_at', $data['created_at'] ?? date('Y-m-d H:i:s'), PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); // trả về ID log vừa tạo
        }

        return false;
    }


    public function updateBooking($booking_id, array $data)
    {
        // $fields = [];
        // $params = [':id' => $booking_id];

        // foreach ($data as $key => $value) {
        //     $fields[] = "`$key` = :$key"; // tạo câu lệnh SET `field` = :field
        //     $params[":$key"] = $value;     // bind giá trị
        // }

        // $sql = "UPDATE `{$this->table}` SET " . implode(', ', $fields) . " WHERE `id` = :id";
        // $stmt = $this->conn->prepare($sql);

        // return $stmt->execute($params); // trả về true/false
    }

    // Tạo booking mới
    public function create($data)
    {
        $sql = "INSERT INTO bookings 
                (tour_id, tour_version_id, customer_name, customer_phone, customer_email, 
                group_type, number_of_people, note, status, created_at, updated_at) 
                VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['tour_id'],
            $data['tour_version_id'],
            $data['customer_name'],
            $data['customer_phone'],
            $data['customer_email'],
            $data['group_type'],
            $data['number_of_people'],
            $data['note'],
            $data['status']
        ]);
    }
}
