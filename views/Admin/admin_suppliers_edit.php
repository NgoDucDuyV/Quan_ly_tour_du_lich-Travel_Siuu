<?php
// Biến $supplier và $supplierTypes được truyền từ AdminSupplierController::editSupplier()
?>
<div class="max-w-[1800px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Đối Tác Nhà cung cấp</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-500">
                Sửa nhà cung cấp
            </li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-[500] text-slate-900 m-0">
                Sửa nhà cung cấp #<?= htmlspecialchars($supplier['id']) ?>
            </h1>
            <p class="text-sm text-slate-500">
                Cập nhật thông tin đối tác nhà cung cấp cho hệ thống tour.
            </p>
        </div>

        <a href="<?= BASE_URL ?>?mode=admin&act=supplier-list"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition">
            <i class="fa-solid fa-arrow-left"></i>
            Quay lại danh sách
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white border border-slate-100 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-main/10 text-main text-sm font-semibold">
                    <i class="fa-regular fa-pen-to-square"></i>
                </span>
                <h2 class="text-base font-[500] text-slate-900">
                    Thông tin nhà cung cấp
                </h2>
            </div>
        </div>

        <form
            action="<?= BASE_URL ?>?mode=admin&act=update-supplier"
            method="post"
            class="px-6 py-6 space-y-6"
        >
            <input type="hidden" name="id" value="<?= htmlspecialchars($supplier['id']) ?>">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Tên nhà cung cấp -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Tên nhà cung cấp <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        required
                        value="<?= htmlspecialchars($supplier['name']) ?>"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="VD: Khách sạn Mường Thanh..."
                    >
                </div>

                <!-- Loại dịch vụ -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Loại dịch vụ
                    </label>
                    <select
                        name="supplier_types_id"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                    >
                        <option value="">-- Không chọn --</option>
                        <?php foreach ($supplierTypes as $type): ?>
                            <option
                                value="<?= $type['id'] ?>"
                                <?= $supplier['supplier_types_id'] == $type['id'] ? 'selected' : '' ?>
                            >
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
                    <input
                        type="text"
                        name="contact_name"
                        value="<?= htmlspecialchars($supplier['contact_name'] ?? '') ?>"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="Tên người phụ trách"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Số điện thoại -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Số điện thoại
                    </label>
                    <input
                        type="text"
                        name="contact_phone"
                        value="<?= htmlspecialchars($supplier['contact_phone'] ?? '') ?>"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="0987 xxx xxx"
                    >
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Email
                    </label>
                    <input
                        type="email"
                        name="contact_email"
                        value="<?= htmlspecialchars($supplier['contact_email'] ?? '') ?>"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="example@domain.com"
                    >
                </div>

                <!-- Địa chỉ -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Địa chỉ
                    </label>
                    <input
                        type="text"
                        name="address"
                        value="<?= htmlspecialchars($supplier['address'] ?? '') ?>"
                        class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                        placeholder="Địa chỉ chi tiết"
                    >
                </div>
            </div>

            <!-- Ghi chú -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Ghi chú / mô tả
                </label>
                <textarea
                    name="description"
                    rows="3"
                    class="block w-full rounded-md border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm focus:bg-white focus:border-main focus:ring-1 focus:ring-main outline-none"
                    placeholder="Ghi chú thêm về chính sách, ưu đãi..."
                ><?= htmlspecialchars($supplier['description'] ?? '') ?></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="<?= BASE_URL ?>?mode=admin&act=supplier-list"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Hủy
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-md bg-main text-white text-sm font-medium hover:bg-hover transition-all duration-150"
                >
                    <i class="fa-regular fa-floppy-disk"></i>
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
