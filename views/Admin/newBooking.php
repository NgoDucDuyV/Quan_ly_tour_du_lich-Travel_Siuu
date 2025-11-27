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
                <div class="p-6 rounded-2xl border border-gray-200 shadow-lg space-y-6 bg-white w-full mx-auto">
                    <h4 class="text-2xl font-bold text-gray-800 mb-4 text-center md:text-left">1. Thông Tin Tour & Khách Chính</h4>

                    <!-- Chọn Tour -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Chọn Tour *</label>
                        <select name="tour_id" class="w-full p-4 border rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300" required
                            onchange="if(this.value) { window.location.href='?act=newBooking&tour_id=' + this.value; }">
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
                        <select name="tour_version_id" class="w-full p-4 border rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300" required>
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
                        <div class="border rounded-2xl p-4 bg-gray-50 space-y-6 shadow-inner">
                            <h5 class="font-bold text-gray-800 text-lg mb-3">Chi tiết Tour</h5>

                            <!-- Suppliers -->
                            <?php if (!empty($tourFullData['suppliers'])): ?>
                                <div class="bg-white p-3 rounded-xl shadow-sm overflow-x-auto">
                                    <h6 class="font-semibold text-gray-700 mb-2">Nhà cung cấp dịch vụ</h6>
                                    <ul class="list-disc pl-5 space-y-1 whitespace-nowrap">
                                        <?php foreach ($tourFullData['suppliers'] as $s): ?>
                                            <li><?= $s['role'] ?? '' ?>: <?= $s['supplier_name'] ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- Itineraries -->
                            <?php if (!empty($tourFullData['tourDetail'])): ?>
                                <?php
                                $itineraries = [];
                                foreach ($tourFullData['tourDetail'] as $item) {
                                    $id = $item['itinerary_id'];
                                    if (!isset($itineraries[$id])) {
                                        $itineraries[$id] = [
                                            'day_number' => $item['day_number'],
                                            'itinerary_title' => $item['itinerary_title'],
                                            'itinerary_description' => $item['itinerary_description'],
                                            'activities' => [],
                                        ];
                                    }
                                    $itineraries[$id]['activities'][] = [
                                        'time' => $item['activity_time'],
                                        'activity' => $item['activity'],
                                        'location' => $item['location'],
                                        'description' => $item['activity_description'],
                                    ];
                                }
                                ?>

                                <div class="space-y-3">
                                    <?php foreach ($itineraries as $day): ?>
                                        <div class="border-l-4 border-indigo-300 pl-4 bg-white p-3 rounded-xl shadow-sm">
                                            <h6 class="font-semibold text-gray-800 mb-1 text-lg">
                                                Ngày <?= $day['day_number'] ?>: <?= $day['itinerary_title'] ?>
                                            </h6>
                                            <p class="text-sm text-gray-500 mb-2"><?= $day['itinerary_description'] ?></p>

                                            <?php if (!empty($day['activities'])): ?>
                                                <ul class="space-y-2">
                                                    <?php foreach ($day['activities'] as $act): ?>
                                                        <li class="flex flex-col sm:flex-row sm:items-start sm:space-x-2">
                                                            <span class="text-indigo-500 font-semibold"><?= $act['time'] ?></span>
                                                            <div>
                                                                <p class="font-medium text-gray-700"><?= $act['activity'] ?> <span class="text-gray-400"> (<?= $act['location'] ?>)</span></p>
                                                                <p class="text-gray-400 text-sm"><?= $act['description'] ?></p>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Hình ảnh slider -->
                            <?php if (!empty($tourFullData['images'])): ?>
                                <div>
                                    <h6 class="font-semibold text-gray-700 mb-2">Hình ảnh tour</h6>
                                    <div class="swiper mySwiper rounded-xl overflow-hidden shadow-md">
                                        <div class="swiper-wrapper">
                                            <?php foreach ($tourFullData['images'] as $img): ?>
                                                <div class="swiper-slide">
                                                    <img src="<?= $img['image_url'] ?>" alt="<?= $img['description'] ?>" class="w-full h-60 md:h-72 object-cover rounded-xl">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="swiper-pagination"></div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                    <script>
                                        const swiper = new Swiper(".mySwiper", {
                                            loop: true,
                                            spaceBetween: 20,
                                            slidesPerView: 1,
                                            breakpoints: {
                                                640: {
                                                    slidesPerView: 1
                                                },
                                                768: {
                                                    slidesPerView: 2
                                                },
                                                1024: {
                                                    slidesPerView: 3
                                                },
                                            },
                                            pagination: {
                                                el: ".swiper-pagination",
                                                clickable: true
                                            },
                                            navigation: {
                                                nextEl: ".swiper-button-next",
                                                prevEl: ".swiper-button-prev"
                                            },
                                            autoplay: {
                                                delay: 3000,
                                                disableOnInteraction: false
                                            },
                                        });
                                    </script>
                                </div>
                            <?php endif; ?>

                            <!-- Policies -->
                            <?php if (!empty($tourFullData['policies'])): ?>
                                <div>
                                    <h6 class="font-semibold text-gray-700 mb-3 text-lg">Chính sách tour</h6>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                        <?php foreach ($tourFullData['policies'] as $p): ?>
                                            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                                                <h6 class="font-semibold text-indigo-800 mb-1"><?= $p['policy_type'] ?></h6>
                                                <p class="text-gray-600 text-sm"><?= $p['description'] ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                    <!-- Thông tin khách hàng -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tên Khách hàng *</label>
                            <input type="text" name="customer_name" class="w-full p-4 border rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại *</label>
                            <input type="tel" name="customer_phone" class="w-full p-4 border rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Khách hàng *</label>
                        <input type="email" name="customer_email" class="w-full p-4 border rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300" required>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="nextStep(2)" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl shadow-md transition">Tiếp theo</button>
                    </div>
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
                <div class="p-6 rounded-2xl border border-[#d0e2ff] shadow-md space-y-6 bg-[#f5f7fa]">
                    <h4 class="text-xl font-bold text-[#1f3d7a]">3. Hành khách & Dịch vụ</h4>

                    <!-- Hành khách -->
                    <div class="space-y-4">
                        <h5 class="font-semibold mb-2 text-[#1f3d7a]">Danh sách Hành khách</h5>
                        <div id="passenger-list" class="space-y-3">
                            <div class="passenger-item border p-4 rounded-xl bg-white shadow-sm space-y-2 relative group">
                                <button
                                    class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                                    onclick="removePassenger(this)"
                                    title="button">
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

                    <!-- Dịch vụ -->
                    <div class="space-y-4 mt-6">
                        <h5 class="font-semibold mb-2 text-[#1f3d7a]">Dịch vụ thêm</h5>
                        <div id="service-list" class="space-y-3">
                            <div class="service-item border p-4 rounded-xl bg-white shadow-sm space-y-2 relative group">
                                <button
                                    class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                                    onclick="removeService(this)"
                                    title="button">
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
                function addPassenger() {
                    const container = document.getElementById('passenger-list');
                    const template = container.querySelector('.passenger-item');
                    const clone = template.cloneNode(true);
                    clone.querySelectorAll('input, select, textarea').forEach(input => input.value = '');
                    container.appendChild(clone);
                }

                function removePassenger(btn) {
                    const container = document.getElementById('passenger-list');
                    if (container.children.length > 1) {
                        btn.parentElement.remove();
                    }
                }

                function addService() {
                    const container = document.getElementById('service-list');
                    const template = container.querySelector('.service-item');
                    const clone = template.cloneNode(true);
                    clone.querySelectorAll('input, textarea').forEach(input => input.value = input.type === 'number' ? 1 : '');
                    container.appendChild(clone);
                }

                function removeService(btn) {
                    const container = document.getElementById('service-list');
                    if (container.children.length > 1) {
                        btn.parentElement.remove();
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