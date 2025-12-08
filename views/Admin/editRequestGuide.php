<main class="flex-1 p-6 space-y-6">

    <header class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Sửa yêu cầu</h1>
    </header>

    <form action="?mode=admin&act=updateRequestGuide" method="POST" enctype="multipart/form-data"
        class="bg-white p-6 rounded-xl shadow space-y-4">

        <input type="hidden" name="id" value="<?= $req['id'] ?>">
        <input type="hidden" name="old_attachment" value="<?= $req['attachment'] ?>">

        <div>
            <label>Tiêu đề yêu cầu</label>
            <input name="title" value="<?= htmlspecialchars($req['title']) ?>"
                class="w-full border rounded-lg px-3 py-2 mt-1">
        </div>

        <div>
            <label>Loại yêu cầu</label>
            <input type="text" value="<?= htmlspecialchars($req['request_type']) ?>"
                class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-100" disabled>
        </div>

        <div>
            <label>Ngày mong muốn</label>
            <input type="date" name="desired_date" value="<?= $req['desired_date'] ?>"
                class="w-full border rounded-lg px-3 py-2 mt-1">
        </div>

        <div>
            <label>Mức độ ưu tiên</label>
            <select name="priority" class="w-full border rounded-lg px-3 py-2 mt-1">
                <option value="low" <?= $req['priority'] == "low" ? "selected" : "" ?>>Thấp</option>
                <option value="medium" <?= $req['priority'] == "medium" ? "selected" : "" ?>>Trung bình</option>
                <option value="high" <?= $req['priority'] == "high" ? "selected" : "" ?>>Cao</option>
                <option value="urgent" <?= $req['priority'] == "urgent" ? "selected" : "" ?>>Khẩn cấp</option>
            </select>
        </div>

        <div>
            <label>Nội dung chi tiết</label>
            <textarea name="content" rows="4"
                class="w-full border rounded-lg px-3 py-2 mt-1"><?= htmlspecialchars($req['content']) ?></textarea>
        </div>

        <div>
            <label>File đính kèm mới</label>
            <input type="file" name="attachment" class="w-full border rounded-lg px-3 py-2 mt-1">

            <?php if ($req['attachment']): ?>
                <p class="text-sm text-gray-500 mt-1">
                    File hiện tại: <a href="<?= $req['attachment'] ?>" target="_blank" class="text-blue-600 underline">
                        Xem file
                    </a>
                </p>
            <?php endif; ?>
        </div>
        <button class="px-6 py-2 bg-blue-600 text-white rounded-lg">Cập nhật</button>
    </form>
</main>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>