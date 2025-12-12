<?php
class ScheduleStatusModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lưu mới schedule_status → trả về ID
    public function createScheduleStatus(
        int $schedule_id,
        int $schedule_status_type_id,
        int $guide_status_id,
        string $schedule_status_type_code,
        string $guide_status_code,
        string $description
    ): int {
        try {
            // echo "<pre>";
            // print_r([
            //     'schedule_id'               => $schedule_id,
            //     'schedule_status_type_id'   => $schedule_status_type_id,
            //     'guide_status_id'           => $guide_status_id,
            //     'schedule_status_type_code' => $schedule_status_type_code,
            //     'guide_status_code'         => $guide_status_code,
            //     'description'               => $description
            // ]);
            // echo "</pre>";
            // die;

            $sql = "INSERT INTO `schedule_status`
            (`schedule_id`, `schedule_status_type_id`, `guide_status_id`,
            `schedule_status_type_code`, `guide_status_code`, `description`)
            VALUES
            (:schedule_id, :schedule_status_type_id, :guide_status_id,
            :schedule_status_type_code, :guide_status_code, :description)";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':schedule_id'               => $schedule_id,
                ':schedule_status_type_id'   => $schedule_status_type_id,
                ':guide_status_id'           => $guide_status_id,
                ':schedule_status_type_code' => $schedule_status_type_code,
                ':guide_status_code'         => $guide_status_code,
                ':description'               => $description
            ]);

            return (int)$this->conn->lastInsertId();
        } catch (Exception $e) {
            error_log("Lỗi createScheduleStatus: " . $e->getMessage());
            throw new Exception("Không thể tạo trạng thái lịch: " . $e->getMessage());
        }
    }

    public function updateScheduleStatusByScheduleId(
        int $schedule_id,
        int $schedule_status_type_id,
        int $guide_status_id,
        string $schedule_status_type_code,
        string $guide_status_code,
        string $description
    ): bool {

        // echo "<pre>DEBUG DATA:\n";
        // print_r([
        //     'schedule_id' => $schedule_id,
        //     'schedule_status_type_id' => $schedule_status_type_id,
        //     'guide_status_id' => $guide_status_id,
        //     'schedule_status_type_code' => $schedule_status_type_code,
        //     'guide_status_code' => $guide_status_code,
        //     'description' => $description
        // ]);
        // echo "</pre>";
        // die;
        try {
            $sql = "UPDATE `schedule_status`
                SET 
                    schedule_status_type_id = :schedule_status_type_id,
                    guide_status_id = :guide_status_id,
                    schedule_status_type_code = :schedule_status_type_code,
                    guide_status_code = :guide_status_code,
                    description = :description
                WHERE schedule_id = :schedule_id";

            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                ':schedule_id'                 => $schedule_id,
                ':schedule_status_type_id'     => $schedule_status_type_id,
                ':guide_status_id'             => $guide_status_id,
                ':schedule_status_type_code'   => $schedule_status_type_code,
                ':guide_status_code'           => $guide_status_code,
                ':description'                 => $description
            ]);
            return true;
        } catch (Exception $e) {
            error_log("Lỗi updateScheduleStatusByScheduleId: " . $e->getMessage());
            throw new Exception("Không thể cập nhật trạng thái lịch theo schedule_id: " . $e->getMessage());
            return false;
        }
    }
}
