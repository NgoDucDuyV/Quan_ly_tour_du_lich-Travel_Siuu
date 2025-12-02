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

        <!-- Form -->
        <form action="<?= BASE_URL ?>?mode=admin&act=createBooking" class="space-y-10" method="POST" enctype="multipart/form-data">

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

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Code Booking</label>
                                <input type="text" name="booking_code"
                                    placeholder="VD: BK0001"
                                    class="w-full p-4 border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300"
                                    required>
                            </div>

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
                    <h4 class="text-xl font-bold text-[#1f55ad]">2. Số Lượng & Trạng Thái</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Số lượng khách *</label>
                            <input type="number" id="number-of-people" name="number_of_people" min="1" class="w-full p-4 border rounded-xl" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Loại nhóm *</label>
                            <select
                                name="group_type_id"
                                id="group_type"
                                class="w-full p-4 border rounded-xl"
                                required>
                                <option value="">-- Chọn loại nhóm --</option>
                                <?php foreach ($dataGroupType as $group): ?>
                                    <option
                                        value="<?= $group['id'] ?>"
                                        data-percent="<?= $group['price_change_percent'] ?>">
                                        <?= ucfirst(str_replace('_', ' ', $group['group_name'])) ?>
                                        (<?= $group['price_change_percent'] >= 0 ? '+' : '' ?><?= $group['price_change_percent'] ?>% người)
                                    </option>
                                <?php endforeach; ?>
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

                    <div id="schedule-box" class="mt-6" style="display:none;">
                        <h6 class="text-xl font-bold text-hover mb-5">Chọn lịch trình</h6>
                        <select id="schedule-select" name="schedule_id"
                            class="w-full p-3 border rounded-xl shadow focus:ring-blue-500 focus:border-blue-500"
                            onchange="showScheduleDates(this)" required>
                            <option value="">-- Chọn lịch trình Theo Tour --</option>

                            <?php foreach ($dataSchedulesByTourId as $s): ?>
                                <option value="<?= $s['id'] ?>"
                                    data-start="<?= $s['start_date'] ?>"
                                    data-end="<?= $s['end_date'] ?>">
                                    <?= $s['start_date'] ?> → <?= $s['end_date'] ?> | HDV #<?= $s['guide_id'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ngày bắt đầu</label>
                                <input type="date" id="start-date-display" class="w-full p-3 border rounded-xl shadow bg-gray-100 cursor-not-allowed" readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ngày kết thúc</label>
                                <input type="date" id="end-date-display" class="w-full p-3 border rounded-xl shadow bg-gray-100 cursor-not-allowed" readonly>
                            </div>
                        </div>
                    </div>
                    <div id="schedule-detail-container" class="mt-4 grid gap-4 md:grid-cols-2"></div>


                    <script>
                        function showScheduleDates(select) {
                            const option = select.options[select.selectedIndex];

                            const start = option.getAttribute("data-start");
                            const end = option.getAttribute("data-end");

                            // Gán vào input
                            document.getElementById("start-date-display").value = start || "";
                            document.getElementById("end-date-display").value = end || "";
                        }
                    </script>


                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const groupTypeSelect = document.getElementById("group_type");

                            // Các khối muốn ẩn/hiện
                            const blocks = {
                                schedule: document.getElementById("schedule-box"),
                                service: document.getElementById("tour-service-box"),
                                departure: document.getElementById("departure-box")
                            };

                            const scheduleSelect = document.getElementById("schedule-select");
                            const scheduleContainer = document.getElementById("schedule-detail-container");

                            const servicehtml = document.getElementById("tour-service-box").innerHTML;
                            const departurehtml = document.getElementById("departure-box").innerHTML;

                            function toggleBlocks(value) {
                                // Nếu là khách lẻ hoặc khách lẻ theo yêu cầu
                                if (value == "1") {
                                    blocks.schedule.style.display = "block";
                                    blocks.service.style.display = "none";
                                    blocks.departure.style.display = "none";
                                    blocks.service.innerHTML = "";
                                    blocks.departure.innerHTML = "";
                                    scheduleSelect.disabled = false;
                                } else {
                                    blocks.schedule.style.display = "none";
                                    blocks.service.style.display = "block";
                                    blocks.departure.style.display = "block";
                                    blocks.service.innerHTML = servicehtml;
                                    blocks.departure.innerHTML = departurehtml;
                                    loadBookedDates();
                                    loadSupplierServices();
                                    scheduleSelect.disabled = true;
                                    scheduleSelect.value = "";
                                    scheduleContainer.innerHTML = "";
                                }
                            }

                            // Khi chọn nhóm
                            groupTypeSelect.addEventListener("change", function() {
                                toggleBlocks(this.value);
                            });

                            // Khởi tạo khi load page
                            toggleBlocks(groupTypeSelect.value);

                            // Khi chọn lịch, gọi API lấy dịch vụ + nhà cung cấp
                            scheduleSelect.addEventListener("change", function() {
                                const selectedId = this.value;
                                scheduleContainer.innerHTML = "";

                                if (!selectedId) return;

                                axios.post(`${BASE_URL}?mode=admin&act=getAllSchedulesByid`, {
                                        schedules_id: selectedId
                                    })
                                    .then(({
                                        data
                                    }) => {
                                        console.log(data);

                                        scheduleContainer.innerHTML = ''; // Reset trước khi append dữ liệu

                                        if (!data || data.length === 0) {
                                            scheduleContainer.innerHTML = `<p class="text-gray-500 italic">Không có dịch vụ nào.</p>`;
                                            return;
                                        }

                                        data.forEach(item => {
                                            scheduleContainer.innerHTML += `
                                                <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200 transition hover:shadow-xl mb-4">
                                                    <h3 class="text-xl font-bold text-main mb-4">${item.service_name}</h3>

                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <p class="text-gray-500 font-medium">Số lượng:</p>
                                                            <p class="text-gray-800">${item.service_quantity}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-500 font-medium">Giá dịch vụ:</p>
                                                            <p class="text-main font-semibold">${Number(item.service_price).toLocaleString()} VNĐ</p>
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <p class="text-gray-500 font-medium">Nhà cung cấp:</p>
                                                        <p class="text-gray-800 font-medium">${item.supplier_name}</p>
                                                        <p class="text-gray-600 text-sm">${item.address}</p>
                                                    </div>

                                                    <div>
                                                        <p class="text-gray-500 font-medium">Liên hệ:</p>
                                                        <p class="text-gray-800">${item.contact_name} | ${item.contact_phone}</p>
                                                        <p class="text-gray-600 text-sm">${item.contact_email}</p>
                                                    </div>
                                                </div>
                                            `;
                                        });
                                    })
                                    .catch(error => {
                                        console.error("Lỗi khi lấy chi tiết dịch vụ:", error);
                                        scheduleContainer.innerHTML = `<p class="text-red-500">Không thể tải dịch vụ. Vui lòng thử lại.</p>`;
                                    });
                            });
                        });
                    </script>
                    <?php
                    $bookedDates = [];
                    $bookingDetails = []; // map ngày -> chi tiết booking chưa hoàn tất

                    foreach ($databookingbytourid as $booking) {
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

                    <div id="departure-box" class="mb-6 p-4 bg-white rounded-2xl shadow-md">
                        <h6 class="text-xl font-bold text-hover mb-5">Chọn ngày khởi hành</h6>

                        <label for="departure_date" class="block text-sm font-semibold text-gray-700 mb-2">Ngày khởi hành *</label>
                        <input type="date" id="departure_date" name="departure_date"
                            class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition-colors hover:border-indigo-300 cursor-pointer"
                            min="<?= $today ?>" required>

                        <label for="end_date" class="block text-sm font-semibold text-gray-700 mt-4 mb-2">Ngày kết thúc</label>
                        <input type="date" id="end_date" name="end_date"
                            class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition-colors hover:border-indigo-300 cursor-pointer" required>

                        <div id="date-warning" class="mt-2 hidden space-y-1">
                            <p id="past-warning" class="text-red-500 text-sm">Ngày này đã qua!</p>
                            <p id="booked-warning" class="text-red-500 text-sm">Ngày này đã có booking chưa hoàn tất!</p>
                        </div>

                        <div id="booking-details" class="mt-3 p-3 border rounded-xl bg-red-50 hidden"></div>
                    </div>

                    <script>
                        function loadBookedDates() {
                            const bookedDates = <?= json_encode($bookedDates); ?>;
                            const bookingDetails = <?= json_encode($bookingDetails); ?>;
                            const numberOfDays = <?= $numberOfDays; ?>;

                            const dateInput = document.getElementById('departure_date');
                            const endDateInput = document.getElementById('end_date');
                            const dateWarning = document.getElementById('date-warning');
                            const pastWarning = document.getElementById('past-warning');
                            const bookedWarning = document.getElementById('booked-warning');
                            const detailsDiv = document.getElementById('booking-details');

                            // Hàm format ngày YYYY-MM-DD
                            function formatDate(date) {
                                const d = new Date(date);
                                const day = String(d.getDate()).padStart(2, '0');
                                const month = String(d.getMonth() + 1).padStart(2, '0');
                                const year = d.getFullYear();
                                return `${year}-${month}-${day}`;
                            }

                            // Khi chọn ngày khởi hành
                            dateInput.addEventListener('change', function() {
                                const selectedDate = this.value;
                                const today = formatDate(new Date());

                                // Reset cảnh báo
                                dateWarning.classList.add('hidden');
                                pastWarning.style.display = 'none';
                                bookedWarning.style.display = 'none';
                                detailsDiv.classList.add('hidden');
                                detailsDiv.innerHTML = '';
                                this.classList.remove('border-red-500');

                                if (!selectedDate) return;

                                if (selectedDate < today) {
                                    dateWarning.classList.remove('hidden');
                                    pastWarning.style.display = 'block';
                                    this.classList.add('border-red-500');
                                    endDateInput.value = '';
                                    return;
                                }

                                // Gợi ý ngày kết thúc = ngày khởi hành + số ngày tour
                                const startDate = new Date(selectedDate);
                                const suggestedEnd = new Date(startDate);
                                suggestedEnd.setDate(suggestedEnd.getDate() + numberOfDays);

                                endDateInput.value = formatDate(suggestedEnd);

                                // Kiểm tra booking trùng
                                if (bookedDates.includes(selectedDate)) {
                                    dateWarning.classList.remove('hidden');
                                    bookedWarning.style.display = 'block';
                                    this.classList.add('border-red-500');

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