<main class="flex-1 p-6 space-y-6">

    <header class="bg-white p-5 rounded-xl shadow">
        <h1 class="text-2xl font-semibold text-gray-800">Sửa nhật ký</h1>
    </header>

    <form action="?mode=admin&act=updateDiaryGuide" method="POST" class="bg-white p-6 rounded-xl shadow space-y-5">

        <input type="hidden" name="id" value="<?= $log['id'] ?>">

        <div>
            <label class="text-gray-700 font-medium">Ngày</label>
            <p class="text-gray-500"><?= $log['log_date'] ?></p>
        </div>

        <div>
            <label class="text-gray-700 font-medium">Nội dung</label>
            <textarea name="content" rows="8"
                class="w-full border px-4 py-3 rounded-xl"><?= $log['content'] ?></textarea>
        </div>

        <button class="px-6 py-3 bg-blue-600 text-white rounded-xl text-lg font-semibold hover:bg-blue-700">
            Cập nhật nhật ký
        </button>

    </form>

</main>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>