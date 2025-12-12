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
            <div class="flex items-center justify-between mb-6 mt-5">
                <h3 class="text-lg font-bold text-slate-800">Lịch Trình Trạng Thái HDV</h3>

                <!-- Nút xem trạng thái HDV – nổi bật + icon -->
                <a href="<?= BASE_URL ?>?mode=admin&act=bookingscheduledetail&schedule_id=<?= $dataSchedulesById[0]['schedule_id'] ?>"
                    target="_blank"
                    class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white text-sm font-semibold rounded-xl transition shadow-md hover:shadow-lg flex items-center gap-2.5 transform hover:-translate-y-0.5">
                    Xem LT và Trạng thái HDV
                </a>
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
            <?php if ((float)$bookingPrices[0]['paid_amount'] > 0): ?>
                <a href="#payment-form" class="tab-link text-main flex-1 py-5 px-6 text-center font-bold text-sm hover:bg-slate-50 transition active">Cập nhật thanh toán</a>
            <?php endif; ?>
            <a href="#detail-info" class="tab-link text-main flex-1 py-5 px-6 text-center font-bold text-sm hover:bg-slate-50 transition">Thông tin chi tiết</a>
            <a href="#customer-list" class="tab-link text-main flex-1 py-5 px-6 text-center font-bold text-sm hover:bg-slate-50 transition">Danh sách khách</a>
            <a href="#payment-history" class="tab-link text-main flex-1 py-5 px-6 text-center font-bold text-sm hover:bg-slate-50 transition">Lịch sử thanh toán</a>
            <a href="#status-log" class="tab-link text-main flex-1 py-5 px-6 text-center font-bold text-sm hover:bg-slate-50 transition">Nhật ký trạng thái</a>
        </div>
    </div>


    <?php if ((float)$bookingPrices[0]['paid_amount'] > 0): ?>
        <!-- 1. CẬP NHẬT THANH TOÁN -->
        <div id="payment-form" class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-8">Cập nhật Xác Nhập Đăt chỗ ( Cọc Booking)</h2>

            <form action="<?= BASE_URL ?>?mode=admin&act=updatepayment&booking_id=<?= $databooking['booking_id'] ?>"
                method="POST"
                enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Trạng thái Booking
                        </label>
                        <select name="booking_status_type_id"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-main focus:ring-4 focus:ring-main/10 transition">

                            <option value="<?= $databooking['status_type_id_master'] ?>" selected hidden>
                                <?= htmlspecialchars($databooking['status_type_name'] ?? 'Trạng thái hiện tại') ?>
                            </option>

                            <?php foreach ($bookingStatusTypes as $s): ?>
                                <?php if ($s['id'] == 8):
                                ?>
                                    <option value="<?= $s['id'] ?>">
                                        <?= htmlspecialchars($s['name']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>

                        <div class="mt-2 text-xs text-slate-500">
                            Trạng thái hiện tại:
                            <span class="font-medium text-slate-700">
                                <?= htmlspecialchars($databooking['status_type_name'] ?? 'Chưa xác định') ?>
                            </span>
                            <?php if ($databooking['status_type_id_master'] != 8): ?>
                                → Có thể chuyển thành <strong class="text-red-600">Đã hủy</strong>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Trạng thái Thanh toán
                        </label>
                        <select name="payment_status_type_id"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-main focus:ring-4 focus:ring-main/10 transition"
                            required>

                            <option value="">-- Chọn trạng thái thanh toán --</option>

                            <?php foreach ($paymentStatusTypes as $p): ?>
                                <?php
                                if (in_array($p['id'], [3, 4, 5])):
                                ?>
                                    <option value="<?= $p['id'] ?>"
                                        <?= $p['id'] == $databooking['payment_type_id_master'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p['name']) ?>
                                    </option>
                                <?php endif; ?>
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
    <?php endif; ?>

    <!-- chi tiêt các dịch vụ thanth taiosn -->
    <div id="detail-info" class="mb-12">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-main to-main/90 text-white px-8 py-5 text-xl font-bold">
                Thông tin chi tiết Booking
            </div>

            <div class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-10 text-sm">

                <!-- CỘT TRÁI: Thông tin khách -->
                <div class="space-y-6">
                    ">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-slate-600">Mã booking</span>
                        <code class="bg-slate-100 px-5 py-2.5 rounded-lg font-mono text-main font-bold text-lg">
                            <?= $databooking['booking_code'] ?>
                        </code>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-medium text-slate-600">Khách hàng</span>
                        <div class="text-right">
                            <p class="font-bold text-gray-900"><?= htmlspecialchars($databooking['customer_name']) ?></p>
                            <p class="text-sm text-gray-600"><?= $databooking['customer_phone'] ?> • <?= $databooking['customer_email'] ?></p>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-medium text-slate-600">Ngày tạo</span>
                        <span class="font-semibold"><?= date('d/m/Y H:i', strtotime($databooking['booking_created_at'])) ?></span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="font-medium text-slate-600">Trạng thái</span>
                        <span class="px-5 py-2.5 rounded-full text-sm font-bold <?= $databooking['payment_type_color'] ?>">
                            <?= $databooking['status_type_name'] ?>
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="font-medium text-slate-600">Loại đoàn</span>
                        <span class="px-4 py-2 rounded-full text-xs font-bold <?= $databooking['group_color'] ?>">
                            <?= htmlspecialchars($databooking['group_name']) ?>
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="font-medium text-slate-600">Số khách</span>
                        <span class="text-3xl font-black text-main"><?= $databooking['number_of_people'] ?> người</span>
                    </div>

                    <?php if (!empty($databooking['note'])): ?>
                        <div class="pt-4 border-t border-slate-200">
                            <p class="font-medium text-slate-600 mb-2">Ghi chú từ khách:</p>
                            <div class="bg-slate-50 p-4 rounded-xl text-slate-800">
                                <?= nl2br(htmlspecialchars($databooking['note'])) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- CỘT PHẢI: Giá tour + Dịch vụ -->
                <div class="space-y-6">

                    <!-- Tổng quan giá – chỉ xanh + xám -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200">
                        <h3 class="font-bold text-blue-900 mb-5">Chi tiết giá tour</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between text-lg">
                                <span>Giá hành khách</span>
                                <span class="font-bold"><?= number_format((float)$databooking['passenger_prices']) ?>₫</span>
                            </div>
                            <div class="flex justify-between text-lg">
                                <span>Giá dịch vụ</span>
                                <span class="font-bold"><?= number_format((float)$databooking['service_prices']) ?>₫</span>
                            </div>
                            <div class="flex justify-between text-2xl font-black pt-4 border-t-2 border-blue-200">
                                <span>TỔNG CỘNG</span>
                                <span class="text-main"><?= number_format((float)$databooking['total_price']) ?>₫</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- DỊCH VỤ KÈM THEO – GỌN, SẠCH, ĐẸP -->
            <div class="p-8 border-t border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-5">
                    Dịch vụ kèm theo (<?= count($bookingServicesByBoookingid) ?> mục)
                </h3>

                <?php if (empty($bookingServicesByBoookingid)): ?>
                    <div class="text-center py-10 bg-gray-50 rounded-xl text-gray-500">
                        Không có dịch vụ kèm theo
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($bookingServicesByBoookingid as $sv): ?>
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:bg-gray-100 transition">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="font-bold text-gray-900"><?= htmlspecialchars($sv['service_name']) ?></h4>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Số lượng: <strong><?= $sv['service_quantity'] ?></strong>
                                            <?= !empty($sv['service_note']) ? ' • ' . htmlspecialchars($sv['service_note']) : '' ?>
                                        </p>
                                    </div>
                                    <p class="text-xl font-black text-main">
                                        <?= number_format((float)$sv['service_price']) ?>₫
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <!-- DANH SÁCH HÀNH KHÁCH – TÁCH RIÊNG, ĐƠN GIẢN, ĐẸP -->
    <div id="customer-list" class="mb-12">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-main to-main/90 text-white px-8 py-6">
                <h3 class="text-2xl font-bold">Danh sách hành khách</h3>
                <p class="mt-2 text-blue-100">
                    Tổng: <strong class="text-3xl"><?= $databooking['number_of_people'] ?></strong> khách
                </p>
            </div>

            <div class="p-8 space-y-10">

                <?php
                // Tách khách theo loại
                $groups = [
                    'nguoi_lon' => ['name' => 'Người lớn',    'count' => 0],
                    'tre_em'    => ['name' => 'Trẻ em',      'count' => 0],
                    'em_be'     => ['name' => 'Em bé',       'count' => 0],
                ];

                foreach ($bookingcustomers as $c) {
                    $code = $c['customer_type_code'];
                    if (isset($groups[$code])) $groups[$code]['count']++;
                }
                ?>

                <!-- BẢNG NGƯỜI LỚN -->
                <?php if ($groups['nguoi_lon']['count'] > 0): ?>
                    <div>
                        <div class="bg-blue-50 border-l-4 border-main px-6 py-4 font-bold text-lg text-blue-900">
                            Người lớn – <?= $groups['nguoi_lon']['count'] ?> khách
                        </div>
                        <div class="overflow-x-auto mt-3">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">STT</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Họ tên</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Năm sinh</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Hộ chiếu</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $stt = 1;
                                    foreach ($bookingcustomers as $c): ?>
                                        <?php if ($c['customer_type_code'] !== 'nguoi_lon') continue; ?>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-6 py-4"><?= $stt++ ?></td>
                                            <td class="px-6 py-4 font-medium"><?= htmlspecialchars($c['full_name']) ?></td>
                                            <td class="px-6 py-4"><?= date('d/m/Y', strtotime($c['birth_year'])) ?></td>
                                            <td class="px-6 py-4 font-mono"><?= $c['passport'] ?></td>
                                            <td class="px-6 py-4">
                                                <?= !empty($c['note']) ? '<span class="text-amber-700 font-medium">' . htmlspecialchars($c['note']) . '</span>' : '<span class="text-gray-400">—</span>' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- BẢNG TRẺ EM -->
                <?php if ($groups['tre_em']['count'] > 0): ?>
                    <div>
                        <div class="bg-green-50 border-l-4 border-green-600 px-6 py-4 font-bold text-lg text-green-900">
                            Trẻ em – <?= $groups['tre_em']['count'] ?> khách
                        </div>
                        <div class="overflow-x-auto mt-3">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">STT</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Họ tên</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Năm sinh</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Hộ chiếu</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $stt = 1;
                                    foreach ($bookingcustomers as $c): ?>
                                        <?php if ($c['customer_type_code'] !== 'tre_em') continue; ?>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-6 py-4"><?= $stt++ ?></td>
                                            <td class="px-6 py-4 font-medium"><?= htmlspecialchars($c['full_name']) ?></td>
                                            <td class="px-6 py-4"><?= date('d/m/Y', strtotime($c['birth_year'])) ?></td>
                                            <td class="px-6 py-4 font-mono"><?= $c['passport'] ?></td>
                                            <td class="px-6 py-4">
                                                <?= !empty($c['note']) ? '<span class="text-amber-700 font-medium">' . htmlspecialchars($c['note']) . '</span>' : '<span class="text-gray-400">—</span>' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- BẢNG EM BÉ -->
                <?php if ($groups['em_be']['count'] > 0): ?>
                    <div>
                        <div class="bg-purple-50 border-l-4 border-purple-600 px-6 py-4 font-bold text-lg text-purple-900">
                            Em bé – <?= $groups['em_be']['count'] ?> khách
                        </div>
                        <div class="overflow-x-auto mt-3">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">STT</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Họ tên</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Năm sinh</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Hộ chiếu</th>
                                        <th class="text-left px-6 py-3 font-medium text-gray-700">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $stt = 1;
                                    foreach ($bookingcustomers as $c): ?>
                                        <?php if ($c['customer_type_code'] !== 'em_be') continue; ?>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-6 py-4"><?= $stt++ ?></td>
                                            <td class="px-6 py-4 font-medium"><?= htmlspecialchars($c['full_name']) ?></td>
                                            <td class="px-6 py-4"><?= date('d/m/Y', strtotime($c['birth_year'])) ?></td>
                                            <td class="px-6 py-4 font-mono"><?= $c['passport'] ?></td>
                                            <td class="px-6 py-4">
                                                <?= !empty($c['note']) ? '<span class="text-amber-700 font-medium">' . htmlspecialchars($c['note']) . '</span>' : '<span class="text-gray-400">—</span>' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Không có khách nào -->
                <?php if (empty($bookingcustomers)): ?>
                    <div class="text-center py-16 bg-gray-50 rounded-xl">
                        <p class="text-xl text-gray-600">Chưa có danh sách khách hàng</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- lihc sử thanh toán -->
    <!-- LỊCH SỬ THANH TOÁN – GỌN, ĐẸP, CÓ ẢNH NGƯỜI CẬP NHẬT -->
    <div id="payment-history" class="mb-12">
        <div class="bg-white rounded-3xl shadow-lg border border-gray-200 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-6">
                <h3 class="text-2xl font-bold">Lịch sử thanh toán</h3>
                <p class="text-blue-100 mt-1"><?= count($paymentLogs ?? []) ?> giao dịch</p>
            </div>

            <?php if (empty($paymentLogs)): ?>
                <div class="text-center py-20 bg-gray-50">
                    <i class="fa-solid fa-receipt text-7xl text-gray-300 mb-5"></i>
                    <p class="text-xl text-gray-600">Chưa có thanh toán nào</p>
                </div>
            <?php else: ?>
                <div class="p-6 space-y-6">

                    <?php foreach ($paymentLogs as $log):
                        $amount              = (float)($log['amount'] ?? 0);
                        $isRefund            = $amount < 0;
                        $methodName          = $log['method_name'] ?? 'Không xác định';
                        $typeName            = $log['type_name'] ?? '';
                        $transactionCode     = $log['transaction_code'] ?? '';
                        $note                = $log['note'] ?? '';
                        $statusName          = $log['status_name'] ?? 'Đã thanh toán';
                        $updatedByName       = $log['updated_by_name'] ?? '';
                        $updatedByAvatar     = !empty($log['updated_by_avatar'])
                            ? BASE_URL . str_replace('\\', '/', $log['updated_by_avatar'])
                            : null;
                        $imagePath          = !empty($log['payment_image']) ? BASE_URL . $log['payment_image'] : null;

                        // Màu trạng thái đơn giản
                        $statusColor = ($log['payment_status_type_id'] ?? 0) == 3
                            ? 'text-emerald-700 bg-emerald-100'
                            : ($isRefund ? 'text-red-700 bg-red-100' : 'text-blue-700 bg-blue-100');
                    ?>

                        <!-- MỖI GIAO DỊCH – CARD RIÊNG, TÁCH RẼ, CÓ ẢNH NGƯỜI CẬP NHẬT -->
                        <div class="bg-gray-50/70 rounded-2xl p-6 border border-gray-200 hover:shadow-md transition-all">

                            <div class="flex items-start gap-5">

                                <!-- Ngày + Số tiền -->
                                <div class="text-center">
                                    <div class="text-4xl font-black text-blue-600">
                                        <?= date('d', strtotime($log['created_at'])) ?>
                                    </div>
                                    <div class="text-sm text-gray-600"><?= date('m/Y', strtotime($log['created_at'])) ?></div>
                                    <div class="text-xs text-gray-500"><?= date('H:i', strtotime($log['created_at'])) ?></div>
                                </div>

                                <!-- Nội dung chính -->
                                <div class="flex-1">

                                    <!-- Trạng thái + Số tiền -->
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="px-4 py-2 rounded-full text-sm font-bold <?= $statusColor ?>">
                                            <?= $statusName ?>
                                        </span>
                                        <p class="text-3xl font-black <?= $isRefund ? 'text-red-600' : 'text-emerald-600' ?>">
                                            <?= $isRefund ? '-' : '+' ?><?= number_format(abs($amount)) ?>₫
                                        </p>
                                    </div>

                                    <!-- Thông tin ngắn gọn -->
                                    <div class="text-sm text-gray-700 space-y-1">
                                        <p class="font-medium"><?= htmlspecialchars($methodName) ?>
                                            <?= $typeName ? ' • ' . htmlspecialchars($typeName) : '' ?>
                                        </p>
                                        <?php if ($transactionCode): ?>
                                            <p class="font-mono text-blue-600">Mã GD: <?= htmlspecialchars($transactionCode) ?></p>
                                        <?php endif; ?>
                                        <?php if ($note): ?>
                                            <p class="italic text-gray-600 mt-2">"<?= htmlspecialchars($note) ?>"</p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- NGƯỜI CẬP NHẬT – CÓ ẢNH ĐẸP -->
                                    <?php if ($updatedByName): ?>
                                        <div class="flex items-center gap-3 mt-5 pt-4 border-t border-gray-200">
                                            <?php if ($updatedByAvatar): ?>
                                                <img src="<?= $updatedByAvatar ?>"
                                                    class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-lg">
                                            <?php else: ?>
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                                    <?= mb_substr($updatedByName, 0, 1) ?>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="text-xs text-gray-500">Cập nhật bởi</p>
                                                <p class="font-semibold text-gray-800"><?= htmlspecialchars($updatedByName) ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <!-- Ảnh chứng từ -->
                                <?php if ($imagePath): ?>
                                    <div class="flex-shrink-0">
                                        <img src="<?= $imagePath ?>"
                                            onclick="openImage('<?= $imagePath ?>')"
                                            class="w-24 h-24 object-cover rounded-xl shadow border-4 border-white cursor-pointer hover:scale-105 transition">
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal xem ảnh -->
    <script>
        function openImage(src) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black/90 z-[9999] flex items-center justify-center p-4 cursor-pointer';
            modal.innerHTML = `<div class="relative"><button onclick="this.parentElement.parentElement.remove()" class="absolute -top-10 right-0 text-white text-5xl">&times;</button><img src="${src}" class="max-w-full max-h-full rounded-xl"></div>`;
            document.body.appendChild(modal);
        }
    </script>

    <!--lịch sử trang thái bookign  -->
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
            const sections = ['payment-form', 'detail-info', 'customer-list', 'payment-history', 'status-log'];
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