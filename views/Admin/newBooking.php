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
                Bước <span id="step-display">1</span>/3: <span id="step-title">Bước Tạo booking</span>
            </h3>
            <div class="w-full h-3 mt-2 bg-[#a8c4f0] rounded-full">
                <div id="progress-bar" class="h-3 rounded-full transition-all duration-500"
                    style="width:33%; background:linear-gradient(to right,#1f55ad,#5288e0)"></div>
            </div>
        </div>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="mb-5 p-4 bg-green-50 border border-green-200 text-red rounded-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-check-circle"></i> <?= $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="<?= BASE_URL ?>?mode=admin&act=createBooking" class="space-y-10" method="POST" enctype="multipart/form-data">

            <!-- Hidden Fields -->
            <input type="hidden" name="tour_id" value="<?= $selectedTourId ?? '' ?>">
            <input type="hidden" name="booking_id" value="">
            <input type="hidden" name="booking_code" value="BK<?= date('His') ?>">

            <!-- STEP 1: Tour & Khách chính -->
            <div id="step-1-content" class="step-content">
                <div class="p-6 rounded-2xl border border-gray-200 shadow-md space-y-6 bg-white w-full mx-auto">

                    <h4 class="text-2xl font-bold text-gray-800 mb-4 text-center md:text-left">1. Thông Tin Tour & Khách Chính</h4>

                    <!-- Chọn Tour -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Chọn Tour *</label>
                        <select name="tour_id"
                            class="w-full p-4 border border-gray-200 rounded-2xl shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 bg-white"
                            required onchange="if(this.value) { window.location.href='?act=newBooking&tour_id=' + this.value; }">
                            <option value="">-- Chọn Tour --</option>
                            <?php foreach ($datatour as $tour): ?>
                                <option value="<?= $tour['id'] ?>" <?= isset($selectedTourId) ? (($tour['id'] == $selectedTourId) ? 'selected' : '') : "" ?>>
                                    <?= $tour['name'] ?> - <?= $tour['duration'] ?> - <?= number_format($tour['price'], 0, ',', '.') ?>₫
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
                            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 p-4 bg-white rounded-2xl shadow-lg">
                                <!-- Ảnh chính tour -->
                                <img src="<?= $tourFullData['oneTour']['images'] ?>"
                                    alt="<?= $tourFullData['oneTour']['name'] ?>"
                                    class="w-full md:w-64 h-48 md:h-64 object-cover rounded-2xl shadow-md">

                                <!-- Thông tin tour -->
                                <div class="flex-1 space-y-3">
                                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800"><?= $tourFullData['oneTour']['name'] ?></h2>
                                    <p class="text-gray-600"><?= $tourFullData['oneTour']['description'] ?></p>
                                    <div class="space-y-1 text-gray-700">
                                        <p><span class="font-semibold">Mã tour:</span> <?= $tourFullData['oneTour']['code'] ?></p>
                                        <p><span class="font-semibold">Thời gian:</span> <?= $tourFullData['oneTour']['duration'] ?></p>
                                        <p><span class="font-semibold">Giá cơ bản:</span> Người lớn <?= number_format($tourFullData['oneTour']['price']) ?>đ, Trẻ em 70%, Em bé 20%</p>
                                    </div>
                                </div>

                                <!-- Carousel hình ảnh -->
                                <div id="default-carousel" class="relative flex-[1] w-full md:w-80 mt-4 md:mt-0" data-carousel="slide">
                                    <div class="overflow-hidden relative h-56 md:h-80 rounded-xl shadow-inner">
                                        <?php foreach ($tourFullData['images'] as $index => $img): ?>
                                            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                                <img src="<?= $img['image_url'] ?>"
                                                    class="absolute block w-full h-full object-cover rounded-xl"
                                                    alt="<?= htmlspecialchars($img['description']) ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- Slider controls -->
                                    <button type="button" class="absolute top-1/2 left-2 transform -translate-y-1/2 z-30 flex items-center justify-center w-10 h-10 bg-white/70 rounded-full shadow hover:bg-white transition" data-carousel-prev>
                                        ‹
                                    </button>
                                    <button type="button" class="absolute top-1/2 right-2 transform -translate-y-1/2 z-30 flex items-center justify-center w-10 h-10 bg-white/70 rounded-full shadow hover:bg-white transition" data-carousel-next>
                                        ›
                                    </button>
                                </div>
                            </div>
                            <!-- Flowbite JS -->
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>


                            <!-- Box giá tour -->
                            <div class="bg-white rounded-2xl border shadow-md p-6 max-w-full mx-auto">
                                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Bảng giá tour Niêm yết</h2>

                                <?php
                                $basePrice = (float)$tourFullData['oneTour']['price'];
                                ?>

                                <div class="mb-4 p-4 bg-indigo-50 rounded-2xl flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">Giá cơ bản:</span>
                                    <span class="text-main font-bold text-lg"><?= number_format($basePrice, 0, ',', '.') ?> VNĐ</span>
                                </div>

                                <ul class="divide-y divide-gray-200 text-gray-700">
                                    <?php if (!empty($dataCustomerTypes)): ?>
                                        <?php foreach ($dataCustomerTypes as $type): ?>
                                            <?php $price = $basePrice * ($type['price_percentage'] / 100); ?>
                                            <li class="py-3 flex justify-between items-center">
                                                <span class="font-medium"><?= $type['name'] ?></span>
                                                <span class="font-semibold text-main"><?= number_format($price, 0, ',', '.') ?> VNĐ</span>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li class="py-3 text-red-500 flex justify-between items-center">
                                            <span>Không có dữ liệu khách hàng!</span>
                                            <button onclick="location.reload()" class="ml-4 px-3 py-1 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">Load lại</button>
                                        </li>
                                    <?php endif; ?>
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
                                <div class="bg-white rounded-3xl border border-gray-200 shadow-lg p-6 mt-6">
                                    <h3 class="font-bold text-gray-900 mb-6 text-xl tracking-wide">Dịch vụ kèm theo tour</h3>

                                    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                        <?php foreach ($tourFullData['supplier_types'] as $s): ?>
                                            <li class="bg-gwhite border border-indigo-200 rounded-2xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 ease-in-out">

                                                <!-- Tên dịch vụ -->
                                                <h4 class="font-semibold text-indigo-900 mb-2 text-lg">
                                                    <?= htmlspecialchars($s['supplier_type_name']) ?>
                                                </h4>

                                                <!-- Mô tả -->
                                                <p class="text-gray-700 text-sm mb-2">
                                                    <?= htmlspecialchars($s['description']) ?>
                                                </p>

                                                <!-- Chất lượng & sao -->
                                                <?php if (!empty($s['stars']) && $s['stars'] > 0): ?>
                                                    <p class="text-yellow-500 text-sm mb-1 flex items-center gap-2">
                                                        <?= str_repeat('⭐', $s['stars']) ?>
                                                        <span class="text-green-700 font-medium">Chất lượng: <?= htmlspecialchars($s['quality']) ?></span>
                                                    </p>
                                                <?php else: ?>
                                                    <p class="text-gray-800 text-sm font-medium mb-1">
                                                        Chất lượng: <?= htmlspecialchars($s['quality']) ?>
                                                    </p>
                                                <?php endif; ?>

                                                <!-- Ghi chú -->
                                                <?php if (!empty($s['notes'])): ?>
                                                    <p class="text-gray-500 italic text-sm mt-2">
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
                                <div class="bg-white rounded-3xl border border-gray-200 shadow-lg p-6 mt-6">
                                    <h3 class="font-bold text-gray-900 mb-6 text-xl tracking-wide">Chính sách tour</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                        <?php foreach ($tourFullData['policies'] as $p): ?>
                                            <div class="bg-white border border-indigo-200 rounded-2xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 ease-in-out">
                                                <h4 class="font-semibold text-indigo-900 mb-2 text-lg"><?= htmlspecialchars($p['policy_type']) ?></h4>
                                                <p class="text-gray-700 text-sm"><?= htmlspecialchars($p['description']) ?></p>
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
                                        placeholder="Nhập họ và tên đầy đủ"
                                        class="w-full p-4 border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại *</label>
                                    <input type="tel" name="customer_phone"
                                        placeholder="Nhập số điện thoại, VD: 0912345678"
                                        class="w-full p-4 border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300"
                                        required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Khách hàng *</label>
                                <input type="email" name="customer_email"
                                    placeholder="Nhập email hợp lệ, VD: example@mail.com"
                                    class="w-full p-4 border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300"
                                    required>
                            </div>

                            <!-- <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Code Booking</label>
                                <input type="text" name="booking_code"
                                    placeholder="VD: BK0001"
                                    class="w-full p-4 border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300"
                                    required>
                            </div> -->

                            <div class="flex justify-end mt-4">
                                <button type="button" onclick="nextStep(2)"
                                    class="px-8 py-3 bg-main hover:bg-hover text-white rounded-2xl shadow-md transition">Tiếp theo</button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- STEP 2: Số lượng & Trạng thái -->
            <div id="step-2-content" class="step-content hidden">
                <div class="p-6 rounded-2xl border border-[#5288e0] shadow-md space-y-6 bg-[#ffffff]">
                    <h6 class="text-xl font-bold text-[#1f55ad]">2. Số Lượng & Trạng Thái</h6>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Số lượng khách *</label>
                            <input type="number" id="number-of-people" name="number_of_people" min="1" class="w-full p-4 border rounded-xl" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Loại nhóm *</label>
                            <select name="group_type_id" id="group_type" class="w-full p-4 border rounded-xl" required>
                                <option value="">-- Chọn loại nhóm --</option>

                                <?php if (!empty($dataGroupType) && is_array($dataGroupType)): ?>
                                    <?php foreach ($dataGroupType as $group): ?>
                                        <?php
                                        // Bảo vệ dữ liệu: đảm bảo các key tồn tại
                                        $id       = $group['id'] ?? '';
                                        $percent  = $group['price_change_percent'] ?? 0;
                                        $name     = $group['group_name'] ?? 'Không tên';
                                        ?>
                                        <option value="<?= htmlspecialchars($id) ?>"
                                            data-percent="<?= htmlspecialchars($percent) ?>">
                                            <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $name))) ?>
                                            (<?= $percent >= 0 ? '+' : '' ?><?= htmlspecialchars($percent) ?>% người)
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled class="text-red-600">
                                        Không có dữ liệu loại nhóm
                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Trạng thái *</label>
                            <select name="booking_status_type_id" class="w-full p-4 border rounded-xl" required>
                                <option value="">-- Chọn trạng thái --</option>

                                <?php if (!empty($dataBookingStatusType)): ?>
                                    <?php foreach ($dataBookingStatusType as $item): ?>
                                        <option value="<?= $item['id'] ?>"
                                            <?= $item['code'] === 'PENDING' ? 'selected' : '' ?>>
                                            <?= $item['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </select>
                        </div>
                    </div>

                    <div id="schedule-box" class="mt-8 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200" style="display:none;">
                        <h6 class="font-bold text-main mb-6 flex items-center gap-3">
                            Chọn Lịch Trình Có Sẵn (Dành riêng cho Khách lẻ)
                        </h6>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Lịch khả dụng</label>
                                <select id="schedule-select" name="schedule_id"
                                    class="w-full p-4 border-2 border-slate-300 rounded-xl focus:border-main focus:ring-4 focus:ring-main/20 transition font-medium">

                                    <option value="">-- Chọn lịch trình --</option>

                                    <?php if (!empty($dataSchedulesByTourId)): ?>
                                        <?php foreach ($dataSchedulesByTourId as $s): ?>
                                            <?php
                                            $start = date('d/m/Y', strtotime($s['start_date']));
                                            $end   = date('d/m/Y', strtotime($s['end_date']));
                                            $dateRange = $start === $end ? $start : "$start → $end";

                                            // Trạng thái lịch trình - dùng đúng tên tiếng Việt từ DB
                                            $scheduleStatus = $s['schedule_status_name_vn'] ?? 'Chưa xác định';

                                            // Màu theo trạng thái thực tế
                                            $statusColor = match (strtolower($s['schedule_status_code'] ?? '')) {
                                                'planned'     => 'text-sky-600',
                                                'in_progress' => 'text-orange-600',
                                                'completed'   => 'text-emerald-600',
                                                'cancelled'   => 'text-red-600',
                                                default       => 'text-gray-600'
                                            };

                                            // HDV
                                            $guideText = !empty($s['guide_id']) ? "HDV #{$s['guide_id']}" : 'Chưa phân công';

                                            // Nếu có trạng thái HDV thì hiện thêm (rất hữu ích)
                                            $guideStatus = '';
                                            if (!empty($s['guide_status_name'])) {
                                                $guideStatus = ' • ' . $s['guide_status_name'];
                                            }
                                            ?>

                                            <option value="<?= $s['id'] ?>"
                                                data-start="<?= $s['start_date'] ?>"
                                                data-end="<?= $s['end_date'] ?>">
                                                <?= $dateRange ?> | <?= $guideText ?><?= $guideStatus ?>
                                                <span class="<?= $statusColor ?> font-semibold">(<?= $scheduleStatus ?>)</span>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="" disabled class="text-gray-500 italic">
                                            Không có lịch trình khả dụng
                                        </option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ngày khởi hành</label>
                                    <input type="date" id="start-date-display" name="start_date[]"
                                        class="w-full p-4 bg-white border-2 border-slate-300 rounded-xl font-bold text-main"
                                        readonly placeholder="Chưa chọn">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ngày kết thúc</label>
                                    <input type="date" id="end-date-display" name="end_date[]"
                                        class="w-full p-4 bg-white border-2 border-slate-300 rounded-xl font-bold text-main"
                                        readonly placeholder="Chưa chọn">
                                </div>
                            </div>

                            <div class="bg-white/80 rounded-xl p-5 border border-blue-200">
                                <p class="text-sm text-slate-600">Chọn lịch để xem chi tiết dịch vụ bên dưới</p>
                            </div>
                        </div>

                        <!-- Khu vực hiển thị chi tiết dịch vụ -->
                        <div id="schedule-detail-container" class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3"></div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const groupTypeSelect = document.getElementById("group_type");
                            const scheduleBox = document.getElementById("schedule-box");
                            const serviceBox = document.getElementById("tour-service-box");
                            const departureBox = document.getElementById("departure-box");
                            const scheduleSelect = document.getElementById("schedule-select");
                            const scheduleContainer = document.getElementById("schedule-detail-container");

                            // Lưu nội dung gốc
                            const serviceHTML = serviceBox?.innerHTML || '';
                            const departureHTML = departureBox?.innerHTML || '';

                            function toggleSchedule() {
                                const value = groupTypeSelect?.value || '';

                                if (value === "1") { // Khách lẻ
                                    scheduleBox.style.display = "block";
                                    if (serviceBox) {
                                        serviceBox.style.display = "none";
                                        serviceBox.innerHTML = "";
                                    }
                                    if (departureBox) {
                                        departureBox.style.display = "none";
                                        departureBox.innerHTML = "";
                                    }
                                    if (scheduleSelect) scheduleSelect.disabled = false;
                                } else { // Đoàn
                                    scheduleBox.style.display = "none";
                                    if (serviceBox) {
                                        serviceBox.style.display = "block";
                                        serviceBox.innerHTML = serviceHTML;
                                    }
                                    if (departureBox) {
                                        departureBox.style.display = "block";
                                        departureBox.innerHTML = departureHTML;
                                    }

                                    // Reset
                                    if (scheduleSelect) {
                                        scheduleSelect.value = "";
                                        scheduleSelect.disabled = true;
                                    }
                                    scheduleContainer.innerHTML = "";
                                    document.getElementById("start-date-display").value = "";
                                    document.getElementById("end-date-display").value = "";

                                    if (typeof loadBookedDates === 'function') loadBookedDates();
                                    if (typeof loadSupplierServices === 'function') loadSupplierServices();
                                }
                            }

                            groupTypeSelect?.addEventListener("change", toggleSchedule);
                            toggleSchedule();

                            // Hiển thị ngày + load dịch vụ
                            scheduleSelect.addEventListener("change", function() {
                                const option = this.selectedOptions[0];
                                if (!option || !option.value) {
                                    document.getElementById("start-date-display").value = "";
                                    document.getElementById("end-date-display").value = "";
                                    scheduleContainer.innerHTML = "";
                                    return;
                                }

                                const start = option.dataset.start;
                                const end = option.dataset.end;

                                // Với input type="date", format phải là YYYY-MM-DD
                                document.getElementById("start-date-display").value = start || "";
                                document.getElementById("end-date-display").value = end || "";

                                loadScheduleDetails(option.value);
                            });


                            function loadScheduleDetails(scheduleId) {
                                if (!scheduleId) return;

                                scheduleContainer.innerHTML = `<div class="col-span-full text-center py-12"><i class="fa-solid fa-spinner fa-spin text-4xl text-main"></i></div>`;

                                axios.post(`${BASE_URL}?mode=admin&act=getAllSchedulesByid`, {
                                        schedules_id: scheduleId
                                    })
                                    .then(({
                                        data
                                    }) => {
                                        scheduleContainer.innerHTML = "";
                                        if (!data || data.length === 0) {
                                            scheduleContainer.innerHTML = `<div class="col-span-full text-center py-16 text-slate-500 text-lg">Chưa có dịch vụ nào cho lịch này</div>`;
                                            return;
                                        }

                                        data.forEach(item => {
                                            scheduleContainer.innerHTML += `
                            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6 hover:shadow-2xl transition">
                                <h3 class="text-xl font-bold text-main mb-4">${item.service_name || 'Dịch vụ'}</h3>
                                <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                    <div><strong>Số lượng:</strong> ${item.service_quantity || 1}</div>
                                    <div><strong>Giá:</strong> <span class="text-main font-bold text-lg">${Number(item.service_price || 0).toLocaleString('vi-VN')} VNĐ</span></div>
                                </div>
                                <hr class="border-dashed border-slate-300 my-4">
                                <div class="text-sm space-y-2">
                                    <p class="font-bold text-slate-800">${item.supplier_name || 'Chưa có NCC'}</p>
                                    <p class="text-xs text-slate-600">${item.address || ''}</p>
                                    <p class="text-slate-700">${item.contact_name || ''} | ${item.contact_phone || ''}</p>
                                </div>
                            </div>`;
                                        });
                                    })
                                    .catch(() => {
                                        scheduleContainer.innerHTML = `<div class="col-span-full text-center py-12 text-red-600">Lỗi tải dịch vụ!</div>`;
                                    });
                            }
                        });
                    </script>
                    <?php
                    $bookedDates     = [];
                    $bookingDetails  = [];

                    if (!empty($databookingbytourid) && is_array($databookingbytourid)) {
                        foreach ($databookingbytourid as $b) {
                            // Kiểm tra trạng thái an toàn
                            $statusCode = $b['status_code'] ?? $b['booking_status'] ?? $b['status'] ?? '';
                            if (in_array(strtoupper($statusCode), ['HOANTAT', 'HUY', 'COMPLETED', 'CANCELLED'])) {
                                continue;
                            }

                            $startDate = $b['start_date'] ?? null;
                            if (!$startDate || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
                                continue;
                            }

                            $bookedDates[] = $startDate;

                            $bookingDetails[$startDate][] = [
                                'code'     => $b['booking_code'] ?? 'N/A',
                                'name'     => $b['customer_name'] ?? 'Khách đoàn',
                                'people'   => (int)($b['number_of_people'] ?? 0),
                                'status'   => $b['status_name'] ?? $statusCode,
                                'payment'  => $b['payment_status_name'] ?? $b['payment_status_code'] ?? 'Chưa rõ',
                                'phone'    => $b['customer_phone'] ?? '',
                            ];
                        }
                    }

                    // Loại trùng ngày
                    $bookedDates = array_unique($bookedDates);
                    // Thông tin tour –
                    $numberOfDays = $tourFullData['oneTour']['days'] ?? 1;
                    $today = date('Y-m-d');
                    ?>

                    <div id="departure-box" class="mb-6 p-5 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200 rounded-2xl shadow-lg border">
                        <h6 class="text-lg font-bold text-main mb-4">Chọn ngày khởi hành</h6>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ngày khởi hành *</label>
                                <input type="date" id="start_date" name="start_date[]"
                                    class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-main focus:border-main transition"
                                    min="<?= $today ?>" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ngày kết thúc (tự động)</label>
                                <input type="date" id="end_date" name="end_date[]"
                                    class="w-full p-3 border rounded-xl bg-gray-50 font-medium text-main" readonly>
                            </div>
                        </div>

                        <div id="conflict-info" class="mt-4 hidden">
                            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-300 rounded-xl p-5">
                                <div class="flex items-center gap-3 mb-3">
                                    <svg class="w-7 h-7 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.366-.446.982-.446 1.348 0l6.726 8.214c.367.447.16 1.09-.404 1.09H3.375c-.564 0-.77-.643-.404-1.09l6.726-8.214zM10 7.5a.75.75 0 01.75.75v3a.75.75 0 01-1.5 0v-3A.75.75 0 0110 7.5zm.75 5.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>
                                    <div>
                                        <h4 class="font-bold text-amber-900 text-lg">Ngày này đã có đoàn khác đặt</h4>
                                        <p class="text-sm text-amber-800">Vẫn có thể tạo booking mới – vui lòng kiểm tra kỹ thông tin bên dưới</p>
                                    </div>
                                </div>
                                <div id="conflict-details" class="space-y-3"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function loadBookedDates() {
                            const bookedDates = <?= json_encode(array_values($bookedDates)) ?>;
                            const bookingDetails = <?= json_encode($bookingDetails) ?>;
                            const numberOfDays = <?= (int)$numberOfDays ?>;
                            const today = '<?= $today ?>';

                            const startInput = document.getElementById('start_date');
                            const endInput = document.getElementById('end_date');
                            const conflictInfo = document.getElementById('conflict-info');
                            const conflictDetails = document.getElementById('conflict-details');

                            if (!startInput) return; // Bảo vệ nếu không có element

                            function calcEndDate(start) {
                                if (!start) return '';
                                const d = new Date(start);
                                d.setDate(d.getDate() + numberOfDays);
                                return d.toISOString().split('T')[0];
                            }

                            startInput.addEventListener('change', function() {
                                const selected = this.value;

                                // Reset
                                conflictInfo.classList.add('hidden');
                                conflictDetails.innerHTML = '';
                                endInput.value = '';

                                if (!selected) return;

                                endInput.value = calcEndDate(selected);

                                // Kiểm tra trùng ngày
                                if (bookedDates.includes(selected)) {
                                    conflictInfo.classList.remove('hidden');

                                    const bookings = bookingDetails[selected] || [];
                                    let html = '';

                                    bookings.forEach((b, i) => {
                                        const statusText = (b.status || '').replace(/_/g, ' ').toUpperCase() || 'CHƯA XÁC ĐỊNH';
                                        const statusColor = b.status === 'da_coc' ? 'bg-blue-100 text-blue-800' :
                                            b.status === 'cho_xac_nhan' ? 'bg-yellow-100 text-yellow-800' :
                                            b.status === 'hoan_tat' ? 'bg-green-100 text-green-800' :
                                            'bg-gray-100 text-gray-700';

                                        html += `
                        <div class="bg-white rounded-lg border border-amber-200 p-4 shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-main">#${i+1} • ${b.code || 'N/A'}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold ${statusColor}">${statusText}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div><span class="text-gray-500">Khách:</span> <strong>${b.name || '—'}</strong></div>
                                <div><span class="text-gray-500">Số khách:</span> <strong class="text-orange-600">${b.people || 0} người</strong></div>
                                <div><span class="text-gray-500">Thanh toán:</span> <strong>${b.payment || '—'}</strong></div>
                                <div><span class="text-gray-500">Liên hệ:</span> <strong>${b.phone || '—'}</strong></div>
                            </div>
                        </div>`;
                                    });

                                    conflictDetails.innerHTML = html;
                                }
                            });
                        }
                        loadBookedDates();
                    </script>


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

                    <!-- Box giá tour -->
                    <div class="bg-white rounded-2xl border shadow-md p-6 max-w-full mx-auto">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Bảng giá tour Niêm yết</h2>
                        <?php
                        $basePrice = (float)$tourFullData['oneTour']['price'];
                        ?>

                        <div class="mb-4 p-4 bg-indigo-50 rounded-2xl flex justify-between items-center">
                            <span class="text-gray-700 font-medium">Giá cơ bản:</span>
                            <span class="text-main font-bold text-lg"><?= number_format($basePrice, 0, ',', '.') ?> VNĐ</span>
                        </div>

                        <ul class="divide-y divide-gray-200 text-gray-700">
                            <?php if (!empty($dataGroupType)): ?>
                                <?php foreach ($dataGroupType as $group): ?>
                                    <?php
                                    // Tính giá cuối = giá cơ bản + phần trăm
                                    $priceFinal = $basePrice * (1 + ($group['price_change_percent'] / 100));
                                    ?>
                                    <li class="py-3 flex justify-between items-center">
                                        <span class="font-medium"><?= ucfirst(str_replace('_', ' ', $group['group_name'])) ?></span>
                                        <span class="font-semibold text-main">
                                            <?= number_format($priceFinal, 0, ',', '.') ?> VNĐ
                                            (<?= $group['price_change_percent'] > 0 ? '+' : '' ?><?= $group['price_change_percent'] ?>%)
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="py-3 text-red-500 flex justify-between items-center">
                                    <span>Không có dữ liệu nhóm!</span>
                                    <button onclick="location.reload()" class="ml-4 px-3 py-1 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">Load lại</button>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- Box giá tour khách hàng -->
                    <div class="bg-white rounded-2xl border shadow-md p-6 max-w-full mx-auto">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                            Bảng giá theo <span id="group-name-display" class="text-main">---</span>
                        </h2>

                        <?php $basePrice = (float)$tourFullData['oneTour']['price']; ?>

                        <div class="mb-4 p-4 bg-indigo-50 rounded-2xl flex justify-between items-center">
                            <span class="text-gray-700 font-medium">Giá cơ bản:</span>
                            <span class="text-main font-bold text-lg" id="base-price">
                                <?= number_format($basePrice, 0, ',', '.') ?> VNĐ
                            </span>
                        </div>

                        <ul id="customer-prices-list" class="divide-y divide-gray-200 text-gray-700">
                            <?php if (!empty($dataCustomerTypes)): ?>
                                <?php foreach ($dataCustomerTypes as $type): ?>
                                    <?php $price = $basePrice * ($type['price_percentage'] / 100); ?>
                                    <li class="py-3 flex justify-between items-center" data-base-price="<?= $price ?>">
                                        <span class="font-medium"><?= $type['name'] ?></span>
                                        <span class="font-semibold text-main"><?= number_format($price, 0, ',', '.') ?> VNĐ</span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="py-3 text-red-500 flex justify-between items-center">
                                    <span>Không có dữ liệu khách hàng!</span>
                                    <button onclick="location.reload()" class="ml-4 px-3 py-1 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">
                                        Load lại
                                    </button>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <script>
                        const groupSelect = document.getElementById('group_type');
                        const groupNameDisplay = document.getElementById('group-name-display');

                        groupSelect.addEventListener('change', function() {
                            const selectedOption = this.selectedOptions[0];

                            const groupName = selectedOption ? selectedOption.text : '---';
                            const percent = selectedOption ? parseFloat(selectedOption.dataset.percent) : 0;

                            // Cập nhật tên loại nhóm
                            groupNameDisplay.textContent = groupName;

                            // Update giá theo từng loại khách
                            const listItems = document.querySelectorAll('#customer-prices-list li[data-base-price]');
                            listItems.forEach(li => {
                                const basePrice = parseFloat(li.dataset.basePrice);
                                const newPrice = basePrice + (basePrice * percent / 100);

                                const priceTag = li.querySelector('.font-semibold');
                                priceTag.textContent = newPrice.toLocaleString('vi-VN') + ' VNĐ';
                            });
                        });
                    </script>

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
                                        <option value="">-- Chọn loại hành khách --</option>
                                        <?php foreach ($dataCustomerTypes as $type): ?>
                                            <option value="<?= htmlspecialchars($type['id']) ?>"><?= htmlspecialchars($type['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="text" name="passenger_passport[]" placeholder="Số hộ chiếu" class="p-2 border rounded border-[#d0e2ff]">
                                    <textarea name="passenger_note[]" placeholder="Ghi chú hành khách" class="p-2 border rounded border-[#d0e2ff]"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- <button type="button" onclick="addPassenger()" class="px-4 py-2 bg-[#5288e0] text-white rounded-2xl shadow hover:bg-[#3f6ecf] transition">+ Thêm hành khách</button> -->
                    </div>

                    <!-- Khối Dịch vụ theo tour -->
                    <div id="tour-service-box" class="space-y-4 mt-6">
                        <h5 class="font-semibold mb-2 text-[#1f3d7a]">
                            Dịch Vụ theo tour (<span id="service-count"><?= count($dataSuppliersByType) ?></span>)
                        </h5>

                        <div id="service-list-bytour" class="space-y-3 max-h-[350px] overflow-y-auto pr-2">
                            <?php if (!empty($dataSuppliersByType)): ?>
                                <?php foreach ($dataSuppliersByType as $supplierTypeId => $suppliers): ?>
                                    <div class="service-item border p-4 rounded-xl bg-white shadow-xl space-y-2 relative">
                                        <!-- Tên loại dịch vụ -->
                                        <?php
                                        $typeName = '';
                                        foreach ($tourFullData['suppliers'] as $st) {
                                            if ($st['id'] == $supplierTypeId) {
                                                $typeName = $st['name'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <label class="font-medium"><?= $typeName ?></label>
                                        <div id="suppliers-container">
                                            <!-- Block mẫu -->
                                            <div class="grid grid-cols-1 md:grid-cols-4 gap-2 supplier-block">
                                                <select name="supplier_id[]" class="supplier-select p-2 border rounded border-[#d0e2ff]" required>
                                                    <option value="">-- Chọn nhà cung cấp --</option>
                                                    <?php foreach ($suppliers as $supplier): ?>
                                                        <option value="<?= $supplier['id'] ?>"><?= $supplier['name'] ?> (<?= $supplier['contact_phone'] ?>)</option>
                                                    <?php endforeach; ?>
                                                </select>

                                                <select name="supplier_type_id[]" class="supplier-service-select p-2 border rounded border-[#d0e2ff]" required>
                                                    <option value="">-- Chọn dịch vụ --</option>
                                                </select>

                                                <input type="number" name="service_quantity[]" class="service-quantity p-2 border rounded border-[#d0e2ff]" placeholder="Số lượng" value="1" min='0' required>
                                                <input type="number" name="service_price[]" class="service-price p-2 border rounded border-[#d0e2ff]" placeholder="Giá" min='0' required>
                                            </div>
                                        </div>


                                        <textarea name="service_note[]" placeholder="Ghi chú dịch vụ" class="w-full p-2 border rounded border-[#d0e2ff]"></textarea>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Tour chưa có dịch vụ nào.</p>
                            <?php endif; ?>
                            <script>
                                function loadSupplierServices() {
                                    function attachSupplierChangeEvent(block) {
                                        const supplierSelect = block.querySelector('.supplier-select');
                                        const serviceSelect = block.querySelector('.supplier-service-select');
                                        const priceInput = block.querySelector('.service-price');
                                        const quantityInput = block.querySelector('.service-quantity');

                                        // Khi chọn nhà cung cấp → load dịch vụ
                                        supplierSelect.addEventListener('change', function() {
                                            const supplierId = this.value;
                                            serviceSelect.innerHTML = '<option value="">Đang tải...</option>';
                                            priceInput.value = '';
                                            quantityInput.value = 1;

                                            if (!supplierId) {
                                                serviceSelect.innerHTML = '<option value="">-- Chọn dịch vụ --</option>';
                                                return;
                                            }

                                            axios.post(`${BASE_URL}?mode=admin&act=getsupplierPricesBySupplierId`, {
                                                    supplier_id: supplierId
                                                })
                                                .then((
                                                    data
                                                ) => {
                                                    // console.log('Dữ liệu dịch vụ:', data);`
                                                    serviceSelect.innerHTML = `<option value="">-- Chọn dịch vụ --</option>
                                                                                <option value="0">-- Dịch vụ khác  --</option>
                                                                                `;
                                                    data.data.forEach(service => {
                                                        const option = document.createElement('option');
                                                        option.value = service.id;

                                                        // Hiển thị tên + giá
                                                        const formatted = Number(service.unit_price).toLocaleString('vi-VN');
                                                        option.textContent = `${service.service_name} - ${formatted}đ`;

                                                        // lưu giá gốc
                                                        option.dataset.price = service.unit_price;

                                                        serviceSelect.appendChild(option);
                                                    });
                                                })
                                                .catch(error => {
                                                    console.error('Lỗi khi lấy dịch vụ:', error);
                                                    serviceSelect.innerHTML = '<option value="">-- Chọn dịch vụ --</option>';
                                                    alert('Không lấy được dịch vụ, vui lòng thử lại.');
                                                });
                                        });

                                        // Khi chọn dịch vụ → tính giá theo số lượng
                                        serviceSelect.addEventListener('change', function() {
                                            updatePrice();
                                        });

                                        // Khi thay đổi số lượng → tính lại giá
                                        quantityInput.addEventListener('input', function() {
                                            updatePrice();
                                        });

                                        function updatePrice() {
                                            const selected = serviceSelect.selectedOptions[0];
                                            if (!selected) return;

                                            const unitPrice = Number(selected.dataset.price || 0);
                                            const quantity = Number(quantityInput.value || 1);

                                            const total = unitPrice * quantity;
                                            priceInput.value = total;
                                        }
                                    }

                                    // Gắn event cho block ban đầu
                                    document.querySelectorAll('.supplier-block').forEach(block => attachSupplierChangeEvent(block));
                                }
                                loadSupplierServices();
                            </script>
                        </div>
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

                    <!-- BÁO GIÁ TỔNG HỢP STEP3 -->
                    <div id="step3-quote" class="p-5 bg-white rounded-2xl border border-[#d0e2ff] shadow-md mt-6 mx-auto max-w-full">
                        <h4 class="font-semibold text-lg text-[#1f3d7a] mb-4">Báo giá tổng hợp</h4>

                        <!-- Giá hành khách -->
                        <div id="passenger-quote" class="mb-3 p-3 bg-[#f0f5ff] rounded-lg border border-[#cbdcff] text-[#1f3d7a]"></div>

                        <!-- Giá dịch vụ -->
                        <div id="service-quote" class="mb-3 p-3 bg-[#f0f5ff] rounded-lg border border-[#cbdcff] text-[#1f3d7a]"></div>

                        <!-- Tổng cộng -->
                        <div class="font-semibold text-white p-3 bg-[#5288e0] rounded-lg text-center text-lg">
                            Tổng cộng: <span id="total-step3">0 VNĐ</span>
                        </div>

                        <!-- Input ẩn lưu dữ liệu giá để gửi form -->
                        <div id="hidden-prices">
                            <!-- Giá hành khách -->
                            <input type="hidden" name="passenger_prices" id="passenger-prices-hidden" value="">
                            <!-- Giá dịch vụ -->
                            <input type="hidden" name="service_prices" id="service-prices-hidden" value="">
                            <!-- Tổng cộng -->
                            <input type="hidden" name="total_price" id="total-price-hidden" value="">
                        </div>
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

                    <script>
                        function formatCurrency(number) {
                            return new Intl.NumberFormat("vi-VN", {
                                    style: "currency",
                                    currency: "VND"
                                })
                                .format(number).replace("₫", "VNĐ");
                        }

                        const dataCustomerTypes = <?= json_encode($dataCustomerTypes) ?>;
                        const basePrice = <?= $basePrice ?>;

                        function getGroupPercent() {
                            const groupSelect = document.getElementById('group_type');
                            const selectedOption = groupSelect.selectedOptions[0];
                            return selectedOption ? parseFloat(selectedOption.dataset.percent) : 0;
                        }

                        function calculatePassengerPrice() {
                            const items = document.querySelectorAll("#passenger-list .passenger-item");
                            let total = 0;
                            let html = '';
                            const pricesData = [];
                            const count = {};
                            const groupPercent = getGroupPercent(); // lấy % nhóm

                            items.forEach(item => {
                                const typeId = item.querySelector("select[name='passenger_type[]']").value;
                                if (!typeId) return;

                                const type = dataCustomerTypes.find(t => t.id == typeId);
                                if (!type) return;

                                // tính giá cơ bản + điều chỉnh theo group_type
                                let price = basePrice * (type.price_percentage / 100);
                                price = price + price * (groupPercent / 100);

                                total += price;
                                count[type.name] = (count[type.name] || 0) + 1;
                            });

                            for (const [typeName, qty] of Object.entries(count)) {
                                const type = dataCustomerTypes.find(t => t.name === typeName);
                                let price = basePrice * (type.price_percentage / 100);
                                price = price + price * (groupPercent / 100);

                                html += `${typeName} (${qty} x ${formatCurrency(price)}): ${formatCurrency(qty * price)}<br>`;
                                pricesData.push({
                                    type: typeName,
                                    quantity: qty,
                                    unit_price: price,
                                    total_price: price * qty
                                });
                            }

                            document.getElementById("passenger-quote").innerHTML = html;
                            document.getElementById("passenger-prices-hidden").value = JSON.stringify(pricesData);

                            return total;
                        }

                        function calculateServicePrice() {
                            const serviceItems = document.querySelectorAll("#service-list-bytour .service-item, #service-list .service-item");
                            let total = 0;
                            let html = '';
                            const pricesData = [];

                            serviceItems.forEach(item => {
                                const supplierName = item.querySelector('select[name="supplier_id[]"]')?.selectedOptions[0]?.text || '';
                                const serviceSelect = item.querySelector('select[name="supplier_type_id[]"]');
                                const serviceName = serviceSelect?.selectedOptions[0]?.text || item.querySelector('input[name="service_name[]"]')?.value || '';
                                const quantity = parseFloat(item.querySelector('input[name="service_quantity[]"]').value) || 0;
                                const price = parseFloat(item.querySelector('input[name="service_price[]"]').value) || 0;

                                if (serviceName && quantity > 0 && price > 0) {
                                    const subtotal = quantity * price;
                                    total += subtotal;
                                    html += `${supplierName ? supplierName + ' - ' : ''}${serviceName} (${quantity} x ${formatCurrency(price)}): ${formatCurrency(subtotal)}<br>`;
                                    pricesData.push({
                                        supplier: supplierName,
                                        service: serviceName,
                                        quantity,
                                        unit_price: price,
                                        total_price: subtotal
                                    });
                                }
                            });

                            document.getElementById("service-quote").innerHTML = html || 'Chưa chọn dịch vụ nào.';
                            document.getElementById("service-prices-hidden").value = JSON.stringify(pricesData);

                            return total;
                        }

                        function calculateTotalStep3() {
                            const passengerTotal = calculatePassengerPrice();
                            const serviceTotal = calculateServicePrice();
                            const total = passengerTotal + serviceTotal;

                            document.getElementById("total-step3").textContent = formatCurrency(total);
                            document.getElementById("total-price-hidden").value = total;
                        }

                        // chạy khi input, change, hoặc chọn group_type thay đổi
                        document.addEventListener('input', calculateTotalStep3);
                        document.addEventListener('change', calculateTotalStep3);
                        document.getElementById('group_type').addEventListener('change', calculateTotalStep3);

                        calculateTotalStep3();
                    </script>

                </div>
            </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const numberInput = document.getElementById('number-of-people');
            const passengerList = document.getElementById('passenger-list');

            function updateCounts() {
                document.getElementById('passenger-count').textContent =
                    passengerList.querySelectorAll('.passenger-item').length;
            }

            function removePassenger(btn) {
                const items = passengerList.querySelectorAll('.passenger-item');
                if (items.length > 1) { // ít nhất còn 1 dòng
                    btn.closest('.passenger-item').remove();
                    updateCounts();
                }
            }

            function addPassenger() {
                const template = passengerList.querySelector('.passenger-item');
                const clone = template.cloneNode(true);

                // Reset input/select/textarea
                clone.querySelectorAll('input, select, textarea').forEach(el => el.value = '');
                passengerList.appendChild(clone);
                updateCounts();
            }

            // Đồng bộ số lượng khách với input
            function syncPassengers() {
                const targetCount = parseInt(numberInput.value) || 1;
                let currentCount = passengerList.querySelectorAll('.passenger-item').length;
                const template = passengerList.querySelector('.passenger-item');

                if (targetCount > currentCount) {
                    for (let i = currentCount; i < targetCount; i++) {
                        const clone = template.cloneNode(true);
                        clone.querySelectorAll('input, select, textarea').forEach(el => el.value = '');
                        passengerList.appendChild(clone);
                    }
                } else if (targetCount < currentCount) {
                    const items = passengerList.querySelectorAll('.passenger-item');
                    for (let i = currentCount - 1; i >= targetCount; i--) {
                        items[i].remove();
                    }
                }
                updateCounts();
            }

            // Lắng nghe thay đổi input số lượng khách
            numberInput.addEventListener('change', syncPassengers);
            numberInput.addEventListener('input', syncPassengers);

            // Gắn sự kiện xóa cho template ban đầu và các clone mới
            passengerList.addEventListener('click', function(e) {
                if (e.target.closest('button[title="Xóa hành khách"]')) {
                    removePassenger(e.target.closest('button'));
                }
            });

            // Khởi tạo khi load trang
            if (!numberInput.value) numberInput.value = 1;
            syncPassengers();
        });

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