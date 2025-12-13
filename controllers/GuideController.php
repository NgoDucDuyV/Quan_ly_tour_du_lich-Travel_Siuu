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
        // // var_dump($today);
        // var_dump($dataSchedulesByGuideId);
        // echo "<pre>";
        // die;

        $totalUpcomingTours = $model->getUpcomingTours($guide_id);

        $countUpcomingTours = 0;

        foreach ($totalUpcomingTours as $tour) {
            if (isset($tour['guide_status_code']) && strtoupper($tour['guide_status_code']) !== 'PENDING') {
                $countUpcomingTours++;
            }
        }
        // echo '<pre>';
        // var_dump($countUpcomingTours);
        // echo '<pre>';
        // die;
        //Đếm khách hôm nay
        $totalCustomersToday = $model->getTotalCustomersToday($guide_id);
        // Đếm số tour hoàn thành
        $totalCompletedTours = $model->countCompletedTours($guide_id);
        // Nhật ký gần đây
        $diary = $model->getRecentDiary($guide_id);

        // kiểm tra có tour hôm này
        $todayTours = [];
        $today = today();
        // echo '<pre>';
        // var_dump($totalCompletedTours);
        // echo '<pre>';
        // die;
        foreach ($dataSchedulesByGuideId as $schedule) {
            $start = $schedule['start_date'];
            $end   = $schedule['end_date'];
            // echo $start;
            // die;
            $status_code = $schedule['schedule_status_code']; // Lấy mã trạng thái từ Model đã sửa

            // Điều kiện: (1) Đang diễn ra hôm nay VÀ (2) Trạng thái không phải là Hoàn thành/Đã hủy
            if (
                ($today >= $start && $today <= $end) && // <-- Logic này bao gồm tour đang diễn ra
                !in_array($status_code, ['completed', 'cancelled', 'closed'])
            ) {
                $todayTours[] = $schedule;
            }
        }
        // echo '<pre>';
        // var_dump($todayTours);
        // echo '<pre>';
        // die;
        // Yêu cầu gần đây
        $requests = $model->getRecentRequests($guide_id);

        require_once "./views/Admin/homeguide.php";
    }

    public function StartTour($schedule_id)
    {
        // echo $schedule_id;
        // die;
        $dataschedule = (new SchedulesModel())->getAllSchedulesByid($schedule_id);
        $databooking = (new BookingModel())->getBookingById($dataschedule[0]['booking_id']);
        // echo '<pre>';
        // var_dump($databooking);
        // echo '<pre>';
        // die;
        // update trạng thái
        (new ScheduleStatusModel())->updateScheduleStatusByScheduleId(
            $schedule_id,
            2,
            4,
            "in_progress",
            "ON_ROUTE",
            "hướng dẫn viên đang bắt đàu tour di chuyển hoạt đôgnj tour"
        );
        // cập nhật trạng thái booking
        (new BookingStatusModel())->updateStatusByBookingId(
            $databooking['booking_id'],
            5,
            $databooking['payment_type_id_master'],
            'Hướng dẫn viên bắt đầu haotj đôgn tour !'
        );

        // Ghi log trạng thái
        (new BookingStatusModel())->insertBookingLog(
            $databooking['booking_id'],
            $databooking['status_type_code_master'],
            'IN_PROGRESS',
            $_SESSION['admin_logged']['id'],
            "Hướng dẫn viên xác nhận bắt đầu hoạt đôngj tour"
        );

        header("Location: " . BASE_URL . "?mode=admin&act=checkguide");
        exit;
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

        // echo "<pre>";
        // Var_dump($todayTour);
        // die;
        $datacustomers = [];

        // Nếu hôm nay có tour → lấy danh sách khách
        if ($todayTour) {
            $tour_id = $todayTour['tour_id'];
            $start = $todayTour['start_date'];
            $end   = $todayTour['end_date'];

            // Lấy danh sách khách hàng từ các booking khớp với tour_id VÀ khoảng ngày của schedule
            $datacustomers = $model->getCustomerListByTourid($tour_id, $start, $end);

            $datatour = (new TourModel())->getOne($todayTour['tour_id']);
            // echo "<pre>";
            // Var_dump($datatour);
            // die;
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
        $guide_id = $guide['id'];

        $schedule_id = $_POST['schedule_id'];
        $content = $_POST['content'];
        $images = $_FILES['images'];

        $uploadDir = "uploads/logs/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $uploadedImages = [];

        // Upload nhiều ảnh
        if (!empty($images['name'][0])) {
            foreach ($images['name'] as $key => $name) {
                $newName = $uploadDir . uniqid() . "_" . $name;

                if (move_uploaded_file($images['tmp_name'][$key], $newName)) {
                    $uploadedImages[] = $newName;
                }
            }
        }

        // Gửi sang Model
        (new GuideTourModel())->insertLog(
            $schedule_id,
            $guide_id,
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

        $dataSchedulesByGuideId = (new GuideTourModel())->getSchedulesForGuide($guide_id);

        $todayTours = [];
        $today = today();
        // echo '<pre>';
        // var_dump($totalCompletedTours);
        // echo '<pre>';
        // die;
        foreach ($dataSchedulesByGuideId as $schedule) {
            $start = $schedule['start_date'];
            $end   = $schedule['end_date'];
            // echo $start;
            // die;
            $status_code = $schedule['schedule_status_code']; // Lấy mã trạng thái từ Model đã sửa

            // Điều kiện: (1) Đang diễn ra hôm nay VÀ (2) Trạng thái không phải là Hoàn thành/Đã hủy
            if (
                ($today >= $start && $today <= $end) && // <-- Logic này bao gồm tour đang diễn ra
                !in_array($status_code, ['completed', 'cancelled', 'closed'])
            ) {
                $todayTours[] = $schedule;
            }
        }

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
            'current_day_number' => $current_day_number,
            'todayTours' => $todayTours
        ];
    }

    // Lưu điểm danh từng chặng 1 
    public function saveAttendance()
    {
        // Bắt buộc phải có 2 dòng này ở đầu mọi AJAX trả JSON
        ob_clean();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if (!is_array($data) || empty($data)) {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
            exit;
        }

        $user_id = $_SESSION['admin_logged']['id'] ?? 0;
        $model   = new GuideTourModel();
        $guide   = $model->getGuideUserid($user_id);

        if (!$guide) {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy hướng dẫn viên']);
            exit;
        }

        $todayTour = $model->getTodayTour($guide['id']);
        if (!$todayTour) {
            echo json_encode(['success' => false, 'message' => 'Hôm nay không có tour']);
            exit;
        }

        $schedule_id = $todayTour['schedule_id'];
        $count = 0;

        foreach ($data as $customerId => $status) {
            if (in_array($status, ['present', 'late', 'absent'], true)) {
                $model->saveOrUpdateAttendance($schedule_id, $customerId, $status);
                $count++;
            }
        }

        echo json_encode([
            'success' => true,
            'message' => "Đã cập nhật trạng thái tổng cho $count khách"
        ]);
        exit;
    }

    public function saveAttendanceByActivity()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['att'])) {
            $_SESSION['error'] = 'Dữ liệu không hợp lệ!';
            header("Location: ?mode=admin&act=checkguide");
            exit;
        }

        $model = new GuideTourModel();
        $user_id = $_SESSION['admin_logged']['id'];
        $guide = $model->getGuideUserid($user_id);
        $todayTour = $model->getTodayTour($guide['id']);

        if (!$todayTour) {
            $_SESSION['error'] = 'Không có tour hôm nay!';
            header("Location: ?mode=admin&act=checkguide");
            exit;
        }

        $schedule_id = $todayTour['schedule_id'];
        $saved = 0;

        foreach ($_POST['att'] as $customerId => $activities) {
            foreach ($activities as $activityId => $data) {
                $status = $data['status'] ?? 'absent';
                $notes = ($status === 'present') ? null : ($data['notes'] ?? null);

                $ok = $model->saveOrUpdateAttendanceActivity(
                    $schedule_id,
                    $customerId,
                    $activityId,
                    $status,
                    $notes
                );

                if ($ok) {
                    $model->saveOrUpdateAttendance($schedule_id, $customerId, $status);
                    $saved++;
                }
            }
        }

        $_SESSION['success_message'] = "Đã lưu thành công $saved điểm danh!";
        header("Location: ?mode=admin&act=checkguide");
        exit;
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
