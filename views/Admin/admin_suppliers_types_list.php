<?php
// === XỬ LÝ MODAL THÊM / SỬA TRONG CÙNG TRANG ===
$showCreate = isset($_GET['create']);
$showEdit = false;
$editType = null;

// Xử lý khi bấm Edit
if (isset($_GET['edit_id'])) {
    $editId = (int)$_GET['edit_id'];
    $editType = (new SupplierModel())->getSupplierTypeById($editId);
    $showEdit = $editType ? true : false;
}
?>

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
        <div class="flex items-center space-x-3">
            <h1 class="text-3xl font-[500] text-slate-900 m-0">Loại Dịch Vụ</h1>
            <span class="inline-flex items-center justify-center font-[500] text-white px-2 py-0.5 rounded-full bg-main">
                <?= count($dataSupplierTypes) ?>
            </span>
        </div>

        <div class="flex items-center space-x-3">
            <!-- Nút Tạo mới -->
            <a href="?mode=admin&act=supplier-list-types&create=1" 
               class="flex items-center gap-2 px-4 py-2 rounded-md bg-main hover:bg-hover text-white transition-all duration-200 ease-out">
                Tạo mới
            </a>

            <button class="flex items-center gap-2 px-4 py-2 border rounded-md text-sm text-dark hover:bg-main hover:text-white transition-all duration-200 ease-out">
                Lọc
            </button>
        </div>
    </div>

    <!-- Thông báo -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md border border-green-300 text-sm font-medium">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md border border-red-300 text-sm font-medium">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Table (giữ nguyên hoàn toàn của bạn, chỉ sửa link Edit) -->
    <div class="overflow-x-auto bg-white border border-slate-100 rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50 text-slate-500 text-sm font-medium">
                <tr>
                    <th class="px-6 py-3 text-center w-10">
                        <input type="checkbox" id="selectAll" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
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
                            <td class="px-6 py-4 font-medium text-slate-900"><?= htmlspecialchars($value['name']) ?></td>
                            <td class="px-6 py-4 truncate max-w-xs text-slate-600 break-words">
                                <?= htmlspecialchars($value['description'] ?? 'Không có mô tả') ?>
                            </td>
                            <td class="px-6 py-4 text-center font-medium text-yellow-500">
                                <?php for ($i = 0; $i < $value['stars']; $i++) echo '★'; ?>
                                <?php for ($i = $value['stars']; $i < 5; $i++) echo '☆'; ?>
                            </td>
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
                            <td class="px-6 py-4 text-center font-medium text-slate-900"><?= $value['total_suppliers'] ?></td>
                            <td class="px-6 py-4 text-center font-medium text-slate-900"><?= $value['total_tour'] ?></td>
                            <td class="px-6 py-4 text-slate-500"><?= $value['updated_at'] ?></td>

                            <td class="px-6 py-4 text-center relative flex justify-end group">
                                <button class="py-1 px-2 flex items-center justify-center rounded-lg text-slate-600 hover:bg-slate-200 transition duration-150">
                                    <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                                </button>

                                <div class="absolute right-0 top-0 mt-2 w-44 bg-white border border-slate-200 rounded-lg shadow-lg text-sm py-1 
                                    opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-20 overflow-hidden">

                                    <a href="?mode=admin&act=view-supplier-type&id=<?= $value['id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        Chi Tiết
                                    </a>

                                    <!-- Link Edit → mở modal sửa -->
                                    <a href="?mode=admin&act=supplier-list-types&edit_id=<?= $value['id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        Edit
                                    </a>

                                    <a href="?mode=admin&act=delete-supplier-type&id=<?= $value['id'] ?>"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa loại dịch vụ này?')"
                                        class="flex items-center px-3 py-2 text-red-600 hover:bg-red-50 transition">
                                        Xóa
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- ================== MODAL TẠO MỚI ================== -->
    <?php if ($showCreate): ?>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h2 class="text-xl font-semibold text-slate-900 mb-5">Tạo loại dịch vụ mới</h2>
            <form action="?mode=admin&act=add-supplier-type" method="POST">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tên loại dịch vụ *</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-main">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Mô tả</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-md"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Số sao</label>
                            <select name="stars" class="w-full px-3 py-2 border border-slate-300 rounded-md">
                                <?php for($i=0; $i<=5; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?> sao</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Chất lượng</label>
                            <select name="quality" class="w-full px-3 py-2 border border-slate-300 rounded-md">
                                <option value="Tốt">Tốt</option>
                                <option value="Rất tốt">Rất tốt</option>
                                <option value="Xuất sắc">Xuất sắc</option>
                                <option value="Trung bình">Trung bình</option>
                                <option value="Kém">Kém</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <a href="?mode=admin&act=supplier-list-types" class="px-4 py-2 border border-slate-300 rounded-md text-slate-600 hover:bg-slate-50">Hủy</a>
                    <button type="submit" class="px-4 py-2 bg-main text-white rounded-md hover:bg-hover">Tạo mới</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================== MODAL SỬA ================== -->
    <?php if ($showEdit && $editType): ?>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h2 class="text-xl font-semibold text-slate-900 mb-5">Sửa loại dịch vụ #<?= $editType['id'] ?></h2>
            <form action="?mode=admin&act=update-supplier-type" method="POST">
                <input type="hidden" name="id" value="<?= $editType['id'] ?>">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tên loại dịch vụ *</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($editType['name']) ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Mô tả</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-md"><?= htmlspecialchars($editType['description'] ?? '') ?></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Số sao</label>
                            <select name="stars" class="w-full px-3 py-2 border border-slate-300 rounded-md">
                                <?php for($i=0; $i<=5; $i++): ?>
                                    <option value="<?= $i ?>" <?= $editType['stars'] == $i ? 'selected' : '' ?>><?= $i ?> sao</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Chất lượng</label>
                            <select name="quality" class="w-full px-3 py-2 border border-slate-300 rounded-md">
                                <?php foreach(['Tốt','Rất tốt','Xuất sắc','Trung bình','Kém'] as $q): ?>
                                    <option value="<?= $q ?>" <?= $editType['quality'] === $q ? 'selected' : '' ?>><?= $q ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <a href="?mode=admin&act=supplier-list-types" class="px-4 py-2 border border-slate-300 rounded-md text-slate-600 hover:bg-slate-50">Hủy</a>
                    <button type="submit" class="px-4 py-2 bg-main text-white rounded-md hover:bg-hover">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- JS chọn tất cả -->
    <script>
        const selectAll = document.getElementById('selectAll');
        selectAll?.addEventListener('change', function() {
            document.querySelectorAll('tbody input[type="checkbox"]').forEach(cb => cb.checked = this.checked);
        });
    </script>
</div>