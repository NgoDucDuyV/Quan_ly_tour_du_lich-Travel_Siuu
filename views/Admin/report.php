<div class="p-6 max-w-7xl mx-auto">

    <!-- Tổng quan -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow border text-center">
            <p class="text-gray-600 text-sm">Tổng booking hoàn thành</p>
            <p class="text-4xl font-bold text-blue-600 mt-2"><?= $totalBookings ?></p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow border text-center">
            <p class="text-gray-600 text-sm">Tổng doanh thu</p>
            <p class="text-4xl font-bold text-emerald-600 mt-2"><?= number_format($totalRevenue) ?> VNĐ</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow border text-center">
            <p class="text-gray-600 text-sm">Trung bình/booking</p>
            <p class="text-4xl font-bold text-purple-600 mt-2">
                <?= $totalBookings > 0 ? number_format(round($totalRevenue / $totalBookings)) : 0 ?> VNĐ
            </p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow border text-center">
            <p class="text-gray-600 text-sm">Tour kết thúc gần nhất</p>
            <p class="text-2xl font-bold mt-2">
                <?= !empty($completedBookings) ? date('d/m/Y', strtotime($completedBookings[0]['end_date'])) : '--' ?>
            </p>
        </div>
    </div>

    <h2 class="text-3xl font-bold mb-6">Danh sách booking đã hoàn thành</h2>

    <div class="bg-white rounded-2xl shadow border overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                <tr>
                    <th class="px-6 py-4 text-left">Mã booking</th>
                    <th class="px-6 py-4 text-left">Khách hàng</th>
                    <th class="px-6 py-4 text-left">Tour</th>
                    <th class="px-6 py-4 text-right">Giá tiền</th>
                    <th class="px-6 py-4 text-center">Khởi hành</th>
                    <th class="px-6 py-4 text-center">Kết thúc</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php if (!empty($completedBookings)): ?>
                    <?php foreach ($completedBookings as $b): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium"><?= htmlspecialchars($b['booking_code']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($b['customer_name']) ?></td>
                            <td class="px-6 py-4 font-medium"><?= htmlspecialchars($b['tour_name']) ?></td>
                            <td class="px-6 py-4 text-right font-bold text-emerald-600">
                                <?= number_format($b['price']) ?> VNĐ
                            </td>
                            <td class="px-6 py-4 text-center"><?= date('d/m/Y', strtotime($b['start_date'])) ?></td>
                            <td class="px-6 py-4 text-center"><?= date('d/m/Y', strtotime($b['end_date'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-12 text-gray-500 text-lg">
                            Chưa có booking nào hoàn thành
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>