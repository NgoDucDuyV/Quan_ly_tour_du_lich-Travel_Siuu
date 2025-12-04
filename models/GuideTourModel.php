<?php
class GuideTourModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
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

    // DiaryGuide
    // Thêm nhật ký mới
    public function insertLog($schedule_id, $guide_id, $content, $images)
    {
        $sql = "INSERT INTO tour_logs (schedule_id, guide_id, log_date, content, images)
                VALUES (:schedule_id, :guide_id, CURDATE(), :content, :images)";

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
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'content' => $content
        ]);
    }

    // CheckGuide
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
                SELECT COUNT(*)
                FROM attendance a
                WHERE a.schedule_id = s.id
            ) AS total_customers
        FROM schedules s
        JOIN tours t ON t.id = s.tour_id
        WHERE s.guide_id = :guide_id
          AND DATE(s.start_date) = CURDATE()
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
            SELECT s.*, t.name AS tour_name,
            (SELECT COUNT(*) FROM attendance WHERE schedule_id = s.id) AS total_customers
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
    // Lấy lịch trình theo HDV
    public function getSchedulesForGuide($guide_id)
    {
        $sql = "
        SELECT 
            s.id AS schedule_id,
            t.name AS tour_name,
            t.code AS tour_code,
            s.start_date,
            s.end_date,
            s.meeting_point,
            s.vehicle,
            s.hotel,
            s.restaurant,
            s.status AS schedule_status
        FROM schedules s
        JOIN tours t ON t.id = s.tour_id
        WHERE s.guide_id = :guide_id
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
        $sql = "
        SELECT 
            b.id AS booking_id,
            b.booking_code,
            b.tour_id,
            t.name AS tour_name,
            b.start_date AS booking_start,
            b.end_date AS booking_end,
            b.customer_name AS main_customer,
            b.customer_phone,
            b.customer_email,
            b.group_type,
            b.number_of_people,
            bc.id AS customer_id,
            bc.full_name AS customer_full_name,
            bc.birth_year,
            bc.passport,
            bc.customer_type_id
        FROM bookings b
        LEFT JOIN booking_customers bc ON bc.booking_id = b.id
        JOIN tours t ON t.id = b.tour_id
        WHERE b.tour_id = :tour_id
        AND b.start_date >= :start_date
        AND b.end_date <= :end_date
        ORDER BY b.id, bc.id
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'tour_id' => $tour_id,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);

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
}
