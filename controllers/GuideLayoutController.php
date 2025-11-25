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

        $model = new TourModel();

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
        $guide_id = $_SESSION['admin_logged']['id'] ?? null;

        if (!$guide_id) {
            die("Bạn chưa đăng nhập!");
        }

        // Lấy dữ liệu từ form POST
        $schedule_id = $_POST['schedule_id'] ?? null;
        $content = $_POST['content'] ?? "";
        $images = $_FILES['images'] ?? [];

        // Không chọn tour → báo lỗi
        if (!$schedule_id) {
            die("Bạn phải chọn tour trước khi lưu nhật ký!");
        }

        // Tạo thư mục nếu chưa có
        $uploadDir = "uploads/logs/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Xử lý upload ảnh
        $uploadedImages = [];
        if (!empty($images['name'][0])) {
            foreach ($images['name'] as $key => $name) {
                $tmp = $images['tmp_name'][$key];
                $newName = $uploadDir . uniqid() . "_" . basename($name);

                if (move_uploaded_file($tmp, $newName)) {
                    $uploadedImages[] = $newName;
                }
            }
        }

        // Lưu vào database
        (new TourModel())->insertLog(
            $schedule_id,
            $guide_id,
            $content,
            $uploadedImages
        );

        header("Location: " . BASE_URL . "?mode=admin&act=diaryguide");
        exit;
    }
    public function deleteDiaryGuide()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) die("Thiếu ID nhật ký!");

        $model = new TourModel();

        // Xóa trong database
        $model->deleteLog($id);

        header("Location: " . BASE_URL . "?mode=admin&act=diaryguide");
        exit;
    }
    public function editDiaryGuide()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) die("Thiếu ID!");

        $model = new TourModel();

        $log = $model->getLogById($id);
        $tours = $model->getSchedulesByGuide($_SESSION['admin_logged']['id']);

        require "./views/Admin/editDiaryguide.php";
    }
    public function updateDiaryGuide()
    {
        $id = $_POST['id'];
        $content = $_POST['content'];

        (new TourModel())->updateLog($id, $content);

        header("Location: " . BASE_URL . "?mode=admin&act=diaryguide");
        exit;
    }




    public function checkGuide()
    {
        $guide_id = $_SESSION['admin_logged']['id'];

        $model = new TourModel();

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
