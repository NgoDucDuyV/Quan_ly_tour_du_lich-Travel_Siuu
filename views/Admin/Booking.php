<div class="max-w-[1800px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý booking</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Booking</li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-semibold text-slate-900">Danh mục Tour</h1>
            <span class="inline-block bg-slate-100 text-slate-600 px-2 py-0.5 text-sm rounded-full">
                <?= count($categories) ?>
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

    <!-- Table -->
    <div class="overflow-x-auto bg-white border border-slate-100 rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50 text-slate-500 text-sm font-medium">
                <tr>
                    <th class="px-6 py-3 text-left w-10">
                        <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                    </th>
                    <th class="px-6 py-3 text-left w-16">ID</th>
                    <th class="px-6 py-3 text-left">Tên danh mục</th>
                    <th class="px-6 py-3 text-left">Mô tả</th>
                    <th class="px-6 py-3 text-left">Số lượng tour</th>
                    <th class="px-6 py-3 text-right w-36">Cập nhật</th>
                    <th class="px-6 py-3 text-right w-36">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-slate-500 text-center">
                            Không có danh mục nào trong hệ thống.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $value): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                            </td>
                            <td class="px-6 py-4"><?= $value['id'] ?></td>
                            <td class="px-6 py-4"><?= $value['name'] ?></td>
                            <td class="px-6 py-4 truncate max-w-xs"><?= $value['description'] ?></td>
                            <th class="px-6 py-3 text-left"><?= $value['total_tours'] ?></th>
                            <td class="px-6 py-4 text-right"><?= $value['updated_at'] ?></td>
                            <th class="px-6 py-3 text-right w-36">
                                :
                            </th>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>