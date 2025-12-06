<?php
$booking = $databooking; // từ controller
$total   = $booking['total_price'] ?? 0;
$paid    = $booking['paid_amount'] ?? 0;
$remain  = $total - $paid;
$percent = $total > 0 ? round(($paid / $total) * 100) : 0; 

// Hàm lấy màu trạng thái
function getStatusColor($code)
{
    return match (strtoupper($code)) {
        'PENDING', 'CHXACNHAN'     => 'bg-yellow-100 text-yellow-800',
        'DEPOSITED', 'DACO'        => 'bg-orange-100 text-orange-800',
        'ASSIGN_GUIDE'            => 'bg-purple-100 text-purple-800',
        'UPCOMING', 'UPCOMINGS'    => 'bg-amber-100 text-amber-800',
        'IN_PROGRESS'             => 'bg-cyan-100 text-cyan-800',
        'COMPLETED', 'HOANTAT'     => 'bg-emerald-100 text-emerald-800',
        'CLOSED'                  => 'bg-gray-300 text-gray-700',
        'CANCELED', 'CANCELLED'    => 'bg-red-100 text-red-800',
        default                   => 'bg-gray-100 text-gray-800'
    };
}
$statusColor = getStatusColor($booking['status_type_code_master'] ?? $booking['booking_status_code'] ?? '');
?>

