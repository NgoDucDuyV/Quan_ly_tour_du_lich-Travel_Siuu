<main class="flex-1 p-6 space-y-6">

    <header class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Nhật ký tour & khách</h1>
        <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full border">
    </header>

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Form thêm nhật ký -->
        <div class="bg-white p-5 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Thêm nhật ký</h2>

            <select class="w-full border rounded-lg px-3 py-2">
                <option>Chọn tour...</option>
            </select>

            <textarea rows="5" class="w-full border rounded-lg px-3 py-2" placeholder="Ghi chú..."></textarea>

            <button class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Lưu nhật ký</button>
        </div>

        <!-- Danh sách nhật ký -->
        <div class="bg-white p-5 rounded-xl shadow space-y-3">

            <h2 class="text-xl font-semibold">Nhật ký gần đây</h2>

            <?php foreach ($logs as $log): ?>
                <div class="p-4 border rounded-lg hover:bg-gray-50">

                    <h3 class="font-semibold text-gray-800">
                        Nhật ký ngày <?= $log['log_date'] ?>
                    </h3>

                    <p class="text-gray-600 text-sm">
                        <?= nl2br($log['content']) ?>
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        Cập nhật: <?= $log['updated_at'] ?>
                    </p>

                    <?php if (!empty($log['images'])) : ?>
                        <?php $imgs = json_decode($log['images'], true); ?>
                        <div class="flex gap-2 mt-2">
                            <?php foreach ($imgs as $img): ?>
                                <img src="<?= $img ?>" class="w-16 h-16 rounded-lg object-cover border">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        </div>

    </section>

</main>
