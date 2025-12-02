<?php
class BookingController
{

    public function ShowBooking()
    {
        $bookingModel = new BookingModel();
        $bookings = $bookingModel->getAllBookings();
        require_once "./views/Admin/booking.php";
    }

    public function ShowFromThanhToan($booking_id = null)
    {
        $dataBookingStatusType = (new BookingStatusModel())->getBookingStatusType();

        $dataPaymentTypes = (new BookingStatusModel())->getPaymentTypes();

        $datagetBookinglogsbyid = (new BookingStatusModel())->getBookinglogsbyid($booking_id);

        $dataBookingServicesWithSuppliers = (new BookingModel())->getBookingServicesWithSuppliers($booking_id);

        $datagetPaymentModel = (new PaymentModel())->getPaymentModel();

        require_once "./views/Admin/update_from_thanh_toan.php";
    }

    public function UpdateFromBookingStatus($booking_id)
    {
        // Nếu không có booking, chuyển hướng về trang danh sách

        $databooking = (new BookingModel())->getBookingById($booking_id);

        if (!$databooking) {
            header("Location: ?act=booking_list"); // thay ?act=booking_list bằng URL trang cũ của bạn
            exit;
        }

        $dataBookingStatusType = (new BookingStatusModel())->getBookingStatusType();

        $dataPaymentTypes = (new BookingStatusModel())->getPaymentTypes();

        $datagetBookinglogsbyid = (new BookingStatusModel())->getBookinglogsbyid($booking_id);

        $dataBookingServicesWithSuppliers = (new BookingModel())->getBookingServicesWithSuppliers($booking_id);

        $datagetPaymentModel = (new PaymentModel())->getPaymentModel();
        // echo "<pre>";
        // var_dump('$datagetPaymentModel = ' . print_r($datagetPaymentModel, true));
        // var_dump('$dataBookingStatusType = ' . print_r($dataBookingStatusType, true));
        // var_dump('$dataPaymentTypes = ' . print_r($dataPaymentTypes, true));
        // var_dump('$datagetBookinglogsbyid = ' . print_r($datagetBookinglogsbyid, true));
        // var_dump('$dataBookingServicesWithSuppliers = ' . print_r($dataBookingServicesWithSuppliers, true));
        // echo "<pre>";
        // die;
        require_once "./views/Admin/update_booking_status.php";
    }

    public function createBookingStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $errors = [];
        $booking_id = $_POST['booking_id'] ?? null;
        $old_status = $_POST['old_status'] ?? null;
        $booking_status = $_POST['booking_status'] ?? 'CHXACNHAN';
        $note = trim($_POST['note'] ?? '');

        if (!$booking_id) $errors[] = "Booking không hợp lệ.";
        if (!$booking_status) $errors[] = "Vui lòng chọn trạng thái booking.";

        // Thông tin thanh toán
        $payer_name = $deposit_amount = $payment_method_id = $payment_description = $payment_image = null;

        if ($booking_status === 'DACOC') {
            $payer_name = trim($_POST['payer_name'] ?? '');
            $deposit_amount = trim($_POST['deposit_amount'] ?? '');
            $payment_method_id = $_POST['payment_method_id'] ?? '';
            $payment_description = trim($_POST['payment_description'] ?? '');

            if (!$payer_name) $errors[] = "Vui lòng nhập tên người thanh toán.";
            if (!$deposit_amount || !is_numeric($deposit_amount) || $deposit_amount <= 0) $errors[] = "Số tiền cọc không hợp lệ.";
            if (!$payment_method_id) $errors[] = "Vui lòng chọn phương thức thanh toán.";

            // Upload ảnh thanh toán
            if (isset($_FILES['payment_image']) && $_FILES['payment_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = "./uploads/payment_images/";
                if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

                $filename = time() . "_" . basename($_FILES['payment_image']['name']);
                $targetFile = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['payment_image']['tmp_name'], $targetFile)) {
                    $payment_image = $filename;
                } else {
                    $errors[] = "Upload hình ảnh thất bại.";
                }
            } else {
                $errors[] = "Vui lòng upload hình ảnh chuyển tiền.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_data'] = $_POST;
            header("Location: ?mode=admin&act=update_from_booking_status&id=" . $booking_id);
            exit;
        }

