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
            <span class="inline-flex items-center justify-center font-[500] text-white px-2 py-0.5 rounded-full bg-main">
                <?= count($dataSupplier) ?>
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
                            <td class="px-6 py-4 font-medium text-slate-900"><?= htmlspecialchars($value['supplier_name']) ?></td>
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
</div>