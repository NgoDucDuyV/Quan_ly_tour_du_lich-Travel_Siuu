<div class="max-w-[1900px] mx-auto p-6">
    <!-- breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Quản lý booking</li>
        </ul>
    </nav>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3 bg-">
            <h1 class="text-3xl font-[500] text-slate-900 m-0">Danh Sách Booking</h1>
            <span class="inline-flex items-center justify-center font-[500] text-white px-2 py-0.5 rounded-full bg-main">
                <?= count($bookings) ?>
            </span>
        </div>

        <div class="flex items-center space-x-3">

            <a href="?mode=admin&act=newBooking" class="flex items-center gap-2 px-4 py-2 rounded-md border-[1px_solid_main] text-sm font-[300] bg-main hover:bg-hover text-white transition-all duration-200 ease-out">
                <i class="fa-solid fa-plus"></i>
                Tạo mới Booking
            </a>

            <button class="flex items-center gap-2 px-4 py-2 border rounded-md
                text-sm text-dark hover:bg-main hover:text-white transition-all duration-200 ease-out">
                <i class="fa-solid fa-filter"></i>
                Lọc
            </button>
        </div>
    </div>

    <!-- thông báo -->
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

    <!-- ghi chú trạng thái -->
    <div class="mt-6 flex gap-4 text-xs mb-5">
        <span class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-yellow-100"></div> chờ xác nhận
        </span>
        <span class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-blue-100"></div> đã cọc
        </span>
        <span class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-green-100"></div> hoàn tất
        </span>
        <span class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-purple-100"></div> đoàn
        </span>
        <span class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-blue-100"></div> lẻ
        </span>
    </div>
    <!-- bảng booking -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left w-10">
                            <input type="checkbox"
                                class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">tour id</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">tên khách hàng</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">số điện thoại</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">loại nhóm</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">số người</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">ghi chú</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">trạng thái</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">ngày tạo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">cập nhật</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase w-5">hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200 text-sm">
                    <?php if (empty($bookings)): ?>
                        <tr>
                            <td colspan="12" class="px-6 py-16 text-center text-slate-500 text-base">
                                chưa có booking nào trong hệ thống
                            </td>
                        </tr>
                        <?php else: foreach ($bookings as $b): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                                </td>
                                <td class="px-4 py-4 font-medium text-slate-900">#<?= $b['id'] ?></td>
                                <td class="px-4 py-4"><?= $b['tour_id'] ?> <small class="text-slate-500">(v<?= $b['tour_version_id'] ?? '-' ?>)</small></td>
                                <td class="px-4 py-4 font-medium"><?= htmlspecialchars($b['customer_name']) ?></td>
                                <td class="px-4 py-4"><?= htmlspecialchars($b['customer_phone']) ?></td>
                                <td class="px-4 py-4 text-slate-600"><?= htmlspecialchars($b['customer_email']) ?></td>
                                <td class="px-4 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                    <?= $b['group_type'] == 'le' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' ?>">
                                        <?= $b['group_type'] == 'le' ? 'lẻ' : 'đoàn' ?>
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center font-medium"><?= $b['number_of_people'] ?></td>
                                <td class="px-4 py-4 text-slate-600 max-w-xs truncate" title="<?= htmlspecialchars($b['note'] ?? '') ?>">
                                    <?= $b['note'] ? htmlspecialchars($b['note']) : '<span class="text-slate-400">không có</span>' ?>
                                </td>
                                <td class="px-4 py-4">
                                    <?php
                                    $status = $b['status'] ?? 'cho_xac_nhan';
                                    $statusText = $status == 'cho_xac_nhan' ? 'chờ xác nhận' : ($status == 'da_coc' ? 'đã cọc' : ($status == 'hoan_tat' ? 'hoàn tất' : $status));
                                    $statusColor = $status == 'hoan_tat' ? 'bg-green-100 text-green-800' : ($status == 'da_coc' ? 'bg-blue-100 text-blue-800' :
                                        'bg-yellow-100 text-yellow-800');
                                    ?>
                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full <?= $statusColor ?>">
                                        <?= ucwords(str_replace('_', ' ', $statusText)) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-slate-600 text-xs">
                                    <?= date('d/m/Y H:i', strtotime($b['created_at'])) ?>
                                </td>
                                <td class="px-4 py-4 text-slate-600 text-xs">
                                    <?= $b['updated_at'] ? date('d/m/Y H:i', strtotime($b['updated_at'])) : '-' ?>
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

                                        <a href="?act=booking&view_id=<?= $b['id'] ?>"
                                            class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                            <i class="fa-regular fa-eye w-5 mr-3"></i> Chi Tiết
                                        </a>

                                        <a href="?act=booking&edit_id=<?= $b['id'] ?>"
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
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>