<div class="max-w-[1900px] mx-auto p-6">

    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4">
        <ul class="inline-flex items-center space-x-2">
            <li><a href="?act=booking" class="hover:text-slate-700">Quản lý booking</a></li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Chi tiết booking</li>
        </ul>
    </nav>

    <!-- Header + Trạng thái -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-5">
            <h1 class="text-3xl font-bold text-slate-900">BK: <?= $booking['booking_code'] ?></h1>
            <div class="flex gap-3">
                <span class="px-5 py-2 rounded-full text-sm font-bold <?= $statusColor ?>">
                    <?= $booking['status_type_name'] ?? 'Chưa xác định' ?>
                </span>
                <span class="px-5 py-2 rounded-full text-sm font-bold <?= $booking['payment_type_color'] ?? 'bg-gray-100 text-gray-800' ?>">
                    <?= $booking['payment_type_name'] ?? 'Chưa thanh toán' ?>
                </span>
            </div>
        </div>
        <a href="?act=booking" class="flex items-center gap-2 px-5 py-2.5 border border-slate-300 rounded-lg hover:bg-slate-50 text-sm">
            ← Danh sách
        </a>
    </div>

    <!-- Card tổng quan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Thông tin khách hàng -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Thông tin khách hàng</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-600">Họ tên</span>
                    <span class="font-semibold"><?= htmlspecialchars($booking['customer_name']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Số điện thoại</span>
                    <span class="font-medium"><?= $booking['customer_phone'] ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Email</span>
                    <span class="font-medium"><?= $booking['customer_email'] ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Loại khách</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold <?= $booking['group_color'] ?? 'bg-gray-100 text-gray-800' ?>">
                        <?= $booking['group_name'] ?? 'Chưa xác định' ?>
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Số người</span>
                    <span class="font-bold text-xl text-main"><?= $booking['number_of_people'] ?> khách</span>
                </div>
            </div>
        </div>

        <!-- Thông tin tour -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Thông tin tour</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-600">Mã tour</span>
                    <span class="font-mono font-bold">#<?= $booking['tour_id'] ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Ngày khởi hành</span>
                    <span class="font-semibold"><?= date('d/m/Y', strtotime($booking['start_date'])) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Ngày kết thúc</span>
                    <span class="font-semibold"><?= date('d/m/Y', strtotime($booking['end_date'])) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Tạo booking lúc</span>
                    <span class="text-slate-500"><?= date('d/m/Y H:i', strtotime($booking['booking_created_at'])) ?></span>
                </div>
            </div>
        </div>

        <!-- Tình hình thanh toán -->
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4">Tình hình thanh toán</h3>
            <div class="space-y-4">
                <div class="flex justify-between text-2xl font-bold">
                    <span>Tổng tiền</span>
                    <span><?= number_format($total) ?>đ</span>
                </div>
                <div class="flex justify-between text-xl">
                    <span>Đã thu</span>
                    <span class="text-emerald-300"><?= number_format($paid) ?>đ</span>
                </div>
                <div class="flex justify-between text-xl">
                    <span>Còn thiếu</span>
                    <span class="<?= $remain > 0 ? 'text-orange-300' : 'text-emerald-300' ?>">
                        <?= number_format($remain) ?>đ
                    </span>
                </div>
                <div class="mt-4">
                    <div class="bg-white bg-opacity-20 rounded-full h-4 overflow-hidden">
                        <div class="bg-emerald-400 h-full transition-all duration-700" style="width: <?= $percent ?>%"></div>
                    </div>
                    <div class="text-right mt-1 text-sm"><?= $percent ?>% đã thu</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs nội dung -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="border-b border-slate-200">
            <div class="flex">
                <button class="tab-btn active px-6 py-4 font-medium text-main border-b-2 border-main">Lịch sử trạng thái</button>
                <button class="tab-btn px-6 py-4 font-medium text-slate-600 hover:text-main">Lịch sử thanh toán</button>
                <button class="tab-btn px-6 py-4 font-medium text-slate-600 hover:text-main">Dịch vụ đã đặt</button>
                <button class="tab-btn px-6 py-4 font-medium text-slate-600 hover:text-main">Ghi chú nội bộ</button>
            </div>
        </div>

        <div class="p-6 tab-content active">
            <!-- Lịch sử trạng thái -->
            <?php if (!empty($bookingLogs)): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Thời gian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Từ → Đến</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Nội dung</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Người thực hiện</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($bookingLogs as $log): ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4"><?= date('d/m/Y H:i', strtotime($log['created_at'])) ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700"><?= $log['old_status'] ?></span>
                                        <i class="fa-solid fa-arrow-right mx-2 text-slate-400"></i>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700"><?= $log['new_status'] ?></span>
                                    </td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($log['description']) ?></td>
                                    <td class="px-6 py-4 text-slate-500">NV<?= $log['updated_by'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center py-12 text-slate-500">Chưa có lịch sử thay đổi</p>
            <?php endif; ?>
        </div>

        <div class="p-6 tab-content hidden">
            <!-- Lịch sử thanh toán -->
            <?php if (!empty($paymentLogs)): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Ngày</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Số tiền</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Phương thức</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Loại</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Mã GD</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($paymentLogs as $p): ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4"><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                                    <td class="px-6 py-4 font-bold text-emerald-600"><?= number_format($p['amount']) ?>đ</td>
                                    <td class="px-6 py-4"><?= $p['payment_method_name'] ?? 'Chưa xác định' ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                            <?= $p['payment_type_name'] ?? 'Đặt cọc' ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs"><?= $p['transaction_code'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center py-12 text-slate-500">Chưa có giao dịch nào</p>
            <?php endif; ?>
        </div>

        <!-- Các tab khác tương tự... -->
    </div>

    <!-- Nút hành động nhanh -->
    <div class="fixed bottom-6 right-6 flex flex-col gap-3 z-50">
        <?php if ($booking['status_type_code_master'] === 'PENDING'): ?>
            <a href="?act=from_confirm_booking_deposit&id=<?= $booking['booking_id'] ?>"
                class="flex items-center gap-3 px-6 py-4 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-full shadow-2xl transition">
                Xác nhận đặt cọc
            </a>
        <?php endif; ?>

        <?php if (in_array($booking['status_type_code_master'], ['PENDING', 'DEPOSITED', 'ASSIGN_GUIDE', 'UPCOMING', 'IN_PROGRESS'])): ?>
            <a href="?act=updatePayment&booking_id=<?= $booking['booking_id'] ?>"
                class="flex items-center gap-3 px-6 py-4 bg-teal-500 hover:bg-teal-600 text-white font-bold rounded-full shadow-2xl transition">
                Cập nhật thanh toán
            </a>
        <?php endif; ?>

        <button onclick="window.print()" class="p-4 bg-slate-700 hover:bg-slate-800 text-white rounded-full shadow-2xl">
            Print
        </button>
    </div>
</div>

<script>
    // Tab đơn giản
    document.querySelectorAll('.tab-btn').forEach((btn, idx) => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active', 'text-main', 'border-main');
                b.classList.add('text-slate-600');
            });
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));

            btn.classList.add('active', 'text-main', 'border-b-2', 'border-main');
            btn.classList.remove('text-slate-600');
            document.querySelectorAll('.tab-content')[idx].classList.remove('hidden');
        });
    });
</script>