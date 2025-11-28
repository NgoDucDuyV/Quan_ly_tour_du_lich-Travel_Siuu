<?php
if (!empty($tourFullData)) {
    $selectedTourId = !empty($tourFullData['oneTour']) ? $tourFullData['oneTour']['id'] : null;
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Booking Tour Hoàn Chỉnh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f9;
        }

        .step-content {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>

<body>
    <div class="max-w-[1500px] mx-auto p-6 md:p-10">
        <!-- Breadcrumb -->
        <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
            <ul class="inline-flex items-center space-x-2">
                <li>Quản trị viên</li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300">Tạo Booking</li>
            </ul>
        </nav>

        <!-- Step Indicator -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#0f2b57]">
                Bước <span id="step-display">1</span>/3: <span id="step-title">Lựa chọn Tour & Thông tin cơ bản</span>
            </h3>
            <div class="w-full h-3 mt-2 bg-[#a8c4f0] rounded-full">
                <div id="progress-bar" class="h-3 rounded-full transition-all duration-500"
                    style="width:33%; background:linear-gradient(to right,#1f55ad,#5288e0)"></div>
            </div>
        </div>

        <!-- Form -->
        <form id="multi-step-booking-form" class="space-y-10" enctype="multipart/form-data">

            <!-- Hidden Fields -->
            <input type="hidden" name="booking_id" value="">
            <input type="hidden" name="booking_code" value="BK<?= date('YmdHis') ?>">

            <!-- STEP 1: Tour & Khách chính -->
            <div id="step-1-content" class="step-content">
                <div class="p-6 rounded-2xl border border-gray-200 shadow-md space-y-6 bg-white w-full mx-auto">

                    <h4 class="text-2xl font-bold text-gray-800 mb-4 text-center md:text-left">1. Thông Tin Tour & Khách Chính</h4>

                    <!-- Chọn Tour -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Chọn Tour *</label>
                        <select name="tour_id"
                            class="w-full p-4 border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300"
                            required onchange="if(this.value) { window.location.href='?act=newBooking&tour_id=' + this.value; }">
                            <option value="">-- Chọn Tour --</option>
                            <?php foreach ($datatour as $tour): ?>
                                <option value="<?= $tour['id'] ?>" <?= isset($selectedTourId) ? (($tour['id'] == $selectedTourId) ? 'selected' : '') : "" ?>>
                                    <?= $tour['name'] ?> - <?= $tour['duration'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Phiên bản Tour -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Phiên bản Tour / Ngày khởi hành *</label>
                        <select name="tour_version_id"
                            class="w-full p-4 border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300"
                            required>
                            <option value="">-- Chọn Phiên bản --</option>
                            <?php if (!empty($tourFullData['versions'])): ?>
                                <?php foreach ($tourFullData['versions'] as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= $v['name'] ?>: <?= $v['start_date'] ?> - <?= number_format($v['price']) ?> VND</option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Chi tiết tour -->
                    <?php if (!empty($tourFullData)) : ?>
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-md p-6 space-y-6">

                            <!-- Thông tin chính của tour -->
                            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                                <img src="<?= $tourFullData['oneTour']['images'] ?>" alt="<?= $tourFullData['oneTour']['name'] ?>"
                                    class="w-full md:w-64 h-48 object-cover rounded-2xl shadow-sm">
                                <div class="flex-1 space-y-2">
                                    <h2 class="text-2xl font-bold text-gray-800"><?= $tourFullData['oneTour']['name'] ?></h2>
                                    <p class="text-gray-600"><?= $tourFullData['oneTour']['description'] ?></p>
                                    <p class="text-gray-700"><span class="font-semibold">Mã tour:</span> <?= $tourFullData['oneTour']['code'] ?></p>
                                    <p class="text-gray-700"><span class="font-semibold">Thời gian:</span> <?= $tourFullData['oneTour']['duration'] ?></p>
                                    <p class="text-gray-700">
                                        <span class="font-semibold">Giá cơ bản:</span> Người lớn <?= number_format($tourFullData['oneTour']['price']) ?>đ,
                                        Trẻ em 70%, Em bé 50%
                                    </p>
                                </div>
                            </div>

                            <!-- Box giá tour -->
                            <div class="bg-white rounded-2xl border shadow-md p-6 max-w-full mx-auto">
                                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Bảng giá tour</h2>

                                <?php
                                $basePrice = (float)$tourFullData['oneTour']['price'];
                                $prices = [
                                    'Người lớn' => $basePrice * 1.0,
                                    'Trẻ em' => $basePrice * 0.7,
                                    'Em bé' => $basePrice * 0.4
                                ];
                                ?>

                                <div class="mb-4 p-4 bg-indigo-50 rounded-2xl flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">Giá cơ bản:</span>
                                    <span class="text-main font-bold text-lg"><?= number_format($basePrice, 0, ',', '.') ?> VNĐ</span>
                                </div>

                                <ul class="divide-y divide-gray-200 text-gray-700">
                                    <?php foreach ($prices as $type => $price): ?>
                                        <li class="py-3 flex justify-between items-center">
                                            <span class="font-medium"><?= $type ?></span>
                                            <span class="font-semibold text-main"><?= number_format($price, 0, ',', '.') ?> VNĐ</span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- Timeline lịch trình tour -->
                            <?php
                            $groupedData = [];
                            foreach ($tourFullData['tourDetail'] as $item) {
                                $day = $item['day_number'];
                                $groupedData[$day][] = $item;
                            }
                            ?>

                            <div class="space-y-4">
                                <?php foreach ($groupedData as $dayNumber => $activities):
                                    $firstItem = $activities[0];
                                ?>
                                    <div class="bg-white border border-gray-200 rounded-2xl shadow-md overflow-hidden">
                                        <button type="button"
                                            class="w-full flex justify-between items-center p-4 bg-indigo-50 hover:bg-indigo-100 transition-colors rounded-t-2xl focus:outline-none"
                                            onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180');">
                                            <div class="flex items-center gap-4">
                                                <span class="bg-main text-white w-10 h-10 flex items-center justify-center rounded-full font-bold shadow-md">
                                                    <?= $dayNumber ?>
                                                </span>
                                                <span class="text-gray-800 font-medium text-base"><?= htmlspecialchars($firstItem['itinerary_title']) ?></span>
                                            </div>
                                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>

                                        <div class="p-4 text-gray-700 text-sm sm:text-base hidden border-t border-gray-200">
                                            <?php if (!empty($firstItem['itinerary_description'])): ?>
                                                <p class="mb-4 text-gray-600"><?= htmlspecialchars($firstItem['itinerary_description']) ?></p>
                                            <?php endif; ?>

                                            <ul class="space-y-3">
                                                <?php foreach ($activities as $act): ?>
                                                    <li class="flex items-start gap-3">
                                                        <span class="flex-shrink-0 text-main font-medium w-16"><?= htmlspecialchars($act['activity_time']) ?></span>
                                                        <div>
                                                            <span class="font-medium text-gray-800"><?= htmlspecialchars($act['activity']) ?></span>
                                                            <?php if (!empty($act['location'])): ?>
                                                                — <span class="text-gray-600"><?= htmlspecialchars($act['location']) ?></span>
                                                            <?php endif; ?>
                                                            <?php if (!empty($act['activity_description'])): ?>
                                                                <div class="text-gray-500 text-sm mt-1"><?= htmlspecialchars($act['activity_description']) ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Dịch vụ kèm tour -->
                            <?php if (!empty($tourFullData['supplier_types'])): ?>
                                <div class="bg-white rounded-2xl border border-gray-200 shadow-md p-6 mt-6">
                                    <h3 class="font-semibold text-gray-800 mb-4 text-lg">Dịch vụ kèm theo tour</h3>

                                    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                        <?php foreach ($tourFullData['supplier_types'] as $s): ?>
                                            <li class="bg-indigo-50 border border-indigo-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition">

                                                <!-- Tên dịch vụ -->
                                                <h4 class="font-semibold text-indigo-800 mb-1">
                                                    <?= htmlspecialchars($s['supplier_type_name']) ?>
                                                </h4>

                                                <p class="text-gray-600 text-sm mb-1">
                                                    <?= htmlspecialchars($s['description']) ?>
                                                </p>

                                                <?php if (!empty($s['stars']) && $s['stars'] > 0): ?>
                                                    <p class="text-yellow-500 text-sm">
                                                        ⭐ <?= $s['stars'] ?> sao |
                                                        <span class="text-green-700">Chất lượng: <?= htmlspecialchars($s['quality']) ?></span>
                                                    </p>
                                                <?php else: ?>
                                                    <p class="text-gray-700 text-sm">
                                                        Chất lượng: <?= htmlspecialchars($s['quality']) ?>
                                                    </p>
                                                <?php endif; ?>

                                                <!-- Ghi chú -->
                                                <?php if (!empty($s['notes'])): ?>
                                                    <p class="text-gray-500 italic text-sm mt-1">
                                                        Ghi chú: <?= htmlspecialchars($s['notes']) ?>
                                                    </p>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>


                            <!-- Chính sách tour -->
                            <?php if (!empty($tourFullData['policies'])): ?>
                                <div class="bg-white rounded-2xl border border-gray-200 shadow-md p-6 mt-6">
                                    <h3 class="font-semibold text-gray-800 mb-4 text-lg">Chính sách tour</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                        <?php foreach ($tourFullData['policies'] as $p): ?>
                                            <div class="bg-indigo-50 border border-indigo-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition">
                                                <h4 class="font-semibold text-indigo-800 mb-1"><?= htmlspecialchars($p['policy_type']) ?></h4>
                                                <p class="text-gray-600 text-sm"><?= htmlspecialchars($p['description']) ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Thông tin khách hàng -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên Khách hàng *</label>
                                    <input type="text" name="customer_name"
                                        class="w-full p-4 border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại *</label>
                                    <input type="tel" name="customer_phone"
                                        class="w-full p-4 border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300"
                                        required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Khách hàng *</label>
                                <input type="email" name="customer_email"
                                    class="w-full p-4 border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300"
                                    required>
                            </div>

                            <div class="flex justify-end mt-4">
                                <button type="button" onclick="nextStep(2)"
                                    class="px-8 py-3 bg-main hover:bg-indigo-600 text-white rounded-2xl shadow-md transition">Tiếp theo</button>
                            </div>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- STEP 2: Số lượng & Trạng thái -->
            <div id="step-2-content" class="step-content hidden">
                <div class="p-6 rounded-2xl border border-[#5288e0] shadow-md space-y-6 bg-[#ffffff]">
                    <h4 class="text-xl font-bold text-[#1f55ad]">2. Số Lượng & Trạng Thái</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Số lượng khách *</label>
                            <input type="number" name="number_of_people" min="1" class="w-full p-4 border rounded-xl" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Loại nhóm *</label>
                            <select name="group_type" class="w-full p-4 border rounded-xl" required>
                                <option value="le">Khách lẻ</option>
                                <option value="doan">Khách đoàn</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Trạng thái *</label>
                            <select name="status" class="w-full p-4 border rounded-xl" required>
                                <option value="cho_xac_nhan">Chờ xác nhận</option>
                                <option value="da_coc">Đã cọc</option>
                                <option value="hoan_tat">Hoàn tất</option>
                                <option value="huy">Hủy</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Ghi chú</label>
                        <textarea name="note" rows="3" class="w-full p-4 border rounded-xl"></textarea>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" onclick="prevStep(1)" class="px-6 py-3 bg-[#5288e0] text-white rounded-2xl">Quay lại</button>
                        <button type="button" onclick="nextStep(3)" class="px-8 py-3 bg-[#1f55ad] text-white rounded-2xl">Tiếp theo</button>
                    </div>
                </div>
            </div>

            <!-- STEP 3: Hành khách & Dịch vụ & File -->
            <div id="step-3-content" class="step-content hidden">
                <div class="p-6 rounded-2xl border border-[#5288e0] shadow-md space-y-6 bg-white">
                    <h4 class="text-xl font-bold text-[#1f3d7a] mb-4">3. Hành khách & Dịch vụ</h4>

                    <?php
                    $bookedDates = [];
                    $bookingDetails = []; // map ngày -> chi tiết booking chưa hoàn tất
                    foreach ($databookingbytourid as $booking) {
                        // chỉ quan tâm booking chưa hoàn tất
                        if (!in_array($booking['status_code'], ['HOANTAT'])) {
                            $bookedDates[] = $booking['start_date'];
                            $bookingDetails[$booking['start_date']][] = [
                                'booking_code' => $booking['booking_code'],
                                'customer_name' => $booking['customer_name'],
                                'number_of_people' => $booking['number_of_people'],
                                'status_code' => $booking['status_code'],
                                'payment_status_code' => $booking['payment_status_code']
                            ];
                        }
                    }

                    $numberOfDays = $tourFullData['oneTour']['days'];
                    $today = date('Y-m-d');
                    ?>

                    <div class="mb-6">
                        <!-- Input ngày khởi hành -->
                        <label for="departure_date" class="block text-sm font-semibold text-gray-700 mb-2">Ngày khởi hành *</label>
                        <input type="date" id="departure_date" name="departure_date"
                            min="<?php echo $today; ?>"
                            class="w-full p-4 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition-colors hover:border-indigo-300 cursor-pointer">

                        <!-- Input ngày kết thúc -->
                        <label for="end_date" class="block text-sm font-semibold text-gray-700 mt-4 mb-2">Ngày kết thúc</label>
                        <input type="date" id="end_date" name="end_date"
                            readonly
                            class="w-full p-4 border border-gray-300 rounded-xl shadow-sm bg-gray-100 text-indigo-600 font-semibold cursor-not-allowed">

                        <!-- Cảnh báo -->
                        <div id="date-warning" class="mt-2 hidden">
                            <p id="past-warning" class="text-red-500 text-sm">Ngày này đã qua!</p>
                            <p id="booked-warning" class="text-red-500 text-sm">Ngày này đã có booking chưa hoàn tất!</p>
                        </div>

                        <!-- Chi tiết booking trùng -->
                        <div id="booking-details" class="mt-3 p-3 border rounded-xl bg-red-50 hidden"></div>
                    </div>

                    <script>
                        const bookedDates = <?php echo json_encode($bookedDates); ?>;
                        const bookingDetails = <?php echo json_encode($bookingDetails); ?>;
                        const numberOfDays = <?php echo $numberOfDays; ?>;

                        const dateInput = document.getElementById('departure_date');
                        const endDateInput = document.getElementById('end_date');
                        const dateWarning = document.getElementById('date-warning');
                        const pastWarning = document.getElementById('past-warning');
                        const bookedWarning = document.getElementById('booked-warning');
                        const detailsDiv = document.getElementById('booking-details');

                        dateInput.addEventListener('change', function() {
                            const selectedDate = this.value;
                            const today = new Date().toISOString().split('T')[0];

                            // Reset
                            dateWarning.classList.add('hidden');
                            pastWarning.style.display = 'none';
                            bookedWarning.style.display = 'none';
                            detailsDiv.classList.add('hidden');
                            detailsDiv.innerHTML = '';
                            endDateInput.value = '';
                            this.classList.remove('border-red-500');

                            if (selectedDate < today) {
                                dateWarning.classList.remove('hidden');
                                pastWarning.style.display = 'block';
                                this.classList.add('border-red-500');
                            } else {
                                // Tính ngày kết thúc
                                const startDate = new Date(selectedDate);
                                const endDate = new Date(startDate);
                                endDate.setDate(endDate.getDate() + numberOfDays);

                                // Format yyyy-mm-dd để đưa vào input type="date"
                                const day = String(endDate.getDate()).padStart(2, '0');
                                const month = String(endDate.getMonth() + 1).padStart(2, '0');
                                const year = endDate.getFullYear();
                                endDateInput.value = `${year}-${month}-${day}`;

                                if (bookedDates.includes(selectedDate)) {
                                    dateWarning.classList.remove('hidden');
                                    bookedWarning.style.display = 'block';
                                    this.classList.add('border-red-500');

                                    // Hiển thị chi tiết booking chưa hoàn tất
                                    const bookings = bookingDetails[selectedDate];
                                    let html = '<h4 class="font-semibold mb-2 text-red-600">Chi tiết booking trùng:</h4>';
                                    html += '<table class="w-full border-collapse text-sm">';
                                    html += '<thead><tr class="bg-red-100"><th class="border px-2 py-1">Mã booking</th><th class="border px-2 py-1">Khách hàng</th><th class="border px-2 py-1">Số lượng</th><th class="border px-2 py-1">Trạng thái</th><th class="border px-2 py-1">Thanh toán</th></tr></thead>';
                                    html += '<tbody>';
                                    bookings.forEach(b => {
                                        html += `<tr class="bg-white hover:bg-red-50">
                                            <td class="border px-2 py-1">${b.booking_code}</td>
                                            <td class="border px-2 py-1">${b.customer_name}</td>
                                            <td class="border px-2 py-1">${b.number_of_people}</td>
                                            <td class="border px-2 py-1 capitalize">${b.status_code.replace('_',' ')}</td>
                                            <td class="border px-2 py-1">${b.payment_status_code}</td>
                                        </tr>`;
                                    });
                                    html += '</tbody></table>';

                                    detailsDiv.innerHTML = html;
                                    detailsDiv.classList.remove('hidden');
                                }
                            }
                        });
                    </script>
                    <!-- Box giá tour -->
                    <div class="bg-white rounded-2xl border shadow-md p-6 max-w-full mx-auto">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Bảng giá tour</h2>

                        <?php
                        $basePrice = (float)$tourFullData['oneTour']['price'];
                        $prices = [
                            'Người lớn' => $basePrice * 1.0,
                            'Trẻ em' => $basePrice * 0.7,
                            'Em bé' => $basePrice * 0.4
                        ];
                        ?>

                        <div class="mb-4 p-4 bg-indigo-50 rounded-2xl flex justify-between items-center">
                            <span class="text-gray-700 font-medium">Giá cơ bản:</span>
                            <span class="text-main font-bold text-lg"><?= number_format($basePrice, 0, ',', '.') ?> VNĐ</span>
                        </div>

                        <ul class="divide-y divide-gray-200 text-gray-700">
                            <?php foreach ($prices as $type => $price): ?>
                                <li class="py-3 flex justify-between items-center">
                                    <span class="font-medium"><?= $type ?></span>
                                    <span class="font-semibold text-main"><?= number_format($price, 0, ',', '.') ?> VNĐ</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- Hành khách -->
                    <div class="space-y-4 mt-6">
                        <h5 class=" font-semibold mb-2 text-[#1f3d7a]">
                            Danh sách Hành khách (<span id="passenger-count">1</span>)
                        </h5>

                        <div id="passenger-list" class="space-y-3 max-h-[350px] overflow-y-auto pr-2">
                            <div class="passenger-item border p-4 rounded-xl bg-white shadow-xl space-y-2 relative group">
                                <button
                                    class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                                    onclick="removePassenger(this)"
                                    title="Xóa hành khách">
                                    <i class="fas fa-times"></i>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-2">
                                    <input type="text" name="passenger_full_name[]" placeholder="Họ tên" class="p-2 border rounded border-[#d0e2ff]" required>
                                    <input type="date" name="passenger_birth_date[]" class="p-2 border rounded border-[#d0e2ff]" required>
                                    <select name="passenger_type[]" class="p-2 border rounded border-[#d0e2ff]" required>
                                        <option value="adult">Người lớn</option>
                                        <option value="child">Trẻ em</option>
                                        <option value="infant">Em bé</option>
                                    </select>
                                    <input type="text" name="passenger_passport[]" placeholder="Số hộ chiếu" class="p-2 border rounded border-[#d0e2ff]">
                                    <textarea name="passenger_note[]" placeholder="Ghi chú hành khách" class="p-2 border rounded border-[#d0e2ff]"></textarea>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="addPassenger()" class="px-4 py-2 bg-[#5288e0] text-white rounded-2xl shadow hover:bg-[#3f6ecf] transition">+ Thêm hành khách</button>
                    </div>

                    <!-- Dịch vụ thêm -->
                    <div class="space-y-4 mt-6">
                        <h5 class="font-semibold mb-2 text-[#1f3d7a]">
                            Dịch vụ thêm (<span id="service-count">1</span>)
                        </h5>

                        <div id="service-list" class="space-y-3 max-h-[350px] overflow-y-auto pr-2">
                            <div class="service-item border p-4 rounded-xl bg-white shadow-xl space-y-2 relative group">
                                <button
                                    class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                                    onclick="removeService(this)"
                                    title="Xóa dịch vụ">
                                    <i class="fas fa-times"></i>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                    <input type="text" name="service_name[]" placeholder="Tên dịch vụ" class="p-2 border rounded border-[#d0e2ff]" required>
                                    <input type="number" name="service_quantity[]" placeholder="Số lượng" class="p-2 border rounded border-[#d0e2ff]" value="1" required>
                                    <input type="number" name="service_price[]" placeholder="Giá" class="p-2 border rounded border-[#d0e2ff]" required>
                                </div>

                                <textarea name="service_note[]" placeholder="Ghi chú dịch vụ" class="w-full p-2 border rounded border-[#d0e2ff]"></textarea>
                            </div>
                        </div>

                        <button type="button" onclick="addService()" class="px-4 py-2 bg-[#5288e0] text-white rounded-2xl shadow hover:bg-[#3f6ecf] transition">+ Thêm dịch vụ</button>
                    </div>


                    <!-- File đính kèm -->
                    <div class="mt-6">
                        <label class="block font-medium mb-2 text-[#1f3d7a]">File đính kèm</label>
                        <input type="file" id="attachments" name="attachments[]" multiple class="w-full p-2 border rounded-xl border-[#d0e2ff]" onchange="previewFiles()">
                        <div id="attachment-preview" class="mt-2 space-y-2"></div>
                    </div>

                    <!-- Nút điều hướng -->
                    <div class="flex justify-between mt-6">
                        <button type="button" onclick="prevStep(2)" class="px-6 py-3 bg-[#5288e0] text-white rounded-2xl shadow hover:bg-[#3f6ecf] transition">Quay lại</button>
                        <button type="submit" class="px-8 py-3 bg-dark text-white rounded-2xl shadow hover:bg-hover transition">Hoàn tất</button>
                    </div>
                </div>
            </div>



            <script>
                function updateCounts() {
                    document.getElementById('passenger-count').textContent =
                        document.querySelectorAll('#passenger-list .passenger-item').length;

                    document.getElementById('service-count').textContent =
                        document.querySelectorAll('#service-list .service-item').length;
                }

                function addPassenger() {
                    const container = document.getElementById('passenger-list');
                    const template = container.querySelector('.passenger-item');
                    const clone = template.cloneNode(true);

                    clone.querySelectorAll('input, select, textarea').forEach(input => input.value = '');
                    container.appendChild(clone);

                    updateCounts();
                }

                function removePassenger(btn) {
                    const container = document.getElementById('passenger-list');
                    if (container.children.length > 1) {
                        btn.parentElement.remove();
                        updateCounts();
                    }
                }

                function addService() {
                    const container = document.getElementById('service-list');
                    const template = container.querySelector('.service-item');
                    const clone = template.cloneNode(true);

                    clone.querySelectorAll('input, textarea').forEach(input => {
                        input.value = input.type === 'number' ? 1 : '';
                    });

                    container.appendChild(clone);

                    updateCounts();
                }

                function removeService(btn) {
                    const container = document.getElementById('service-list');
                    if (container.children.length > 1) {
                        btn.parentElement.remove();
                        updateCounts();
                    }
                }

                function previewFiles() {
                    const preview = document.getElementById('attachment-preview');
                    preview.innerHTML = '';
                    const files = document.getElementById('attachments').files;
                    Array.from(files).forEach(file => {
                        const div = document.createElement('div');
                        div.classList.add('flex', 'items-center', 'justify-between', 'p-2', 'bg-white', 'border', 'rounded-xl', 'shadow-sm');
                        div.innerHTML = `
                <span class="truncate">${file.name}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 font-bold">&times;</button>
            `;
                        preview.appendChild(div);
                    });
                }
            </script>
        </form>

        <!-- SUCCESS -->
        <div id="success-view" class="hidden text-center p-10 bg-[#37d4d9]/10 border border-[#37d4d9] rounded-2xl mt-6">
            <h2 class="text-3xl font-bold text-[#0f2b57]">Tạo Booking Thành Công!</h2>
        </div>
    </div>

    <script>
        let currentStep = 1;

        function nextStep(step) {
            document.getElementById(`step-${currentStep}-content`).classList.add('hidden');
            currentStep = step;
            document.getElementById(`step-${currentStep}-content`).classList.remove('hidden');
            document.getElementById('step-display').innerText = currentStep;
            document.getElementById('progress-bar').style.width = (currentStep / 3 * 100) + '%';
        }

        function prevStep(step) {
            document.getElementById(`step-${currentStep}-content`).classList.add('hidden');
            currentStep = step;
            document.getElementById(`step-${currentStep}-content`).classList.remove('hidden');
            document.getElementById('step-display').innerText = currentStep;
            document.getElementById('progress-bar').style.width = (currentStep / 3 * 100) + '%';
        }

        document.getElementById('multi-step-booking-form').addEventListener('submit', function(e) {
            e.preventDefault();
            // Gửi dữ liệu Ajax hoặc submit form PHP
            document.getElementById('multi-step-booking-form').classList.add('hidden');
            document.getElementById('success-view').classList.remove('hidden');
        });
    </script>
</body>

</html>