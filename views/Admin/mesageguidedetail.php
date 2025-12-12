<?php
// === Lấy dữ liệu ===
$schedule = $dataSchedulesById[0] ?? [];
$booking  = $databooking ?? [];
$tour     = $datatour ?? [];
$customers = $dataCustomers ?? [];

// === Ngày đi – về ===
$start_date = !empty($booking['start_date']) ? date('d/m/Y', strtotime($booking['start_date'])) : 'Chưa xác định';
$end_date   = !empty($booking['end_date']) ? date('d/m/Y', strtotime($booking['end_date'])) : 'Chưa xác định';

// === Tên tour ===
$tour_name = $tour['name'] ?? "Chưa có tên tour";

// === Số khách ===
$number_of_people = $booking['number_of_people'] ?? 0;

// Loại khách đầu tiên (nếu muốn hiển thị dạng: 4 người lớn)
$customer_type = $customers[0]['customer_type_name'] ?? 'Khách';
$customer_text = $number_of_people . " " . strtolower($customer_type);

// === Deadline mẫu ===
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
            <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white p-5 text-center">
                <p class="font-bold text-lg"><?= $deadline_text ?></p>
            </div>

            <div class="p-8 space-y-8">

                <!-- Tên tour + mã booking -->
                <div class="text-center">
                    <h2 class="text-3xl font-black text-gray-900"><?= htmlspecialchars($tour_name) ?></h2>

                    <p class="text-2xl font-bold text-blue-600 mt-3">
                        #<?= htmlspecialchars($booking['booking_code'] ?? '') ?>
                    </p>
                </div>

                <!-- Ngày đi – về + số khách -->
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

                <!-- Thông tin đón -->
                <div class="bg-gray-50 rounded-2xl p-6 space-y-4 text-sm border border-gray-200">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Đón tại:</span>
                        <span class="text-right"><?= htmlspecialchars($schedule['meeting_point'] ?: 'Chưa có cụ thể !') ?></span>
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
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        <?= $booking['group_color'] ?>">
                            <?= htmlspecialchars($booking['group_name']) ?>
                        </span>
                    </div>
                </div>

                <!-- Thông tin hành khách -->
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                    <p class="font-bold text-blue-900 flex items-center gap-2">
                        <i data-lucide="users" class="w-6 h-6"></i> Danh sách hành khách
                    </p>

                    <div class="mt-4 space-y-4 text-sm">
                        <?php foreach ($customers as $c): ?>
                            <div class="p-4 bg-white rounded-xl border border-gray-200 shadow-sm">
                                <p><b>Họ tên:</b> <?= htmlspecialchars($c['full_name']) ?></p>
                                <p><b>Hộ chiếu/CMND:</b> <?= htmlspecialchars($c['passport']) ?></p>
                                <p><b>Loại khách:</b> <?= htmlspecialchars($c['customer_type_name']) ?>
                                    (<?= number_format($c['price_percentage'], 0) ?>%)</p>
                                <p><b>Ghi chú:</b> <?= htmlspecialchars($c['note']) ?></p>
                            </div>
                        <?php endforeach; ?>
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
                            <span class="italic"><?= htmlspecialchars($schedule['guide_notes'] ?: 'Chưa có ghi chú') ?></span>
                        </div>
                        <div>
                            <span class="font-medium">Ghi chú của khách:</span><br>
                            <?= htmlspecialchars($booking['note'] ?: 'Không có ghi chú') ?>
                        </div>
                    </div>
                </div>

                <!-- Nút hành động -->
                <div class="p-4 bg-gradient-to-t from-white via-white to-transparent">
                    <div class="max-w-2xl mx-auto flex gap-3">

                        <a href="?act=reject_tour&id=<?= $schedule['schedule_id'] ?>"
                            class="flex-1 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-lg rounded-2xl text-center shadow-lg">
                            Từ chối
                        </a>

                        <a href="?act=accept_tour&schedule_id=<?= $schedule['schedule_id'] ?>"
                            onclick="return confirm('Bạn có chắc chắn muốn xác nhận nhận tour này không? Hành động này sẽ thông báo tới điều hành!')"
                            class="flex-1 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 
                            text-white font-bold text-lg rounded-2xl text-center shadow-xl flex items-center justify-center gap-2">
                            Xác nhận nhận tour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>