<main class="flex-1 p-8 space-y-10 bg-gray-50 min-h-screen">

    <header class="relative bg-gradient-to-r from-main to-blue-400 text-white rounded-2xl p-6 shadow-lg flex justify-between items-center">
        <h1 class="text-3xl text-white text-shadow-xl font-bold flex items-center gap-3">
            <i data-lucide="calendar" class="w-7 h-7"></i>
            Lịch Trình Hướng Dẫn
        </h1>

        <a href="?mode=admin&act=sheduleguide"
            class="bg-white text-main font-semibold px-4 py-2 rounded-xl text-sm shadow hover:bg-blue-50 transition duration-200">
            Quản lý lịch trình
        </a>
    </header>

    <div class="space-y-10">

        <!-- TOUR TRONG TUẦN -->
        <section class="bg-white p-6 rounded-3xl shadow-lg">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2 border-b pb-4">
                <i data-lucide="calendar-check" class="w-5 h-5 text-green-600"></i>
                Tour Trong Tuần Này
            </h2>

            <?php if (empty($weekTours)): ?>
                <div class="p-6 text-center text-gray-500 bg-gray-50 rounded-2xl border border-dashed">
                    <p>Tuần này bạn không có tour nào.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto rounded-2xl border">
                    <table class="w-full text-left border-collapse min-w-[700px]">
                        <thead>
                            <tr class="bg-gray-100 text-sm text-gray-600">
                                <th class="p-4 font-semibold">Tên Tour</th>
                                <th class="p-4 font-semibold">Ngày Đi</th>
                                <th class="p-4 font-semibold text-center">Số Khách</th>
                                <th class="p-4 font-semibold text-center">Trạng Thái</th>
                                <th class="p-4 font-semibold text-center">Tùy Chọn</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            <?php foreach ($weekTours as $tour): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 font-semibold text-gray-800">
                                        <?= htmlspecialchars($tour['tour_name']) ?>
                                    </td>

                                    <td class="p-4 text-gray-700">
                                        <?= date("d/m/Y", strtotime($tour['start_date'])) ?>
                                    </td>

                                    <td class="p-4 text-center text-gray-700 font-medium">
                                        <?= $tour['total_customers'] ?? 0 ?> khách
                                    </td>

                                    <td class="p-4 text-center">
                                        <?php
                                        $status = today() >= $tour['start_date'] ? "Đang diễn ra" : "Sắp tới";
                                        $color = $status == "Đang diễn ra"
                                            ? 'bg-green-100 text-green-700 border-green-200'
                                            : 'bg-yellow-100 text-yellow-700 border-yellow-200';
                                        ?>
                                        <span class="px-4 py-1 rounded-full text-xs font-semibold border <?= $color ?>">
                                            <?= $status ?>
                                        </span>
                                    </td>

                                    <td class="p-3 text-center space-x-2">
                                        <?php
                                        $today_YMD = today();
                                        $is_active = $today_YMD >= $tour['start_date'] && $today_YMD <= $tour['end_date'];
                                        $schedule_id = $tour['id'];

                                        if ($is_active):
                                        ?>
                                            <a href="?mode=admin&act=checkguide&schedule_id=<?= $schedule_id ?>"
                                                class="inline-flex items-center text-xs font-semibold px-3 py-1 border border-green-500 rounded-lg bg-green-50 text-green-700 hover:bg-green-100 transition duration-150">
                                                <i data-lucide="user-check" class="w-3 h-3 mr-1"></i> Điểm danh ngay
                                            </a>
                                        <?php endif; ?>

                                        <a href="?mode=admin&act=tourdetailguide&schedule_id=<?= $schedule_id ?>"
                                            class="inline-flex items-center text-xs font-semibold px-3 py-1 border border-indigo-500 rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition duration-150">
                                            <i data-lucide="eye" class="w-3 h-3 mr-1"></i> Chi tiết Tour
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            <?php endif; ?>
        </section>

        <!-- LỊCH SỬ TOUR -->
        <section class="bg-white p-6 rounded-3xl shadow-lg">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2 border-b pb-4">
                <i data-lucide="clock-history" class="w-5 h-5 text-main"></i>
                Lịch Sử Tour Gần Đây (Đã kết thúc)
            </h2>

            <?php if (empty($recentTours)): ?>
                <div class="p-6 text-center text-gray-500 bg-gray-50 rounded-2xl border border-dashed">
                    <p>Chưa có tour nào được hoàn thành gần đây.</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($recentTours as $tour): ?>
                        <div class="flex items-center justify-between p-5 border rounded-2xl hover:bg-gray-50 transition shadow-sm">
                            <div>
                                <h3 class="font-bold text-gray-800">
                                    <?= htmlspecialchars($tour['tour_name']) ?>
                                </h3>
                                <p class="text-gray-500 text-sm mt-1">
                                    Kết thúc ngày <?= date("d/m/Y", strtotime($tour['end_date'])) ?> —
                                    <?= $tour['total_customers'] ?? 0 ?> khách
                                </p>
                            </div>

                            <span class="px-4 py-1.5 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold border">
                                Hoàn thành
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

    </div>

</main>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>