<div class="max-w-[1800px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Đối Tác Nhà cung cấp</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Loại Dịch Vụ</li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3 bg-">
            <h1 class="text-3xl font-[500] text-slate-900 m-0">Loại Dịch Vụ</h1>
            <span class="inline-flex items-center justify-center font-[500] text-white px-2 py-0.5 rounded-full bg-main">
                <?= count($dataSupplierTypes) ?>
            </span>
        </div>

        <div class="flex items-center space-x-3">

            <button class="flex items-center gap-2 px-4 py-2 rounded-md border-[1px_solid_main] text-sm font-[300] bg-main hover:bg-hover text-white transition-all duration-200 ease-out">
                <i class="fa-solid fa-plus"></i>
                Tạo mới
            </button>

            <button class="flex items-center gap-2 px-4 py-2 border rounded-md
                text-sm text-dark hover:bg-main hover:text-white transition-all duration-200 ease-out">
                <i class="fa-solid fa-filter"></i>
                Lọc
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white border border-slate-100 rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50 text-slate-500 text-sm font-medium">
                <tr>
                    <th class="px-6 py-3 text-center w-10">
                        <input type="checkbox" id="selectAll" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID Loại</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Tên loại dịch vụ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Mô tả dịch vụ</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase">Tổng nhà cung cấp</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Cập nhật</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 uppercase w-5">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php if (empty($dataSupplierTypes)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-xs font-medium text-slate-500 uppercase">
                            Không có danh mục nào trong hệ thống.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($dataSupplierTypes as $value): ?>
                        <tr class="hover:bg-slate-50 transition-shadow duration-150">
                            <td class="px-6 py-3 text-center w-10">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                            </td>

                            <td class="px-6 py-4 text-center font-medium text-slate-900">#<?= $value['type_id'] ?></td>

                            <td class="px-6 py-4 font-medium text-slate-900">
                                <?= htmlspecialchars($value['type_name']) ?>
                            </td>

                            <td class="px-6 py-4 truncate max-w-xs text-slate-600 break-words">
                                <?= htmlspecialchars($value['type_description']) ?>
                            </td>

                            <td class="px-6 py-4 text-center font-medium text-slate-900"><?= $value['total_suppliers'] ?></td>

                            <td class="px-6 py-4 text-slate-500">
                                <?= $value['type_updated_at'] ?>
                            </td>

                            <td class="px-6 py-4 text-center relative flex justify-end group">
                                <button class="py-1 px-2 flex items-center justify-center rounded-lg text-slate-600 
                                hover:bg-slate-200 transition duration-150 focus:outline-none">
                                    <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                                </button>

                                <!-- Dropdown actions -->
                                <div class="absolute right-0 top-0 mt-2 w-44 bg-white border border-slate-200 
                                rounded-lg shadow-lg text-sm py-1 
                                opacity-0 invisible 
                                group-hover:opacity-100 group-hover:visible 
                                transition-all duration-200 z-20 overflow-hidden">

                                    <a href="?mode=admin&act=view-supplier-type&id=<?= $value['type_id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-regular fa-eye w-5 mr-3"></i> Chi Tiết
                                    </a>

                                    <a href="?mode=admin&act=edit-supplier-type&id=<?= $value['type_id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-regular fa-pen-to-square w-5 mr-3"></i> Edit
                                    </a>

                                    <a href="?mode=admin&act=delete-supplier-type&id=<?= $value['type_id'] ?>"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa loại dịch vụ này?')"
                                        class="flex items-center px-3 py-2 text-red-600 hover:bg-red-50 transition">
                                        <i class="fa-regular fa-trash-can w-5 mr-3"></i> Xóa
                                    </a>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- JS chọn tất cả -->
    <script>
        const selectAll = document.getElementById('selectAll');
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('tbody input[type="checkbox"]').forEach(cb => cb.checked = this.checked);
        });
    </script>

</div>