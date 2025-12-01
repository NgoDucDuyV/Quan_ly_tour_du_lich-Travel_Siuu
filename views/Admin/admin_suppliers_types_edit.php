<?php
// Biến $supplierType được truyền từ AdminSupplierController::editSupplierType()
?>
<div class="max-w-[1800px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Đối Tác Nhà cung cấp</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-500">
                Sửa loại dịch vụ
            </li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-[500] text-slate-900 m-0">
                Sửa loại dịch vụ #<?= htmlspecialchars($supplierType['id']) ?>
            </h1>
            <p class="text-sm text-slate-500">
                Cập nhật thông tin loại dịch vụ cho đối tác nhà cung cấp.
            </p>
        </div>

        <a href="<?= BASE_URL ?>?mode=admin&act=supplier-list-types"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition">
            <i class="fa-solid fa-arrow-left"></i>
            Quay lại danh sách
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white border border-slate-100 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-main/10 text-main text-sm font-semibold">
                    <i class="fa-regular fa-pen-to-square"></i>
                </span>
                <h2 class="text-base font-[500] text-slate-900">
                    Thông tin loại dịch vụ
                </h2>
            </div>
        </div>

        <form action="<?= BASE_URL ?>?mode=admin&act=update-supplier-type" method="post" class="px-6 py-6 space-y-6">
            <input type="hidden" name="id" value="<?= htmlspecialchars($supplierType['id']) ?>">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Tên loại dịch vụ -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Tên loại dịch vụ <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required value="<?= htmlspecialchars($supplierType['name']) ?>"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="VD: Khách sạn, Nhà hàng...">
                </div>

                <!-- Stars -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Số sao (0-5)
                    </label>
                    <input type="number" name="stars" min="0" max="5"
                        value="<?= htmlspecialchars($supplierType['stars'] ?? 0) ?>"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none">
                </div>

                <!-- Quality -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Chất lượng
                    </label>
                    <?php
                    $qualities = ['Xuất sắc', 'Rất tốt', 'Tốt', 'Trung bình', 'Kém'];
                    $currentQuality = $supplierType['quality'] ?? 'Tốt';
                    ?>
                    <select name="quality"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none">
                        <?php foreach ($qualities as $q): ?>
                            <option value="<?= $q ?>" <?= $currentQuality === $q ? 'selected' : '' ?>>
                                <?= $q ?>
                            </option>
                        <?php endforeach; ?>
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
                    placeholder="Mô tả chi tiết về loại dịch vụ..."><?= htmlspecialchars($supplierType['description'] ?? '') ?></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="<?= BASE_URL ?>?mode=admin&act=supplier-list-types"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Hủy
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-main text-white text-sm font-medium hover:bg-hover transition-all duration-150">
                    <i class="fa-regular fa-floppy-disk"></i>
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>