<main class="flex-1 p-6 space-y-6">

    <!-- Header -->
    <header class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Check-in & Điểm danh</h1>
        <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full border">
    </header>

    <!-- Tour hôm nay -->
    <section class="bg-white p-5 rounded-xl shadow space-y-3">
        <h2 class="text-xl font-semibold text-gray-700">Tour hôm nay</h2>

        <?php if ($todayTour): ?>
            <div class="p-4 border rounded-lg flex items-center justify-between hover:bg-gray-50">
                <div>
                    <h3 class="text-gray-800 font-semibold">
                        <?= $todayTour['tour_name'] ?> – <?= $todayTour['total_customers'] ?> khách
                    </h3>
                    <p class="text-gray-500 text-sm">
                        Bắt đầu lúc <?= $todayTour['start_time'] ?? '' ?>
                    </p>
                </div>

                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Check-in ngay
                </button>
            </div>

        <?php else: ?>
            <p class="text-gray-500">Hôm nay bạn không có tour nào.</p>
        <?php endif; ?>

    </section>


    <!-- Danh sách khách -->
    <section class="bg-white p-5 rounded-xl shadow space-y-4">
        <h2 class="text-xl font-semibold text-gray-700">Danh sách khách</h2>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100 text-gray-600">
                    <th class="p-3">Tên khách</th>
                    <th class="p-3">Trạng thái</th>
                    <th class="p-3 text-right">Điểm danh</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $c): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3"><?= htmlspecialchars($c['customer_name']) ?></td>
                            <td class="p-3 font-medium
                    <?= $c['status'] == 'present' ? 'text-green-600' : ($c['status'] == 'late' ? 'text-orange-600' : 'text-yellow-600') ?>">
                                <?= $c['status'] == 'present' ? 'Đã đến' : ($c['status'] == 'late' ? 'Đến muộn' : 'Chưa đến') ?>
                            </td>
                            <td class="p-3 text-right text-blue-600 cursor-pointer hover:underline">
                                Cập nhật
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="p-3 text-center text-gray-500">Không có khách trong tour này.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>

    </section>

</main>