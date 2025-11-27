<?php
class GuideLayoutController
{
    public function Header()
    {
        require_once "./views/Admin/layout_guide/header.php";
    }
    public function Sidebar()
    {
        require_once "./views/Admin/layout_guide/sidebar.php";
    }
    public function Footer()
    {
        require_once "./views/Admin/layout_guide/footer.php";
    }
    // Danh sách khách của HDV
    public function listGuide()
    {
        // Hàm tìm kiếm khách hàng theo từ khóa
        $keyword = $_GET['keyword'] ?? '';

        $bookings = (new BookingModel())->getBookings($keyword);

        require "./views/Admin/listguide.php";
    }
    // Nhật ký ghi lại của HDV 
    public function diaryGuide()
    {
        $guide_id = $_SESSION['admin_logged']['id'];

        $model = new GuideTourModel();

        $diary = $model->getLogsByGuide($guide_id);
        $tours = $model->getSchedulesByGuide($guide_id);

        return [
            'diary' => $diary,
            'tours' => $tours
        ];
    }

    // Thêm nhật ký mới cho HDV
    public function saveDiaryGuide()
    {
        $guide_id = $_SESSION['admin_logged']['id'];

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
            $guide_id,
            $content,
            $uploadedImages
        );

        header("Location: ?mode=admin&act=diaryguide");
    }

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
    public function editDiaryGuide()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) die("Thiếu ID!");

        $model = new GuideTourModel();

        $log = $model->getLogById($id);
        $tours = $model->getSchedulesByGuide($_SESSION['admin_logged']['id']);

        require "./views/Admin/editDiaryguide.php";
    }
    public function updateDiaryGuide()
    {
        $id = $_POST['id'];
        $content = $_POST['content'];

        (new GuideTourModel())->updateLog($id, $content);

        header("Location: " . BASE_URL . "?mode=admin&act=diaryguide");
        exit;
    }




    public function checkGuide()
    {
        $guide_id = $_SESSION['admin_logged']['id'];

        $model = new GuideTourModel();

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
}
