<?php
class SchedulesModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function createSchedule(
        int $booking_id,
        int $tour_id,
        int $guide_id,
        string $start_date,
        string $end_date,
        string $meeting_point
    ): int {
        // echo "<pre>";
        // echo "DỮ LIỆU TRUYỀN VÀO createSchedule:\n";
        // print_r([
        //     'booking_id'    => $booking_id,
        //     'tour_id'       => $tour_id,
        //     'guide_id'      => $guide_id,
        //     'start_date'    => $start_date,
        //     'end_date'      => $end_date,
        //     'meeting_point' => $meeting_point
        // ]);
        // echo "</pre>";
        // die;
        $sql = "INSERT INTO schedules 
        (booking_id, tour_id, guide_id, start_date, end_date, meeting_point,
        vehicle, hotel, restaurant, flight_info, guide_notes,
        created_at, updated_at, schedule_status_id)
        VALUES 
        (:booking_id, :tour_id, :guide_id, :start_date, :end_date, :meeting_point,
        NULL, NULL, NULL, NULL, NULL, NOW(), NOW(), NULL)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':booking_id'     => $booking_id,
            ':tour_id'        => $tour_id,
            ':guide_id'       => $guide_id,
            ':start_date'     => $start_date,
            ':end_date'       => $end_date,
            ':meeting_point'  => $meeting_point
        ]);

        return (int)$this->conn->lastInsertId();
    }

    public function updateScheduleStatusId(
        int $schedule_id,
        int $status_id
    ): bool {
        $sql = "UPDATE schedules 
            SET schedule_status_id = :status_id,
                updated_at = NOW()
            WHERE id = :schedule_id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':status_id'     => $status_id,
            ':schedule_id'   => $schedule_id
        ]);
    }

    public function getAllSchedulesByTourId($tour_id)
    {
        $sql = "
        SELECT 
            sch.*,
            sst.code AS schedule_status_code,
            sst.name AS schedule_status_name_vn,
            gs.code AS guide_status_code,
            gs.name AS guide_status_name
        FROM schedules sch
        JOIN bookings b 
            ON sch.booking_id = b.id
        JOIN group_type gt 
            ON b.group_type_id = gt.id
        LEFT JOIN schedule_status ss 
            ON sch.schedule_status_id = ss.id
        LEFT JOIN schedule_status_types sst 
            ON ss.schedule_status_type_id = sst.id
        LEFT JOIN guide_status gs 
            ON ss.guide_status_id = gs.id
        WHERE sch.tour_id = :tour_id
        AND gt.group_code = 'DOAN'
        ORDER BY sch.start_date ASC;
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tour_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSchedulesByTourAndBooking($tour_id, $booking_id)
    {
        $sql = "
        SELECT *
        FROM schedules
        WHERE tour_id = :tour_id
        AND booking_id = :booking_id
        ORDER BY start_date ASC
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tour_id', $tour_id, PDO::PARAM_INT);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSchedulesStatusById($schedule_id)
    {
        try {
            $sql = "
                SELECT 
                    s.id                    AS schedule_id,
                    s.booking_id,
                    s.tour_id,
                    s.guide_id,
                    s.start_date,
                    s.end_date,
                    s.meeting_point,
                    s.vehicle,
                    s.hotel,
                    s.restaurant,
                    s.flight_info,
                    s.guide_notes,
                    sst.id 					AS schedule_status_id,
                    sst.code                AS schedule_status_code,
                    sst.name                AS schedule_status_name_vn,
                    gs.id 					AS guide_status_id,
                    gs.code                 AS guide_status_code,
                    gs.name                 AS guide_status_name_vn,
                    COALESCE(ss.description, 'Chưa có mô tả') AS status_description
                FROM schedules s
                LEFT JOIN schedule_status ss 
                    ON s.schedule_status_id = ss.id
                LEFT JOIN schedule_status_types sst 
                    ON ss.schedule_status_type_id = sst.id
                LEFT JOIN guide_status gs 
                    ON ss.guide_status_id = gs.id
                WHERE s.id = :schedule_id
                ORDER BY s.start_date DESC, s.id DESC
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
            return [];
        }
    }


    public function getAllSchedulesByid($schedules_id)
    {
        $sql = "
        SELECT 
            bs.*, 
            s.name AS supplier_name,
            s.supplier_types_id,
            s.contact_name,
            s.contact_phone,
            s.contact_email,
            s.address,
            s.description
        FROM schedules sc
        JOIN booking_services bs ON bs.booking_id = sc.booking_id
        LEFT JOIN suppliers s ON bs.supplier_id = s.id
        WHERE sc.id = :schedules_id
        ORDER BY bs.id;
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':schedules_id', $schedules_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllStatusSchedulesByid($schedules_id)
    {
        $sql = "
        SELECT 
            ss.id AS schedule_status_id,
            ss.schedule_id,
            ss.schedule_status_type_id,
            sst.code AS schedule_status_code,
            sst.name AS schedule_status_name,
            ss.guide_status_id,
            gs.code AS guide_status_code,
            gs.name AS guide_status_name,
            ss.description
        FROM schedule_status ss
        LEFT JOIN schedule_status_types sst 
            ON ss.schedule_status_type_id = sst.id
        LEFT JOIN guide_status gs          -- <--- sửa tên bảng ở đây
            ON ss.guide_status_id = gs.id
        WHERE ss.schedule_id = :schedules_id
        ORDER BY ss.id ASC
        LIMIT 0, 25;
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':schedules_id', $schedules_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSchedulesStatusByBookingId($booking_id)
    {
        try {
            $sql = "
                SELECT 
                    s.id                    AS schedule_id,
                    s.booking_id,
                    s.tour_id,
                    s.guide_id,
                    s.start_date,
                    s.end_date,
                    s.meeting_point,
                    s.vehicle,
                    s.hotel,
                    s.restaurant,
                    s.flight_info,
                    s.guide_notes,
                    sst.id 					AS schedule_status_id,
                    sst.code                AS schedule_status_code,
                    sst.name                AS schedule_status_name_vn,
                    gs.id 					AS guide_status_id,
                    gs.code                 AS guide_status_code,
                    gs.name                 AS guide_status_name_vn,
                    COALESCE(ss.description, 'Chưa có mô tả') AS status_description
                FROM schedules s
                LEFT JOIN schedule_status ss 
                    ON s.schedule_status_id = ss.id
                LEFT JOIN schedule_status_types sst 
                    ON ss.schedule_status_type_id = sst.id
                LEFT JOIN guide_status gs 
                    ON ss.guide_status_id = gs.id
                WHERE s.booking_id = :booking_id
                ORDER BY s.start_date DESC, s.id DESC
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
            return [];
        }
    }

    public function getSchedulesStatusByGuideId($guide_id)
    {
        try {
            $sql = "
            SELECT 
                s.id                    AS schedule_id,
                s.booking_id,
                s.tour_id,
                s.guide_id,
                s.start_date,
                s.end_date,
                s.meeting_point,
                s.vehicle,
                s.hotel,
                s.restaurant,
                s.flight_info,
                s.guide_notes,
                sst.id 					AS schedule_status_id,
                sst.code                AS schedule_status_code,
                sst.name                AS schedule_status_name_vn,
                gs.id 					AS guide_status_id,
                gs.code                 AS guide_status_code,
                gs.name                 AS guide_status_name_vn,
                COALESCE(ss.description, 'Chưa có mô tả') AS status_description
            FROM schedules s
            LEFT JOIN schedule_status ss 
                ON s.schedule_status_id = ss.id
            LEFT JOIN schedule_status_types sst 
                ON ss.schedule_status_type_id = sst.id
            LEFT JOIN guide_status gs 
                ON ss.guide_status_id = gs.id
            WHERE s.guide_id = :guide_id
            ORDER BY s.start_date DESC, s.id DESC
        ";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':guide_id', $guide_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
            return [];
        }
    }


    public function getSchedulesByGuideId($guide_id)
    {
        try {
            $sql = "
            SELECT 
                s.*,
                ss.id AS ss_id,
                ss.schedule_status_type_id,
                ss.guide_status_id,
                ss.schedule_status_type_code,
                ss.guide_status_code,
                ss.description AS schedule_status_description,

                gst.name AS guide_status_name,
                gst.description AS guide_status_description,

                sst.name AS schedule_status_type_name

            FROM schedules AS s

            LEFT JOIN schedule_status AS ss 
                ON s.id = ss.schedule_id

            LEFT JOIN guide_status AS gst
                ON ss.guide_status_id = gst.id

            LEFT JOIN schedule_status_types AS sst
                ON ss.schedule_status_type_id = sst.id

            WHERE s.guide_id = :guide_id
            ORDER BY s.start_date DESC
        ";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":guide_id", $guide_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            // Ghi log lỗi (tùy bạn muốn bật hay tắt)
            error_log("Lỗi truy vấn schedules: " . $e->getMessage());

            // Báo lỗi ra ngoài nếu cần
            throw new Exception("Không thể lấy dữ liệu lịch trình hướng dẫn viên!");
        }
    }
}
