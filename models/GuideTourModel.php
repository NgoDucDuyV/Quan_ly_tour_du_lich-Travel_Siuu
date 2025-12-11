<?php
class GuideTourModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllGuides()
    {
        $sql = "SELECT * FROM `guides` ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGuidesByStatus($status)
    {
        $sql = "SELECT * FROM `guides` WHERE status = :status ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getGuideById($id)
    {
        $sql = "SELECT * FROM `guides` WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy ID người dùng theo hdv
    public function getGuideUserid($user_id)
    {
        $sql = "
        SELECT * 
        FROM guides 
        WHERE user_id = :user_id
        LIMIT 1
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // fetch một row duy nhất
    }
    // Lịch trình của hdv 
    public function getCustomerListByScheduleId($schedule_id)
    {
        $sql = "
            SELECT 
                s.id AS schedule_id,
                s.tour_id,
                s.guide_id,
                s.schedule_status_id,
                s.start_date,
                s.end_date,
                s.meeting_point,
                s.vehicle,
                s.hotel,
                s.restaurant,
                s.flight_info,
                s.guide_notes,

                t.name AS tour_name,
                t.code AS tour_code,
                t.description AS tour_description,
                t.days AS tour_days,
                t.nights AS tour_nights,

                g.name AS guide_name,
                g.phone AS guide_phone,
                g.email AS guide_email,

                ss.guide_status_id,
                ss.schedule_status_type_id,

                gs.name AS guide_status_name,
                gs.code AS guide_status_code,

                sst.name AS schedule_status_name,
                sst.code AS schedule_status_code

            FROM schedules s
            LEFT JOIN tours t 
                ON t.id = s.tour_id
            LEFT JOIN guides g 
                ON g.id = s.guide_id
            LEFT JOIN schedule_status ss 
                ON ss.id = s.schedule_status_id
            LEFT JOIN guide_status gs 
                ON gs.id = ss.guide_status_id
            LEFT JOIN schedule_status_types sst 
                ON sst.id = ss.schedule_status_type_id
            WHERE s.guide_id = :guide_id     
            ORDER BY s.start_date ASC;
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['sid' => $schedule_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 1. Lấy chi tiết Schedule (dùng cho trang chi tiết)
    public function getScheduleDetailsById($schedule_id)
    {
        $sql = "
        SELECT 
            s.*, 
            t.name AS tour_name, 
            t.code AS tour_code, 
            t.days, 
            t.nights 
        FROM schedules s
        JOIN tours t ON t.id = s.tour_id
        WHERE s.id = :schedule_id
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['schedule_id' => $schedule_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Lấy tất cả Hoạt động (Activities) nhóm theo Itinerary Day
    public function getTourItinerariesBySchedule($schedule_id)
    {
        $sql = "
        SELECT
            ti.day_number,
            ti.title AS day_title,
            ti.description AS day_description,
            ta.id AS activity_id,
            ta.time AS activity_time,
            ta.activity AS activity_name,
            ta.location,
            ta.description AS activity_description
        FROM schedules s
        JOIN tours t ON s.tour_id = t.id
        JOIN tour_itineraries ti ON t.id = ti.tour_id
        JOIN tour_activities ta ON ti.id = ta.itinerary_id
        WHERE s.id = :schedule_id
        ORDER BY ti.day_number ASC, ta.time ASC
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['schedule_id' => $schedule_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Nhóm kết quả theo day_number
        $grouped = [];
        foreach ($result as $row) {
            $day = $row['day_number'];
            if (!isset($grouped[$day])) {
                $grouped[$day] = [
                    'day_number' => $day,
                    'title' => $row['day_title'],
                    'description' => $row['day_description'],
                    'activities' => []
                ];
            }
            $grouped[$day]['activities'][] = [
                'activity_id' => $row['activity_id'],
                'time' => $row['activity_time'],
                'name' => $row['activity_name'],
                'location' => $row['location'],
                'description' => $row['activity_description']
            ];
        }
        return $grouped;
    }

    // DiaryGuide
    // Thêm nhật ký mới
    public function insertLog($schedule_id, $guide_id, $content, $images)
    {
        $sql = "INSERT INTO tour_logs (schedule_id, guide_id, log_date, content, images)
            VALUES (:schedule_id, :guide_id, :log_date, :content, :images)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'schedule_id' => $schedule_id,
            'guide_id' => $guide_id,
            'content' => $content,
            'images' => json_encode($images)
        ]);

        return $this->conn->lastInsertId();
    }

    // Xóa nhật ký 
    public function deleteLog($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tour_logs WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    // Lấy nhật ký theo guide_id
    public function getLogById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_logs WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Cập nhật nhật ký
    public function updateLog($id, $content)
    {
        $stmt = $this->conn->prepare("
        UPDATE tour_logs
        SET content = :content, updated_at = NOW()
        WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'content' => $content
        ]);
    }

    // CheckGuide
    // Cập nhật trạng thái điểm danh 
    public function updateAttendance($id, $status)
    {
        $sql = "UPDATE attendance 
            SET status = :status, checked_at = NOW()
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'id' => $id
        ]);
    }
    // Lấy lịch trình từng ngày

    //   Tính toán ngày hiện tại của Tour
    //   @param date $start_date Ngày bắt đầu tour (từ schedules.start_date)
    //  @return int Số thứ tự ngày trong tour (Ngày 1, Ngày 2, ...)
    public function getTodayTourDayNumber($start_date)
    {
        // Chuyển đổi ngày bắt đầu và ngày hiện tại sang đối tượng DateTime
        $start = new DateTime($start_date);
        $now = new DateTime(date('Y-m-d')); // Lấy ngày hiện tại

        // Tính khoảng cách giữa hai ngày
        $interval = $start->diff($now);

        // Số ngày đã trôi qua (+1 vì ngày khởi hành là Ngày 1, khoảng cách là 0)
        $day_number = $interval->days + 1;

        // Giới hạn không cho số ngày quá nhỏ hơn 1
        return max(1, $day_number);
    }
    // Lấy hoạt động trong 1 tour 
    public function getTourActivitiesBySchedule($schedule_id)
    {
        $sql = "
        SELECT
            ta.id AS activity_id,
            ta.time AS activity_time,
            ta.activity AS activity_name,
            ta.location,
            ti.day_number
        FROM schedules s
        JOIN tours t ON s.tour_id = t.id
        JOIN tour_itineraries ti ON t.id = ti.tour_id
        JOIN tour_activities ta ON ti.id = ta.itinerary_id
        WHERE s.id = :schedule_id
        ORDER BY ti.day_number ASC, ta.time ASC
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['schedule_id' => $schedule_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy khách điểm danh theo lịch trình 
    public function getCustomersAttendanceBySchedule($schedule_id)
    {
        // Lấy danh sách khách hàng thuộc Schedule này (từ bookings -> booking_customers)
        $sqlCustomers = "
    SELECT bc.id AS customer_id, bc.full_name AS customer_name
    FROM bookings b
    JOIN booking_customers bc ON b.id = bc.booking_id
    JOIN schedules s ON b.id = s.booking_id
    WHERE s.id = :schedule_id
";
        $stmtCustomers = $this->conn->prepare($sqlCustomers);
        $stmtCustomers->execute(['schedule_id' => $schedule_id]);
        $customers = $stmtCustomers->fetchAll(PDO::FETCH_ASSOC);

        // Lấy tất cả trạng thái điểm danh cho các khách trong tour này
        $sqlAttendance = "
    SELECT customer_id, activity_id, status, notes -- ĐÃ THÊM NOTES
    FROM attendance_activity
    WHERE schedule_id = :schedule_id
";
        $stmtAttendance = $this->conn->prepare($sqlAttendance);
        $stmtAttendance->execute(['schedule_id' => $schedule_id]);
        $attendanceData = $stmtAttendance->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

        // Kết hợp dữ liệu (Customer ID -> Activity ID -> { Status, Notes })
        $result = [];
        foreach ($customers as $customer) {
            $customer_id = $customer['customer_id'];
            $customer['attendance'] = [];

            // Gán trạng thái đã điểm danh theo từng activity_id
            if (isset($attendanceData[$customer_id])) {
                foreach ($attendanceData[$customer_id] as $record) {
                    // Lưu cả status và notes vào cấu trúc mảng
                    $customer['attendance'][$record['activity_id']] = [
                        'status' => $record['status'],
                        'notes' => $record['notes']
                    ];
                }
            }
            $result[] = $customer;
        }

        return $result;
    }
    //  Lưu điểm danh khách của Hdv 
    public function saveOrUpdateAttendanceActivity($schedule_id, $customer_id, $activity_id, $status, $notes = NULL)
    {
        $sql = "
        INSERT INTO attendance_activity 
            (schedule_id, customer_id, activity_id, status, notes, checked_at)
        VALUES 
            (:schedule_id, :customer_id, :activity_id, :status, :notes, NOW())
        ON DUPLICATE KEY UPDATE 
            status = VALUES(status),
            notes = VALUES(notes),
            checked_at = NOW()
    ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':schedule_id' => $schedule_id,
            ':customer_id' => $customer_id,
            ':activity_id' => $activity_id,
            ':status'      => $status,
            ':notes'      => $notes  // ← Đảm bảo bind đúng tên
        ]);
    }
    // Đếm số thông báo chưa đọc của HDV
    public function countUnreadNotifications($guide_id)
    {
        $sql = "
        SELECT COUNT(*) 
        FROM notifications 
        WHERE guide_id = :guide_id 
          AND is_read = 0 
          AND deleted_at IS NULL
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['guide_id' => $guide_id]);
        return (int)$stmt->fetchColumn();
    }
    // Lưu điểm danh của hdv 
    public function saveAttendanceByActivity()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $user_id = $_SESSION['admin_logged']['id'];
        $guide = (new GuideTourModel())->getGuideUserid($user_id);
        $todayTour = (new GuideTourModel())->getTodayTour($guide['id']);

        if (!$todayTour || !$data) {
            http_response_code(400);
            echo "error";
            return;
        }

        $schedule_id = $todayTour['schedule_id'];
        $model = new GuideTourModel();
        $count = 0;

        foreach ($data as $customerId => $activities) {
            foreach ($activities as $activityId => $record) {
                $status = $record['status'] ?? 'absent';
                $notes = $record['notes'] ?? null;

                // Nếu điểm danh "Đã đến" → tự động xóa ghi chú
                if ($status === 'present') {
                    $notes = null;
                }

                $model->saveOrUpdateAttendanceActivity(
                    $schedule_id,
                    $customerId,
                    $activityId,
                    $status,
                    $notes
                );
                $count++;
            }
        }

        echo $count > 0 ? 'success' : 'nothing';
    }
    // Requestguide
    // Lấy yêu cầu của hướng dẫn viên
    public function getRequestsByGuide($guide_id)
    {
        $sql = "SELECT *
                FROM tour_request
                WHERE guide_id = :guide_id
                ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":guide_id", $guide_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Thêm yêu cầu mới của HDV
    public function insertRequest($guide_id, $data)
    {
        $sql = "INSERT INTO tour_request 
        (guide_id, title, request_type, desired_date, priority, content, attachment)
        VALUES (:guide_id, :title, :request_type, :desired_date, :priority, :content, :attachment)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'guide_id' => $guide_id,
            'title' => $data['title'],
            'request_type' => $data['request_type'],
            'desired_date' => (!empty($data['desired_date']) ? $data['desired_date'] : null),
            'priority' => $data['priority'],
            'content' => $data['content'],
            'attachment' => $data['attachment']
        ]);
    }
    // Lấy yêu cầu cụ thể của HDV
    public function getRequest($id, $guide_id)
    {
        $sql = "SELECT * FROM tour_request WHERE id = :id AND guide_id = :guide_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id, 'guide_id' => $guide_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Cập nhật yêu cầu của HDV
    public function updateRequest($id, $guide_id, $data)
    {
        $sql = "UPDATE tour_request
            SET title=:title, desired_date=:desired_date,
                priority=:priority, content=:content, attachment=:attachment,
                updated_at=NOW()
            WHERE id=:id AND guide_id=:guide_id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'title' => $data['title'],
            'desired_date' => $data['desired_date'],
            'priority' => $data['priority'],
            'content' => $data['content'],
            'attachment' => $data['attachment'],
            'id' => $id,
            'guide_id' => $guide_id
        ]);
    }
    // Xóa yêu cầu của HDV
    public function deleteRequest($id, $guide_id)
    {
        $stmt = $this->conn->prepare("
        DELETE FROM tour_request 
        WHERE id = :id AND guide_id = :guide_id
    ");

        return $stmt->execute(['id' => $id, 'guide_id' => $guide_id]);
    }

    // Tổng tour
    // Tour hôm nay
    public function getTodayTour($guide_id)
    {
        $sql = "
        SELECT
            s.id AS schedule_id,
            s.tour_id,
            t.name AS tour_name,
            s.start_date,
            s.end_date,
            (
            SELECT COUNT(bc.id)
            FROM bookings b
            JOIN booking_customers bc ON b.id = bc.booking_id
            WHERE b.id = s.booking_id
        ) AS total_customers,
                ss.schedule_status_type_id,
                sst.name AS schedule_status_name,
                sst.code AS schedule_status_code,
                gs.name AS guide_status_name,
                gs.code AS guide_status_code
            FROM schedules s
            JOIN tours t ON t.id = s.tour_id
            LEFT JOIN schedule_status ss ON ss.schedule_id = s.id
            LEFT JOIN schedule_status_types sst ON sst.id = ss.schedule_status_type_id
            LEFT JOIN guide_status gs ON gs.id = ss.guide_status_id
            WHERE s.guide_id = :guide_id
            AND CURDATE() BETWEEN s.start_date AND s.end_date -- Đang diễn ra hôm nay
            LIMIT 1
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['guide_id' => $guide_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Tour trong tuần
    public function getThisWeekTours($guide_id)
    {
        $sql = "
        SELECT 
            s.*, 
            t.name AS tour_name,
            -- FIX: Sử dụng subquery để đếm số lượng khách hàng từ booking_customers
            (
                SELECT COUNT(bc.id)
                FROM bookings b
                JOIN booking_customers bc ON b.id = bc.booking_id
                WHERE b.id = s.booking_id
            ) AS total_customers
        FROM schedules s
        JOIN tours t ON s.tour_id = t.id
        WHERE s.guide_id = :guide_id
        AND YEARWEEK(s.start_date, 1) = YEARWEEK(CURDATE(), 1)
        ORDER BY s.start_date ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['guide_id' => $guide_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Tour gần đây
    public function getRecentTours($guide_id)
    {
        $sql = "
            SELECT s.*, t.name AS tour_name,
            (SELECT COUNT(*) FROM attendance WHERE schedule_id = s.id) AS total_customers
            FROM schedules s
            JOIN tours t ON s.tour_id = t.id
            WHERE s.guide_id = :guide_id
            AND s.end_date < CURDATE()
            ORDER BY s.end_date DESC
            LIMIT 5
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['guide_id' => $guide_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy tất cả các dữ liệu có trên trang chủ
    // Lấy khách hàng theo lịch trình
    public function getCustomersBySchedule($schedule_id)
    {
        $sql = "
        SELECT 
            bc.id AS customer_id,
            bc.full_name AS customer_name,
            a.id AS attendance_id,
            a.status AS attendance_status
        FROM attendance a
        JOIN booking_customers bc ON bc.id = a.customer_id
        WHERE a.schedule_id = :sid
        ORDER BY bc.full_name ASC
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['sid' => $schedule_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy lịch trình theo 
    public function getSchedulesForGuide($guide_id)
    {
        $sql = "
SELECT 
s.id AS schedule_id,
t.name AS tour_name,
t.days AS tour_days, 
t.nights AS tour_nights, 
t.code AS tour_code,
s.start_date,
s.end_date,
s.meeting_point,
s.vehicle,
s.hotel,
s.restaurant,
s.flight_info, 
s.guide_notes, 
s.schedule_status_id, 

-- Lấy trạng thái lịch trình
ss.schedule_status_type_id,
sst.name AS schedule_status_name,
sst.code AS schedule_status_code,

-- Trạng thái HDV
ss.guide_status_id,
gs.name AS guide_status_name,
gs.code AS guide_status_code

FROM schedules s
JOIN tours t 
ON t.id = s.tour_id

LEFT JOIN schedule_status ss 
ON ss.schedule_id = s.id 

LEFT JOIN schedule_status_types sst 
ON sst.id = ss.schedule_status_type_id

LEFT JOIN guide_status gs 
ON gs.id = ss.guide_status_id

WHERE s.guide_id = :guide_id
-- FIX MỚI: Bao gồm các tour:
-- 1. Chưa có trạng thái (sst.code IS NULL - tour mới tạo)
-- 2. Đã có trạng thái nhưng KHÔNG phải là hoàn thành, hủy, hoặc đóng.
AND (
    sst.code IS NULL OR 
    sst.code NOT IN ('completed', 'cancelled', 'closed') 
)
-- Đảm bảo ngày kết thúc chưa qua ngày hiện tại
AND s.end_date >= CURDATE() 
ORDER BY s.start_date ASC
";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['guide_id' => $guide_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy nhật ký theo HDV
    public function getLogsByGuide($guide_id)
    {
        $sql = "
            SELECT tl.*, s.tour_id, t.name AS tour_name
            FROM tour_logs tl
            JOIN schedules s ON tl.schedule_id = s.id
            JOIN tours t ON s.tour_id = t.id
            WHERE tl.guide_id = :guide_id
            ORDER BY tl.log_date DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['guide_id' => $guide_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Thống kê tour tuần này
    public function getTourStatsThisWeek($guide_id)
    {
        $sql = "
            SELECT COUNT(*) AS total 
            FROM schedules
            WHERE guide_id = :guide_id 
            AND YEARWEEK(start_date, 1) = YEARWEEK(CURDATE(), 1)
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['guide_id' => $guide_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Lấy danh sách khách hàng theo HDV
    public function getCustomerListByTourid($tour_id, $start_date, $end_date)
    {
        // Lấy booking_id liên quan đến tour/ngày/hdv này
        $sqlBookingId = "
        SELECT booking_id FROM schedules 
        WHERE tour_id = :tour_id 
          AND CURDATE() BETWEEN start_date AND end_date
        LIMIT 1
        ";
        $stmtBooking = $this->conn->prepare($sqlBookingId);
        $stmtBooking->execute([
            'tour_id' => $tour_id,
        ]);
        $bookingId = $stmtBooking->fetchColumn();

        if (!$bookingId) return [];

        $sql = "
        SELECT 
            t.name AS tour_name,
            b.start_date AS booking_start,
            bc.id AS customer_id,
            bc.full_name AS customer_full_name,
            bc.birth_year,
            bc.passport,
            bc.customer_type_id
        FROM bookings b
        JOIN booking_customers bc ON bc.booking_id = b.id
        JOIN tours t ON t.id = b.tour_id
        WHERE b.id = :booking_id
        ORDER BY bc.id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['booking_id' => $bookingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 5 nhật ký gần nhất
    public function getRecentDiary($guide_id)
    {
        $sql = "
        SELECT tl.*, t.name AS tour_name
        FROM tour_logs tl
        JOIN schedules s ON tl.schedule_id = s.id
        JOIN tours t ON s.tour_id = t.id
        WHERE tl.guide_id = :gid
        ORDER BY tl.id DESC
        LIMIT 3
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['gid' => $guide_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy 5 yêu cầu gần đây
    public function getRecentRequests($guide_id)
    {
        $sql = "SELECT * FROM tour_request 
            WHERE guide_id = :gid 
            ORDER BY id DESC 
            LIMIT 3";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['gid' => $guide_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Tổng số khách trong ngày hnay 
    public function getTotalCustomersToday($guide_id)
    {
        $sql = "
        SELECT COUNT(bc.id) AS total_customers
        FROM schedules s
        JOIN bookings b ON b.id = s.booking_id
        JOIN booking_customers bc ON bc.booking_id = b.id
        WHERE s.guide_id = :guide_id
        AND CURDATE() BETWEEN s.start_date AND s.end_date
        AND s.id = (
            SELECT id FROM schedules 
            WHERE guide_id = :guide_id 
            AND CURDATE() BETWEEN start_date AND end_date
            LIMIT 1
        )
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['guide_id' => $guide_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Thêm hàm đếm tour sắp tới/đang diễn ra
    // Trong Model/GuideTourModel.php
    public function countUpcomingTours($guide_id)
    {
        $sql = "
    SELECT 
        COUNT(s.id) AS total_upcoming_tours
    FROM schedules s
    LEFT JOIN schedule_status ss ON ss.schedule_id = s.id
    LEFT JOIN schedule_status_types sst ON sst.id = ss.schedule_status_type_id
    WHERE s.guide_id = :guide_id
    -- Đếm tất cả tour CHƯA kết thúc ngày hôm nay
    AND s.end_date >= CURDATE()
    -- VÀ trạng thái KHÔNG phải là hoàn thành/hủy/đóng
    AND (
        sst.code IS NULL OR 
        sst.code NOT IN ('completed', 'cancelled', 'closed') 
    )
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['guide_id' => $guide_id]);

        // Trả về số lượng dưới dạng integer
        return (int) $stmt->fetchColumn();
    }
    // Đếm tour đã hoàn thành 
    public function countCompletedTours($guide_id)
    {
        $sql = "
        SELECT COUNT(*)
        FROM schedules s
        JOIN schedule_status ss ON ss.schedule_id = s.id
        JOIN schedule_status_types st ON st.id = ss.schedule_status_type_id
        WHERE s.guide_id = :gid
        AND st.code = 'completed'
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['gid' => $guide_id]);
        return (int)$stmt->fetchColumn();
    }
}
