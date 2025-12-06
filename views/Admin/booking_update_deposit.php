<!-- booking_update_deposit.php - PHIÊN BẢN HOÀN CHỈNH & ĐẸP NHẤT 2025 -->
<div class="max-w-[1900px] mx-auto p-6">

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
        <a href="?mode=admin&act=bookinglist" class="flex items-center gap-2 px-6 py-3 border border-slate-300 rounded-xl hover:bg-slate-50 transition text-sm font-medium">
            ← Danh sách booking
        </a>
    </div>

    <?php
    $total   = $databooking['total_price'] ?? 0;
    $paid    = $bookingPrices[0]['paid_amount'] ?? 0;
    $remain  = $total - $paid;
    $percent = $total > 0 ? round(($paid / $total) * 100) : 0;
    ?>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="mb-5 p-4 bg-green-50 border border-green-200 text-red rounded-lg text-sm flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> <?= $_SESSION['success_message']; ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="mb-5 p-4 bg-red-100 border-red-700 text-red-600 rounded-lg text-sm flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> <?= $_SESSION['error_message']; ?>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
    <!-- 3 Card tổng quan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <!-- Card 1: Khách hàng -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-5">Thông tin khách hàng</h3>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-600">Họ tên</span>
                    <span class="font-semibold text-slate-900"><?= htmlspecialchars($databooking['customer_name']) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Điện thoại</span>
                    <span class="font-medium><?= $databooking['customer_phone'] ?></span>
                </div>
                <div class=" flex justify-between">
                        <span class="text-slate-600">Email</span>
                        <span class="font-medium text-slate-700"><?= $databooking['customer_email'] ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-600">Loại khách</span>
                    <span class="px-4 py-1.5 rounded-full text-xs font-bold <?= $databooking['group_color'] ?>">
                        <?= htmlspecialchars($databooking['group_name']) ?>
                    </span>
                </div>
                <div class="flex justify-between pt-3 border-t">
                    <span class="text-slate-600">Số người</span>
                    <span class="text-2xl font-bold text-main"><?= $databooking['number_of_people'] ?> khách</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Tour + NÚT XEM CHI TIẾT TOUR -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-slate-800">Thông tin tour</h3>
                <a href="<?= BASE_URL ?>?mode=admin&act=admin_detail_tour&tour_id=<?= $databooking['tour_id'] ?>"
                    target="_blank"
                    class="px-4 py-2 bg-main hover:bg-hover text-white text-sm font-medium rounded-lg transition shadow hover:shadow-md flex items-center gap-2">
                    Xem chi tiết tour
                </a>
            </div>

            <div class="space-y-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-600">Mã tour</span>
                    <span class="font-mono font-bold text-main">#<?= $databooking['tour_id'] ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Ngày đi → về</span>
                    <span class="font-semibold">
                        <?= date('d/m', strtotime($databooking['start_date'])) ?> → <?= date('d/m/Y', strtotime($databooking['end_date'])) ?>
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Số ngày</span>
                    <span class="font-medium">
                        <?php
                        $days = (strtotime($databooking['end_date']) - strtotime($databooking['start_date'])) / 86400 + 1;
                        echo $days . ' ngày';
                        ?>
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Tổng tiền tour</span>
                    <span class="text-xl font-bold text-main"><?= number_format($total) ?>₫</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Tạo booking lúc</span>
                    <span class="text-slate-500"><?= date('d/m/Y H:i', strtotime($databooking['booking_created_at'])) ?></span>
                </div>

                <?php if (!empty($databooking['note'])): ?>
                    <div class="pt-4 border-t border-slate-200 mt-4">
                        <p class="text-xs text-slate-600 mb-1">Ghi chú khách hàng:</p>
                        <p class="text-slate-700"><?= nl2br(htmlspecialchars($databooking['note'])) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Card 3: Thanh toán – PHIÊN BẢN GỌN GÀNG NHẤT, ĐẸP NHẤT -->
        <div class="bg-main text-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold mb-6">Tình hình thanh toán</h3>

            <div class="space-y-5 text-sm">

                <!-- Tổng tiền -->
                <div class="flex justify-between items-baseline pb-3 border-b border-white/20">
                    <span class="opacity-90">Tổng giá trị booking</span>
                    <span class="text-2xl font-black"><?= number_format($total) ?>₫</span>
                </div>

                <!-- Đã thu -->
                <div class="flex justify-between items-end">
                    <span class="opacity-90">Đã thu</span>
                    <div class="text-right">
                        <div class="text-2xl font-bold"><?= number_format($paid) ?>₫</div>
                        <?php if (!empty($paymentLogs)): ?>
                            <div class="text-xs opacity-80 mt-1"><?= count($paymentLogs) ?> lần</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Còn lại -->
                <div class="flex justify-between items-end">
                    <span class="opacity-90">Còn phải thu</span>
                    <div class="text-right">
                        <div class="text-2xl font-bold <?= $remain > 0 ? 'text-orange-300' : 'text-emerald-300' ?>">
                            <?= number_format($remain) ?>₫
                        </div>
                        <?php if ($remain <= 0): ?>
                            <div class="text-xs mt-1 font-bold text-emerald-300">Đã thu đủ</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Thanh tiến độ đơn giản -->
                <div class="mt-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-xs opacity-80">Tiến độ</span>
                        <span class="font-bold"><?= $percent ?>%</span>
                    </div>
                    <div class="bg-white/20 rounded-full h-3 overflow-hidden">
                        <div class="bg-white h-full transition-all duration-700"
                            style="width: <?= $percent ?>%"></div>
                    </div>
                </div>

                <!-- Trạng thái hiện tại -->
                <div class="text-center pt-4 border-t border-white/20">
                    <span class="px-4 py-1.5 rounded-full text-xs font-bold <?= $databooking['payment_type_color'] ?>">
                        <?= htmlspecialchars($databooking['payment_type_name']) ?>
                    </span>
                </div>

            </div>
        </div>
    </div>

    <!-- Form cập nhật -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
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
                    <label class="block text-sm font-medium text-slate-700 mb-2">Phương thức thanh toán</label>
                    <select name="payment_method_id" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-main focus:ring-4 focus:ring-main/10 transition" required>
                        <option value="">-- Chọn phương thức --</option>
                        <?php foreach ($paymentMethods as $m): ?>
                            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="space-y-6">
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

    <!-- ==================== LỊCH SỬ THANH TOÁN (CÓ ẢNH) ==================== -->
    <?php if (!empty($paymentLogs)): ?>
        <div class="mt-10 bg-white rounded-xl shadow-sm border border-slate-200 rounded-xl overflow-hidden">
            <div class="bg-main text-white px-6 py-4 font-bold text-lg">
                Lịch sử thanh toán (<?= count($paymentLogs) ?> lần)
            </div>

            <div class="divide-y divide-slate-100">
                <?php foreach ($paymentLogs as $log):
                    $methodName = '—';
                    foreach ($paymentMethods as $m) {
                        if ($m['id'] == $log['payment_method_id']) {
                            $methodName = $m['name'];
                            break;
                        }
                    }
                    $hasImage = !empty($log['payment_image']);
                ?>
                    <div class="p-6 hover:bg-slate-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                                <div>
                                    <div class="text-slate-500">Ngày thanh toán</div>
                                    <div class="font-semibold text-slate-900"><?= date('d/m/Y H:i', strtotime($log['created_at'])) ?></div>
                                </div>
                                <div>
                                    <div class="text-slate-500">Số tiền</div>
                                    <div class="text-2xl font-bold text-main"><?= number_format($log['amount']) ?>₫</div>
                                </div>
                                <div>
                                    <div class="text-slate-500">Hình thức</div>
                                    <div class="font-medium"><?= htmlspecialchars($methodName) ?></div>
                                </div>
                                <div>
                                    <div class="text-slate-500">Mã giao dịch</div>
                                    <div class="font-mono text-sm bg-slate-100 px-3 py-1 rounded">
                                        <?= htmlspecialchars($log['transaction_code'] ?? '—') ?>
                                    </div>
                                </div>
                            </div>

                            <?php if ($hasImage): ?>
                                <button type="button"
                                    onclick="openImageModal('<?= BASE_URL ?>uploads/payments/<?= htmlspecialchars($log['payment_image']) ?>')"
                                    class="px-5 py-2.5 bg-main hover:bg-hover text-white rounded-lg text-sm font-medium transition">
                                    Xem ảnh chuyển khoản
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- ==================== NHẬT KÝ TRẠNG THÁI BOOKING ==================== -->
    <?php if (!empty($bookingLogs)): ?>
        <div class="mt-10 bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="bg-main text-white px-6 py-4 font-bold text-lg">
                Nhật ký thay đổi trạng thái
            </div>
            <div class="p-6 space-y-4">
                <?php foreach ($bookingLogs as $log): ?>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="shrink-0 text-xs bg-slate-100 text-slate-600 px-3 py-1.5 rounded-full">
                            <?= date('d/m/Y H:i', strtotime($log['created_at'])) ?>
                        </span>
                        <span class="text-slate-500">→</span>
                        <span class="font-medium text-slate-800">
                            <?= htmlspecialchars($log['description'] ?? 'Cập nhật trạng thái') ?>
                        </span>
                        <?php if (!empty($log['updated_by'])): ?>
                            <span class="text-xs text-slate-400">(NV: <?= $log['updated_by'] ?>)</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- Modal xem ảnh thanh toán (đơn giản + đẹp) -->
<script>
    function openImageModal(src) {
        // Xóa modal cũ nếu có
        const old = document.getElementById('paymentImageModal');
        if (old) old.remove();

        const modal = document.createElement('div');
        modal.id = 'paymentImageModal';
        modal.className = 'fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4';
        modal.innerHTML = `
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 bg-main text-white">
                <h3 class="font-bold text-lg">Ảnh minh chứng thanh toán</h3>
                <button type="button" onclick="this.closest('#paymentImageModal').remove()" class="text-2xl hover:opacity-70">&times;</button>
            </div>
            <div class="p-6 bg-gray-50">
                <img src="${src}" class="w-full rounded-xl shadow-lg" alt="Ảnh chuyển khoản">
            </div>
        </div>
    `;
        document.body.appendChild(modal);
    }
</script>