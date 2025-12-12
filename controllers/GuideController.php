<?php
class GuideController
{
    // HomeGuide
    // Trong GuideController.php
    public function homeGuide()
    {
        $user_id = $_SESSION['admin_logged']['id'];

        $getGuideUserid = (new GuideTourModel())->getGuideUserid($user_id);
        $guide_id = $getGuideUserid['id'];

        $model = new GuideTourModel();

        $dataSchedulesByGuideId = $model->getSchedulesForGuide($guide_id);

        // $today = date('Y-m-d');
        // echo "<pre>";
        // var_dump($today);
        // var_dump($dataSchedulesByGuideId);
        // echo "<pre>";
        // die;
        $totalUpcomingTours = $model->countUpcomingTours($guide_id);

        // ⭐ Đếm khách hôm nay
        $totalCustomersToday = $model->getTotalCustomersToday($guide_id);
        // Đếm số tour hoàn thành
        $totalCompletedTours = $model->countCompletedTours($guide_id);
        // Nhật ký gần đây
        $diary = $model->getRecentDiary($guide_id);

        // Yêu cầu gần đây
        $requests = $model->getRecentRequests($guide_id);

        require_once "./views/Admin/homeguide.php";
    }


    // ListGuide
    // Danh sách khách của HDV
    public function listGuide()
    {
        $user_id = $_SESSION['admin_logged']['id'];
        $model = new GuideTourModel();
        $guide = $model->getGuideUserid($user_id);
        $guide_id = $guide['id'];

        // Lấy tour hôm nay của HDV
        $todayTour = $model->getTodayTour($guide_id); // Lấy tour có start_date = CURDATE()

        $datacustomers = [];

        // Nếu hôm nay có tour → lấy danh sách khách
        if ($todayTour) {
            $tour_id = $todayTour['tour_id'];
            $start = $todayTour['start_date'];
            $end   = $todayTour['end_date'];

            // Lấy danh sách khách hàng từ các booking khớp với tour_id VÀ khoảng ngày của schedule
            $datacustomers = $model->getCustomerListByTourid($tour_id, $start, $end);
        }

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

        if (!empty($tour_id)) {
            $datacustomers = $model->getCustomerListByTourid($tour_id, $start_date, $end_date);
        }


        require "./views/Admin/scheduleguide.php";
    }
    // Hiển thị chi tiết lịch trình tour (bao gồm activities)
    public function showTourDetail($schedule_id)
    {
        if (!$schedule_id) {
            header("Location: " . BASE_URL . "?mode=admin&act=scheduleguide");
            exit;
        }

        $model = new GuideTourModel();

        // Lấy thông tin chi tiết Schedule
        $scheduleData = $model->getScheduleDetailsById($schedule_id);

        // Lấy tất cả hoạt động (activities) và nhóm theo ngày
        $itineraries = $model->getTourItinerariesBySchedule($schedule_id);

        // Kiểm tra xem HDV này có phụ trách tour này không (Nghiệp vụ quan trọng)
        $user_id = $_SESSION['admin_logged']['id'];
        $guide = $model->getGuideUserid($user_id);
        if (empty($scheduleData) || $scheduleData['guide_id'] != $guide['id']) {
            // Nếu không tìm thấy hoặc HDV không phụ trách
            header("Location: " . BASE_URL . "?mode=admin&act=404");
            exit;
        }

        require "./views/Admin/tour_detail_guide.php";
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
        $user_id = $_SESSION['admin_logged']['id'];
        $guide = (new GuideTourModel())->getGuideUserid($user_id);
        $guide_id = $guide['id'];

        $model = new GuideTourModel();

        $todayTour = $model->getTodayTour($guide_id);

        $customers = [];
        $activities = [];
        $current_day_number = null;

        if ($todayTour) {
            $schedule_id = $todayTour['schedule_id'];
            $start_date = $todayTour['start_date'];

            // 1. Tính toán Ngày thứ mấy của tour
            $current_day_number = $model->getTodayTourDayNumber($start_date);

            // 2. Lấy TẤT CẢ các hoạt động
            $allActivities = $model->getTourActivitiesBySchedule($schedule_id);

            // 3. LỌC Activities: CHỈ lấy hoạt động của NGÀY HIỆN TẠI
            $filteredActivities = [];
            foreach ($allActivities as $activity) {
                if ($activity['day_number'] == $current_day_number) { // <--- ĐÃ SỬA: Dùng '==' thay vì '<='
                    $filteredActivities[] = $activity;
                }
            }
            $activities = $filteredActivities;

            // 4. Lấy danh sách khách và trạng thái điểm danh
            $customers = $model->getCustomersAttendanceBySchedule($schedule_id);
        }

        return [
            'todayTour' => $todayTour,
            'customers' => $customers,
            'activities' => $activities,
            'current_day_number' => $current_day_number
        ];
    }
    // Lưu điểm danh từng chặng 1 
    public function saveAttendanceByActivity()
    {
        // Đọc dữ liệu JSON: { customer_id: { activity_id: { status: '...', notes: '...' }, ... }, ... }
        $data = json_decode(file_get_contents("php://input"), true);

        // 1. Xác định schedule_id đang hoạt động
        $user_id = $_SESSION['admin_logged']['id'];
        $guide_id = (new GuideTourModel())->getGuideUserid($user_id)['id'];
        $todayTour = (new GuideTourModel())->getTodayTour($guide_id);

        if (!$todayTour) {
            echo "Lỗi: Không tìm thấy tour hôm nay để lưu điểm danh.";
            return;
        }

        $schedule_id = $todayTour['schedule_id'];
        $model = new GuideTourModel();
        $successCount = 0;

        // 2. Vòng lặp qua dữ liệu và lưu vào Model
        if (is_array($data)) {
            foreach ($data as $customerId => $activities) {
                if (is_array($activities)) {
                    foreach ($activities as $activityId => $record) {
                        $status = $record['status'] ?? 'absent';
                        $notes = $record['notes'] ?? NULL; // Nhận ghi chú

                        // LOGIC ĐIỀU KIỆN: Nếu Đã đến, xóa ghi chú thành NULL
                        if ($status === 'present') {
                            $notes = NULL;
                        }

                        // Lưu vào DB (ĐÃ CÓ $notes mới)
                        $model->saveOrUpdateAttendanceActivity($schedule_id, $customerId, $activityId, $status, $notes);
                        $successCount++;
                    }
                }
            }
        }

        if ($successCount > 0) {
            echo "success";
        } else {
            echo "Lỗi: Không có dữ liệu hợp lệ để lưu trữ.";
        }
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


    // thông báo guide chờ sác nhận 
    public function MesageGuide($guide_id)
    {
        if (!$guide_id) {
            header("Location: ?mode=admin&act=homeguide");
            exit;
        }
        $dataSchedulesByIdGuide = (new SchedulesModel())->getSchedulesStatusByGuideId($guide_id);
        // echo '<pre>';
        // var_dump($dataSchedulesByIdGuide);
        // die;
        require_once "./views/Admin/mesageguide.php";
    }

    public function MesageGuideDetail($schedule_id)
    {
        if (!$schedule_id) {
            header("Location: ?mode=admin&act=homeguide");
            exit;
        }

        $dataSchedulesById = (new SchedulesModel())->getSchedulesStatusById($schedule_id);


        $databooking = (new BookingModel())->getBookingById($dataSchedulesById[0]['booking_id']);

        $dataCustomers = (new BookingCustomersModel())->getCustomersByBookingId($dataSchedulesById[0]['booking_id']);

        $datatour = (new TourModel())->getOne($dataSchedulesById[0]['tour_id']);
        // echo "<pre>";
        // echo "\n=== \$dataSchedulesById ===\n";
        // print_r($dataSchedulesById);

        // echo "\n=== \$databooking ===\n";
        // print_r($databooking);

        // echo "\n=== \$dataCustomers ===\n";
        // print_r($dataCustomers);

        // echo "\n=== \$datatour ===\n";
        // print_r($datatour);
        // echo "</pre>";
        // die;
        require_once "./views/Admin/mesageguidedetail.php";
    }

    public function AcceptTour($schedule_id)
    {
        if (!$schedule_id) {
            $_SESSION['error_message'] = "Thiếu ID lịch trình!";
            header("Location: ?mode=admin&act=homeguide");
            exit;
        }

        $dataSchedulesById = (new SchedulesModel())->getSchedulesStatusById($schedule_id);

        if (empty($dataSchedulesById)) {
            $_SESSION['error_message'] = "Không tìm thấy lịch trình!";
            header("Location: ?mode=admin&act=homeguide");
            exit;
        }

        $guide_id = $dataSchedulesById[0]['guide_id'] ?? null;

        if (!$guide_id) {
            $_SESSION['error_message'] = "Không tìm thấy Hướng dẫn viên của lịch trình!";
            header("Location: ?mode=admin&act=homeguide");
            exit;
        }

        $updateStatus = (new ScheduleStatusModel())->updateScheduleStatusByScheduleId(
            $schedule_id,
            6,
            2,
            'AVAILABLE',
            'confirmed',
            'HDV Đã xác nhận đi tour phục vụ đoàn'
        );

        if (!$updateStatus) {
            $_SESSION['error_message'] = "Cập nhật trạng thái thất bại!";
            header("Location: ?mode=admin&act=homeguide");
            exit;
        }

        $_SESSION['success_message'] = "Xác nhận tour thành công!";

        header("Location: ?mode=admin&act=mesageguide&guide_id=" . $guide_id);
        exit;
    }
}
