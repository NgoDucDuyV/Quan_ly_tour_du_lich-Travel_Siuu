<div class="max-w-[1800px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Đối Tác Nhà cung cấp</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Nhà cung cấp</li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-semibold text-slate-900">Nhà Cung Cấp</h1>
            <span class="inline-block bg-slate-100 text-slate-600 px-2 py-0.5 text-sm rounded-full">
                <?= count($dataSupplier) ?>
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
                    <th class="px-6 py-3 text-left">Tên nhà cung cấp</th>
                    <th class="px-6 py-3 text-left">Loại</th>
                    <th class="px-6 py-3 text-left">Người liên hệ</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Số điện thoại</th>
                    <th class="px-6 py-3 text-left">Địa chỉ</th>
                    <th class="px-6 py-3 text-center w-20">Tổng tour</th>
                    <th class="px-6 py-3 text-right w-36">Cập nhật</th>
                    <th class="px-6 py-3 text-right w-36">Hành động</th>

                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php if (empty($dataSupplier)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-slate-500 text-center">
                            Không có danh mục nào trong hệ thống.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($dataSupplier as $value): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                            </td>
                            <th class="px-6 py-3 text-left w-16">ID<?= $value['supplier_id'] ?></th>
                            <th class="px-6 py-3 text-left"><?= $value['supplier_name'] ?></th>
                            <th class="px-6 py-3 text-left"><?= $value['type_name'] ?></th>
                            <th class="px-6 py-3 text-left"><?= $value['contact_name'] ?></th>
                            <th class="px-6 py-3 text-left"><?= $value['contact_email'] ?></th>
                            <th class="px-6 py-3 text-left"><?= $value['contact_phone'] ?></th>
                            <th class="px-6 py-3 text-left"><?= $value['address'] ?></th>
                            <th class="px-6 py-3 text-center w-20"><?= $value['total_tours'] ?></th>
                            <th class="px-6 py-3 text-right w-36"><?= $value['supplier_updated_at'] ?></th>
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