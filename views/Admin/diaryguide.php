<main class="flex-1 p-6 space-y-8">

    <!-- HEADER -->
    <header class="bg-white p-6 rounded-2xl shadow flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
            Nhật ký tour & khách
        </h1>
        <img src="https://i.pravatar.cc/40" class="w-12 h-12 rounded-full border shadow-sm">
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
                                <?= $t['tour_name'] ?>
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
                <div class="p-5 rounded-xl border border-gray-200 bg-gray-50 hover:bg-white transition shadow-sm">

                    <h3 class="font-bold text-gray-800 text-lg mb-1">
                        📅 <?= $log['log_date'] ?>
                    </h3>
                    <div class="flex justify-end gap-3 mb-2">

                        <!-- Nút sửa -->
                        <a href="?mode=admin&act=editDiaryGuide&id=<?= $log['id'] ?>"
                            class="px-3 py-1 bg-yellow-500 text-white rounded-lg text-sm hover:bg-yellow-600">
                            Sửa
                        </a>

                        <!-- Nút xóa -->
                        <a href="?mode=admin&act=deleteDiaryGuide&id=<?= $log['id'] ?>"
                            onclick="return confirm('Bạn có chắc muốn xóa nhật ký này?')"
                            class="px-3 py-1 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700">
                            Xóa
                        </a>

                    </div>


                    <p class="text-gray-700 leading-relaxed mb-2">
                        <?= nl2br($log['content']) ?>
                    </p>

                    <p class="text-xs text-gray-400 mb-3">
                        Cập nhật lúc: <?= $log['updated_at'] ?>
                    </p>

                    <?php if (!empty($log['images'])) : ?>
                        <?php $imgs = json_decode($log['images'], true); ?>

                        <div class="flex gap-3 flex-wrap">
                            <?php foreach ($imgs as $img): ?>
                                <img src="<?= BASE_URL . $img ?>" class="w-20 h-20 rounded-xl object-cover border shadow">
                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        </div>


    </section>

</main>