        // Lưu log trạng thái
        (new BookingModel())->addBookingLog([
            'booking_id' => $booking_id,
            'old_status' => $old_status,
            'new_status' => $booking_status,
            'description' => $payment_description ?: $note,
            'updated_by' => $_SESSION['admin_logged']['id'] ?? 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // --- Xử lý status ---
        $status_id = null;
        $dataBookingStatusType = (new BookingStatusModel())->getBookingStatusType();
        foreach ($dataBookingStatusType as $status) {
            if ($status['code'] === $booking_status) {
                $status_id = $status['id'];
                break;
            }
        }

        // --- Cập nhật booking ---
        $updateData = ['status_code' => $booking_status, 'status_id' => $status_id];

        if ($booking_status === 'DACOC') {
            $updateData['payment_status_id'] = $payment_method_id;
            $updateData['payment_status_code'] = $payment_method_id;
        }

        (new BookingModel())->updateBooking($booking_id, $updateData);

        // --- Lưu thông tin thanh toán vào booking_payments ---
        if ($booking_status === 'DACOC') {
            $paymentModel = new PaymentModel();
            $paymentModel->createPayment([
                'booking_id' => $booking_id,
                'amount' => $deposit_amount,
                'payment_method_id' => $payment_method_id,
                'payment_type_id' => 1, // 1 = deposit
                'transaction_code' => 'TXN' . time(),
                'payment_image' => $payment_image,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $_SESSION['success'] = "Cập nhật trạng thái booking thành công!";
        header("Location: ?mode=admin&act=update_from_booking_status&id=" . $booking_id);
        exit;
    }

    public function ShowFromNewBooking($tour_id = null)
    {
        $datatour = (new TourModel())->getAll();

        $dataCustomerTypes = (new BookingModel())->getAlCustomerTypes();

        $dataCustomerTypes = (new BookingCustomers())->getCustomerTypes();

        $dataGroupType = (new BookingModel())->getAlGroupType();
        // echo "<pre>";
        // var_dump($dataGroupType);
        // echo "<pre>";
        // die;
        if (!empty($tour_id)) {

            $dataTourDetai = (new TourModel())->TourDetailItineraryModel($tour_id);

            $dataOneTour = (new TourModel())->getOne($tour_id);

            $dataTourSupplier = (new TourModel())->TourSuppliersModel($tour_id);

            $datatour_supplier_types = (new SupplierModel())->getallTour_supplier_types($tour_id);

            $dataTourVersions = (new TourModel())->TourVersionsModel($tour_id);

            $dataTourImages = (new TourModel())->TourImagesModel($tour_id);

            $dataTourPolicies = (new TourModel())->TourPoliciesModel($tour_id);

            $databookingbytourid = (new BookingModel())->getAllBookingsByTourId($tour_id);

            $dataSchedulesByTourId = (new SchedulesModel())->getallSchedulesByTourId($tour_id);

            $tourFullData = [
                'tourDetail'    => $dataTourDetai ?? [],
                'oneTour'       => $dataOneTour ?? [],
                'suppliers'     => $dataTourSupplier ?? [],
                'versions'      => $dataTourVersions ?? [],
                'images'        => $dataTourImages ?? [],
                'policies'      => $dataTourPolicies ?? [],
                'supplier_types' => $datatour_supplier_types ?? [],
            ];
        }
        $dataSuppliersByType = []; // khởi tạo mảng chứa kết quả

        if (isset($tourFullData['suppliers'])) {
            foreach ($tourFullData['suppliers'] as $item) {
                $suppliers = (new SupplierModel())->getSuppliersByType($item['id']);
                if (!empty($suppliers)) {
                    // lưu theo supplier_type_id
                    $dataSuppliersByType[$item['id']] = $suppliers;
                }
            }
        }
        // $dataSchedulesByid = (new SchedulesModel())->getAllSchedulesByid(1);

        // if (isset($tourFullData)) {
        //     echo "<pre>";
        //     var_dump($dataCustomerTypes);
        //     echo "<pre>";
        //     die;
        // }

        require_once "./views/Admin/newBooking.php";
    }

    public function ShowPhanTourFromGuides()
    {
        require_once "./views/Admin/phan_tour_guides.php";
    }
    // call api js
    public function getAllSchedulesByid($requestData)
    {
        header('Content-Type: application/json');
        // echo json_encode([
        //     "id" => $requestData['schedules_id'],
        // ]);
        // exit;
        $dataSchedulesByid = (new SchedulesModel())->getAllSchedulesByid($requestData['schedules_id']);
        echo json_encode($dataSchedulesByid);
        exit;
    }
    // call api js
    public function getsupplierPricesBySupplierId($requestData)
    {
        header('Content-Type: application/json');
        // echo json_encode([
        //     "id" => $requestData['schedules_id'],
        // ]);
        // exit;
        $dataSupplierPricesBySupplierId = (new SupplierModel())->getsupplierPricesBySupplierId($requestData['supplier_id']);
        echo json_encode($dataSupplierPricesBySupplierId);
        exit;
    }

    public function createBooking()
    {
        var_dump('lueu okign');
        die;
        if (session_status() === PHP_SESSION_NONE) session_start();

        //check quyền chỉ admin mới thao tác
        if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'admin') {
            $_SESSION['error'] = "bạn không có quyền!";
            header("Location: ?mode=admin&act=booking");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?mode=admin&act=booking");
            exit;
        }

        $data = [
            'tour_id'          => (int)($_POST['tour_id'] ?? 0),
            'tour_version_id'  => (int)($_POST['tour_version_id'] ?? 0),
            'customer_name'    => trim($_POST['customer_name'] ?? ''),
            'customer_phone'   => trim($_POST['customer_phone'] ?? ''),
            'customer_email'   => trim($_POST['customer_email'] ?? ''),
            'group_type'       => $_POST['group_type'] ?? 'le', // le hoặc doan
            'number_of_people' => (int)($_POST['number_of_people'] ?? 1),
            'note'             => trim($_POST['note'] ?? ''),
            'status'           => $_POST['status'] ?? 'cho_xac_nhan', // mặc định chờ xác nhận
        ];

        // check validate
        if (empty($data['tour_id']) || empty($data['customer_name']) || empty($data['customer_phone']) || empty($data['customer_email'])) {
            $_SESSION['error'] = "vui lòng điền đầy đủ các trường bắt buộc!";
            header("Location: ?mode=admin&act=newBooking");
            exit;
        }

        $bookingModel = new BookingModel();
        if ($bookingModel->create($data)) {
            $_SESSION['success'] = "Tạo booking thành công!";
        } else {
            $_SESSION['error'] = "Tạo booking thất bại, vui lòng thử lại!";
        }

        header("Location: ?mode=admin&act=booking");
        exit;
    }
}
