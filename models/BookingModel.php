<?php
class BookingModel
{
    private $conn;
    protected $table = 'bookings';

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy toàn bộ booking
    public function getAllBookings()
    {

        $sql = "SELECT 
            b.id AS booking_id,
            b.booking_code,
            b.tour_id,
            b.tour_version_id,
            b.start_date,
            b.end_date,
            b.customer_name,
            b.customer_phone,
            b.customer_email,
            b.group_type_id,
            b.number_of_people,
            b.total_price,
            b.service_prices,
            b.passenger_prices,
            b.note,
            b.created_at AS booking_created_at,
            b.updated_at AS booking_updated_at,

            -- Trạng thái booking (chờ xác nhận, đã cọc, hoàn tất, hủy...)
            bst.id AS status_type_id_master,
            bst.code AS status_type_code_master,
            bst.name AS status_type_name,

            -- Trạng thái thanh toán
            pst.id AS payment_type_id_master,
            pst.code AS payment_type_code_master,
            pst.name AS payment_type_name,
            pst.description AS payment_type_description,
            pst.color AS payment_type_color,

            -- Thông tin loại nhóm (mới thêm)
            gt.group_name,
            gt.group_code,
            gt.price_change_percent,
            gt.color AS group_color

        FROM bookings b
        LEFT JOIN booking_status bs ON b.id = bs.booking_id
        LEFT JOIN booking_status_type bst ON bs.booking_status_type_id = bst.id
        LEFT JOIN payment_status_type pst ON bs.payment_status_type_id = pst.id
        LEFT JOIN group_type gt ON b.group_type_id = gt.id

        ORDER BY b.created_at DESC;
        ";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingById($booking_id)
    {
        $booking_id = (int) $booking_id;

        $sql = "
            SELECT 
                b.id AS booking_id,
                b.booking_code,
                b.tour_id,
                b.tour_version_id,
                b.start_date,
                b.end_date,
                b.customer_name,
                b.customer_phone,
                b.customer_email,
                b.group_type_id,
                b.number_of_people,
                b.total_price,
                b.service_prices,
                b.passenger_prices,
                b.note,
                b.created_at AS booking_created_at,
                b.updated_at AS booking_updated_at,

                -- booking status (latest)
                bst.id AS status_type_id_master,
                bst.code AS status_type_code_master,
                bst.name AS status_type_name,

                -- payment status (latest)
                pst.id AS payment_type_id_master,
                pst.code AS payment_type_code_master,
                pst.name AS payment_type_name,
                pst.description AS payment_type_description,
                pst.color AS payment_type_color,

                -- group type info
                gt.group_name,
                gt.group_code,
                gt.price_change_percent,
                gt.color AS group_color

            FROM bookings b

            -- Lấy trạng thái mới nhất bằng cách join vào bản ghi có ID lớn nhất
            LEFT JOIN booking_status bs 
                ON bs.id = (
                        SELECT id FROM booking_status 
                        WHERE booking_id = b.id 
                        ORDER BY id DESC 
                        LIMIT 1
                )

            LEFT JOIN booking_status_type bst 
                ON bs.booking_status_type_id = bst.id

            LEFT JOIN payment_status_type pst 
                ON bs.payment_status_type_id = pst.id

            LEFT JOIN group_type gt 
                ON b.group_type_id = gt.id

            WHERE b.id = :booking_id
            LIMIT 1
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();

        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        return $booking ?: null;
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


    public function updateBooking(int $booking_id, array $data): bool
    {
        if (empty($data) || !$booking_id) return false;

        $fields = [];
        $params = [':id' => $booking_id];

        // Chỉ update 4 cột cần thiết
        $validColumns = ['status_id', 'payment_status_id', 'status_code', 'payment_status_code'];

        foreach ($data as $key => $value) {
            if (in_array($key, $validColumns)) {
                $fields[] = "`$key` = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($fields)) return false; // Không có trường hợp hợp lệ để update

        $sql = "UPDATE `{$this->table}` SET " . implode(', ', $fields) . ", `updated_at` = NOW() WHERE `id` = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute($params);
    }



    // Tạo booking mới
    public function InsertBooking($data)
    {
        $sql = "INSERT INTO bookings 
            (booking_code, tour_id, tour_version_id, start_date, end_date, customer_name, 
            customer_phone, customer_email, group_type_id, number_of_people, total_price, 
            service_prices, passenger_prices, note, created_at, updated_at) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $stmt = $this->conn->prepare($sql);

        try {
            $stmt->execute([
                $data['booking_code'] ?? null,
                $data['tour_id'] ?? null,
                $data['tour_version_id'] ?? null,
                $data['start_date'] ?? null,
                $data['end_date'] ?? null,
                $data['customer_name'] ?? null,
                $data['customer_phone'] ?? null,
                $data['customer_email'] ?? null,
                $data['group_type_id'] ?? null,
                $data['number_of_people'] ?? 0,
                $data['total_price'] ?? 0,
                $data['service_prices'] ?? 0,
                $data['passenger_prices'] ?? 0,
                $data['note'] ?? null
            ]);

            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Lỗi insert booking: " . $e->getMessage();
            return false;
        }
    }
}
