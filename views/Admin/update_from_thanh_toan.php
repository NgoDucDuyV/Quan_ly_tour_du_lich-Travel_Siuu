<div class="max-w-[1200px] mx-auto p-6">

    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 text-slate-400">Cập nhật thanh toán</li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-semibold text-slate-900">Cập nhật Thanh Toán</h1>
        <a href="?mode=admin&act=booking"
            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm transition">
            Quay lại
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 space-y-6">

        <!-- Booking Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Mã Booking</label>
                <div class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg">
                    <?= $booking['booking_code'] ?? '#N/A' ?>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tên khách hàng</label>
                <div class="px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg">
                    <?= $booking['customer_name'] ?? 'N/A' ?>
                </div>
            </div>
        </div>

        <hr class="border-slate-200">

        <!-- Payment Form -->
        <form method="POST" enctype="multipart/form-data" class="space-y-6">

            <input type="hidden" name="booking_id" value="<?= $booking['id'] ?? '' ?>">

            <!-- Amount + Method + Type -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-1 block">Số tiền</label>
                    <input type="number" name="amount" value="<?= $payment['amount'] ?? '' ?>"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-main focus:border-main transition" required>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-1 block">Phương thức thanh toán</label>
                    <select name="payment_method_id"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-main" required>
                        <?php foreach ($datagetPaymentModel as $method): ?>
                            <option value="<?= $method['id'] ?>" <?= isset($payment['payment_method_id']) && $payment['payment_method_id'] == $method['id'] ? 'selected' : '' ?>>
                                <?= $method['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-1 block">Loại thanh toán</label>
                    <select name="payment_type_id"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-main" required>
                        <?php foreach ($dataPaymentTypes as $type): ?>
                            <option value="<?= $type['id'] ?>" <?= isset($payment['payment_type_id']) && $payment['payment_type_id'] == $type['id'] ? 'selected' : '' ?>>
                                <?= $type['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <!-- Transaction Code -->
            <div>
                <label class="text-sm font-semibold text-slate-700 mb-1 block">Mã giao dịch</label>
                <input type="text" name="transaction_code" value="<?= $payment['transaction_code'] ?? '' ?>"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-main" required>
            </div>

            <!-- Booking Status -->
            <div>
                <label class="text-sm font-semibold text-slate-700 mb-1 block">Trạng thái booking</label>
                <select name="booking_status_id"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-main" required>
                    <?php foreach ($dataBookingStatusType as $status): ?>
                        <option value="<?= $status['id'] ?>" <?= isset($booking['status_id']) && $booking['status_id'] == $status['id'] ? 'selected' : '' ?>>
                            <?= $status['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Payment Image -->
            <div>
                <label class="text-sm font-semibold text-slate-700 mb-2 block">Ảnh chứng từ thanh toán</label>
                <div class="flex items-center gap-6">
                    <div class="w-40 h-40 border border-slate-300 rounded-lg overflow-hidden bg-slate-100 flex items-center justify-center">
                        <img id="preview-img" src="<?= isset($payment['payment_image']) ? '/uploads/payment/' . $payment['payment_image'] : 'https://via.placeholder.com/200' ?>" class="w-full h-full object-cover">
                    </div>
                    <label class="cursor-pointer">
                        <span class="px-4 py-2 bg-main text-white rounded-lg hover:bg-hover transition text-sm">Tải ảnh lên</span>
                        <input type="file" name="payment_image" id="payment_image" class="hidden" accept="image/*" onchange="previewPaymentImage(event)">
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full md:w-auto px-6 py-3 bg-main text-white rounded-lg hover:bg-hover transition text-sm font-medium shadow-sm">
                Cập nhật thanh toán
            </button>
        </form>

    </div>
</div>

<script>
    function previewPaymentImage(event) {
        const output = document.getElementById('preview-img');
        output.src = URL.createObjectURL(event.target.files[0]);
    }
</script>