<?php
// Giả sử bạn đã có các biến này từ database
// $dataSchedulesById[0] là mảng lịch trình
// $databooking là mảng booking
// $dataCustomers là mảng khách (chỉ có 1 khách)

// Tính toán vài giá trị dùng chung
$schedule = $dataSchedulesById[0] ?? [];
$booking = $databooking ?? [];
$customer = $dataCustomers[0] ?? [];

// Ngày đi - về (định dạng dd/mm/yyyy)
$start_date = $booking['start_date'] ? date('d/m/Y', strtotime($booking['start_date'])) : 'Chưa xác định';
$end_date = $booking['end_date'] ? date('d/m/Y', strtotime($booking['end_date'])) : 'Chưa xác định';

// Tên tour (nếu có trong DB thì thay thế, hiện tại dùng tên mẫu)
$tour_name = "Đà Lạt – Crazy House 4N3Đ";

// Số khách + loại
$number_of_people = $booking['number_of_people'] ?? 0;
$customer_type = $customer['customer_type_name'] ?? 'Người lớn';
$customer_text = $number_of_people . " " . strtolower($customer_type);

// Deadline (giả lập còn 23h45p, bạn có thể tính chính xác từ created_at nếu muốn)
$deadline_text = "Còn <span class='text-2xl'>23 giờ 45 phút</span> để xác nhận";
?>

<div class="max-w-[1300px] mx-auto p-2 space-y-6">
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-3xl p-8 shadow-lg">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl text-white font-bold">Xác nhận nhận tour</h1>
                <p class="mt-2 text-blue-100">Vui lòng phản hồi trong thời gian sớm nhất</p>
            </div>
        </div>

        <!-- Card chính -->
        <div class="bg-white rounded-2xl shadow hover:shadow-xl transition border border-gray-200 mt-6 overflow-hidden">
            <!-- Banner đếm ngược -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-5 text-center">
                <p class="font-bold text-lg"><?= $deadline_text ?></p>
            </div>

            <div class="p-8 space-y-8">
                <!-- Tên tour + mã booking -->
                <div class="text-center">
                    <h2 class="text-3xl font-black text-gray-900"><?= htmlspecialchars($tour_name) ?></h2>
                    <p class="text-2xl font-bold text-blue-600 mt-3">#<?= htmlspecialchars($booking['booking_code'] ?? 'BK092457') ?></p>
                </div>

                <!-- Ngày đi về + Số khách -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-blue-50 rounded-2xl p-6 text-center border border-blue-100">
                        <p class="text-blue-700 text-sm font-medium">Ngày đi – về</p>
                        <p class="text-2xl font-bold text-blue-800 mt-2"><?= $start_date ?> – <?= $end_date ?></p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-6 text-center border border-gray-200">
                        <p class="text-gray-700 text-sm font-medium">Số khách</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2"><?= $customer_text ?></p>
                    </div>
                </div>

                <!-- Thông tin đón tiễn -->
                <div class="bg-gray-50 rounded-2xl p-6 space-y-4 text-sm border border-gray-200">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Đón tại:</span>
                        <span class="text-right"><?= htmlspecialchars($schedule['meeting_point'] ?? 'Chưa có cụ thể !') ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Giờ đón:</span>
                        <span>Chưa xác định</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Xe:</span>
                        <span><?= htmlspecialchars($schedule['vehicle'] ?: 'Chưa xác định') ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Loại đoàn:</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            <?= htmlspecialchars($booking['group_name'] ?? 'Đoàn tiêu chuẩn') ?>
                        </span>
                    </div>
                </div>

                <!-- Thông tin hành khách -->
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                    <p class="font-bold text-blue-900 flex items-center gap-2">
                        <i data-lucide="users" class="w-6 h-6"></i>
                        Thông tin hành khách
                    </p>
                    <div class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Họ tên:</span>
                            <span class="font-medium"><?= htmlspecialchars($customer['full_name'] ?? 'Chưa có') ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Số điện thoại:</span>
                            <span class="font-medium"><?= htmlspecialchars($booking['customer_phone'] ?? 'Chưa có') ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Hộ chiếu/CMND:</span>
                            <span class="font-medium"><?= htmlspecialchars($customer['passport'] ?? 'Chưa có') ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Loại khách:</span>
                            <span class="font-medium"><?= htmlspecialchars($customer_type) ?> (<?= number_format($customer['price_percentage'] ?? 100, 0) ?>% giá tour)</span>
                        </div>
                    </div>
                </div>

                <!-- Ghi chú -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
                    <p class="font-bold text-blue-900 flex items-center gap-2">
                        <i data-lucide="message-square" class="w-6 h-6"></i>
                        Ghi chú
                    </p>
                    <div class="text-blue-800 mt-3 leading-relaxed space-y-3">
                        <div>
                            <span class="font-medium">Từ điều hành:</span><br>
                            <span class="italic">Chưa có ghi chú từ điều hành</span>
                        </div>
                        <div>
                            <span class="font-medium">Ghi chú của khách:</span><br>
                            <?= htmlspecialchars($booking['note'] ?? 'Không có ghi chú') ?>
                        </div>
                    </div>
                </div>

                <!-- Nút hành động siêu gọn & đẹp (2025 style) -->
                <div class="p-4 bg-gradient-to-t from-white via-white to-transparent">
                    <div class="max-w-2xl mx-auto flex gap-3">
                        <!-- Nút Từ chối -->
                        <a href="?act=reject_tour&id=<?= $dataSchedulesById[0]['schedule_id'] ?>"
                            class="flex-1 py-4 bg-gray-100 hover:bg-gray-200 active:bg-gray-300 text-gray-700 font-bold text-lg rounded-2xl text-center transition shadow-lg">
                            Từ chối
                        </a>

                        <!-- Nút Xác nhận (nổi bật nhất) -->
                        <a href="?act=accept_tour&id=<?= $dataSchedulesById[0]['schedule_id'] ?>"
                            class="flex-1 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold text-lg rounded-2xl text-center shadow-xl flex items-center justify-center gap- gap-2 transform active:scale-95 transition">
                            Xác nhận nhận tour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>