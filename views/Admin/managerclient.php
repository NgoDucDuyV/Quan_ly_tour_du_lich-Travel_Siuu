<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-3">
        <h1 class="text-2xl font-semibold text-slate-900">Danh sách khách hàng</h1>
        <span class="inline-block bg-slate-100 text-slate-600 px-2 py-0.5 text-sm rounded-full">
            <?= count($clients) ?>
        </span>
    </div>

    <div class="flex items-center space-x-3">
        <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-md text-sm text-slate-600 bg-white hover:bg-slate-50">
            Lọc
        </button>
        <button class="flex items-center gap-2 px-4 py-2 bg-white border border-indigo-600 text-indigo-600 rounded-md text-sm hover:bg-indigo-50">
            Tạo mới
        </button>
    </div>
</div>

<!-- Table container -->
<div class="bg-white border border-slate-200 rounded-lg shadow-sm">

    <!-- Table header -->
    <div class="hidden md:grid grid-cols-12 items-center gap-4 px-6 py-3 border-b border-slate-200 text-slate-600 text-sm font-medium">
        <div class="col-span-1"><input type="checkbox" /></div>
        <div class="col-span-1">ID</div>
        <div class="col-span-4">Tên khách hàng</div>
        <div class="col-span-4">Email</div>
        <div class="col-span-2 text-right">Cập nhật</div>
    </div>

    <!-- Table body -->
    <div class="divide-y divide-slate-100">
        <?php foreach ($clients as $c): ?>
            <div class="grid grid-cols-12 items-center gap-4 px-6 py-4">
                <div class="col-span-1"><input type="checkbox" /></div>

                <div class="col-span-1 text-sm text-slate-600"><?= $c['id'] ?></div>

                <div class="col-span-4 text-sm text-slate-800"><?= htmlspecialchars($c['username']) ?></div>

                <div class="col-span-4 text-sm text-slate-700"><?= htmlspecialchars($c['email']) ?></div>

                <div class="col-span-2 flex items-center justify-end gap-3 text-sm text-slate-500">
                    <span><?= $c['updated_at'] ?></span>
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </div>
                
            </div>
        <?php endforeach; ?>
    </div>
</div>