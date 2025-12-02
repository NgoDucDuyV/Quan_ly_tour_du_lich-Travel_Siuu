<?php
// Giả sử các biến dữ liệu đã có sẵn từ controller
// $databooking, $dataBookingStatusType, $dataPaymentTypes, $datagetBookinglogsbyid, $dataBookingServicesWithSuppliers
$old_data = $_SESSION['old_data'] ?? [];
unset($_SESSION['old_data']);
?>

<div class="max-w-[1600px] mx-auto p-6 space-y-8 font-sans">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-2" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-gray-300 text-gray-400">
                Cập nhật trạng thái Booking
            </li>
        </ul>
    </nav>

    <!-- Title -->
    <h1 class="text-3xl font-semibold text-gray-900">
        Cập nhật trạng thái Booking #<?= htmlspecialchars($databooking['booking_code']) ?>
    </h1>

    <!-- Thông báo lỗi / success -->
    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="p-4 bg-red-100 text-red-700 rounded-xl mb-4">
            <ul class="list-disc pl-5">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="p-4 bg-green-100 text-green-700 rounded-xl mb-4">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- MAIN CARD FORM -->
    <form action="<?= BASE_URL ?>?mode=admin&act=create_booking_status" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-xl space-y-8 border border-gray-200">

        <input type="hidden" name="booking_id" value="<?= $databooking['id'] ?>">
        <input type="hidden" name="old_status" value="<?= $databooking['status_code'] ?>">

        <!-- Thông tin khách hàng -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-800">Thông tin khách hàng</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Tên khách hàng</label>
                    <input name="customer_name" value="<?= htmlspecialchars($databooking['customer_name']) ?>" disabled class="w-full p-3 bg-gray-100 rounded-xl border text-gray-700 shadow-sm">
                </div>
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Số điện thoại</label>
                    <input name="customer_phone" value="<?= htmlspecialchars($databooking['customer_phone']) ?>" disabled class="w-full p-3 bg-gray-100 rounded-xl border text-gray-700 shadow-sm">
                </div>
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Email</label>
                    <input name="customer_email" value="<?= htmlspecialchars($databooking['customer_email']) ?>" disabled class="w-full p-3 bg-gray-100 rounded-xl border text-gray-700 shadow-sm">
                </div>
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Loại nhóm</label>
                    <span class="px-4 py-2 bg-indigo-100 text-indigo-800 font-medium rounded-full text-sm">
                        <?= $databooking['group_type'] == 'doan' ? 'Đoàn' : 'Lẻ' ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Trạng thái Booking -->
        <div class="space-y-3">
            <h2 class="text-xl font-semibold text-gray-800">Trạng thái booking</h2>
            <select id="status" name="booking_status"
                class="w-full p-4 border rounded-xl shadow-sm text-gray-800 font-semibold bg-gray-50">
                <?php foreach ($dataBookingStatusType as $status): ?>
                    <?php
                    $status_name_vn = '';
                    switch ($status['code']) {
                        case 'CHXACNHAN':
                            $status_name_vn = 'Chờ xác nhận';
                            break;
                        case 'DACOC':
                            $status_name_vn = 'Đã cọc';
                            break;
                        case 'HOANTAT':
                            $status_name_vn = 'Hoàn tất';
                            break;
                        case 'HUY':
                            $status_name_vn = 'Hủy';
                            break;
                    }
                    $selected = $old_data['booking_status'] ?? $databooking['status_code'];
                    ?>
                    <option value="<?= $status['code'] ?>" <?= $selected == $status['code'] ? 'selected' : '' ?>>
                        <?= $status_name_vn ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Ghi chú -->
        <div>
            <label class="block font-semibold mb-2 text-gray-700">Ghi chú</label>
            <textarea name="note" rows="3"
                class="w-full p-4 border rounded-xl shadow-sm bg-white text-gray-700"><?= htmlspecialchars($old_data['note'] ?? $databooking['note']) ?></textarea>
        </div>

        <!-- Thanh toán đặt cọc -->
        <div id="payment_section" class="<?= (($old_data['booking_status'] ?? $databooking['status_code']) === 'DACOC') ? '' : 'hidden' ?> p-6 bg-blue-50 rounded-2xl shadow-inner space-y-4 border border-blue-100">
            <h2 class="text-lg font-semibold text-blue-800">Thông tin thanh toán đặt cọc</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block font-semibold mb-2 text-blue-700">Người thanh toán</label>
                    <input name="payer_name" value="<?= htmlspecialchars($old_data['payer_name'] ?? $databooking['payer_name'] ?? '') ?>" class="w-full p-3 border rounded-xl shadow-sm" placeholder="Tên người thanh toán">
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-blue-700">Số tiền cọc</label>
                    <input name="deposit_amount" type="number" value="<?= htmlspecialchars($old_data['deposit_amount'] ?? $databooking['deposit_amount'] ?? '') ?>" class="w-full p-3 border rounded-xl shadow-sm" placeholder="Nhập số tiền">
                </div>

                <div class="md:col-span-2">
                    <label class="block font-semibold mb-2 text-blue-700">Trạng thái thannh toán</label>
                    <select name="payment_method_id" class="w-full p-3 border rounded-xl shadow-sm">
                        <option value="">-- Chọn trạng thái --</option>
                        <?php foreach ($dataPaymentTypes as $payment): ?>
                            <option value="<?= $payment['id'] ?>">
                                <?= htmlspecialchars($payment['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block font-semibold mb-2 text-blue-700">Hình ảnh chuyển tiền</label>
                    <input name="payment_image" type="file" accept="image/*" class="w-full p-3 border rounded-xl shadow-sm">
                    <?php if (!empty($databooking['payment_image'])): ?>
                        <p class="text-xs text-gray-500 mt-1">Ảnh hiện tại: <a href="./uploads/payment_images/<?= $databooking['payment_image'] ?>" target="_blank" class="underline text-blue-600"><?= $databooking['payment_image'] ?></a></p>
                    <?php endif; ?>
                </div>

                <div class="md:col-span-2">
                    <label class="block font-semibold mb-2 text-blue-700">Phương thức thanh toán</label>
                    <select name="payment_status_id" class="w-full p-3 border rounded-xl shadow-sm">
                        <option value="">-- Chọn phương thức --</option>
                        <?php foreach ($datagetPaymentModel as $payment): ?>
                            <option value="<?= $payment['id'] ?>"
                                <?= (isset($old_data['payment_status_id']) && $old_data['payment_status_id'] == $payment['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($payment['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block font-semibold mb-2 text-blue-700">Ghi chú thanh toán</label>
                    <textarea name="payment_description" rows="3" class="w-full p-3 border rounded-xl shadow-sm" placeholder="Nhập ghi chú về thanh toán (nếu có)"><?= htmlspecialchars($old_data['payment_description'] ?? $databooking['payment_description'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Lịch sử thay đổi -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-800">Lịch sử thay đổi trạng thái</h2>
            <?php foreach ($datagetBookinglogsbyid as $log): ?>
                <div class="p-4 border rounded-xl bg-gray-50 shadow-sm">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">
                            Từ:
                            <?php
                            $old_status = match ($log['old_status']) {
                                'CHXACNHAN' => 'Chờ xác nhận',
                                'DACOC' => 'Đã cọc',
                                'HOANTAT' => 'Hoàn tất',
                                'HUY' => 'Hủy',
                                default => $log['old_status']
                            };
                            $new_status = match ($log['new_status']) {
                                'CHXACNHAN' => 'Chờ xác nhận',
                                'DACOC' => 'Đã cọc',
                                'HOANTAT' => 'Hoàn tất',
                                'HUY' => 'Hủy',
                                default => $log['new_status']
                            };
                            echo "$old_status → $new_status";
                            ?>
                        </span>
                        <span class="text-sm text-gray-500"><?= $log['created_at'] ?></span>
                    </div>
                    <p class="text-gray-600 text-sm"><?= htmlspecialchars($log['description']) ?> • Nhân viên #<?= $log['updated_by'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Dịch vụ đã đặt -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-800">Dịch vụ đã đặt</h2>
            <?php foreach ($dataBookingServicesWithSuppliers as $service): ?>
                <div class="p-5 bg-white border rounded-xl shadow-sm">
                    <p class="font-medium text-gray-700">Dịch vụ: <?= htmlspecialchars($service['service_name']) ?> - Nhà cung cấp: <?= htmlspecialchars($service['supplier_name']) ?></p>
                    <p class="text-gray-600">Số lượng: <?= $service['service_quantity'] ?> - Giá: <?= number_format($service['service_price'], 0, ',', '.') ?>đ</p>
                    <p class="text-gray-600">Liên hệ: <?= htmlspecialchars($service['contact_name']) ?> - <?= htmlspecialchars($service['contact_phone']) ?> - <?= htmlspecialchars($service['contact_email']) ?></p>
                    <p class="text-gray-600">Địa chỉ: <?= htmlspecialchars($service['address']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Button submit -->
        <button type="submit"
            class="w-full md:w-auto px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 transition">
            Cập nhật trạng thái
        </button>

    </form>
</div>

<script>
    const statusSelect = document.getElementById('status');
    const paymentSection = document.getElementById('payment_section');

    statusSelect.addEventListener('change', () => {
        paymentSection.classList.toggle('hidden', statusSelect.value !== 'DACOC');
    });
</script>