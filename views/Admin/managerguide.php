<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-3">
        <h1 class="text-2xl font-semibold text-slate-900">Danh sách hướng dẫn viên</h1>
        <span class="inline-block bg-slate-100 text-slate-600 px-2 py-0.5 text-sm rounded-full">
            <?= count($guides) ?>
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

<!-- Card / Table container -->
<div class="bg-white border border-slate-200 rounded-lg shadow-sm">

    <!-- Header của bảng -->
    <div class="hidden md:grid grid-cols-12 items-center gap-4 px-6 py-3 border-b border-slate-200 text-slate-600 text-sm font-medium">
        <div class="col-span-1 flex items-center">
            <input type="checkbox" class="h-4 w-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500" />
        </div>
        <div class="col-span-1">ID</div>
        <div class="col-span-4">Tên hướng dẫn viên</div>
        <div class="col-span-4">Email hướng dẫn viên</div>
        <div class="col-span-2 text-right">Cập nhật</div>
    </div>

    <!-- Table body -->
    <div class="divide-y divide-slate-100">

        <?php foreach ($guides as $g): ?>
            <div class="grid grid-cols-12 items-center gap-4 px-6 py-4">

                <!-- Checkbox -->
                <div class="col-span-1">
                    <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                </div>

                <!-- ID -->
                <div class="col-span-1 text-sm text-slate-600">
                    <?= $g['id'] ?>
                </div>

                <!-- Name -->
                <div class="col-span-4 text-sm text-slate-800">
                    <?= htmlspecialchars($g['username']) ?>
                </div>

                <!-- Email -->
                <div class="col-span-4 text-sm text-slate-700">
                    <?= htmlspecialchars($g['email']) ?>
                </div>

                <!-- Updated_at + Menu -->
                <div class="col-span-2 flex items-center justify-end gap-3 text-sm text-slate-500">

                    <span><?= $g['updated_at'] ?></span>

                    <div class="relative">
                        <button type="button"
                            class="p-1 rounded hover:bg-slate-100"
                            data-menu-btn="<?= $g['id'] ?>">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>

                        <!-- Dropdown -->
                        <div class="absolute right-0 mt-2 w-32 bg-white border border-slate-200 rounded-md
                                    shadow-lg text-xs text-slate-700 py-1 hidden"
                            data-menu="<?= $g['id'] ?>">
                            <button class="w-full text-left px-3 py-1.5 hover:bg-slate-50">
                                Chi tiết
                            </button>
                            <button class="w-full text-left px-3 py-1.5 hover:bg-slate-50">
                                Sửa
                            </button>
                            <button class="w-full text-left px-3 py-1.5 text-red-600 hover:bg-red-50">
                                Xóa
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        <?php endforeach; ?>

    </div>

</div>