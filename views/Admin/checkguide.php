<main class="flex-1 p-6 space-y-8 bg-gray-50">

    <!-- HEADER -->
    <header class="bg-white p-6 rounded-2xl shadow flex items-center justify-between border border-gray-100">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📍 Check-in & Điểm danh</h1>
            <p class="text-gray-500 text-sm mt-1">Quản lý khách trong tour bạn đang phụ trách</p>
        </div>
    </header>

    <!-- TOUR HÔM NAY -->
    <section class="bg-white p-6 rounded-2xl shadow border space-y-5 border-gray-100">
        <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
            🚐 Tour hôm nay
        </h2>

        <?php if ($todayTour): ?>
            <div class="p-5 rounded-xl border bg-gray-50 hover:bg-gray-100 transition shadow-sm">
                <div class="flex items-center justify-between">
                    <!-- THÔNG TIN TOUR -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">
                            <?= $todayTour['tour_name'] ?>
                        </h3>

                        <p class="text-gray-500 text-sm mt-1">
                            👥 <span class="font-medium"><?= $todayTour['total_customers'] ?></span> khách tham gia
                        </p>

                        <p class="text-gray-500 text-sm">
                            🕒 Bắt đầu lúc: <span class="font-medium"><?= $todayTour['start_time'] ?? '' ?></span>
                        </p>
                    </div>

                    <!-- NÚT CHECKIN -->
                    <button class="px-5 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 active:scale-95 transition font-medium">
                        Check-in ngay
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="p-4 bg-yellow-50 border-yellow-200 text-yellow-700 border rounded-xl">
                Hôm nay bạn không có tour nào.
            </div>
        <?php endif; ?>
    </section>

    <!-- DANH SÁCH KHÁCH -->
    <section class="bg-white p-6 rounded-2xl shadow border border-gray-100 space-y-6">
        <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
            📝 Danh sách khách
        </h2>

        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
            <table class="w-full text-left">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-4 text-sm font-medium">Tên khách</th>
                        <th class="p-4 text-sm font-medium">Trạng thái</th>
                        <th class="p-4 text-right text-sm font-medium">Điểm danh</th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $c): ?>

                            <!-- Badge trạng thái -->
                            <?php
                            $statusText = $c['status'] == 'present' ? 'Đã đến' : ($c['status'] == 'late' ? 'Đến muộn' : 'Chưa đến');

                            $statusColor = $c['status'] == 'present' ? 'text-green-600 bg-green-50' : ($c['status'] == 'late' ? 'text-orange-600 bg-orange-50' : 'text-gray-600 bg-gray-100');
                            ?>

                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-4 font-medium text-gray-800">
                                    <?= htmlspecialchars($c['customer_name']) ?>
                                </td>

                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium <?= $statusColor ?>">
                                        <?= $statusText ?>
                                    </span>
                                </td>

                                <td class="p-4 text-right">
                                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition active:scale-95">
                                        Cập nhật
                                    </button>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-5 text-center text-gray-500">
                                Không có khách trong tour này.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </section>
</main>