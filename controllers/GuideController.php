<?php
class GuideController
{
    public function homeGuide()
    {
        $user_id = $_SESSION['admin_logged']['id'];

        $getGuideUserid = (new GuideTourModel())->getGuideUserid($user_id);
        // echo "<pre>";
        // var_dump($getGuideUserid);
        // echo "<pre>";
        // die;
        $dataSchedulesByGuideId = (new GuideTourModel())->getAllSchedulesByGuideId($getGuideUserid['id']);
        $model = new GuideTourModel();
        // Nhật ký gần đây
        $diary = $model->getRecentDiary($getGuideUserid['id']);

        // Yêu cầu gần đây
        $requests = $model->getRecentRequests($getGuideUserid['id']);
        // echo "<pre>";
        // var_dump($dataSchedulesByGuideId);
        // echo "<pre>";
        // die;
        require_once "./views/Admin/homeguide.php";
    }

    // ListGuide
    // Danh sách khách của HDV
    public function listGuide($tour_id = null, $start_date = null, $end_date = null)
    {
        $guide_id = $_SESSION['admin_logged']['id'];

        $model = new GuideTourModel();

        if (empty($tour_id)) {
            $datacustomers = $model->getCustomerListByTourid($tour_id, $start_date, $end_date);
        }
        // Lấy dữ liệu khách theo hướng dẫn viên

        // echo "<pre>";
        // var_dump($datacustomers);
        // echo "<pre>";
        // die;
        require "./views/Admin/listguide.php";
    }

    // ScheduleGuide
    // Lịch trình của HDV
    public function scheduleGuide($tour_id = null, $start_date = null, $end_date = null)
    {
        $user_id = $_SESSION['admin_logged']['id'];

        // echo "<pre>";
        // var_dump($user_id);
        // echo "<pre>";
        // die;
        $getGuideUserid = (new GuideTourModel())->getGuideUserid($user_id);

        $model = new GuideTourModel();

        $weekTours = $model->getThisWeekTours($getGuideUserid['id']);
        $recentTours = $model->getRecentTours($getGuideUserid['id']);

        if (empty($tour_id)) {
            $datacustomers = $model->getCustomerListByTourid($tour_id, $start_date, $end_date);
        }

        require "./views/Admin/scheduleguide.php";
    }

    // DiaryGuide
    // Nhật ký ghi lại của HDV 
    public function diaryGuide()
    {
        $user_id = $_SESSION['admin_logged']['id'];

        $getGuideUserid = (new GuideTourModel())->getGuideUserid($user_id);


        $model = new GuideTourModel();

        $diary = $model->getLogsByGuide($getGuideUserid['id']);
        $tours = $model->getSchedulesForGuide($getGuideUserid['id']);

        return [
            'diary' => $diary,
            'tours' => $tours
        ];
        // echo "<pre>";
        // print_r($guide);
        // die;
    }
    // Thêm nhật ký mới cho HDV
    public function saveDiaryGuide()
    {
        // Lấy user_id đang đăng nhập
        $user_id = $_SESSION['admin_logged']['id'];

        // Lấy đúng guide_id từ bảng guides
        $guide = (new GuideTourModel())->getGuideUserid($user_id);
        $guide_id = $guide['id'];  // <-- Luôn = 2

        $schedule_id = $_POST['schedule_id'];
        $content = $_POST['content'];
        $images = $_FILES['images'];

        $uploadDir = "uploads/logs/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $uploadedImages = [];

        if (!empty($images['name'][0])) {
            foreach ($images['name'] as $key => $name) {
                $newName = $uploadDir . uniqid() . "_" . $name;
                if (move_uploaded_file($images['tmp_name'][$key], $newName)) {
                    $uploadedImages[] = $newName;
                }
            }
        }

        (new GuideTourModel())->insertLog(
            $schedule_id,
            $guide_id,   // <-- bây giờ đúng: 2
            $content,
            $uploadedImages
        );

        header("Location: ?mode=admin&act=diaryguide");
    }

