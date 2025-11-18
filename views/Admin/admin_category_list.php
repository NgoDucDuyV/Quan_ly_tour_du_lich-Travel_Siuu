<div class="max-w-[1800px] mx-auto p-6">

    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Bảng điều khiển</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Danh mục Tour</li>
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

            <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-md 
                text-sm text-slate-600 bg-white hover:bg-slate-50">
                Lọc
            </button>

            <button class="flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium text-white"
                style="background-color:#1f55ad"
                onmouseover="this.style.backgroundColor='#0f2b90'"
                onmouseout="this.style.backgroundColor='#1f55ad'">
                Tạo mới
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white border border-slate-100 rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50 text-slate-600 text-sm font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left w-10">
                        <input type="checkbox"
                            class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                    </th>
                    <th class="px-6 py-3 text-left w-16">ID</th>
                    <th class="px-6 py-3 text-left">Tên danh mục</th>
                    <th class="px-6 py-3 text-left">Mô tả</th>
                    <th class="px-6 py-3 text-left">Số tour</th>
                    <th class="px-6 py-3 text-right">Cập nhật</th>
                    <th class="px-6 py-3 text-right">Hành động</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-slate-500 text-center">
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

                            <td class="px-6 py-4 font-medium text-slate-900">
                                <?= $value['name'] ?>
                            </td>

                            <td class="px-6 py-4 truncate max-w-xs text-slate-600">
                                <?= $value['description'] ?>
                            </td>

                            <td class="px-6 py-4"><?= $value['total_tours'] ?></td>

                            <td class="px-6 py-4 text-right text-slate-500">
                                <?= $value['updated_at'] ?>
                            </td>

                            <td class="px-6 py-4 text-right relative flex justify-end group">

                                <button class="py-1 px-2 flex items-center justify-center rounded-lg text-slate-600 
                                        hover:bg-slate-200 transition duration-150 focus:outline-none">
                                    <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                                </button>

                                <div class="absolute right-0 top-0 mt-2 w-40 bg-white border border-slate-200 
                                    rounded-md shadow-lg text-sm py-1 
                                    opacity-0 invisible 
                                    group-hover:opacity-100 group-hover:visible 
                                    transition-all duration-200 z-20 overflow-hidden">

                                    <a href="?act=admintour&id=<?= $value['id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-regular fa-eye w-5 mr-3"></i> Chi Tiết
                                    </a>

                                    <a href="?act=editcategory&id=<?= $value['id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-regular fa-pen-to-square w-5 mr-3"></i> Edit
                                    </a>

                                    <a href="?act=deletecategory&id=<?= $value['id'] ?>"
                                        class="flex items-center px-3 py-2 text-red-600 hover:bg-red-50 transition">
                                        <i class="fa-regular fa-trash-can w-5 mr-3"></i> Xóa bỏ
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