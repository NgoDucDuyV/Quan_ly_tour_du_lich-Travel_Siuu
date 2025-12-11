<main class="flex-1 p-8 space-y-10">

    <!-- HEADER / BANNER MINI -->
    <?php
    $name = $_SESSION['admin_logged']['fullname'] ?? "Hướng dẫn viên";
    ?>

    <section class="relative bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-3xl p-8 shadow-lg">
        <div class="relative z-10">
            <h1 class="text-3xl text-dark font-bold">
                Xin chào, HDV <span class="text-white text-shadow-xl"><?= $name ?></span> 👋
            </h1>
            <p class="mt-2 text-blue-100">
                Chúc bạn có một ngày làm việc hiệu quả và nhiều trải nghiệm thú vị.
            </p>
        </div>
    </section>


    <!-- 3 CARD THỐNG KÊ -->
    <section class="grid md:grid-cols-4 gap-6">

        <!-- CARD 1 -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition group cursor-pointer"
            onclick="location.href='#schedulenewquyj'">

            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-100 rounded-xl group-hover:bg-blue-200">
                    <i data-lucide="calendar" class="w-6 h-6 text-blue-700"></i>
                </div>
                <div>
                    <p class="text-gray-500">Tour sắp tới</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        <?= $totalUpcomingTours ?? 0 ?> tour
                    </h3>
                </div>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition group">

            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-100 rounded-xl group-hover:bg-green-200">
                    <i data-lucide="clock" class="w-6 h-6 text-green-700"></i>
                </div>
                <div>
                    <p class="text-gray-500">Lịch làm việc</p>
                    <h3 class="text-xl font-bold text-gray-800">12/11 - 19/11</h3>
                </div>
            </div>
        </div>

        <!-- CARD 3 -->
        <div onclick="window.location='?mode=admin&act=listguide'"
            class="cursor-pointer bg-white p-6 rounded-2xl shadow hover:shadow-xl transition group">

            <div class="flex items-center gap-4">
                <div class="p-3 bg-red-100 rounded-xl group-hover:bg-red-200">
                    <i data-lucide="users" class="w-6 h-6 text-red-600"></i>
                </div>

                <div>
                    <p class="text-gray-500">Khách hôm nay</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        <?= $totalCustomersToday['total_customers'] ?>
                    </h3>
                </div>
            </div>
        </div>
        <!-- CARD 4 -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition group cursor-pointer"
            onclick="window.location='?mode=admin&act=historyguide'">

            <div class="flex items-center gap-4">
                <div class="p-3 bg-purple-100 rounded-xl group-hover:bg-purple-200">
                    <i data-lucide="check-circle" class="w-6 h-6 text-purple-700"></i>
                </div>
                <div>
                    <p class="text-gray-500">Tour hoàn thành</p>
                    <h3 class="text-xl font-bold text-gray-800">
                        <?= $totalCompletedTours ?? 0 ?>
                    </h3>
                </div>
            </div>
        </div>
    </section>

    <!-- LỊCH TRÌNH HÔM NAY -->
    <section class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="map"></i> Lịch trình hôm nay
            <span class="text-sm font-normal text-gray-500">(<?= date('d/m/Y') ?>)</span>
        </h2>

        <?php
        $todayTours = [];
        $today = '2025-12-12'; // Ngày hôm nay định dạng Y-m-d


        foreach ($dataSchedulesByGuideId as $schedule) {
            $start = $schedule['start_date'];
            $end   = $schedule['end_date'];
            $status_code = $schedule['schedule_status_code']; // Lấy mã trạng thái từ Model đã sửa

            // Điều kiện: (1) Đang diễn ra hôm nay VÀ (2) Trạng thái không phải là Hoàn thành/Đã hủy
            if (
                ($today >= $start && $today <= $end) && // <-- Logic này bao gồm tour đang diễn ra
                !in_array($status_code, ['completed', 'cancelled', 'closed'])
            ) {
                $todayTours[] = $schedule;
            }
        }

        if (empty($todayTours)): ?>
            <div class="p-8 text-center text-gray-500 bg-gray-50 rounded-xl">
                <i data-lucide="calendar-x" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
                <p>Hôm nay bạn không có lịch hướng dẫn nào.</p>
                <p class="text-sm mt-2">Nghỉ ngơi thật tốt nhé!</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($todayTours as $schedule):
                    $startFormatted = date('d/m/Y', strtotime($schedule['start_date']));
                    $endFormatted   = date('d/m/Y', strtotime($schedule['end_date']));
                    $isOngoing = ($today > $schedule['start_date'] && $today < $schedule['end_date']) ||
                        ($today == $schedule['start_date']) ||
                        ($today == $schedule['end_date']);

                    // Trạng thái hôm nay
                    $todayStatus = $today == $schedule['start_date'] ? "Bắt đầu hôm nay" : ($today == $schedule['end_date'] ? "Kết thúc hôm nay" : "Đang diễn ra");
                ?>
                    <div class="border rounded-xl overflow-hidden bg-gradient-to-br from-indigo-50 to-blue-50 hover:shadow-lg transition-all duration-300">
                        <!-- Tiêu đề tour - Có thể click để mở chi tiết -->
                        <div class="p-5 cursor-pointer flex justify-between items-center bg-white bg-opacity-70 hover:bg-opacity-100 transition"
                            onclick="this.closest('.border').querySelector('.details').classList.toggle('hidden')">
                            <div>
                                <h3 class="font-bold text-lg text-indigo-800">
                                    <?= htmlspecialchars($schedule['tour_name']) ?>
                                    <span class="text-sm font-medium text-indigo-600">(<?= $schedule['tour_code'] ?>)</span>
                                </h3>
                                <p class="text-gray-700 mt-1 flex items-center gap-4 text-sm">
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="calendar"></i>
                                        <?= $startFormatted ?> → <?= $endFormatted ?>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="map-pin"></i>
                                        <?= htmlspecialchars($schedule['meeting_point'] ?? 'Chưa xác định') ?>
                                    </span>
                                </p>
                                <p class="text-green-600 font-semibold text-sm mt-2">
                                    <i data-lucide="clock"></i> <?= $todayStatus ?>
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold text-sm">
                                    ĐANG HOẠT ĐỘNG
                                </span>
                                <i data-lucide="chevron-down" class="w-6 h-6 text-gray-500 ml-3 transition-transform"
                                    id="arrow-<?= $schedule['schedule_id'] ?>"></i>
                            </div>
                        </div>

                        <!-- Phần chi tiết (mở rộng khi click) -->
                        <div class="details hidden bg-white border-t border-gray-200 p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                <div>
                                    <p class="text-gray-600"><strong>Thời gian tour:</strong></p>
                                    <p class="font-medium"><?= $schedule['tour_days'] ?> ngày <?= $schedule['tour_nights'] ?> đêm</p>
                                </div>
                                <div>
                                    <p class="text-gray-600"><strong>Điểm đón:</strong></p>
                                    <p class="font-medium"><?= htmlspecialchars($schedule['meeting_point'] ?? 'Chưa có') ?></p>
                                </div>
                                <div>
                                    <p class="text-gray-600"><strong>Khách sạn:</strong></p>
                                    <p class="font-medium"><?= htmlspecialchars($schedule['hotel'] ?? 'Chưa đặt') ?></p>
                                </div>
                                <div>
                                    <p class="text-gray-600"><strong>Phương tiện:</strong></p>
                                    <p class="font-medium"><?= htmlspecialchars($schedule['vehicle'] ?? 'Chưa có') ?></p>
                                </div>
                                <?php if (!empty($schedule['restaurant'])): ?>
                                    <div>
                                        <p class="text-gray-600"><strong>Nhà hàng:</strong></p>
                                        <p class="font-medium"><?= htmlspecialchars($schedule['restaurant']) ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($schedule['flight_info'])): ?>
                                    <div>
                                        <p class="text-gray-600"><strong>Chuyến bay:</strong></p>
                                        <p class="font-medium"><?= htmlspecialchars($schedule['flight_info']) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($schedule['guide_notes'])): ?>
                                <div class="mt-4 p-4 bg-amber-50 rounded-lg border border-amber-200">
                                    <p class="font-semibold text-amber-800 flex items-center gap-2">
                                        <i data-lucide="alert-circle"></i> Ghi chú từ điều hành
                                    </p>
                                    <p class="text-amber-900 mt-2"><?= nl2br(htmlspecialchars($schedule['guide_notes'])) ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="text-right mt-4">
                                <button onclick="this.closest('.details').classList.add('hidden')"
                                    class="text-sm text-gray-500 hover:text-gray-700 underline">
                                    Đóng chi tiết ↑
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section id="schedulenewquyj" class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="compass"></i> Tour tiếp theo
        </h2>

        <?php if (empty($dataSchedulesByGuideId)): ?>
            <p class="text-gray-500 italic">Chưa có lịch hướng dẫn nào sắp tới.</p>
        <?php else: ?>
            <div class="flex flex-col gap-4">
                <?php
                // Sắp xếp theo ngày bắt đầu gần nhất
                usort($dataSchedulesByGuideId, function ($a, $b) {
                    return strtotime($a['start_date']) <=> strtotime($b['start_date']);
                });

                foreach ($dataSchedulesByGuideId as $schedule):
                    // Format ngày tháng
                    $start = date('d/m/Y', strtotime($schedule['start_date']));
                    $end   = date('d/m/Y', strtotime($schedule['end_date']));

                    // Xác định trạng thái và màu sắc
                    $status_info = match ((int)$schedule['schedule_status_id']) {
                        1 => ['name' => 'Sắp tới',      'color' => 'text-yellow-600 bg-yellow-100'],
                        2 => ['name' => 'Đang diễn ra', 'color' => 'text-green-600 bg-green-100'],
                        3 => ['name' => 'Hoàn thành',   'color' => 'text-gray-500 bg-gray-100'],
                        4 => ['name' => 'Đã hủy',       'color' => 'text-red-600 bg-red-100'],
                        default => ['name' => 'Chưa xác định', 'color' => 'text-gray-600 bg-gray-100'],
                    };
                ?>
                    <div class="relative p-5 border rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 transition-all duration-300 group cursor-pointer">
                        <!-- Thông tin chính -->
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-bold text-lg text-gray-800">
                                    <?= htmlspecialchars($schedule['tour_name']) ?>
                                    <span class="text-sm font-medium text-blue-600">(<?= htmlspecialchars($schedule['tour_code']) ?>)</span>
                                </h3>
                                <p class="text-gray-600 mt-1">
                                    <i data-lucide="calendar"></i> <?= $start ?> → <?= $end ?>
                                    <span class="mx-2">•</span>
                                    <i data-lucide="map-pin"></i> <?= htmlspecialchars($schedule['meeting_point'] ?? 'Chưa xác định') ?>
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    <?= $schedule['tour_days'] ?> ngày <?= $schedule['tour_nights'] ?> đêm
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold <?= $status_info['color'] ?>">
                                    <?= $status_info['name'] ?>
                                </span>
                            </div>
                        </div>

                        <!-- Hover chi tiết -->
                        <div class="absolute left-0 right-0 top-full mt-2 p-5 bg-white border border-gray-200 rounded-xl shadow-xl opacity-0 group-hover:opacity-100 transition-all duration-300 z-20 pointer-events-none group-hover:pointer-events-auto">
                            <h4 class="font-bold text-gray-800 mb-3">Chi tiết lịch hướng dẫn</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                <p><strong>Khách sạn:</strong> <?= htmlspecialchars($schedule['hotel'] ?? 'Chưa có thông tin') ?></p>
                                <p><strong>Phương tiện:</strong> <?= htmlspecialchars($schedule['vehicle'] ?? 'Chưa có') ?></p>
                                <p><strong>Nhà hàng:</strong> <?= htmlspecialchars($schedule['restaurant'] ?? 'Chưa có') ?></p>
                                <p><strong>Chuyến bay:</strong> <?= htmlspecialchars($schedule['flight_info'] ?? 'Không có') ?></p>
                                <?php if (!empty($schedule['guide_notes'])): ?>
                                    <p class="md:col-span-2"><strong>Ghi chú HDV:</strong> <?= nl2br(htmlspecialchars($schedule['guide_notes'])) ?></p>
                                <?php endif; ?>
                                <p class="md:col-span-2 text-xs text-gray-500 mt-3 italic">
                                    Cập nhật lần cuối: <?= date('H:i, d/m/Y') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>



    <!-- NHẬT KÝ GẦN NHẤT -->
    <section class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="notebook-pen"></i> Nhật ký gần nhất
        </h2>

        <?php if (empty($diary)): ?>
            <p class="text-gray-500 italic">Chưa có nhật ký nào...</p>
        <?php endif; ?>

        <div class="space-y-4 max-h-80 overflow-y-auto pr-2
                scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100">

            <?php foreach ($diary as $log): ?>
                <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">

                    <h3 class="font-semibold text-gray-800">
                        <?= date("d/m/Y", strtotime($log['log_date'])) ?>
                    </h3>

                    <p class="text-gray-600 text-sm mt-1">
                        <?= nl2br($log['content']) ?>
                    </p>

                    <?php $imgs = json_decode($log['images'], true); ?>
                    <?php if (!empty($imgs)): ?>
                        <div class="flex gap-2 mt-2">
                            <?php foreach ($imgs as $img): ?>
                                <img src="<?= BASE_URL . $img ?>"
                                    class="w-16 h-16 rounded-xl object-cover shadow-sm">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- YÊU CẦU ĐẶC BIỆT -->
    <section class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="mail-question"></i> Yêu cầu đặc biệt gần đây
        </h2>

        <?php if (empty($requests)): ?>
            <p class="text-gray-500 italic">Chưa có yêu cầu nào...</p>
        <?php endif; ?>

        <ul class="space-y-3 max-h-80 overflow-y-auto pr-2
            scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100">

            <?php foreach ($requests as $req): ?>
                <li class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">

                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold text-gray-800">
                                <?= htmlspecialchars($req['title']) ?>
                            </h3>

                            <p class="text-gray-600 text-sm">
                                <?= nl2br($req['content']) ?>
                            </p>

                            <p class="text-gray-400 text-xs mt-1">
                                Gửi lúc <?= date("H:i d/m/Y", strtotime($req['created_at'])) ?>
                            </p>
                        </div>

                        <?php
                        $color = [
                            "pending"    => "bg-yellow-100 text-yellow-700",
                            "approved"   => "bg-green-100 text-green-700",
                            "processing" => "bg-blue-100 text-blue-700",
                            "rejected"   => "bg-red-100 text-red-700"
                        ][$req['status']];
                        ?>
                        <span class="px-3 py-1 rounded-full text-sm <?= $color ?>">
                            <?= ucfirst($req['status']) ?>
                        </span>
                    </div>

                </li>
            <?php endforeach; ?>

        </ul>
    </section>

</main>
<script>
    // Xử lý logic Mở/Đóng chi tiết Tour
    document.querySelectorAll('.border').forEach(card => {
        const header = card.querySelector('.p-5.cursor-pointer');
        const details = card.querySelector('.details');

        if (header) {
            header.addEventListener('click', () => {
                const arrow = header.querySelector('i[data-lucide="chevron-down"]');
                details.classList.toggle('hidden');

                // Đảo ngược mũi tên
                if (arrow) {
                    arrow.classList.toggle('rotate-180');
                }
            });
        }
    });
</script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>