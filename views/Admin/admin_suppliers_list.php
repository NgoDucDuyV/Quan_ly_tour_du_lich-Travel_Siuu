<?php
// Lấy thông báo (nếu có)
$msg = $_GET['msg'] ?? null;
$error = $_GET['error'] ?? null;

// Lấy danh sách loại dịch vụ để dùng cho form tạo mới
$supplierTypes = (new SupplierModel())->supplier_types();
?>

<?php if ($msg === 'created'): ?>
    <div class="max-w-[1800px] mx-auto px-6 pt-4">
        <div class="mb-4 rounded-md bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
            ✅ Thêm nhà cung cấp thành công.
        </div>
    </div>
<?php elseif ($msg === 'updated'): ?>
    <div class="max-w-[1800px] mx-auto px-6 pt-4">
        <div class="mb-4 rounded-md bg-blue-50 border border-blue-200 px-4 py-3 text-sm text-blue-700">
            ✅ Cập nhật nhà cung cấp thành công.
        </div>
    </div>
<?php elseif ($msg === 'deleted'): ?>
    <div class="max-w-[1800px] mx-auto px-6 pt-4">
        <div class="mb-4 rounded-md bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
            ✅ Xoá nhà cung cấp thành công.
        </div>
    </div>
<?php endif; ?>

<?php if ($error === 'empty_name'): ?>
    <div class="max-w-[1800px] mx-auto px-6 pt-2">
        <div class="mb-4 rounded-md bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
            ⚠️ Tên nhà cung cấp không được để trống.
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
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-500">Nhà cung cấp</li>
        </ul>
    </nav>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3 bg-">
            <h1 class="text-3xl font-[500] text-slate-900 m-0">Nhà cung cấp</h1>
            <span
                class="inline-flex items-center justify-center font-[500] text-white px-2 py-0.5 rounded-full bg-main">
                <?= count($dataSupplier) ?>
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

    <!-- table -->
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
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase w-5">Hành động</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php if (empty($dataSupplier)): ?>
                    <tr>
                        <td colspan="10" class="px-4 py-3 text-center text-xs font-medium text-slate-500 uppercase">
                            Không có nhà cung cấp nào trong hệ thống.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($dataSupplier as $value): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-3 text-left w-10">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                            </td>
                            <td class="px-6 py-4">#<?= $value['supplier_id'] ?></td>
                            <td class="px-6 py-4 font-medium text-slate-900"><?= htmlspecialchars($value['supplier_name']) ?>
                            </td>
                            <td class="px-6 py-4"><?= htmlspecialchars($value['type_name']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($value['contact_name']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($value['contact_email']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($value['contact_phone']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($value['address']) ?></td>
                            <td class="px-6 py-4 text-slate-500"><?= $value['supplier_updated_at'] ?></td>
                            <td class="px-6 py-4 text-center relative flex justify-end group">
                                <button class="py-1 px-2 flex items-center justify-center rounded-lg text-slate-600 
                                    hover:bg-slate-200 transition duration-150 focus:outline-none">
                                    <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                                </button>
                                <div class="absolute right-0 top-0 mt-2 w-40 bg-white border border-slate-200 
                                rounded-md shadow-lg text-sm py-1 
                                opacity-0 invisible 
                                group-hover:opacity-100 group-hover:visible 
                                transition-all duration-200 z-20 overflow-hidden">
                                    <a href="?mode=admin&act=viewsupplier&id=<?= $value['supplier_id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-regular fa-eye w-5 mr-3"></i> Chi Tiết
                                    </a>
                                    <a href="?mode=admin&act=editsupplier&id=<?= $value['supplier_id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-regular fa-pen-to-square w-5 mr-3"></i> Edit
                                    </a>
                                    <a href="?mode=admin&act=deletesupplier&id=<?= $value['supplier_id'] ?>"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này?')"
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

    <!-- FORM THÊM NHÀ CUNG CẤP MỚI -->
    <div class="mt-8 bg-white border border-slate-100 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-main/10 text-main text-sm font-semibold">
                    +
                </span>
                <h2 class="text-base font-[500] text-slate-900">
                    Thêm nhà cung cấp mới
                </h2>
            </div>
        </div>

        <form action="<?= BASE_URL ?>?mode=admin&act=supplier-create" method="post" class="px-6 py-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Tên nhà cung cấp -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Tên nhà cung cấp <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="VD: Khách sạn Mường Thanh...">
                </div>

                <!-- Loại dịch vụ -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Loại dịch vụ
                    </label>
                    <select name="supplier_types_id"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none">
                        <option value="">-- Chọn loại dịch vụ --</option>
                        <?php foreach ($supplierTypes as $type): ?>
                            <option value="<?= $type['id'] ?>">
                                <?= htmlspecialchars($type['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Người liên hệ -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Người liên hệ
                    </label>
                    <input type="text" name="contact_name"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="Tên người phụ trách">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Số điện thoại -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Số điện thoại
                    </label>
                    <input type="text" name="contact_phone"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="0987 xxx xxx">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Email
                    </label>
                    <input type="email" name="contact_email"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="example@domain.com">
                </div>

                <!-- Địa chỉ -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Địa chỉ
                    </label>
                    <input type="text" name="address"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="Địa chỉ chi tiết">
                </div>
            </div>

            <!-- Ghi chú -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Ghi chú / mô tả
                </label>
                <textarea name="description" rows="3"
                    class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                    placeholder="Ghi chú thêm về chính sách, ưu đãi..."></textarea>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-main text-white text-sm font-medium hover:bg-hover transition-all duration-150">
                    <i class="fa-solid fa-plus"></i>
                    Thêm nhà cung cấp
                </button>
            </div>
        </form>
    </div>
</div>