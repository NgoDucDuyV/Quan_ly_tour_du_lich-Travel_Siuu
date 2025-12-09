<?php
class BookingController
{

    public function ShowBooking()
    {
        $bookingModel = new BookingModel();
        $bookings = $bookingModel->getAllBookings();

        // $dataSchedulesStatus = (new SchedulesModel())->getSchedulesStatusByBookingId(1);
        // echo "<pre>";
        // var_dump($bookings);
        // echo "</pre>";
        // die;
        require_once "./views/Admin/bookinglist.php";
    }

    public function ShowBookingDetail($booking_id)
    {
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
        $bookingPrices = (new PaymentModel())->getBookingPricesByBookingId($booking_id);

        // echo "<pre>";
        // var_dump($paymentLogs);
        // echo "</pre>";
        // die;
        require_once "./views/Admin/bookingdetail.php";
    }

    public function ShowFromNewBooking($tour_id = null)
    {
        $datatour = (new TourModel())->getAll();

        $dataCustomerTypes = (new BookingModel())->getAlCustomerTypes();

        $dataCustomerTypes = (new BookingCustomersModel())->getCustomerTypes();

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
        //     var_dump($tourFullData['oneTour']);
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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['success_message'] = "Mời điền đầy đủ thông tin booking!";
            header("Location: " . BASE_URL . "?mode=admin&act=newBooking");
            exit;
        }

        // 1. Nhận dữ liệu POST + FILES
        $data = $_POST;
        $data['files'] = $_FILES;

        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        // die;

        // 2. Lấy START - END DATE, đảm bảo NULL nếu rỗng
        if ($data['group_type_id'] == 1) { // nếu là theo lịch trình{
            $startDate = !empty($data['start_date'][0]) ? $data['start_date'][0] : null;
            $endDate   = !empty($data['end_date'][0]) ? $data['end_date'][0] : null;
        } else { // nếu là đặt riêng
            $startDate = !empty($data['start_date'][1]) ? $data['start_date'][1] : null;
            $endDate   = !empty($data['end_date'][1]) ? $data['end_date'][1] : null;
        }

        // 3. Xử lý passenger_prices
        $passengerRaw = $data['passenger_prices'] ?? '[]';
        $passengerArr = is_string($passengerRaw) ? json_decode($passengerRaw, true) : $passengerRaw;
        $passengerTotal = 0;
        if (is_array($passengerArr)) {
            foreach ($passengerArr as $item) {
                $passengerTotal += $item['total_price'] ?? 0;
            }
        }

        // 4. Xử lý service_prices
        $serviceRaw = $data['service_prices'] ?? '[]';
        $serviceArr = is_string($serviceRaw) ? json_decode($serviceRaw, true) : $serviceRaw;
        $serviceTotal = 0;
        if (is_array($serviceArr)) {
            foreach ($serviceArr as $item) {
                $serviceTotal += $item['total_price'] ?? 0;
            }
        }

        // 5. Chuẩn dữ liệu booking
        $bookingData = [
            'booking_code'     => $data['booking_code'] ?? null,
            'tour_id'          => $data['tour_id'] ?? null,
            'tour_version_id'  => $data['tour_version_id'] ?? null,
            'start_date'       => $startDate,
            'end_date'         => $endDate,
            'customer_name'    => $data['customer_name'] ?? null,
            'customer_phone'   => $data['customer_phone'] ?? null,
            'customer_email'   => $data['customer_email'] ?? null,
            'group_type_id'    => $data['group_type_id'] ?? null,
            'number_of_people' => $data['number_of_people'] ?? 0,
            'total_price'      => $data['total_price'] ?? 0,
            'service_prices'   => $serviceTotal,
            'passenger_prices' => $passengerTotal,
            'note'             => $data['note'] ?? null,
        ];
        // 6. Insert Booking, trả về booking_id
        // echo "<pre>";
        // var_dump($bookingData);
        // echo "<pre>";
        // die;
        $bookingModel = new BookingModel();
        $bookingId = $bookingModel->InsertBooking($bookingData);
        // echo "New Booking ID: " . $bookingId;
        if (!$bookingId) {
            $_SESSION['success_message'] = "Lỗi Thông tin booking chính ! ";
            header("Location: " . BASE_URL . "?mode=admin&act=newBooking&tour_id=" . ($data['tour_id'] ?? ''));
            exit;
        }
        // die;
        // if (!$bookingId) {
        //     die("Lỗi insert booking!");
        // }

