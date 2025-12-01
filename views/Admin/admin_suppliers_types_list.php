<?php
$msg = $_GET['msg'] ?? null;
$error = $_GET['error'] ?? null;
?>

<?php if ($msg === 'created'): ?>
    <div class="max-w-[1800px] mx-auto px-6 pt-4">
        <div class="mb-4 rounded-md bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
            ✅ Thêm loại dịch vụ thành công.
        </div>
    </div>
<?php elseif ($msg === 'updated'): ?>
    <div class="max-w-[1800px] mx-auto px-6 pt-4">
        <div class="mb-4 rounded-md bg-blue-50 border border-blue-200 px-4 py-3 text-sm text-blue-700">
            ✅ Cập nhật loại dịch vụ thành công.
        </div>
    </div>
<?php elseif ($msg === 'deleted'): ?>
    <div class="max-w-[1800px] mx-auto px-6 pt-4">
        <div class="mb-4 rounded-md bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
            ✅ Xoá loại dịch vụ thành công.
        </div>
    </div>
<?php endif; ?>

<?php if ($error === 'empty_name'): ?>
    <div class="max-w-[1800px] mx-auto px-6 pt-2">
        <div class="mb-4 rounded-md bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
            ⚠️ Tên loại dịch vụ không được để trống.
        </div>
    </div>
<?php elseif ($error === 'invalid_data'): ?>
    <div class="max-w-[1800px] mx-auto px-6 pt-2">
        <div class="mb-4 rounded-md bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
            ⚠️ Dữ liệu không hợp lệ, vui lòng thử lại.
        </div>
    </div>
<?php endif; ?>

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
            <span
                class="inline-flex items-center justify-center font-[500] text-white px-2 py-0.5 rounded-full bg-main">
                <?= count($dataSupplierTypes) ?>
            </span>
        </div>

        <div class="flex items-center space-x-3">

            <button
                class="flex items-center gap-2 px-4 py-2 rounded-md border-[1px_solid_main] text-sm font-[300] bg-main hover:bg-hover text-white transition-all duration-200 ease-out">
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
                        <input type="checkbox" id="selectAll"
                            class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID Loại</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Tên loại dịch vụ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Mô tả dịch vụ</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase">Stars</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase">Chất lượng</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase">Tổng nhà cung cấp</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase">Tổng tour</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Cập nhật</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase w-5">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php if (empty($dataSupplierTypes)): ?>
                    <tr>
                        <td colspan="10" class="px-6 py-4 text-center text-xs font-medium text-slate-500 uppercase">
                            Không có danh mục nào trong hệ thống.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($dataSupplierTypes as $value): ?>
                        <tr class="hover:bg-slate-50 transition-shadow duration-150">
                            <td class="px-6 py-3 text-center w-10">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                            </td>

                            <td class="px-6 py-4 text-center font-medium text-slate-900">#<?= $value['id'] ?></td>

                            <td class="px-6 py-4 font-medium text-slate-900">
                                <?= htmlspecialchars($value['name']) ?>
                            </td>

                            <td class="px-6 py-4 truncate max-w-xs text-slate-600 break-words">
                                <?= htmlspecialchars($value['description']) ?>
                            </td>

                            <!-- Stars -->
                            <td class="px-6 py-4 text-center font-medium text-yellow-500">
                                <?php for ($i = 0; $i < $value['stars']; $i++)
                                    echo '★'; ?>
                                <?php for ($i = $value['stars']; $i < 5; $i++)
                                    echo '☆'; ?>
                            </td>

                            <!-- Quality -->
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 text-xs rounded-full 
                            <?= match ($value['quality']) {
                                'Xuất sắc' => 'bg-green-200 text-green-800',
                                'Rất tốt' => 'bg-blue-200 text-blue-800',
                                'Tốt' => 'bg-indigo-200 text-indigo-800',
                                'Trung bình' => 'bg-yellow-200 text-yellow-800',
                                'Kém' => 'bg-red-200 text-red-800',
                                default => 'bg-gray-200 text-gray-800'
                            } ?>">
                                    <?= $value['quality'] ?>
                                </span>
                            </td>

                            <!-- Tổng nhà cung cấp -->
                            <td class="px-6 py-4 text-center font-medium text-slate-900"><?= $value['total_suppliers'] ?></td>

                            <!-- Tổng tour -->
                            <td class="px-6 py-4 text-center font-medium text-slate-900"><?= $value['total_tour'] ?></td>

                            <td class="px-6 py-4 text-slate-500"><?= $value['updated_at'] ?></td>

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

                                    <a href="?mode=admin&act=view-supplier-type&id=<?= $value['id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-regular fa-eye w-5 mr-3"></i> Chi Tiết
                                    </a>

                                    <a href="?mode=admin&act=edit-supplier-type&id=<?= $value['id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-regular fa-pen-to-square w-5 mr-3"></i> Edit
                                    </a>

                                    <a href="?mode=admin&act=delete-supplier-type&id=<?= $value['id'] ?>"
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

    <!-- FORM THÊM LOẠI DỊCH VỤ MỚI -->
    <div class="mt-8 bg-white border border-slate-100 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-main/10 text-main text-sm font-semibold">
                    +
                </span>
                <h2 class="text-base font-[500] text-slate-900">
                    Thêm loại dịch vụ mới
                </h2>
            </div>
        </div>

        <form action="<?= BASE_URL ?>?mode=admin&act=supplier-type-create" method="post" class="px-6 py-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Tên loại dịch vụ -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Tên loại dịch vụ <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="VD: Khách sạn, Nhà hàng...">
                </div>

                <!-- Stars -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Số sao (0-5)
                    </label>
                    <input type="number" name="stars" min="0" max="5"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="VD: 4">
                </div>

                <!-- Quality -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Chất lượng
                    </label>
                    <select name="quality"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none">
                        <option value="Xuất sắc">Xuất sắc</option>
                        <option value="Rất tốt">Rất tốt</option>
                        <option value="Tốt" selected>Tốt</option>
                        <option value="Trung bình">Trung bình</option>
                        <option value="Kém">Kém</option>
                    </select>
                </div>
            </div>

            <!-- Mô tả -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Mô tả dịch vụ
                </label>
                <textarea name="description" rows="3"
                    class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                    placeholder="Mô tả chi tiết về loại dịch vụ..."></textarea>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-main text-white text-sm font-medium hover:bg-hover transition-all duration-150">
                    <i class="fa-solid fa-plus"></i>
                    Thêm loại dịch vụ
                </button>
            </div>
        </form>
    </div>

    <!-- JS chọn tất cả -->
    <script>
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function () {
                document.querySelectorAll('tbody input[type="checkbox"]').forEach(cb => cb.checked = this.checked);
            });
        }
    </script>

</div>