<main class="flex-1 p-6 space-y-8">

    <!-- HEADER -->
    <header class="bg-white p-6 rounded-2xl shadow flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
            Nhật ký tour & khách
        </h1>
    </header>

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- FORM THÊM NHẬT KÝ -->
        <div class="bg-white p-6 rounded-2xl shadow space-y-5 border border-gray-100">

            <h2 class="text-2xl font-semibold text-gray-800 mb-3">
                ➕ Thêm nhật ký tour
            </h2>

            <form action="?mode=admin&act=saveDiaryGuide" method="POST" enctype="multipart/form-data"
                class="space-y-5">

                <div class="space-y-3">
                    <label class="text-gray-600 text-sm font-medium">Chọn tour</label>
                    <select name="schedule_id" class="w-full border rounded-xl px-4 py-3">
                        <option value="">Chọn tour...</option>

                        <?php foreach ($tours as $t): ?>
                            <option value="<?= $t['schedule_id'] ?>">
                                <?= $t['tour_name'] ?> (<?= $t['start_date'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="text-gray-600 text-sm font-medium">Ghi chú nhật ký</label>
                    <textarea name="content" rows="6" class="w-full border border-gray-300 rounded-xl px-4 py-3"
                        placeholder="Mô tả hoạt động, sự kiện, phản hồi..."></textarea>
                </div>

                <div>
                    <label class="text-gray-600 text-sm font-medium">Ảnh tour</label>
                    <input type="file" name="images[]" multiple
                        class="w-full border border-gray-300 rounded-xl px-4 py-2">
                </div>


                <button class="w-full py-3 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700">
                    Lưu nhật ký
                </button>
            </form>

        </div>

        <!-- NHẬT KÝ GẦN ĐÂY -->
        <div class="bg-white p-6 rounded-2xl shadow space-y-5 border border-gray-100
            max-h-[80vh] overflow-y-auto scrollbar-thin 
            scrollbar-thumb-gray-300 scrollbar-track-gray-100">

            <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                📝 Nhật ký gần đây
            </h2>


            <?php if (empty($diary)): ?>
                <p class="text-gray-500 italic">Chưa có nhật ký nào...</p>
            <?php endif; ?>

            <?php foreach ($diary as $log): ?>
                <div class="p-5 rounded-xl border bg-gray-50 shadow-sm">

                    <?php
                    $time = $log['updated_at']
                        ? $log['updated_at']
                        : $log['log_date'];
                    ?>

                    <h3 class="font-bold">
                        <?= date("Y-m-d H:i:s", strtotime($time)) ?>
                    </h3>


                    <p><?= nl2br($log['content']) ?></p>

                    <?php
                    $imgs = json_decode($log['images'], true);
                    if ($imgs):
                    ?>
                        <div class="flex gap-2 mt-2">
                            <?php foreach ($imgs as $img): ?>
                                <img src="<?= BASE_URL . $img ?>" class="w-20 h-20 rounded-xl object-cover">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="mt-2 flex gap-2 justify-end">
                        <a href="?mode=admin&act=editDiaryGuide&id=<?= $log['id'] ?>" class="bg-yellow-500 px-3 py-1 text-white rounded">Sửa</a>
                        <a onclick="return confirm('Xóa?')" href="?mode=admin&act=deleteDiaryGuide&id=<?= $log['id'] ?>" class="bg-red-600 px-3 py-1 text-white rounded">Xóa</a>
                    </div>

                </div>
            <?php endforeach; ?>


        </div>


    </section>

</main>