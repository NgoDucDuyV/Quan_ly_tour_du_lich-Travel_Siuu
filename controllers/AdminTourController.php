<?php
class AdminTourController
{

    public function ShowAdminTour($tour_name = null)
    {
        if (!empty($tour_name)) {
            $datatour = (new TourModel())->getByName($tour_name);
        } else {
            $datatour = (new TourModel())->getAll();
        }
        // echo '<pre>';
        // var_dump($datatour);
        // echo '<pre>';
        // die;
        require_once "./views/Admin/admin_tours.php";
    }

    public function showTourDetail($tour_id)
    {
        $datatour = (new TourModel())->getAll();

        $dataTourDetai = (new TourModel())->TourDetailItineraryModel($tour_id);

        $dataOneTour = (new TourModel())->getOne($tour_id);

        $dataTourSupplier = (new TourModel())->TourSuppliersModel($tour_id);

        $dataTourVersions = (new TourModel())->TourVersionsModel($tour_id);

        $dataTourImages = (new TourModel())->TourImagesModel($tour_id);

        $dataTourPolicies = (new TourModel())->TourPoliciesModel($tour_id);
        // echo "<pre>";
        // var_dump($dataTourSupplier);
        // echo "<pre>";
        // die;
        require_once "./views/Admin/admin_detail_tour.php";
    }

    public function showTourDetailPHP($tour_id)
    {
        $datatour = (new TourModel())->getAll();

        $dataTourDetai = (new TourModel())->TourDetailItineraryModel($tour_id);

        $dataOneTour = (new TourModel())->getOne($tour_id);

        $dataTourSupplier = (new TourModel())->TourSuppliersModel($tour_id);

        $dataTourVersions = (new TourModel())->TourVersionsModel($tour_id);

        $dataTourImages = (new TourModel())->TourImagesModel($tour_id);

        $dataTourPolicies = (new TourModel())->TourPoliciesModel($tour_id);
        // echo "<pre>";
        // var_dump($dataTourSupplier);
        // echo "<pre>";
        // die;
        ob_start();
        require_once "./views/Admin/admin_detail_tour.php";
        $htmlView = ob_get_clean();

        $valueViews = $htmlView;
        require_once "./views/Admin/admin_tours.php";
    }

    public function CreateTour()
    {
        // kiểm tran REQUEST_METHOD thất acr các trường dữ liệu
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['success_message'] = "Chưa nhập đủ dữ liệu để tạo tour!";
            header("Location: " . BASE_URL . "?mode=admin&act=admintour");
            exit;
        }
        $datatour = [
            'name'        => $_POST['name'] ?? null,
            'code'        => $_POST['code'] ?? null,
            'category_id' => $_POST['category_id'] ?? null,
            'days'        => $_POST['days'] ?? null,
            'nights'      => $_POST['nights'] ?? null,
            'description' => $_POST['description'] ?? null,
            'itinerary' => $_POST['itinerary'] ?? null,
            'policy'      => $_POST['policy'] ?? null,
            'price'       => $_POST['price'] ?? null,
            'status'      => $_POST['status'] ?? null,
            // File ảnh
            // 'image'       => $_FILES['image'] ?? null
            'image' => $imagePath = uploadImage("public/upload/imageTour", $_FILES['image'])
        ];
        // echo "<pre>";
        // print_r($datatour);
        // echo "</pre>";
        // die;
        $tour_id =  (new TourModel())->CreateTourModel($datatour);
        // echo "giá trị tour_id";
        // var_dump($tour_id);
        // die;


