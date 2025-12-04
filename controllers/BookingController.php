<?php
class BookingController
{

    public function ShowBooking()
    {
        $bookingModel = new BookingModel();
        $bookings = $bookingModel->getAllBookings();
        // echo "<pre>";
        // var_dump($bookings);
        // echo "</pre>";
        // die;
        require_once "./views/Admin/bookinglist.php";
    }

    public function ShowBookingDetail($booking_id)
    {
        // 1. Lấy thông tin booking
        $databooking = (new BookingModel())->getBookingById($booking_id);

        if (!$databooking) {
            header("Location: ?act=booking_list");
            exit;
        }

        // 2. Lấy danh sách loại trạng thái booking
        $bookingStatusTypes = (new BookingStatusModel())->getBookingStatusType();

        // 3. Lấy lịch sử booking
        $bookingLogs = (new BookingStatusModel())->getBookinglogsbyid($booking_id);

        // 4. Lấy phương thức thanh toán (Cash, Bank…)
        $paymentMethods = (new PaymentModel())->getPaymentMethods();

        // 5. Loại thanh toán (1 lần, cọc, trả trước…)
        $paymentTypes = (new PaymentModel())->getPaymentTypes();

        // 6. Trạng thái thanh toán (PAID, UNPAID, DEPOSIT…)
        $paymentStatusTypes = (new PaymentModel())->getPaymentStatusType();

        // 7. Lịch sử thanh toán
        $paymentLogs = (new PaymentModel())->getPaymentlogsbyid($booking_id);

        // 8. Giá booking
        require_once "./views/Admin/bookingdetail.php";
    }

    public function ShowFromNewBooking($tour_id = null)
    {
        $datatour = (new TourModel())->getAll();

        $dataCustomerTypes = (new BookingModel())->getAlCustomerTypes();

        $dataCustomerTypes = (new BookingCustomers())->getCustomerTypes();

        $dataGroupType = (new BookingModel())->getAlGroupType();

        $dataBookingStatusType = (new BookingStatusModel())->getBookingStatusType();
        // echo "<pre>";
        // var_dump($dataBookingStatusType);
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

            // $data
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

        // if (isset($tourFullData)) {
        //     echo "<pre>";
        //     var_dump($dataSchedulesByTourId);
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
        $_SESSION['success_message'] = "Booking thành công!";
        // Chuyển hướng sang trang khác
        header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
        exit;
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Lấy dữ liệu từ form
        $customerTypes   = $_POST['customer_type'] ?? [];
        $servicesSelected = $_POST['services'] ?? [];
        $tourId           = $_POST['tour_id'] ?? null;
        $tourVersionId    = $_POST['tour_version_id'] ?? null;
        $customerName     = $_POST['customer_name'] ?? '';
        $customerPhone    = $_POST['customer_phone'] ?? '';
        $customerEmail    = $_POST['customer_email'] ?? '';
        $bookingCode      = $_POST['booking_code'] ?? '';

        // Hiển thị dữ liệu
        echo "<pre>";
        echo "Tour ID: $tourId\n";
        echo "Tour Version ID: $tourVersionId\n";
        echo "Customer Name: $customerName\n";
        echo "Customer Phone: $customerPhone\n";
        echo "Customer Email: $customerEmail\n";
        echo "Booking Code: $bookingCode\n";

        echo "\nCustomer Types:\n";
        print_r($customerTypes);

        echo "\nSelected Services:\n";
        print_r($servicesSelected);
        echo "</pre>";
    }
}
