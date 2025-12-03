<main class="flex-1 p-6 space-y-8">

    <!-- HEADER -->
    <header class="bg-white p-6 rounded-2xl shadow flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
            Yêu cầu đặc biệt
        </h1>
    </header>

    <!-- GRID 2 CỘT -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start justify-center">

        <!-- FORM GỬI YÊU CẦU -->
        <div class="bg-white p-6 rounded-2xl shadow space-y-5 border border-gray-100 
                    w-full mx-auto max-w-[600px]">

            <h2 class="text-2xl font-semibold text-gray-800 mb-3">
                ➕ Gửi yêu cầu mới
            </h2>

            <form action="?mode=admin&act=saveRequestGuide" method="POST" enctype="multipart/form-data"
                class="space-y-5">

                <div>
                    <label class="text-sm text-gray-600 font-medium">Tiêu đề yêu cầu</label>
                    <input name="title" class="w-full border rounded-xl px-4 py-3 mt-1" required>
                </div>

                <div>
                    <label class="text-sm text-gray-600 font-medium">Loại yêu cầu</label>
                    <select name="request_type" class="w-full border rounded-xl px-4 py-3 mt-1">
                        <option value="Xin nghỉ phép">Xin nghỉ phép</option>
                        <option value="Đổi tour">Đổi tour</option>
                        <option value="Xin hỗ trợ khách">Xin hỗ trợ khách</option>
                        <option value="Bổ sung thiết bị">Bổ sung thiết bị</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-600 font-medium">Ngày mong muốn</label>
                    <input type="date" name="desired_date"
                        class="w-full border rounded-xl px-4 py-3 mt-1">
                </div>

                <div>
                    <label class="text-sm text-gray-600 font-medium">Mức độ ưu tiên</label>
                    <select name="priority" class="w-full border rounded-xl px-4 py-3 mt-1">
                        <option value="low">Thấp</option>
                        <option value="medium">Trung bình</option>
                        <option value="high">Cao</option>
                        <option value="urgent">Khẩn cấp</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-600 font-medium">Nội dung</label>
                    <textarea name="content" rows="5"
                        class="w-full border rounded-xl px-4 py-3"
                        placeholder="Mô tả yêu cầu..."></textarea>
                </div>

                <div>
                    <label class="text-sm text-gray-600 font-medium">Tệp đính kèm (nếu có)</label>
                    <input type="file" name="attachment"
                        class="w-full border rounded-xl px-4 py-2">
                </div>

                <button
                    class="w-full py-3 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700">
                    Gửi yêu cầu
                </button>
            </form>

        </div>

        <!-- DANH SÁCH YÊU CẦU -->
        <div class="bg-white p-6 rounded-2xl shadow space-y-5 border border-gray-100 
            max-h-[calc(100vh-220px)] overflow-y-auto scrollbar-thin 
            scrollbar-thumb-gray-300 scrollbar-track-gray-100 
            w-full mx-auto max-w-[600px]">


            <div class="flex items-center justify-between mb-2">
                <h2 class="text-2xl font-semibold text-gray-800">📌 Yêu cầu đã gửi</h2>

                <a href="?mode=admin&act=requestguide_all"
                    class="text-blue-600 hover:underline text-sm">
                    Xem tất cả
                </a>
            </div>

            <?php if (empty($requests)): ?>
                <p class="text-gray-500 italic">Chưa có yêu cầu nào...</p>
            <?php endif; ?>

            <?php foreach ($requests as $req): ?>
                <div class="p-5 rounded-xl border bg-gray-50 shadow-sm">

                    <div class="flex justify-between items-start gap-4">
                        <!-- LEFT -->
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-800">
                                <?= htmlspecialchars($req['title']) ?>
                            </h3>

                            <p class="text-gray-600 text-sm mt-1">
                                <?= nl2br($req['content']) ?>
                            </p>

                            <p class="text-gray-400 text-xs mt-2">
                                Gửi lúc <?= date("H:i d/m/Y", strtotime($req['created_at'])) ?>
                            </p>
                        </div>

                        <!-- STATUS -->
                        <?php
                        $status = $req['status'];
                        $color = [
                            'pending'   => 'bg-yellow-100 text-yellow-700',
                            'approved'  => 'bg-green-100 text-green-700',
                            'processing' => 'bg-blue-100 text-blue-700',
                            'rejected'  => 'bg-red-100 text-red-700',
                        ][$status];
                        ?>
                        <span class="px-3 py-1 rounded-full text-sm <?= $color ?>">
                            <?= ucfirst($status) ?>
                        </span>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-3 flex justify-end gap-2">
                        <a href="?mode=admin&act=editRequestGuide&id=<?= $req['id'] ?>"
                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Sửa
                        </a>

                        <a href="?mode=admin&act=deleteRequestGuide&id=<?= $req['id'] ?>"
                            onclick="return confirm('Bạn chắc chắn muốn xóa?')"
                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                            Xóa
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    </section>

</main>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>