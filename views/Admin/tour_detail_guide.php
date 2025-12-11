<main class="flex-1 p-8 space-y-8 bg-slate-100 rounded-2xl">

    <!-- ===== HEADER ===== -->
    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <h1 class="text-3xl font-bold text-slate-800 flex items-center gap-2">
            <i data-lucide="compass" class="w-7 h-7 text-indigo-600"></i>
            Lịch Trình: <?= htmlspecialchars($scheduleData['tour_name'] ?? 'N/A') ?>
        </h1>
        <a href="?mode=admin&act=scheduleguide"
            class="flex items-center gap-1 text-indigo-600 hover:text-indigo-800 
                bg-indigo-50 px-4 py-2 rounded-xl transition font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Quay lại
        </a>
    </div>

    <!-- ===== INFO CARD ===== -->
    <section class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-indigo-500 space-y-4">
        <h2 class="text-xl font-semibold text-indigo-700 flex items-center gap-2">
            <i data-lucide="info" class="w-5 h-5"></i>
            Thông tin chung
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
            <p class="bg-slate-50 p-3 rounded-xl border">
                <span class="font-semibold text-slate-700">Mã Tour:</span>
                <?= htmlspecialchars($scheduleData['tour_code'] ?? 'N/A') ?>
            </p>

            <p class="bg-slate-50 p-3 rounded-xl border">
                <span class="font-semibold text-slate-700">Ngày đi:</span>
                <?= date('d/m/Y', strtotime($scheduleData['start_date'])) ?>
            </p>

            <p class="bg-slate-50 p-3 rounded-xl border">
                <span class="font-semibold text-slate-700">Ngày về:</span>
                <?= date('d/m/Y', strtotime($scheduleData['end_date'])) ?>
            </p>

            <p class="bg-slate-50 p-3 rounded-xl border">
                <span class="font-semibold text-slate-700">Thời gian:</span>
                <?= $scheduleData['days'] ?>N / <?= $scheduleData['nights'] ?>Đ
            </p>

            <p class="bg-slate-50 p-3 rounded-xl border col-span-2">
                <span class="font-semibold text-slate-700">Khách sạn:</span>
                <?= htmlspecialchars($scheduleData['hotel'] ?? 'Chưa có') ?>
            </p>

            <p class="bg-slate-50 p-3 rounded-xl border col-span-2">
                <span class="font-semibold text-slate-700">Phương tiện:</span>
                <?= htmlspecialchars($scheduleData['vehicle'] ?? 'N/A') ?>
            </p>
        </div>

        <?php if (!empty($scheduleData['guide_notes'])): ?>
            <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl text-sm flex gap-2 items-start">
                <i data-lucide="alert-circle" class="w-5 h-5 text-amber-600 mt-1"></i>
                <div>
                    <span class="font-semibold text-amber-800">Ghi chú điều hành:</span><br>
                    <span class="text-amber-700">
                        <?= nl2br(htmlspecialchars($scheduleData['guide_notes'])) ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <!-- ===== ITINERARY ===== -->
    <section class="space-y-8">
        <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
            <i data-lucide="route" class="w-6 h-6 text-green-600"></i>
            Hành trình chi tiết
        </h2>

        <?php foreach ($itineraries as $day_number => $itinerary): ?>
            <div class="bg-white p-6 rounded-2xl shadow-md space-y-4">
                <h3 class="text-xl font-bold text-blue-600 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                    <?= htmlspecialchars($itinerary['title']) ?>
                    <span class="text-sm font-normal text-slate-500">(Ngày <?= $day_number ?>)</span>
                </h3>

                <p class="text-slate-600 italic pl-6">
                    <?= nl2br(htmlspecialchars($itinerary['description'])) ?>
                </p>

                <!-- Timeline -->
                <div class="relative border-l-4 border-green-300 pl-10 space-y-4">
                    <?php foreach ($itinerary['activities'] as $activity): ?>
                        <div class="relative bg-slate-50 border rounded-xl p-4 hover:shadow-md transition">

                            <!-- Dot -->
                            <div class="absolute -left-[28px] top-4 w-6 h-6 rounded-full bg-green-500 flex items-center justify-center border-4 border-white shadow">
                                <i data-lucide="clock" class="w-3 h-3 text-white"></i>
                            </div>

                            <p class="font-semibold text-slate-800">
                                [<?= date('H:i', strtotime($activity['time'])) ?>]
                                <?= htmlspecialchars($activity['name']) ?>
                            </p>

                            <p class="text-sm text-slate-600">
                                📍 <span class="font-medium">
                                    <?= htmlspecialchars($activity['location'] ?? 'Chưa xác định') ?>
                                </span>
                            </p>

                            <?php if (!empty($activity['description'])): ?>
                                <p class="text-xs text-slate-500 mt-1 italic">
                                    Ghi chú: <?= htmlspecialchars($activity['description']) ?>
                                </p>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

</main>