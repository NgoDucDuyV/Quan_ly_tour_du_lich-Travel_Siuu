<div class="max-w-[1900px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý chi tiết Booking</li>
        </ul>
    </nav>
    <!-- Header + Trạng thái -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-6">
            <h1 class="text-3xl font-bold text-slate-900">
                Cập nhật thanh toán: <?= htmlspecialchars($databooking['booking_code']) ?>
            </h1>
            <div class="flex gap-3">
                <span class="px-5 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">
                    <?= htmlspecialchars($databooking['status_type_name'] ?? 'Chờ xác nhận') ?>
                </span>
                <span class="px-5 py-2 rounded-full text-sm font-bold <?= $databooking['payment_type_color'] ?>">
                    <?= htmlspecialchars($databooking['payment_type_name']) ?>
                </span>
            </div>
        </div>
        <a href="?mode=admin&act=bookinglist" class="flex items-center gap-2 px-6 py-3 border border-slate-300 rounded-xl hover:text-hover hover:bg-light transition text-main text-sm font-medium">
            ← Danh sách booking
        </a>
    </div>

    <?php
    $total   = $databooking['total_price'] ?? 0;
    $paid    = $bookingPrices[0]['paid_amount'] ?? 0;
    $remain  = $total - $paid;
    $percent = $total > 0 ? round(($paid / $total) * 100) : 0;
    ?>

    <!-- Thông báo -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-lg text-sm flex items-center gap-2 text-green-800">
            <i class="fa-solid fa-check-circle"></i> <?= $_SESSION['success_message'];
                                                        unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="mb-5 p-4 bg-red-100 border border-red-200 rounded-lg text-sm flex items-center gap-2 text-red-800">
            <i class="fa-solid fa-exclamation-triangle"></i> <?= $_SESSION['error_message'];
                                                                unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <!-- 3 Card tổng quan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Khách hàng -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-5">Thông tin khách hàng</h3>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between"><span class="text-slate-600">Họ tên</span><span class="font-semibold"><?= htmlspecialchars($databooking['customer_name']) ?></span></div>
                <div class="flex justify-between"><span class="text-slate-600">Điện thoại</span><span class="font-medium"><?= $databooking['customer_phone'] ?></span></div>
                <div class="flex justify-between"><span class="text-slate-600">Email</span><span class="font-medium text-slate-700"><?= $databooking['customer_email'] ?></span></div>
                <div class="flex justify-between items-center"><span class="text-slate-600">Loại khách</span><span class="px-4 py-1.5 rounded-full text-xs font-bold <?= $databooking['group_color'] ?>"><?= htmlspecialchars($databooking['group_name']) ?></span></div>
                <div class="flex justify-between pt-3 border-t"><span class="text-slate-600">Số người</span><span class="text-2xl font-bold text-main"><?= $databooking['number_of_people'] ?> khách</span></div>
            </div>
        </div>

        <!-- Card 2: Tour -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-slate-800">Thông tin tour</h3>
                <a href="<?= BASE_URL ?>?mode=admin&act=admin_detail_tour&tour_id=<?= $databooking['tour_id'] ?>" target="_blank"
                    class="px-4 py-2 bg-main hover:bg-hover text-white text-sm font-medium rounded-lg transition flex items-center gap-2">
                    Xem chi tiết tour
                </a>
            </div>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between"><span class="text-slate-600">Mã tour</span><span class="font-mono font-bold text-main">#<?= $databooking['tour_id'] ?></span></div>
                <div class="flex justify-between"><span class="text-slate-600">Ngày đi → về</span><span class="font-semibold"><?= date('d/m', strtotime($databooking['start_date'])) ?> → <?= date('d/m/Y', strtotime($databooking['end_date'])) ?></span></div>
                <div class="flex justify-between"><span class="text-slate-600">Số ngày</span><span class="font-medium"><?php $days = (strtotime($databooking['end_date']) - strtotime($databooking['start_date'])) / 86400 + 1;
                                                                                                                        echo $days . ' ngày'; ?></span></div>
                <div class="flex justify-between"><span class="text-slate-600">Tổng tiền tour</span><span class="text-xl font-bold text-main"><?= number_format($total) ?>₫</span></div>
                <div class="flex justify-between"><span class="text-slate-600">Tạo booking lúc</span><span class="text-slate-500"><?= date('d/m/Y H:i', strtotime($databooking['booking_created_at'])) ?></span></div>
                <?php if (!empty($databooking['note'])): ?>
                    <div class="pt-4 border-t border-slate-200 mt-4">
                        <p class="text-xs text-slate-600 mb-1">Ghi chú khách hàng:</p>
                        <p class="text-slate-700"><?= nl2br(htmlspecialchars($databooking['note'])) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Card 3: Thanh toán -->
        <div class="bg-main text-white rounded-xl shadow-lg p-6">
            <h2 class="text-lg font-bold mb-6 text-white">Tình hình thanh toán</h3>
                <div class="space-y-5 text-sm">
                    <div class="flex justify-between items-baseline pb-3 border-b border-white/20">
                        <span class="opacity-90">Tổng giá trị booking</span>
                        <span class="text-2xl font-black"><?= number_format($total) ?>₫</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="opacity-90">Đã thu</span>
                        <div class="text-right">
                            <div class="text-2xl font-bold"><?= number_format($paid) ?>₫</div>
                            <?php if (!empty($paymentLogs)): ?><div class="text-xs opacity-80 mt-1"><?= count($paymentLogs) ?> lần</div><?php endif; ?>
                        </div>
                    </div>
                    <div class="flex justify-between items-end">
                        <span class="opacity-90">Còn phải thu</span>
                        <div class="text-right">
                            <div class="text-2xl font-bold <?= $remain > 0 ? 'text-orange-300' : 'text-emerald-300' ?>">
                                <?= number_format($remain) ?>₫
                            </div>
                            <?php if ($remain <= 0): ?><div class="text-xs mt-1 font-bold text-emerald-300">Đã thu đủ</div><?php endif; ?>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="flex justify-between mb-2"><span class="text-xs opacity-80">Tiến độ</span><span class="font-bold"><?= $percent ?>%</span></div>
                        <div class="bg-white/20 rounded-full h-3 overflow-hidden">
                            <div class="bg-white h-full transition-all duration-700" style="width: <?= $percent ?>%"></div>
                        </div>
                    </div>
                    <div class="text-center pt-4 border-t border-white/20">
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold <?= $databooking['payment_type_color'] ?>">
                            <?= htmlspecialchars($databooking['payment_type_name']) ?>
                        </span>
                    </div>
                </div>
        </div>
    </div>

    <div class="sticky top-0 shadow-xl z-40 bg-white border-b border-slate-200 shadow-sm -mt-4 mb-8 rounded-b-2xl">
        <div class="flex overflow-x-auto scrollbar-hide rounded-b-2xl">
            <a href="#payment-form" class="tab-link text-main flex-1 py-5 px-6 text-center font-bold text-sm hover:bg-slate-50 transition active">Cập nhật thanh toán</a>
            <a href="#payment-history" class="tab-link text-main flex-1 py-5 px-6 text-center font-bold text-sm hover:bg-slate-50 transition">Lịch sử thanh toán</a>
            <a href="#status-log" class="tab-link text-main flex-1 py-5 px-6 text-center font-bold text-sm hover:bg-slate-50 transition">Nhật ký trạng thái</a>
            <a href="#customer-list" class="tab-link text-main flex-1 py-5 px-6 text-center font-bold text-sm hover:bg-slate-50 transition">Danh sách khách</a>
            <a href="#detail-info" class="tab-link text-main flex-1 py-5 px-6 text-center font-bold text-sm hover:bg-slate-50 transition">Thông tin chi tiết</a>
        </div>
    </div>


    <!-- 1. CẬP NHẬT THANH TOÁN -->
    <div id="payment-form" class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-8">Cập nhật Xác Nhập Đăt chỗ ( Cọc Booking)</h2>

        <form action="<?= BASE_URL ?>?mode=admin&act=updatedeposit&booking_id=<?= $databooking['booking_id'] ?>"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Trạng thái Booking</label>
                    <select name="booking_status_type_id" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-main focus:ring-4 focus:ring-main/10 transition" required>
                        <option value="">-- Chọn trạng thái --</option>
                        <?php foreach ($bookingStatusTypes as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= $s['id'] == $databooking['status_type_id_master'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Trạng thái Thanh toán</label>
                    <select name="payment_status_type_id" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-main focus:ring-4 focus:ring-main/10 transition" required>
                        <option value="">-- Chọn trạng thái thanh toán --</option>
                        <?php foreach ($paymentStatusTypes as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= $p['id'] == $databooking['payment_type_id_master'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class=" block text-sm font-medium text-slate-700 mb-2">Phương thức thanh toán</label>
                    <select name="payment_method_id" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-main focus:ring-4 focus:ring-main/10 transition" required>
                        <option value="">-- Chọn phương thức --</option>
                        <?php foreach ($paymentMethods as $m): ?>
                            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Loại thanh toán</label>
                    <select name="payment_type_id" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-main focus:ring-4 focus:ring-main/10 transition" required>
                        <option value="">-- Chọn trạng thái thanh toán --</option>
                        <?php foreach ($paymentTypes as $p): ?>
                            <option value="<?= $p['id'] ?>">
                                <?= htmlspecialchars($p['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class=" space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Số tiền nhận lần này (VNĐ)
                    </label>

                    <!-- Input thật – bạn vẫn gõ bình thường ở đây -->
                    <input type="text"
                        name="amount"
                        id="amount-input"
                        value="<?= $remain > 0 ? number_format($remain) : '0' ?>"
                        class="w-full px-5 py-4 text-2xl font-bold text-right border-2 border-dashed border-slate-300 rounded-lg focus:border-main focus:ring-4 focus:ring-main/10 transition-all duration-200 focus:outline-none"
                        placeholder="0"
                        autocomplete="off"
                        required>

                    <!-- Thông báo bên dưới -->
                    <?php if ($remain <= 0): ?>
                        <p class="text-emerald-600 font-medium mt-3 flex items-center">
                            Đã thu đủ tiền tour
                        </p>
                    <?php else: ?>
                        <p class="text-orange-600 font-medium mt-3">
                            Còn phải thu: <strong><?= number_format($remain) ?>₫</strong>
                            <?php if ($paid > 0): ?>
                                <span class="text-sm block text-gray-600 mt-1">
                                    Đã thu: <?= number_format($paid) ?>₫ (<?= $percent ?>% tổng tiền)
                                </span>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                </div>

                <script>
                    // Tự động định dạng tiền Việt Nam khi gõ
                    document.getElementById('amount-input').addEventListener('input', function(e) {
                        let value = e.target.value;

                        // Chỉ giữ lại số
                        value = value.replace(/\D/g, '');

                        // Nếu rỗng → để 0
                        if (value === '' || value === '0') {
                            e.target.value = '0';
                            return;
                        }

                        // Định dạng có dấu chấm hàng nghìn
                        const formatted = Number(value).toLocaleString('vi-VN');
                        e.target.value = formatted;
                    });

                    // Khi submit form: chuyển về số nguyên (loại bỏ dấu chấm)
                    document.querySelector('form').addEventListener('submit', function() {
                        const input = document.getElementById('amount-input');
                        let cleanValue = input.value.replace(/\D/g, ''); // Xóa hết dấu chấm
                        input.value = cleanValue || '0'; // Gán lại giá trị sạch để gửi đi
                    });
                </script>
                <div class="mt-6">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Mã giao dịch
                        <span class="text-xs text-slate-500">(nếu có)</span>
                    </label>
                    <input type="text"
                        name="transaction_code"
                        placeholder="VD: TXN123456789, MBVCB.123456789, STK1234567890..."
                        class="w-full px-5 py-4 text-lg border-2 border-dashed border-slate-300 rounded-lg focus:border-main focus:ring-4 focus:ring-main/10 transition-all duration-200 focus:outline-none"
                        autocomplete="off">
                    <p class="text-xs text-slate-500 mt-2">
                        Nhập mã giao dịch ngân hàng, ví điện tử hoặc mã chuyển khoản
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Ghi chú (mã giao dịch, ảnh...)</label>
                    <textarea name="note" rows="3" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-main focus:ring-4 focus:ring-main/10 transition" placeholder="VD: Chuyển khoản Vietcombank lúc 15:30, mã TXN123..." required><?= htmlspecialchars($databooking['note'] ?? '') ?></textarea>
                </div>

                <!-- TRƯỜNG UPLOAD ẢNH THANH TOÁN -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Ảnh minh chứng thanh toán (nếu có)
                    </label>
                    <input type="file"
                        name="payment_image"
                        accept="image/*"
                        class="w-full px-4 py-3 border border-dashed border-slate-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-main file:text-white hover:file:bg-hover cursor-pointer transition"
                        required>
                    <p class="text-xs text-slate-500 mt-2">Hỗ trợ: JPG, PNG, GIF (tối đa 5MB)</p>
                </div>
            </div>

            <div class="md:col-span-2 flex justify-end gap-4 mt-8 pt-8 border-t border-slate-200">
                <a href="?mode=admin&act=booking" class="px-8 py-3 border border-slate-300 rounded-xl hover:bg-slate-50 font-medium transition">
                    Hủy
                </a>
                <button type="submit" class="px-10 py-3 bg-main hover:bg-hover text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center gap-3">
                    Lưu cập nhật
                </button>
            </div>
        </form>
    </div>

    <!-- 2 lihc sử thanh toán -->
    <div id="payment-history" class="mb-12">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-5 flex items-center justify-between">
                <h3 class="text-xl font-bold text-white ">Lịch sử thanh toán</h3>
                <span class="bg-white/25 px-5 py-2 rounded-full text-sm font-bold">
                    <?= count($paymentLogs ?? []) ?> giao dịch
                </span>
            </div>

            <?php if (!empty($paymentLogs)): ?>
                <div class="p-6 space-y-6">
                    <?php foreach ($paymentLogs as $log):
                        $imagePath     = !empty($log['payment_image']) ? BASE_URL . $log['payment_image'] : null;
                        $statusColor   = $log['status_color'] ?? 'bg-orange-100 text-orange-700';
                        $updatedName   = $log['updated_by_name'] ?? null;
                        $updatedAvatar = !empty($log['updated_by_avatar']) ? BASE_URL . str_replace('\\', '/', $log['updated_by_avatar']) : null;
                    ?>
                        <div class="bg-gray-50/70 rounded-2xl p-6 flex items-start justify-between gap-6 border border-gray-100">
                            <!-- Cột trái: Thông tin chính -->
                            <div class="flex-1">
                                <!-- Ngày + Trạng thái -->
                                <div class="flex items-center gap-5 mb-4">
                                    <div class="text-center">
                                        <div class="text-4xl font-black text-blue-600">
                                            <?= date('d', strtotime($log['created_at'])) ?>
                                        </div>
                                        <div class="text-sm text-gray-500"><?= date('m/Y', strtotime($log['created_at'])) ?></div>
                                        <div class="text-xs text-gray-400"><?= date('H:i', strtotime($log['created_at'])) ?></div>
                                    </div>

                                    <div class="px-4 py-2 rounded-full text-sm font-bold <?= $statusColor ?>">
                                        <?= $log['status_name'] ?? 'Đã đặt cọc' ?>
                                    </div>
                                </div>

                                <!-- Số tiền -->
                                <div class="text-3xl font-black text-green-600 mb-4">
                                    <?= number_format($log['amount'], 0, ',', '.') ?>₫
                                </div>

                                <!-- Thông tin phụ -->
                                <div class="space-y-2 text-sm text-gray-700">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium"><?= htmlspecialchars($log['method_name'] ?? 'Chuyển khoản') ?></span>
                                        <?php if (!empty($log['type_name'])): ?>
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">
                                                <?= $log['type_name'] ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!empty($log['transaction_code'])): ?>
                                        <div>Mã GD:
                                            <span class="font-mono font-bold text-blue-600"><?= $log['transaction_code'] ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($log['note'])): ?>
                                        <div class="text-sm text-gray-600 mt-2 leading-relaxed">
                                            Ghi chú: <?= htmlspecialchars($log['note']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- DÒNG MỚI: NGƯỜI CẬP NHẬT (ĐẸP NHƯ ẢNH) -->
                                <?php if ($updatedName): ?>
                                    <div class="flex items-center gap-3 mt-5 pt-4 border-t border-gray-200">
                                        <?php if ($updatedAvatar): ?>
                                            <img src="<?= $updatedAvatar ?>"
                                                alt="<?= htmlspecialchars($updatedName) ?>"
                                                class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-lg">
                                        <?php else: ?>
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                                <?= mb_substr($updatedName, 0, 1) ?>
                                            </div>
                                        <?php endif; ?>

                                        <div>
                                            <p class="text-xs text-gray-500">Cập nhật bởi</p>
                                            <p class="font-semibold text-gray-800"><?= htmlspecialchars($updatedName) ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Ảnh chứng từ -->
                            <div class="flex-shrink-0">
                                <?php if ($imagePath): ?>
                                    <img src="<?= $imagePath ?>"
                                        onclick="openPaymentImage('<?= $imagePath ?>')"
                                        class="w-28 h-28 object-cover rounded-2xl shadow-xl border-4 border-white cursor-pointer hover:scale-105 transition-all duration-300">
                                    <p class="text-center text-xs text-gray-500 mt-2">Click để xem lớn</p>
                                <?php else: ?>
                                    <div class="w-28 h-28 bg-gray-200 border-2 border-dashed rounded-2xl flex items-center justify-center">
                                        <i class="fa-solid fa-image text-gray-400 text-3xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-20 text-gray-400">
                    <i class="fa-solid fa-receipt text-6xl mb-4"></i>
                    <p class="text-lg font-medium">Chưa có thanh toán nào</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal xem ảnh – chạy 100% -->
    <script>
        function openPaymentImage(src) {
            const old = document.getElementById('paymentImageModal');
            if (old) old.remove();

            const modal = document.createElement('div');
            modal.id = 'paymentImageModal';
            modal.className = 'fixed inset-0 z-[99999] flex items-center justify-center bg-black/95 p-4';
            modal.innerHTML = `
        <div class="relative max-w-4xl w-full">
            <button onclick="this.closest('#paymentImageModal').remove()" 
                    class="absolute -top-12 right-0 text-white text-5xl hover:text-gray-300">&times;</button>
            <img src="${src}" class="w-full max-h-[90vh] object-contain rounded-2xl shadow-2xl">
        </div>
    `;
            document.body.appendChild(modal);
            modal.onclick = e => e.target === modal && modal.remove();
        }
    </script>

    <!-- 3 lịch sử trang thái bookign  -->
    <div id="status-log" class="mb-12">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-main to-main/90 text-white px-6 py-4 flex items-center justify-between">
                <h3 class="text-xl font-bold text-white">Nhật ký thay đổi trạng thái</h3>
                <span class="bg-white/25 px-4 py-1.5 rounded-full text-sm font-bold">
                    <?= count($bookingLogs ?? []) ?> thay đổi
                </span>
            </div>

            <?php if (!empty($bookingLogs)): ?>
                <div class="p-6 space-y-5">
                    <?php
                    $statusMap = [
                        'PENDING'       => 'Chờ xác nhận',
                        'DEPOSITED'     => 'Đã đặt cọc',
                        'ASSIGN_GUIDE'  => 'Đang phân HDV',
                        'UPCOMING'      => 'Sắp diễn ra',
                        'IN_PROGRESS'   => 'Đang diễn ra',
                        'COMPLETED'     => 'Hoàn thành',
                        'CLOSED'        => 'Kết thúc',
                        'CANCELED'      => 'Đã hủy'
                    ];
                    ?>

                    <?php foreach ($bookingLogs as $log):
                        $oldCode = strtoupper($log['old_status'] ?? '');
                        $newCode = strtoupper($log['new_status'] ?? '');

                        $oldName = $statusMap[$oldCode] ?? $oldCode ?: 'Chưa xác định';
                        $newName = $statusMap[$newCode] ?? $newCode ?: 'Chưa xác định';
                    ?>
                        <div class="flex items-start gap-5 p-6 bg-gradient-to-r from-slate-50 to-white rounded-2xl border border-slate-200 hover:shadow-lg transition-all duration-300">
                            <!-- Thời gian -->
                            <div class="shrink-0 text-center">
                                <div class="text-xs bg-white shadow-md text-slate-700 px-4 py-3 rounded-xl font-bold border border-slate-300">
                                    <?= date('d/m/Y', strtotime($log['created_at'])) ?>
                                    <div class="text-xs mt-1 opacity-70">
                                        <?= date('H:i', strtotime($log['created_at'])) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Nội dung thay đổi -->
                            <div class="flex-1">
                                <!-- Từ trạng thái cũ → mới (ĐÚNG THỨ TỰ!) -->
                                <div class="flex items-center gap-4 mb-3">
                                    <span class="px-4 py-2 bg-gray-200 text-gray-700 rounded-full text-xs font-bold">
                                        <?= htmlspecialchars($oldName) ?>
                                    </span>
                                    <i class="fa-solid fa-arrow-right-long text-main text-xl"></i>
                                    <span class="px-4 py-2 bg-main text-white rounded-full text-xs font-bold shadow-md">
                                        <?= htmlspecialchars($newName) ?>
                                    </span>
                                </div>

                                <!-- Mô tả chi tiết -->
                                <?php if (!empty($log['description'])): ?>
                                    <p class="text-slate-800 font-medium leading-relaxed text-sm">
                                        <?= nl2br(htmlspecialchars($log['description'])) ?>
                                    </p>
                                <?php else: ?>
                                    <p class="text-slate-500 italic text-sm">Cập nhật trạng thái</p>
                                <?php endif; ?>

                                <!-- Người thực hiện -->
                                <?php if (!empty($log['updated_by'])):
                                    $user = (new UserModel())->getAllUserById($log['updated_by']);
                                    $userName = $user['fullname'] ?? "NV #{$log['updated_by']}";
                                ?>
                                    <p class="text-xs text-slate-500 mt-4 flex items-center gap-2">
                                        <i class="fa-solid fa-user-tie"></i>
                                        <span>Thực hiện bởi: <strong><?= htmlspecialchars($userName) ?></strong></span>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-20 text-center text-slate-500">
                    <i class="fa-solid fa-history text-7xl mb-6 text-slate-300"></i>
                    <p class="text-lg font-medium">Chưa có thay đổi trạng thái</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 4. DANH SÁCH KHÁCH -->
    <div id="customer-list" class="mb-12">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8 text-center">
            <i class="fa-solid fa-users text-8xl text-slate-300 mb-6"></i>
            <h3 class="text-2xl font-bold text-slate-800 mb-3">Danh sách hành khách</h3>
            <p class="text-slate-600 mb-4">Tổng: <strong class="text-3xl text-main"><?= $databooking['number_of_people'] ?></strong> khách</p>
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 inline-block">
                <p class="text-amber-800 font-medium">Chưa có danh sách chi tiết khách hàng</p>
                <p class="text-xs text-amber-600 mt-2">Vui lòng cập nhật trong phần quản lý đoàn</p>
            </div>
        </div>
    </div>

    <!-- 5. THÔNG TIN CHI TIẾT -->
    <div id="detail-info" class="mb-12">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-main to-main/90 text-white px-8 py-5 text-xl font-bold">
                Thông tin chi tiết Booking
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
                <div class="space-y-5">
                    <div class="flex justify-between"><span class="font-medium text-slate-600">Mã booking</span><code class="bg-slate-100 px-4 py-2 rounded font-mono"><?= $databooking['booking_code'] ?></code></div>
                    <div class="flex justify-between"><span class="font-medium text-slate-600">Ngày tạo</span><span><?= date('d/m/Y H:i', strtotime($databooking['booking_created_at'])) ?></span></div>
                    <div class="flex justify-between"><span class="font-medium text-slate-600">Loại đoàn</span><span class="px-4 py-1.5 rounded-full text-xs font-bold <?= $databooking['group_color'] ?>"><?= htmlspecialchars($databooking['group_name']) ?></span></div>
                    <div class="flex justify-between"><span class="font-medium text-slate-600">Ghi chú khách</span><span class="text-right"><?= nl2br(htmlspecialchars($databooking['note'] ?? 'Không có')) ?></span></div>
                </div>
                <div class="space-y-5">
                    <div class="flex justify-between"><span class="font-medium text-slate-600">Tổng tiền tour</span><strong class="text-3xl text-main"><?= number_format($total) ?>₫</strong></div>
                    <div class="flex justify-between"><span class="font-medium text-slate-600">Đã thu</span><strong class="text-2xl text-emerald-600"><?= number_format($paid) ?>₫</strong></div>
                    <div class="flex justify-between"><span class="font-medium text-slate-600">Còn lại</span><strong class="text-2xl text-orange-600"><?= number_format($remain) ?>₫</strong></div>
                    <div class="flex justify-between"><span class="font-medium text-slate-600">Tiến độ</span><strong class="text-2xl"><?= $percent ?>%</strong></div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS: Scroll mượt + highlight tab khi scroll -->
    <script>
        document.querySelectorAll('.tab-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                // Highlight tab đang active
                document.querySelectorAll('.tab-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Highlight tab khi scroll (tùy chọn)
        window.addEventListener('scroll', () => {
            const sections = ['payment-form', 'payment-history', 'status-log', 'customer-list', 'detail-info'];
            let current = '';

            sections.forEach(id => {
                const el = document.getElementById(id);
                if (el && el.getBoundingClientRect().top <= 100) current = id;
            });

            document.querySelectorAll('.tab-link').forEach(link => {
                link.classList.toggle('active', link.getAttribute('href') === `#${current}`);
            });
        });

        // Load lần đầu
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('.tab-link').classList.add('active');
        });
    </script>

    <style>
        .tab-link.active {
            background: #1f55ad !important;
            color: white !important;
            border-bottom: 4px solid #0f2b57;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</div>