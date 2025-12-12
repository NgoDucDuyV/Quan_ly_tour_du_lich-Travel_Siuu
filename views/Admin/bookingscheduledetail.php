<?php
// Dữ liệu đã xử lý – có kiểm tra tồn tại
$schedule   = $dataSchedulesStatus[0] ?? null;
$booking    = $databooking ?? null;
$guide      = $dataguideByid ?? null;           // Có thể null
$tourDetail = $dataTourDetai ?? [];             // Có thể rỗng

$start_date = $booking['start_date'] ? date('d/m/Y', strtotime($booking['start_date'])) : 'Chưa xác định';
$end_date   = $booking['end_date'] ? date('d/m/Y', strtotime($booking['end_date'])) : 'Chưa xác định';

// Group lịch trình theo ngày – chỉ khi có dữ liệu
$itineraryByDay = [];
if (!empty($tourDetail) && is_array($tourDetail)) {
    foreach ($tourDetail as $item) {
        $day = $item['day_number'] ?? 1;
        if (!isset($itineraryByDay[$day])) {
            $itineraryByDay[$day] = [
                'title' => $item['itinerary_title'] ?? 'Ngày ' . $day,
                'activities' => []
            ];
        }
        $itineraryByDay[$day]['activities'][] = [
            'time' => substr($item['activity_time'] ?? '00:00:00', 0, 5),
            'activity' => $item['activity'] ?? 'Hoạt động chưa xác định',
            'location' => $item['location'] ?? 'Chưa xác định',
            'desc' => $item['activity_description'] ?? ''
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết lịch trình – Booking #<?= $booking['booking_code'] ?? 'N/A' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        .text-main {
            color: #1d4ed8;
        }

        .bg-main {
            background-color: #1d4ed8;
        }

        .hover\\:bg-hover:hover {
            background-color: #1e40af;
        }

        .bg-light {
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="bg-gray-50 text-slate-800">

    <div class="max-w-[1900px] mx-auto p-6">

        <!-- Breadcrumb -->
        <nav class="text-sm text-slate-500 mb-4">
            <ul class="inline-flex items-center space-x-2">
                <li>Quản trị viên</li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý Booking</li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300"><a href="#" class="hover:text-slate-700">#<?= $booking['booking_code'] ?? 'N/A' ?></a></li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300 font-medium text-slate-700">Chi tiết lịch trình</li>
            </ul>
        </nav>

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-6">
                <h1 class="text-3xl font-bold text-slate-900">
                    Lịch trình Booking: <span class="text-main">#<?= $booking['booking_code'] ?? 'Chưa có mã' ?></span>
                </h1>
                <div class="flex gap-3">
                    <?php if (!empty($schedule['guide_status_name_vn'])): ?>
                        <span class="px-5 py-2 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                            <?= $schedule['guide_status_name_vn'] ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($booking['status_type_name'])): ?>
                        <span class="px-5 py-2 rounded-full text-sm font-bold bg-orange-100 text-orange-800 border border-orange-300">
                            <?= $booking['status_type_name'] ?>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($booking['payment_type_name'])): ?>
                        <span class="px-5 py-2 rounded-full text-sm font-bold <?= $booking['payment_type_color'] ?? 'bg-gray-100 text-gray-700' ?>">
                            <?= $booking['payment_type_name'] ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <a href="javascript:history.back()" class="flex items-center gap-2 px-6 py-3 border border-slate-300 rounded-xl hover:bg-light transition text-main text-sm font-medium">
                Quay lại
            </a>
        </div>

        <!-- 3 Card chính -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Card 1: Thông tin tour -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-5">Thông tin tour</h3>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between"><span class="text-slate-600">Tên tour</span><span class="font-semibold">
                            <?= !empty($tourDetail[0]['tour_name']) ? htmlspecialchars($tourDetail[0]['tour_name']) : 'Chưa có thông tin tour' ?>
                        </span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Mã tour</span><span class="font-mono text-main">
                            <?= $tourDetail[0]['tour_code'] ?? 'Chưa có' ?>
                        </span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Ngày đi → về</span><span class="font-semibold"><?= $start_date ?> → <?= $end_date ?></span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Thời lượng</span><span><?= $tourDetail[0]['duration'] ?? 'Chưa xác định' ?></span></div>
                    <div class="flex justify-between pt-3 border-t"><span class="text-slate-600">Số khách</span><span class="text-2xl font-bold text-main"><?= $booking['number_of_people'] ?? 0 ?> khách</span></div>
                </div>
            </div>

            <!-- Card 2: Hướng dẫn viên – Nếu không có thì báo "Chưa phân công" -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-5">Hướng dẫn viên phụ trách</h3>
                <?php if ($guide && !empty($guide['name'])): ?>
                    <div class="flex items-center gap-4 mb-5">
                        <img src="<?= htmlspecialchars($guide['image'] ?? '/public/upload/default-avatar.jpg') ?>"
                            class="w-20 h-20 rounded-full object-cover border-2 border-slate-200"
                            alt="<?= htmlspecialchars($guide['name']) ?>">
                        <div>
                            <div class="font-bold text-lg"><?= htmlspecialchars($guide['name']) ?></div>
                            <div class="text-sm text-slate-600">HDV #<?= str_pad($guide['id'] ?? 0, 3, '0', STR_PAD_LEFT) ?></div>
                        </div>
                    </div>
                    <div class="space-y-3 text-sm border-t border-slate-200 pt-4">
                        <div class="flex items-center gap-3"><i class="fa-solid fa-phone text-main"></i> <?= $guide['phone'] ?? 'Chưa có' ?></div>
                        <div class="flex items-center gap-3"><i class="fa-solid fa-globe text-main"></i> <?= htmlspecialchars($guide['language'] ?? 'Chưa có') ?></div>
                        <div class="flex items-center gap-3"><i class="fa-solid fa-star text-yellow-500"></i> <?= $guide['performance_score'] ?? 'Chưa đánh giá' ?>/100 điểm</div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-200">
                        <span class="inline-block px-5 py-2 bg-emerald-100 text-emerald-800 rounded-full text-sm font-bold border border-emerald-300">
                            Đã phân công
                        </span>
                    </div>
                <?php else: ?>
                    <div class="text-center py-10">
                        <i class="fa-solid fa-user-slash text-5xl text-slate-300 mb-4"></i>
                        <p class="text-lg font-medium text-slate-500">Chưa phân công hướng dẫn viên</p>
                        <p class="text-sm text-slate-400 mt-2">Booking đang chờ xử lý hoặc chưa được gán HDV</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Card 3: Khách hàng -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-5">Khách hàng đặt tour</h3>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between"><span class="text-slate-600">Họ tên</span><span class="font-semibold"><?= htmlspecialchars($booking['customer_name'] ?? 'Chưa có') ?></span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Điện thoại</span><span><?= $booking['customer_phone'] ?? 'Chưa có' ?></span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Email</span><span class="text-slate-700"><?= $booking['customer_email'] ?? 'Chưa có' ?></span></div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Loại đoàn</span>
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold <?= $booking['group_color'] ?? 'bg-gray-100 text-gray-700' ?> border <?= $booking['group_color'] ? 'border-purple-300' : 'border-gray-300' ?>">
                            <?= $booking['group_name'] ?? 'Chưa xác định' ?>
                        </span>
                    </div>
                    <?php if (!empty($booking['note'])): ?>
                        <div class="pt-4 border-t border-slate-200">
                            <p class="text-xs text-slate-600 mb-1">Ghi chú khách hàng:</p>
                            <p class="text-slate-700 text-sm"><?= nl2br(htmlspecialchars($booking['note'])) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Chi tiết lịch trình – Nếu không có thì báo "Chưa có lịch trình" -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            <div class="bg-slate-50 border-b border-slate-200 px-8 py-5">
                <h3 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                    Chi tiết lịch trình từng ngày
                </h3>
            </div>
            <?php if (!empty($itineraryByDay)): ?>
                <div class="divide-y divide-slate-100">
                    <?php foreach ($itineraryByDay as $day => $data): ?>
                        <?php
                        $dateObj = date_create($booking['start_date'] ?? date('Y-m-d'));
                        date_add($dateObj, date_interval_create_from_date_string(($day - 1) . ' days'));
                        $dateDisplay = date_format($dateObj, 'd');
                        $monthDisplay = date_format($dateObj, 'm/Y');
                        ?>
                        <div class="p-6 hover:bg-slate-50 transition">
                            <div class="flex items-start gap-6">
                                <div class="text-center min-w-[80px]">
                                    <div class="text-3xl font-black text-main"><?= $dateDisplay ?></div>
                                    <div class="text-sm font-medium text-slate-600">Th<?= ltrim($monthDisplay, '0') ?></div>
                                    <div class="text-xs text-slate-500 mt-1">Ngày <?= $day ?></div>
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-lg text-slate-900 mb-4">
                                        <?= htmlspecialchars($data['title']) ?>
                                    </div>
                                    <div class="space-y-4 text-sm">
                                        <?php foreach ($data['activities'] as $act): ?>
                                            <div class="flex items-start gap-4">
                                                <div class="w-12 h-12 bg-main/10 text-main rounded-lg flex items-center justify-center font-bold text-xs flex-shrink-0">
                                                    <?= $act['time'] !== '00:00' ? $act['time'] : 'All' ?>
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-slate-800"><?= htmlspecialchars($act['activity']) ?></div>
                                                    <div class="text-slate-600 text-sm"><?= htmlspecialchars($act['location']) ?></div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-16 bg-slate-50">
                    <i class="fa-solid fa-calendar-xmark text-6xl text-slate-300 mb-4"></i>
                    <p class="text-xl font-medium text-slate-500">Chưa có lịch trình chi tiết</p>
                    <p class="text-sm text-slate-400 mt-2">Tour này chưa được cập nhật hành trình hoặc đang chờ xử lý</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Ghi chú -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-user-tie text-amber-700 text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900">Ghi chú từ HDV</h3>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed">
                    <?= !empty($schedule['guide_notes']) ? nl2br(htmlspecialchars($schedule['guide_notes'])) : 'Chưa có ghi chú từ hướng dẫn viên.' ?>
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-user-gear text-blue-700 text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900">Ghi chú từ Quản lý</h3>
                </div>
                <div class="text-sm text-slate-700 space-y-2 leading-relaxed">
                    <?php if ($guide): ?>
                        <div>• Đã phân công HDV: <strong><?= htmlspecialchars($guide['name']) ?></strong></div>
                    <?php else: ?>
                        <div>• Chưa phân công hướng dẫn viên</div>
                    <?php endif; ?>
                    <div>• Tour đã thanh toán: <strong><?= $booking['payment_type_name'] ?? 'Chưa xác định' ?></strong></div>
                    <div>• Điểm đón: <?= htmlspecialchars($schedule['meeting_point'] ?? 'Chưa xác định') ?></div>
                    <div>• Theo dõi trạng thái và liên hệ khách khi cần</div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>