        // lấy thông tin lịch trình ngày
        if (!empty($_POST['day_number'])) {
            $days   = $_POST['day_number'] ?? [];
            $titles = $_POST['itinerary_title'] ?? [];
            $descs  = $_POST['itinerary_desc'] ?? [];

            $act_day  = $_POST['activity_day'] ?? [];
            $act_name = $_POST['activity_name'] ?? [];
            $act_time = $_POST['activity_time'] ?? [];
            $act_loc  = $_POST['activity_location'] ?? [];
            $act_desc = $_POST['activity_desc'] ?? [];

            $itineraries = [];

            foreach ($days as $i => $day) {
                $itineraries[$day] = [
                    'day' => $day,
                    'title' => $titles[$i] ?? '',
                    'desc'  => $descs[$i] ?? '',
                    'activities' => []
                ];
            }

            foreach ($act_day as $i => $day) {
                // Nếu ngày chưa có trong $itineraries (phòng lỗi), tạo mới
                if (!isset($itineraries[$day])) {
                    $itineraries[$day] = [
                        'day' => $day,
                        'title' => '',
                        'desc' => '',
                        'activities' => []
                    ];
                }
                // Thêm hoạt động vào mảng activities của ngày
                $itineraries[$day]['activities'][] = [
                    'name'        => $act_name[$i] ?? '',
                    'time'        => $act_time[$i] ?? '',
                    'location'    => $act_loc[$i] ?? '',
                    'description' => $act_desc[$i] ?? '',
                ];
            }
            // echo "<pre>";
            // echo "dữ liệu từng ngày";
            // print_r($itineraries);
            // echo "</pre>";
            // die;

            // thêm dữ liệu lịch trình
            foreach ($itineraries as $item) {
                $tour_itineraries_id = (new TourModel())->CreateTourItineraries($item, $tour_id);
                if (isset($item['activities'])) {
                    foreach ($item['activities'] as $activity) {
                        $tour_activities_id = (new TourModel())->CreateTourActivities($activity, $tour_itineraries_id);
                    }
                }
            }
        }
        // Kiểm tra có dữ liệu gửi lên không
        if (!empty($_FILES['tour_images'])) {
            $images = $_FILES['tour_images'];
            $descs  = $_POST['image_desc'] ?? [];
            $links  = $_POST['image_link'] ?? [];

            $tourImages = [];

            // Lặp qua từng ảnh upload
            for ($i = 0; $i < count($images['name']); $i++) {
                // Tạo mảng file tạm như $_FILES['image'] bình thường
                $file = [
                    'name'     => $images['name'][$i],
                    'type'     => $images['type'][$i],
                    'tmp_name' => $images['tmp_name'][$i],
                    'error'    => $images['error'][$i],
                    'size'     => $images['size'][$i]
                ];
                $imagePath = uploadImage("public/upload/imageTour", $file);

                $tourImages[] = [
                    'image' => $imagePath,
                    'desc'  => $descs[$i] ?? '',
                    'link'  => $links[$i] ?? ''
                ];
            }

            // echo "<pre>";
            // print_r($tourImages);
            // echo "</pre>";
            // die;
            foreach ($tourImages as $item) {
                (new TourModel())->CreateTourImages($item, $tour_id);
            }
            // die;
        }
        // chon loai dịch vụ
        if (!empty($_POST['supplier_types_id'])) {
            $supplier_types_id = $_POST['supplier_types_id']; // mảng ID loại dịch vụ
            $notes = $_POST['notes']; // mảng ghi chú tương ứng

            $datasupplierstypes = []; // mảng gom dữ liệu
            $count = count($supplier_types_id);

            for ($i = 0; $i < $count; $i++) {
                $datasupplierstypes[] = [
                    'supplier_types_id' => $supplier_types_id[$i],
                    'note' => $notes[$i]
                ];
            }
            // echo '<pre>';
            // print_r($datasupplierstypes);
            // echo '</pre>';
            // die;
            foreach ($datasupplierstypes as $item) {
                (new TourModel())->CreateTourSuppliersTypes($item, $tour_id);
            }
            // die;
        }
        // thêm version_nametour
        if (!empty($_POST['version_name'])) {
            $names   = $_POST['version_name'];
            $seasons = $_POST['version_season'];
            $prices  = $_POST['version_price'];
            $starts  = $_POST['version_start'];
            $ends    = $_POST['version_end'];
            $statuses = $_POST['version_status'];

            $versions = [];
            $count = count($names);

            for ($i = 0; $i < $count; $i++) {
                $versions[] = [
                    'name'       => $names[$i],
                    'season'     => $seasons[$i],
                    'price'      => $prices[$i],
                    'start_date' => $starts[$i],
                    'end_date'   => $ends[$i],
                    'status'     => $statuses[$i]
                ];
            }

            // echo '<pre>';
            // print_r($versions);
            // echo '</pre>';
            // die;
            foreach ($versions as $item) {
                (new TourModel())->CreateTourVersions($item, $tour_id);
            }
            // die;
        }
        // thêm các chính sách
        if (!empty($_POST['policy_type'])) {
            $policy_types = $_POST['policy_type'];
            $descriptions = $_POST['description'];

            $policies = [];

            $count = count($policy_types);

            for ($i = 0; $i < $count; $i++) {
                $policies[] = [
                    'type' => $policy_types[$i],
                    'description' => $descriptions[$i]
                ];
            }
            // kiểm tra dữ liệu
            // echo '<pre>';
            // print_r($policies);
            // echo '</pre>';
            // die;
            foreach ($policies as $item) {
                (new TourModel())->CreateTourPolicies($item, $tour_id);
            }
            // die;
        }

        $_SESSION['success_message'] = "Tạo tour thành công! Mã Tour #: " . $datatour['code'];
        header("Location: " . BASE_URL . "?mode=admin&act=admintour");
        exit;
    }

    public function showFromCreateTour()
    {
        // category
        $categories = (new CategoryModel())->getAllCategories();

        $datasupplier = (new SupplierModel())->getallSupplier();

        $datasupplier_types = (new SupplierModel())->supplier_types();
        // echo "<pre>";
        // var_dump($datasupplier_types);
        // echo "<pre>";
        // die;
        require_once "./views/Admin/admin_createTour.php";
    }

    public function getByNameController($requestData)
    {
        header('Content-Type: application/json');
        if ($requestData['valueSearch'] == "") {
            $datatour = (new TourModel())->getAll();
            echo json_encode($datatour);
            exit;
        }

        $dataTourByName = (new TourModel())->getByName($requestData['valueSearch']);

        if (!empty($dataTourByName)) {
            echo json_encode($dataTourByName);
        } else {
            echo json_encode([]);
        }

        exit;
    }


    public function DeleteTourController($tour_id)
    {
        (new TourModel())->DeleteTourModel($tour_id);
        header("Location: " . BASE_URL . "?act=admintour");
        exit;
    }
}
