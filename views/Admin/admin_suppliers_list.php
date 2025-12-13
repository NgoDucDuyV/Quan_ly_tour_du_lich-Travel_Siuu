<?php
// Chặn lỗi Undefined array key khi ai đó cố gửi POST trực tiếp vào file view
// Nhưng vẫn cho form gửi bình thường tới controller (không trắng trang)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_GET['act'])) {
    header("Location: ?mode=admin&act=supplier-list");
    exit;
}

$model = new SupplierModel();
$dataSupplier = $model->getallSupplier();
$supplierTypes = $model->supplier_types();

// Xử lý modal
$showCreate = isset($_GET['create']);
$editSupplier = null;
if (isset($_GET['edit_id'])) {
    $editId = (int) $_GET['edit_id'];
    $editSupplier = $model->getSupplierById($editId);
}
?>

<div class="max-w-[1800px] mx-auto p-6">

    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-800 mb-4">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Đối Tác Nhà cung cấp</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-500">Nhà cung cấp</li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <h1 class="text-3xl font-[500] text-slate-900 m-0">Danh Sách Nhà Cung Cấp</h1>
            <span
                class="inline-flex items-center justify-center font-[500] text-white px-2 py-0.5 rounded-full bg-main">
                <?= count($dataSupplier) ?>
            </span>
        </div>

        <div class="flex items-center space-x-3">
            <a href="?mode=admin&act=supplier-list&create=1"
                class="flex items-center gap-2 px-4 py-2 rounded-md border border-main bg-main hover:bg-hover text-white transition-all duration-200">
                Tạo mới
            </a>
            <button
                class="flex items-center gap-2 px-4 py-2 border rounded-md text-sm text-dark hover:bg-main hover:text-white transition-all duration-200">
                Lọc
            </button>
        </div>
    </div>

    <!-- Thông báo -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md border border-green-300 text-sm font-medium">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md border border-red-300 text-sm font-medium">
            <?= $_SESSION['error'];
            unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Bảng -->
    <div class="overflow-x-auto bg-white border border-slate-100 rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50 text-slate-500 text-sm font-medium">
                <tr>
                    <th class="px-6 py-3 text-left w-10">
                        <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Tên nhà cung cấp</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Loại dịch vụ</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Người liên hệ</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Số điện thoại</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Địa chỉ</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Cập nhật</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 uppercase w-5">Hành động</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php foreach ($dataSupplier as $s): ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-900">#<?= $s['supplier_id'] ?></td>
                        <td class="px-6 py-4 font-medium text-slate-900">
                            <?= htmlspecialchars($s['supplier_name'] ?? '') ?>
                        </td>
                        <td class="px-6 py-4"><?= htmlspecialchars($s['type_name'] ?? 'Chưa chọn') ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($s['contact_name'] ?? '-') ?></td>
                        <td class="px-6 py-4 text-blue-600 truncate max-w-[200px]">
                            <?= htmlspecialchars($s['contact_email'] ?? '-') ?>
                        </td>
                        <td class="px-6 py-4"><?= htmlspecialchars($s['contact_phone'] ?? '-') ?></td>
                        <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($s['address'] ?? '-') ?></td>
                        <td class="px-6 py-4 text-slate-500">
                            <?= date('d/m/Y H:i', strtotime($s['supplier_updated_at'] ?? $s['supplier_created_at'] ?? 'now')) ?>
                        </td>

                        <td class="px-6 py-4 text-center relative flex justify-end group">
                            <button class="py-1 px-2 rounded-lg text-slate-600 hover:bg-slate-200 transition">
                                <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                            </button>

                            <div
                                class="absolute right-0 top-0 mt-2 w-40 bg-white border border-slate-200 rounded-md shadow-lg text-sm py-1 
                                opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-20">
                                <a href="?mode=admin&act=supplier-list&edit_id=<?= $s['supplier_id'] ?>"
                                    class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                    Edit
                                </a>
                                <a href="?mode=admin&act=delete-supplier&id=<?= $s['supplier_id'] ?>"
                                    onclick="return confirm('Xóa nhà cung cấp này?')"
                                    class="flex items-center px-3 py-2 text-red-600 hover:bg-red-50 transition">
                                    Xóa
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- MODAL TẠO MỚI -->
    <?php if ($showCreate): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
                <h2 class="text-xl font-bold mb-4">Tạo nhà cung cấp mới</h2>
                <form action="?mode=admin&act=add-supplier" method="POST">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Tên nhà cung cấp *</label>
                            <input type="text" name="name" required class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Loại dịch vụ *</label>
                            <select name="supplier_types_id" required class="w-full border rounded px-3 py-2 mt-1">
                                <?php foreach ($supplierTypes as $t): ?>
                                    <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div><label class="block text-sm font-medium mb-1">Người liên hệ</label><input type="text"
                                name="contact_name" class="w-full border rounded px-3 py-2 mt-1"></div>
                        <div><label class="block text-sm font-medium mb-1">Email</label><input type="email"
                                name="contact_email" class="w-full border rounded px-3 py-2 mt-1"></div>
                        <div><label class="block text-sm font-medium mb-1">Số điện thoại</label><input type="text"
                                name="contact_phone" class="w-full border rounded px-3 py-2 mt-1"></div>
                        <div><label class="block text-sm font-medium mb-1">Địa chỉ</label><input type="text" name="address"
                                class="w-full border rounded px-3 py-2 mt-1"></div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Mô tả</label>
                        <textarea name="description" rows="3" class="w-full border rounded px-3 py-2 mt-1"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="?mode=admin&act=supplier-list" class="px-4 py-2 border rounded">Hủy</a>
                        <button type="submit" class="px-4 py-2 bg-main text-white rounded hover:bg-hover">Lưu lại</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- MODAL SỬA – ĐÃ SỬA HOÀN CHỈNH, KHÔNG CÒN LỖI DÒNG 175 NỮA -->
    <?php if ($editSupplier): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
                <h2 class="text-xl font-bold mb-4">Sửa nhà cung cấp</h2>
                <form action="?mode=admin&act=update-supplier" method="POST">
                    <!-- SỬA CHỖ NÀY: thêm ?? '' để tránh lỗi khi supplier_id null (hiếm nhưng vẫn có thể xảy ra) -->
                    <input type="hidden" name="id" value="<?= $editSupplier['supplier_id'] ?? '' ?>">

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Tên nhà cung cấp *</label>
                            <input type="text" name="name"
                                value="<?= htmlspecialchars($editSupplier['supplier_name'] ?? '') ?>" required
                                class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Loại dịch vụ *</label>
                            <select name="supplier_types_id" required class="w-full border rounded px-3 py-2 mt-1">
                                <?php foreach ($supplierTypes as $t): ?>
                                    <option value="<?= $t['id'] ?>" <?= ($t['id'] ?? 0) == ($editSupplier['supplier_types_id'] ?? 0) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($t['name'] ?? '') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Người liên hệ</label>
                            <input type="text" name="contact_name"
                                value="<?= htmlspecialchars($editSupplier['contact_name'] ?? '') ?>"
                                class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input type="email" name="contact_email"
                                value="<?= htmlspecialchars($editSupplier['contact_email'] ?? '') ?>"
                                class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Số điện thoại</label>
                            <input type="text" name="contact_phone"
                                value="<?= htmlspecialchars($editSupplier['contact_phone'] ?? '') ?>"
                                class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Địa chỉ</label>
                            <input type="text" name="address"
                                value="<?= htmlspecialchars($editSupplier['address'] ?? '') ?>"
                                class="w-full border rounded px-3 py-2 mt-1">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Mô tả</label>
                        <textarea name="description" rows="3"
                            class="w-full border rounded px-3 py-2 mt-1"><?= htmlspecialchars($editSupplier['description'] ?? '') ?></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="?mode=admin&act=supplier-list" class="px-4 py-2 border rounded">Hủy</a>
                        <button type="submit" class="px-4 py-2 bg-main text-white rounded hover:bg-hover">Lưu lại</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>