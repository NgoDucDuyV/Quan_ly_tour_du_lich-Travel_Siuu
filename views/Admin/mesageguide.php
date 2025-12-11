<?php
// Lọc thông báo: guide_status = PENDING + schedule_status = pending
$notifications = array_filter($dataSchedulesByIdGuide, function ($sch) {
    return
        strtoupper(trim($sch['guide_status_code'] ?? '')) === 'PENDING' &&
        strtoupper(trim($sch['schedule_status_code'] ?? '')) === 'PENDING';
});

$notificationCount = count($notifications);
?>

<div class="max-w-[1800px] mx-auto p-2 space-y-6">

    <!-- Header – đồng bộ màu main -->
    <div class="bg-gradient-to-r from-main to-blue-400 text-white rounded-3xl p-8 shadow-lg">
        <h1 class="text-3xl text-white font-bold">Thông báo</h1>
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
            <a href="?act=mesageguidedetail&schedule_id=<?= $sch['schedule_id'] ?>"
                class="block bg-white rounded-2xl shadow hover:shadow-xl transition group border border-gray-200 hover:border-indigo-300">

                <div class="p-4 flex items-center gap-4 bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <!-- Icon với badge nhấp nháy -->
                    <div class="relative flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-xl 
                    flex items-center justify-center">
                            <i class="fa-solid fa-bus text-xl text-indigo-600"></i>
                        </div>
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                    </div>

                    <?php $datatour = (new TourModel())->getOne($sch['tour_id']); ?>

                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 truncate">Bạn được phân tour mới!</h3>

                        <p class="text-sm text-gray-600 mt-0.5 truncate">
                            <span class="font-medium"> Tour: <?= htmlspecialchars($datatour['name'] ?? 'Tour chưa có tên') ?></span>
                        </p>

                        <div class="flex items-center gap-3 mt-2 text-xs">
                            <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 rounded-full font-medium">
                                #<?= $bookingCode ?>
                            </span>
                            <span class="text-gray-500"><?= $start ?> → <?= $end ?></span>
                        </div>
                    </div>

                    <i class="fa-solid fa-chevron-right text-gray-400 text-lg"></i>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>