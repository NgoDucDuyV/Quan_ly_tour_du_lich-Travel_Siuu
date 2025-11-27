<?php
class GuideTourModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

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

    public function deleteLog($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tour_logs WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getLogById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_logs WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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

    // Tour hôm nay
    public function getTodayTour($guide_id)
    {
        $sql = "
            SELECT 
                s.id AS schedule_id,
                t.name AS tour_name,
                s.start_date AS start_time,
                s.end_date AS end_time,
                COUNT(a.customer_id) AS total_customers
            FROM schedules s
            JOIN tours t ON s.tour_id = t.id
            LEFT JOIN attendance a ON a.schedule_id = s.id
            WHERE s.guide_id = :guide_id
              AND CURDATE() BETWEEN DATE(s.start_date) AND DATE(s.end_date)
            GROUP BY s.id
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['guide_id' => $guide_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCustomersBySchedule($schedule_id)
    {
        $sql = "
            SELECT c.name AS customer_name, a.status, a.id AS attendance_id
            FROM attendance a
            JOIN customers c ON c.id = a.customer_id
            WHERE a.schedule_id = :schedule_id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['schedule_id' => $schedule_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSchedulesByGuide($guide_id)
    {
        $sql = "
            SELECT s.id AS schedule_id, t.name AS tour_name, s.start_date
            FROM schedules s
            JOIN tours t ON s.tour_id = t.id
            WHERE s.guide_id = :guide_id
            ORDER BY s.start_date DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['guide_id' => $guide_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

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
}
