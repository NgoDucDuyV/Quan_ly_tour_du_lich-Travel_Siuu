<div class="max-w-[1900px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý booking</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <h1 class="text-3xl font-semibold text-slate-900">Danh Sách Booking</h1>
            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full bg-main text-white font-medium text-sm">
                <?= count($bookings) ?> booking
            </span>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= BASE_URL ?>?act=newBooking" class="flex items-center gap-2 px-5 py-2.5 bg-main hover:bg-hover text-white rounded-lg text-sm font-medium transition">
                <i class="fa-solid fa-plus"></i> Tạo Booking Mới
            </a>
            <button class="flex items-center gap-2 px-4 py-2.5 border border-slate-300 rounded-lg text-sm hover:bg-slate-50">
                <i class="fa-solid fa-filter"></i> Lọc
            </button>
        </div>
    </div>

    <!-- Thông báo -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-5 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> <?= $_SESSION['success'];
                                                        unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm flex items-center gap-2">
            <i class="fa-solid fa-xmark-circle"></i> <?= $_SESSION['error'];
                                                        unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Chú thích màu sắc (cập nhật chính xác 100% theo DB) -->
    <div class="mb-6 p-5 bg-slate-50 rounded-xl border border-slate-200">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 text-xs font-medium">
            <div class="flex items-center gap-2"><span class="w-4 h-4 rounded-full bg-yellow-100"></span> Chờ xác nhận</div>
            <div class="flex items-center gap-2"><span class="w-4 h-4 rounded-full bg-orange-100"></span> Đã đặt cọc</div>
            <div class="flex items-center gap-2"><span class="w-4 h-4 rounded-full bg-emerald-100"></span> Đã thanh toán đủ</div>
            <div class="flex items-center gap-2"><span class="w-4 h-4 rounded-full bg-gray-100"></span> Chưa thanh toán</div>
            <div class="flex items-center gap-2"><span class="w-4 h-4 rounded-full bg-sky-100"></span> Khách lẻ</div>
            <div class="flex items-center gap-2"><span class="w-4 h-4 rounded-full bg-purple-100"></span> Đoàn tiêu chuẩn</div>
            <div class="flex items-center gap-2"><span class="w-4 h-4 rounded-full bg-amber-100"></span> VIP - Cao cấp</div>
        </div>
    </div>

    <!-- Bảng Booking Siêu Đẹp -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left"><input type="checkbox" class="rounded border-slate-300"></th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Mã Booking</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Khách hàng</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Liên hệ</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Loại nhóm</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase text-center">Số người</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Trạng thái</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Thanh toán</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Tạo lúc</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100 text-sm">
                    <?php if (empty($bookings)): ?>
                        <tr>
                            <td colspan="10" class="text-center py-16 text-slate-500 text-lg">
                                <i class="fa-regular fa-calendar-xmark text-4xl mb-3 block text-slate-300"></i>
                                Chưa có booking nào
                            </td>
                        </tr>
                        <?php else: foreach ($bookings as $b): ?>
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="px-6 py-4"><input type="checkbox" class="rounded border-slate-300"></td>

                                <!-- Mã booking -->
                                <td class="px-4 py-4">
                                    <div class="font-bold text-main text-base"><?= $b['booking_code'] ?></div>
                                    <div class="text-xs text-slate-500">Tour #<?= $b['tour_id'] ?> • <?= date('d/m/Y', strtotime($b['start_date'])) ?></div>
                                </td>

                                <!-- Tên khách -->
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-slate-900"><?= htmlspecialchars($b['customer_name']) ?></div>
                                </td>

                                <!-- SĐT + Email -->
                                <td class="px-4 py-4 text-slate-600">
                                    <div class="font-medium"><?= $b['customer_phone'] ?></div>
                                    <div class="text-xs text-slate-500"><?= $b['customer_email'] ?></div>
                                </td>

                                <!-- Loại nhóm (dùng đúng màu + tên + % từ DB) -->
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold <?= $b['group_color'] ?? 'bg-gray-100 text-gray-800' ?>">
                                        <?= $b['group_name'] ?? 'Chưa xác định' ?>
                                        <?php if (!empty($b['price_change_percent']) && $b['price_change_percent'] != 0): ?>
                                            <span class="ml-1.5 <?= $b['price_change_percent'] > 0 ? 'text-emerald-700' : 'text-red-700' ?>">
                                                (<?= $b['price_change_percent'] > 0 ? '+' : '' ?><?= $b['price_change_percent'] ?>%)
                                            </span>
                                        <?php endif; ?>
                                    </span>
                                </td>

                                <!-- Số người -->
                                <td class="px-4 py-4 text-center font-bold text-lg text-slate-700">
                                    <?= $b['number_of_people'] ?>
                                </td>

                                <!-- Trạng thái Booking -->
                                <td class="px-4 py-4">
                                    <?php
                                    $statusColor = match ($b['status_type_code_master'] ?? 'PENDING') {
                                        'PENDING'   => 'bg-yellow-100 text-yellow-800',
                                        'DEPOSITED' => 'bg-orange-100 text-orange-800',
                                        'COMPLETED' => 'bg-emerald-100 text-emerald-800',
                                        'CANCELLED' => 'bg-red-100 text-red-800',
                                        default     => 'bg-gray-100 text-gray-800'
                                    };
                                    ?>
                                    <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold <?= $statusColor ?>">
                                        <?= $b['status_type_name'] ?? 'Chờ xác nhận' ?>
                                    </span>
                                </td>

                                <!-- Thanh toán (dùng đúng màu từ DB) -->
                                <td class="px-4 py-4">
                                    <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold <?= $b['payment_type_color'] ?? 'bg-gray-100 text-gray-800' ?>">
                                        <?= $b['payment_type_name'] ?? 'Chưa thanh toán' ?>
                                    </span>
                                </td>

                                <!-- Ngày tạo -->
                                <td class="px-4 py-4 text-xs text-slate-600">
                                    <div class="font-medium"><?= date('d/m/Y', strtotime($b['booking_created_at'])) ?></div>
                                    <div class="text-slate-400"><?= date('H:i', strtotime($b['booking_created_at'])) ?></div>
                                </td>

                                <!-- Hành động -->
                                <td class="px-4 py-4 text-right">
                                    <div class="inline-block text-left group">
                                        <button class="p-2 rounded-lg hover:bg-slate-100 transition">
                                            <i class="fa-solid fa-ellipsis-vertical text-slate-600"></i>
                                        </button>
                                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-slate-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                                            <a href="?act=bookingdetail&booking_id=<?= $b['booking_id'] ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50">
                                                <i class="fa-regular fa-eye text-blue-600"></i> Xem chi tiết
                                            </a>
                                            <a href="?act=booking&edit_id=<?= $b['booking_id'] ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50">
                                                <i class="fa-regular fa-pen-to-square text-indigo-600"></i> Chỉnh sửa
                                            </a>
                                            <?php if ($b['status_type_code_master'] !== 'CANCELLED'): ?>
                                                <a href="?act=cancelBooking&id=<?= $b['booking_id'] ?>" onclick="return confirm('Hủy booking này?')" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                                    <i class="fa-regular fa-ban"></i> Hủy booking
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($b['status_type_code_master'] === 'PENDING'): ?>
                                                <hr class="my-2 border-slate-200">
                                                <a href="?act=confirmBooking&id=<?= $b['booking_id'] ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-emerald-600 hover:bg-emerald-50">
                                                    <i class="fa-regular fa-circle-check"></i> Xác nhận đặt chỗ
                                                </a>
                                            <?php endif; ?>
                                        </div>
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