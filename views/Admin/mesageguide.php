<?php
// Lọc thông báo: guide_status = PENDING + schedule_status = pending
$notifications = array_filter($dataSchedulesByIdGuide, function ($sch) {
    return
        strtoupper(trim($sch['guide_status_code'] ?? '')) === 'PENDING' &&
        strtoupper(trim($sch['schedule_status_code'] ?? '')) === 'PENDING';
});

$notificationCount = count($notifications);
?>

<div class="max-w-4xl mx-auto p-2 space-y-6">

    <!-- Header – đồng bộ màu main -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 text-white rounded-3xl p-8 shadow-lg">
        <h1 class="text-3xl font-bold">Thông báo</h1>
        <p class="mt-2 text-indigo-100">Bạn có <span class="font-black"><?= $notificationCount ?></span> thông báo mới</p>
    </div>

    <?php if ($notificationCount === 0): ?>
        <div class="text-center py-20 bg-white rounded-3xl shadow border border-gray-200">
            <i class="fa-solid fa-bell-slash text-6xl text-gray-300 mb-6"></i>
            <p class="text-2xl font-semibold text-gray-600">Chưa có thông báo mới</p>
            <p class="text-gray-500 mt-3">Khi có tour mới cần bạn xác nhận, thông báo sẽ hiện ngay tại đây!</p>
        </div>
    <?php else: ?>
        <?php foreach ($notifications as $sch):
            $start = date('d/m/Y', strtotime($sch['start_date']));
            $end   = date('d/m/Y', strtotime($sch['end_date']));
            $bookingCode = 'BK' . str_pad($sch['booking_id'], 6, '0', STR_PAD_LEFT);
        ?>
            <a href="?act=mesageguidedetail&id=<?= $sch['schedule_id'] ?>"
                class="block bg-white rounded-2xl shadow hover:shadow-xl transition group border border-gray-200 hover:border-indigo-300">

                <div class="p-6 flex items-center gap-5">
                    <!-- Icon + Badge – ĐỒNG BỘ 100% với hệ thống -->
                    <div class="relative flex-shrink-0">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl 
                                    flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fa-solid fa-bus text-2xl text-indigo-600"></i>
                        </div>
                        <span class="absolute -top-2 -right-2 w-5 h-5 bg-red-600 rounded-full 
                                    border-4 border-white shadow-lg animate-pulse"></span>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">Bạn được phân tour mới!</h3>
                        <p class="text-gray-700 mt-1">
                            <?= htmlspecialchars($sch['tour_name'] ?? 'Tour chưa có tên') ?>
                        </p>
                        <div class="flex items-center gap-4 mt-3 text-sm">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full font-medium">
                                #<?= $bookingCode ?>
                            </span>
                            <span class="text-gray-600"><?= $start ?> - <?= $end ?></span>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Vừa xong</p>
                    </div>

                    <i class="fa-solid fa-chevron-right text-xl text-gray-400 group-hover:text-indigo-600 transition"></i>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