    // Xóa nhật ký của HDV
    public function deleteDiaryGuide()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) die("Thiếu ID nhật ký!");

        $model = new GuideTourModel();

        // Xóa trong database
        $model->deleteLog($id);

        header("Location: " . BASE_URL . "?mode=admin&act=diaryguide");
        exit;
    }
    // Chỉnh sửa nhật ký của HDV
    public function editDiaryGuide()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) die("Thiếu ID!");

        $model = new GuideTourModel();

        $log = $model->getLogById($id);
        $tours = $model->getSchedulesForGuide($_SESSION['admin_logged']['id']);

        require "./views/Admin/editDiaryguide.php";
    }
    // Cập nhật nhật ký của HDV
    public function updateDiaryGuide()
    {
        $id = $_POST['id'];
        $content = $_POST['content'];

        (new GuideTourModel())->updateLog($id, $content);

        header("Location: " . BASE_URL . "?mode=admin&act=diaryguide");
        exit;
    }

    // CheckGuide
    // Check-in và điểm danh của HDV
    public function checkGuide()
    {
        // Lấy user_id
        $user_id = $_SESSION['admin_logged']['id'];

        // Lấy đúng guide_id từ bảng guides
        $guide = (new GuideTourModel())->getGuideUserid($user_id);
        $guide_id = $guide['id'];   // luôn = 2 đối với Lê Văn Hưng

        $model = new GuideTourModel();

        // Lấy tour hôm nay
        $todayTour = $model->getTodayTour($guide_id);

        $customers = [];
        if ($todayTour) {
            $customers = $model->getCustomersBySchedule($todayTour['schedule_id']);
        }

        return [
            'todayTour' => $todayTour,
            'customers' => $customers
        ];
    }
    // Lưu điểm danh 
    public function saveAttendance()
    {
        // Đọc dữ liệu JSON từ fetch()
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !is_array($data)) {
            echo "Không nhận được dữ liệu!";
            return;
        }

        $model = new GuideTourModel();

        foreach ($data as $attendanceId => $status) {
            $model->updateAttendance($attendanceId, $status);
        }

        echo "success";
    }



    // RequestGuide
    // Yêu cầu đặc biệt của HDV
    public function requestGuide()
    {
        $guide_id = $_SESSION['admin_logged']['id']; // guide_id của HDV đang đăng nhập

        $model = new GuideTourModel();
        $requests = $model->getRequestsByGuide($guide_id);

        require "./views/Admin/requestguide.php";
    }
    // Lưu yêu cầu của HDV
    public function saveRequestGuide()
    {
        // var_dump($_POST);
        // exit;

        $guide_id = $_SESSION['admin_logged']['id'];

        $attachment = null;
        if (!empty($_FILES['attachment']['name'])) {
            $path = "uploads/requests/";
            if (!is_dir($path)) mkdir($path, 0777, true);

            $attachment = $path . uniqid() . "_" . $_FILES['attachment']['name'];
            move_uploaded_file($_FILES['attachment']['tmp_name'], $attachment);
        }

        $data = [
            'title' => $_POST['title'],
            'request_type' => $_POST['request_type'],  // ✔ Thêm dòng này
            'desired_date' => $_POST['desired_date'],
            'priority' => $_POST['priority'],
            'content' => $_POST['content'],
            'attachment' => $attachment
        ];


        (new GuideTourModel())->insertRequest($guide_id, $data);

        header("Location: ?mode=admin&act=requestguide");
    }
    // Sửa yêu cầu của HDV (hiển thị form)
    public function editRequestGuide()
    {
        $guide_id = $_SESSION['admin_logged']['id'];
        $id = $_GET['id'];

        $req = (new GuideTourModel())->getRequest($id, $guide_id);

        require "./views/Admin/editRequestGuide.php";
    }
    // Cập nhật yêu cầu của HDV sau khi sửa
    public function updateRequestGuide()
    {
        $guide_id = $_SESSION['admin_logged']['id'];
        $id = $_POST['id'];

        $attachment = $_POST['old_attachment'];

        if (!empty($_FILES['attachment']['name'])) {
            $path = "uploads/requests/";
            if (!is_dir($path)) mkdir($path, 0777, true);

            $attachment = $path . uniqid() . "_" . $_FILES['attachment']['name'];
            move_uploaded_file($_FILES['attachment']['tmp_name'], $attachment);
        }

        $data = [
            'title' => $_POST['title'],
            'desired_date' => $_POST['desired_date'],
            'priority' => $_POST['priority'],
            'content' => $_POST['content'],
            'attachment' => $attachment
        ];

        (new GuideTourModel())->updateRequest($id, $guide_id, $data);

        header("Location: ?mode=admin&act=requestguide");
    }
    // Xóa yêu cầu của HDV
    public function deleteRequestGuide()
    {
        $guide_id = $_SESSION['admin_logged']['id'];
        $id = $_GET['id'];

        (new GuideTourModel())->deleteRequest($id, $guide_id);

        header("Location: ?mode=admin&act=requestguide");
    }
}
