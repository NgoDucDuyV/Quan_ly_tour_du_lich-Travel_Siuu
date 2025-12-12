<div class="max-w-[1900px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý booking</li>
        </ul>
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
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="mb-5 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> <?= $_SESSION['success_message']; ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="mb-5 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <?= $_SESSION['error_message'] ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

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
    <!-- Tìm kiếm + lọc -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8 sticky top-0 z-10">
        <div class="flex flex-col lg:flex-row gap-6">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Code Booking, Tên khách, email hướng dẫn viên..."
                    class="w-full pl-12 pr-6 py-4 rounded-lg border border-slate-300 focus:outline-none focus:ring-4 focus:ring-main/20 focus:border-main text-lg">
            </div>
            <div class="flex gap-4">
                <select class="w-48 px-5 py-4 rounded-lg border border-slate-300">
                    <option>Lọc theo trang thái</option>
                    <option>Tiếng Anh</option>
                    <option>Tiếng Pháp</option>
                    <option>Tiếng Trung</option>
                    <option>Tiếng Nhật</option>
                    <option>Tiếng Hàn</option>
                </select>
                <select class="w-48 px-5 py-4 rounded-lg border border-slate-300">
                    <option>Kinh nghiệm</option>
                    <option>≥ 3 năm</option>
                    <option>≥ 5 năm</option>
                    <option>≥ 10 năm</option>
                </select>
            </div>
        </div>
    </div>

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

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-h-[1800px]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left"><input type="checkbox" class="rounded border-slate-300"></th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">ID Booking</th>
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
                            <?php
                            $dataSchedulesStatus = (new SchedulesModel())->getSchedulesStatusByBookingId($b['booking_id']);
                            ?>
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="px-6 py-4"><input type="checkbox" class="rounded border-slate-300"></td>

                                <!-- Mã booking -->
                                <td class="px-4 py-4">
                                    <div class="font-bold text-main text-base"><?= $b['booking_id'] ?></div>
                                </td>
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

                                <!-- Trạng thái Booking + HDV -->
                                <td class="px-4 py-4">
                                    <?php
                                    // 1. Trạng thái Booking (luôn hiển thị)
                                    $bookingStatusCode = $b['status_type_code_master'] ?? 'PENDING';

                                    $bookingColor = match ($bookingStatusCode) {
                                        'PENDING'       => 'bg-yellow-100 text-yellow-800',
                                        'DEPOSITED'     => 'bg-orange-100 text-orange-800',
                                        'ASSIGN_GUIDE'  => 'bg-indigo-100 text-indigo-800',   // Màu đặc biệt cho "Đang phân HDV"
                                        'UPCOMING'      => 'bg-purple-100 text-purple-800',
                                        'IN_PROGRESS'   => 'bg-cyan-100 text-cyan-800',
                                        'COMPLETED'     => 'bg-emerald-100 text-emerald-800',
                                        'CLOSED'        => 'bg-teal-100 text-teal-800',
                                        'CANCELED'      => 'bg-red-100 text-red-800',
                                        default         => 'bg-gray-100 text-gray-800'
                                    };
                                    ?>
                                    <div class="flex flex-col gap-1.5">
                                        <!-- Trạng thái Booking -->
                                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold <?= $bookingColor ?>">
                                            <?= htmlspecialchars($b['status_type_name'] ?? 'Chờ xác nhận') ?>
                                        </span>

                                        <!-- HIỂN THỊ TRẠNG THÁI HDV CHỈ KHI: -->
                                        <!-- 1. Booking đang ở trạng thái "Đang phân hướng dẫn viên" -->
                                        <!-- HOẶC -->
                                        <!-- 2. Tour đang diễn ra / đã hoàn thành (IN_PROGRESS, COMPLETED, CLOSED) -->
                                        <?php
                                        $schedules = $dataSchedulesStatus ?? [];
                                        $firstSch = $schedules[0] ?? null;

                                        $showGuideStatus = false;

                                        // Điều kiện bật hiển thị trạng thái HDV
                                        if ($bookingStatusCode === 'ASSIGN_GUIDE') {
                                            $showGuideStatus = true; // Luôn hiện khi đang phân HDV
                                        } elseif (in_array($bookingStatusCode, ['IN_PROGRESS', 'COMPLETED', 'CLOSED'])) {
                                            $showGuideStatus = true; // Tour đang diễn ra hoặc xong → cũng hiện
                                        }

                                        if ($showGuideStatus && $firstSch) {
                                            $guideCode = $firstSch['guide_status_code'] ?? 'PENDING';

                                            $guideColor = match ($guideCode) {
                                                'AVAILABLE'    => 'bg-indigo-100 text-indigo-800',
                                                'ASSIGNED'     => 'bg-blue-100 text-blue-800',
                                                'ON_ROUTE'     => 'bg-purple-100 text-purple-800',
                                                'IN_PROGRESS'  => 'bg-cyan-100 text-cyan-800',
                                                'COMPLETED'    => 'bg-green-100 text-green-800',
                                                'CANCELED'     => 'bg-red-100 text-red-800',
                                                default        => 'bg-gray-100 text-gray-700' // PENDING hoặc chưa rõ
                                            };

                                            $guideName = match ($guideCode) {
                                                'AVAILABLE'    => 'HDV sẵn sàng',
                                                'ASSIGNED'     => 'Đã phân công HDV',
                                                'ON_ROUTE'     => 'HDV đang di chuyển',
                                                'IN_PROGRESS'  => 'Đang hướng dẫn',
                                                'COMPLETED'    => 'HDV hoàn thành',
                                                'CANCELED'     => 'HDV đã hủy',
                                                default        => $firstSch['guide_status_name_vn'] ?? 'Chờ phân công'
                                            };
                                        ?>
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium <?= $guideColor ?>">
                                                <?= htmlspecialchars($guideName) ?>
                                            </span>
                                        <?php
                                        }
                                        ?>
                                    </div>
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
                                    <div class="inline-block text-left relative group">
                                        <button class="p-2 rounded-lg hover:bg-slate-100 transition">
                                            <i class="fa-solid fa-ellipsis-vertical text-slate-600"></i>
                                        </button>

                                        <!-- Menu 3 chấm -->
                                        <div class="absolute right-[-10px] mt-2 w-72 bg-white rounded-lg shadow-xl border border-slate-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">

                                            <!-- 1. Xem chi tiết (luôn có) -->
                                            <a href="?act=bookingdetail&booking_id=<?= $b['booking_id'] ?>"
                                                class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50">
                                                <i class="fa-regular fa-eye text-blue-600"></i> Xem chi tiết
                                            </a>

                                            <!-- 2. Chỉnh sửa (chỉ khi chưa bắt đầu tour) -->
                                            <?php if (in_array($b['status_type_code_master'], ['PENDING', 'DEPOSITED', 'ASSIGN_GUIDE', 'UPCOMINGS'])): ?>
                                                <a href="?act=booking&edit_id=<?= $b['booking_id'] ?>"
                                                    class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50">
                                                    <i class="fa-regular fa-pen-to-square text-indigo-600"></i> Chỉnh sửa booking
                                                </a>
                                            <?php endif; ?>

                                            <?php
                                            $allowPaymentUpdate = in_array($b['status_type_code_master'], [
                                                'DEPOSITED',
                                                'ASSIGN_GUIDE',
                                                'UPCOMING'
                                            ]);
                                            $total  = $b['total_amount'] ?? 0;
                                            $paid   = $b['paid_amount'] ?? 0;
                                            $remain = $total - $paid;
                                            $percent = $total > 0 ? round(($paid / $total) * 100) : 0;
                                            ?>
                                            <?php if ($allowPaymentUpdate): ?>
                                                <a href="?act=from_booking_update_payment&booking_id=<?= $b['booking_id'] ?>"
                                                    class="flex items-center justify-between gap-3 px-4 py-2.5 text-sm font-medium hover:bg-teal-50 border-t border-slate-100 mt-1 pt-3 transition rounded-lg">

                                                    <span class="flex items-center gap-3">
                                                        <i class="fa-solid fa-money-bill-wave text-teal-600"></i>
                                                        <span class="text-teal-700 font-medium">Cập nhật thanh toán</span>
                                                    </span>

                                                    <?php if ($total > 0): ?>
                                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full border
                                                            <?= $paid >= $total
                                                                ? 'bg-emerald-100 text-emerald-700 border-emerald-300'
                                                                : 'bg-orange-100 text-orange-700 border-orange-300' ?>">

                                                            <?= $percent ?>%
                                                            <?= $paid >= $total
                                                                ? '<span class="text-emerald-700">Đã đủ</span>'
                                                                : 'Còn ' . number_format($remain) . 'đ' ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </a>
                                            <?php endif; ?>

                                            <div class="border-t border-slate-200 my-2"></div>

                                            <!-- 3. Hành động chuyển trạng thái tiếp theo -->
                                            <?php $current = $b['status_type_code_master']; ?>

                                            <?php if ($current === 'PENDING'): ?>
                                                <a href="?act=from_booking_update_deposit&booking_id=<?= $b['booking_id'] ?>"
                                                    onclick="return confirm('Xác nhận khách đã đặt cọc/thanh toán?')"
                                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-emerald-600 hover:bg-emerald-50">
                                                    <i class="fa-regular fa-circle-check"></i> Xác nhận đặt cọc
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($current === 'DEPOSITED'): ?>
                                                <a href="?act=guide_tour_schedule&booking_id=<?= $b['booking_id'] ?>"
                                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-purple-600 hover:bg-purple-50">
                                                    <i class="fa-solid fa-user-tie"></i> Phân hướng dẫn viên
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($current === 'ASSIGN_GUIDE'): ?>
                                                <a href="?act=markUpcoming&booking_id=<?= $b['booking_id'] ?>"
                                                    onclick="return confirm('Xác Nhậ đánh dấu sắp diễn ra')"
                                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-orange-600 hover:bg-orange-50">
                                                    <i class="fa-solid fa-calendar-check"></i> Đánh dấu Sắp diễn ra
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($current === 'UPCOMINGS'): ?>
                                                <a href="?act=startTour&id=<?= $b['booking_id'] ?>"
                                                    onclick="return confirm('Bắt đầu tour ngay bây giờ?')"
                                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-green-600 hover:bg-green-50">
                                                    <i class="fa-solid fa-play"></i> Bắt đầu tour (Đang diễn ra)
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($current === 'IN_PROGRESS'): ?>
                                                <a href="?act=completeTour&id=<?= $b['booking_id'] ?>"
                                                    onclick="return confirm('Tour đã hoàn thành đúng kế hoạch?')"
                                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-cyan-600 hover:bg-cyan-50">
                                                    <i class="fa-solid fa-trophy"></i> Hoàn thành tour
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($current === 'COMPLETED'): ?>
                                                <a href="?act=closeBooking&id=<?= $b['booking_id'] ?>"
                                                    onclick="return confirm('Đóng booking và chuyển vào lưu trữ?')"
                                                    class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50">
                                                    <i class="fa-solid fa-box-archive"></i> Đóng booking (Kết thúc)
                                                </a>
                                            <?php endif; ?>

                                            <!-- 4. Hủy booking (trừ các trạng thái đã kết thúc) -->
                                            <?php if (!in_array($current, ['CANCELED', 'CLOSED', 'COMPLETED'])): ?>
                                                <div class="border-t border-slate-200 my-2"></div>
                                                <a href="?act=huy_booking&booking_id=<?= $b['booking_id'] ?>"
                                                    onclick="return confirm('⚠️ HỦY booking này?\nKhách sẽ được thông báo và tiền cọc có thể bị hoàn/hủy theo chính sách!\nHành động KHÔNG THỂ hoàn tác!')"
                                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50">
                                                    <i class="fa-regular fa-ban"></i> Hủy booking
                                                </a>
                                            <?php endif; ?>

                                            <!-- 5. Khôi phục nếu đã hủy -->
                                            <?php if ($current === 'CANCELED'): ?>
                                                <!-- <div class="border-t border-slate-200 my-2"></div> -->
                                                <a href="?act=restoreBooking&booking_id=<?= $b['booking_id'] ?>"
                                                    onclick="return confirm('Khôi phục booking này về trạng thái trước khi hủy?')"
                                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-amber-600 hover:bg-amber-50">
                                                    <i class="fa-solid fa-rotate-left"></i> Khôi phục booking
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