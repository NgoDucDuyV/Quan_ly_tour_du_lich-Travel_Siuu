<main class="flex-1 p-8 space-y-10">

    <!-- HEADER / BANNER MINI -->
    <?php
    $name = $_SESSION['admin_logged']['fullname'] ?? "Hướng dẫn viên";
    ?>

    <section class="relative bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-3xl p-8 shadow-lg">
        <div class="relative z-10">
            <h1 class="text-3xl font-bold">
                Xin chào, HDV <span class="text-white text-shadow-xl"><?= $name ?></span> 👋
            </h1>
            <p class="mt-2 text-blue-100">
                Chúc bạn có một ngày làm việc hiệu quả và nhiều trải nghiệm thú vị.
            </p>
        </div>
    </section>


    <!-- 4 CARD THỐNG KÊ -->
    <section class="grid md:grid-cols-4 gap-6">

        <!-- CARD -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition group">
            <a href="#schedulenewquyj">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 rounded-xl group-hover:bg-blue-200">
                        <i data-lucide="calendar" class="w-6 h-6 text-blue-700"></i>
                    </div>
                    <div>
                        <p class="text-gray-500">Tour sắp tới</p>
                        <h3 class="text-xl font-bold text-gray-800">3 tour</h3>
                    </div>
                </div>
            </a>
        </div>

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

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition group">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-yellow-100 rounded-xl group-hover:bg-yellow-200">
                    <i data-lucide="star" class="w-6 h-6 text-yellow-600"></i>
                </div>
                <div>
                    <p class="text-gray-500">Điểm đánh giá</p>
                    <h3 class="text-xl font-bold text-gray-800">4.9 ⭐</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition group">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-red-100 rounded-xl group-hover:bg-red-200">
                    <i data-lucide="users" class="w-6 h-6 text-red-600"></i>
                </div>
                <div>
                    <p class="text-gray-500">Khách hôm nay</p>
                    <h3 class="text-xl font-bold text-gray-800">26 khách</h3>
                </div>
            </div>
        </div>

    </section>

    <!-- LỊCH TRÌNH HÔM NAY -->
    <section class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="map"></i> Lịch trình hôm nay
        </h2>

        <div class="p-4 border rounded-xl bg-blue-50 hover:bg-blue-100 transition">
            <h3 class="font-semibold text-gray-800">Tour Hạ Long – 26 khách</h3>
            <p class="text-gray-600 text-sm">Bắt đầu lúc 7:30 AM – Kết thúc 5:00 PM</p>
        </div>
    </section>

    <section id="schedulenewquyj" class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="compass"></i> Tour tiếp theo
        </h2>

        <div class="flex flex-col gap-4">
            <?php foreach ($dataSchedulesByGuideId as $schedule): ?>
                <?php
                // Format ngày
                $start = date('d/m/Y', strtotime($schedule['start_date']));
                $end = date('d/m/Y', strtotime($schedule['end_date']));

                // Trạng thái màu
                $status_color = match ($schedule['schedule_status']) {
                    'planned' => 'text-yellow-600',
                    'ongoing' => 'text-green-600',
                    'completed' => 'text-gray-400',
                    default => 'text-gray-600',
                };

                // Thông tin tour
                $tour_name = $schedule['tour_name'] ?? "Tour ID " . $schedule['tour_id'];
                $tour_location = $schedule['tour_location'] ?? 'Chưa có địa điểm';
                $days = $schedule['days'] ?? '';
                $nights = $schedule['nights'] ?? '';

                // Thông tin chi tiết
                $meeting_point = $schedule['meeting_point'] ?? 'Chưa có điểm gặp';
                $hotel = $schedule['hotel'] ?? 'Chưa có khách sạn';
                $vehicle = $schedule['vehicle'] ?? 'Chưa có phương tiện';
                $restaurant = $schedule['restaurant'] ?? 'Chưa có nhà hàng';
                $flight_info = $schedule['flight_info'] ?? 'Chưa có thông tin bay';
                $guide_notes = $schedule['guide_notes'] ?? '';
                $num_customers = $schedule['num_customers'] ?? 0; // nếu có dữ liệu số khách
                ?>
                <div class="p-4 border rounded-xl bg-blue-50 hover:bg-blue-100 transition group relative">
                    <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($tour_name) ?> – <?= $num_customers ?> khách</h3>
                    <p class="text-gray-600 text-sm"><?= $start ?> - <?= $end ?> • <?= htmlspecialchars($meeting_point) ?></p>
                    <span class="<?= $status_color ?> font-medium"><?= ucfirst($schedule['schedule_status']) ?></span>

                    <!-- Hover chi tiết -->
                    <div class="absolute left-0 top-full mt-2 w-full p-4 bg-white border rounded-xl shadow-lg opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        <p><strong>Địa điểm tour:</strong> <?= htmlspecialchars($tour_location) ?></p>
                        <p><strong>Thời gian:</strong> <?= $days ?> ngày <?= $nights ?> đêm</p>
                        <p><strong>Điểm gặp:</strong> <?= htmlspecialchars($meeting_point) ?></p>
                        <p><strong>Khách sạn:</strong> <?= htmlspecialchars($hotel) ?></p>
                        <p><strong>Phương tiện:</strong> <?= htmlspecialchars($vehicle) ?></p>
                        <p><strong>Nhà hàng:</strong> <?= htmlspecialchars($restaurant) ?></p>
                        <p><strong>Thông tin bay:</strong> <?= htmlspecialchars($flight_info) ?></p>
                        <?php if ($guide_notes): ?>
                            <p><strong>Ghi chú hướng dẫn:</strong> <?= htmlspecialchars($guide_notes) ?></p>
                        <?php endif; ?>
                        <p><strong>Trạng thái:</strong> <span class="<?= $status_color ?> font-medium"><?= ucfirst($schedule['schedule_status']) ?></span></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
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

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>