        // 7. Chuẩn dữ liệu booking_prices
        $bookingPricesData = [
            'booking_id'       => $bookingId,
            'passenger_prices' => $passengerTotal,
            'service_prices'   => $serviceTotal,
            'total_price'      => $data['total_price'] ?? 0,
            'paid_amount'      => $data['paid_amount'] ?? 0,
            'remaining_amount' => ($data['total_price'] ?? 0) - ($data['paid_amount'] ?? 0),
            'currency'         => $data['currency'] ?? 'VND',
            'notes'            => $data['booking_price_note'] ?? null,
        ];

        $bookingPricesId = (new PaymentModel())->InsertBookingPrices($bookingPricesData);
        if (!$bookingPricesId) {
            $_SESSION['success_message'] = "Lỗi dữ liệu giá booking ! ";
            header("Location: " . BASE_URL . "?mode=admin&act=newBooking&tour_id=" . ($data['tour_id'] ?? ''));
            exit;
        }
        // echo "New BookingPrices ID: " . $bookingPricesId;
        // die;
        // 8. Xử lý passengers
        $passengers = [];
        if (!empty($data['passenger_full_name'])) {
            for ($i = 0; $i < count($data['passenger_full_name']); $i++) {
                if (trim($data['passenger_full_name'][$i]) === '') continue;
                $passengers[] = [
                    'booking_id'       => $bookingId,
                    'full_name'        => $data['passenger_full_name'][$i],
                    'birth_year'       => $data['passenger_birth_date'][$i] ?? null,
                    'passport'         => $data['passenger_passport'][$i] ?? null,
                    'note'             => $data['passenger_note'][$i] ?? null,
                    'customer_type_id' => $data['passenger_type'][$i] ?? 1,
                ];
            }
        }

        $idBookingCustomersModel = (new BookingCustomersModel())->insertPassengers($passengers);
        // echo "New BookingCustomers ID: " . $idBookingCustomersModel;
        // die;
        // 9. Xử lý services đầy đủ
        $services = [];
        $maxCount = max(
            count($serviceArr ?? []),
            count($data['supplier_id'] ?? []),
            count($data['supplier_type_id'] ?? []),
            count($data['service_quantity'] ?? []),
            count($data['service_price'] ?? []),
            count($data['service_note'] ?? [])
        );

        for ($i = 0; $i < $maxCount; $i++) {
            $services[] = [
                'booking_id'       => $bookingId,
                'supplier_id'      => $data['supplier_id'][$i] ?? null,
                'supplier_type_id' => $data['supplier_type_id'][$i] ?? null,
                'service_name'     => $serviceArr[$i]['service'] ?? '',
                'service_quantity' => $data['service_quantity'][$i] ?? 1,
                'service_price'    => $data['service_price'][$i] ?? 0,
                'service_note'     => $data['service_note'][$i] ?? null,
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ];
        }
        $dataBookingServicesModel = (new BookingServicesModel())->insertServices($services);
        if ($dataBookingServicesModel) {
            echo "lưu dịch vụ thành công dataBookingServicesModel";
        }
        // 10. Upload files
        $uploadedFiles = [];
        if (isset($data['files']['attachments'])) {
            for ($i = 0; $i < count($data['files']['attachments']['name']); $i++) {
                $uploadedFiles[] = [
                    'booking_id' => $bookingId,
                    'name'       => $data['files']['attachments']['name'][$i],
                    'tmp_name'   => $data['files']['attachments']['tmp_name'][$i],
                    'type'       => $data['files']['attachments']['type'][$i],
                    'size'       => $data['files']['attachments']['size'][$i],
                ];
            }
        }

        (new BookingStatusModel())->insertBookingStatusDefault($bookingId);

        $_SESSION['success_message'] = "Tạo Booking thành công! (Mã Booking: " . ($data['booking_code'] ?? '') . ")";
        header("Location: " . BASE_URL . "?mode=admin&act=bookinglist");
        exit;
    }
}
