<div class="p-6">

    <h2 class="text-3xl font-semibold text-dark mb-6">
        📊 Thống kê tour đã hoàn thành
    </h2>

    <div class="bg-white shadow-soft rounded-2xl overflow-hidden border border-gray-200">

        <table class="min-w-full text-left">
            <thead class="bg-main text-white">
                <tr>
                    <th class="px-6 py-4 text-sm font-medium">ID</th>
                    <th class="px-6 py-4 text-sm font-medium">Tên tour</th>
                    <th class="px-6 py-4 text-sm font-medium">Giá</th>
                    <th class="px-6 py-4 text-sm font-medium">Ngày bắt đầu</th>
                    <th class="px-6 py-4 text-sm font-medium">Ngày kết thúc</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">
                <?php if (!empty($completed)): ?>
                    <?php foreach ($completed as $t): ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4"><?= $t['id'] ?></td>

                            <td class="px-6 py-4 font-medium text-dark">
                                <?= $t['name'] ?>
                            </td>

                            <td class="px-6 py-4 font-semibold text-emerald-600">
                                <?= number_format($t['price']) ?> VNĐ
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?= $t['start_date'] ?>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?= $t['end_date'] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            Không có tour nào đã hoàn thành.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
