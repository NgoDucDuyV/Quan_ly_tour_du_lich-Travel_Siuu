<?php
// Đảm bảo biến tồn tại và xử lý an toàn
$todayTour = $todayTour ?? null;
?>

<div class="max-w-[1400px] mx-auto p-4 md:p-6">

    <!-- CARD CHÍNH – BẮT ĐẦU NGÀY TOUR -->
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

        <!-- Header đẹp với gradient nhẹ -->
        <div class="bg-gradient-to-br from-main to-blue-400 text-white px-8 py-10 text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <h1 class="text-3xl text-white text-shadow-xl md:text-4xl font-black tracking-tight">
                    Bắt đầu ngày tour
                </h1>
                <p class="mt-3 text-white/90 text-lg font-medium">
                    <?= today() ?>
                    <!-- Ví dụ: Thứ Sáu, 10/01/2026 -->
                </p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-2 bg-white/20"></div>
        </div>

        <!-- Nội dung chính -->
        <div class="p-8 md:p-10 space-y-8">

            <!-- Thông tin tour hôm nay -->
            <div class="text-center">
                <?php if ($todayTour && !empty($todayTour['tour_name'])): ?>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 leading-tight">
                        <?= htmlspecialchars($todayTour['tour_name']) ?>
                    </h2>

                    <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-8 text-lg">

                        <!-- Mã tour + thời gian -->
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-main/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-bus text-main text-2xl"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-slate-600 text-sm">Mã tour • Lịch trình</p>
                                <p class="font-bold text-main text-xl">#<?= htmlspecialchars($todayTour['tour_id'] ?? 'N/A') ?></p>
                                <p class="text-sm text-slate-600">
                                    <?= date('d/m', strtotime($todayTour['start_date'])) ?> → <?= date('d/m/Y', strtotime($todayTour['end_date'])) ?>
                                </p>
                            </div>
                        </div>

                        <!-- Số khách + trạng thái -->
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-users text-emerald-600 text-2xl"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-slate-600 text-sm">Số khách hiện tại</p>
                                <p class="font-black text-emerald-700 text-3xl">
                                    <?= $todayTour['total_customers'] ?? 0 ?> khách
                                </p>
                                <p class="text-xs text-emerald-600 font-medium mt-1">
                                    <?= $todayTour['guide_status_name'] ?? 'Đã phân công' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Trạng thái lịch trình (nếu cần nổi bật) -->
                    <?php if (!empty($todayTour['schedule_status_name'])): ?>
                        <div class="mt-6 inline-flex items-center gap-2 px-5 py-2 bg-emerald-100 text-emerald-800 rounded-full font-bold text-sm">
                            <i class="fa-solid fa-circle-check"></i>
                            <?= htmlspecialchars($todayTour['schedule_status_name']) ?>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="py-8">
                        <p class="text-2xl text-slate-500 font-medium">Hôm nay bạn chưa có tour nào</p>
                        <p class="text-slate-400 mt-2">Hãy kiểm tra lịch sắp tới hoặc liên hệ điều hành</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- NÚT BẮT ĐẦU ĐIỂM DANH – SIÊU NỔI BẬT -->
            <?php if ($todayTour): ?>
                <div class="pt-8">
                    <a href="?mode=admin&act=start_tour&schedule_id=<?= $todayTour['schedule_id'] ?>"
                        class="block w-full group">
                        <button class="w-full py-7 bg-gradient-to-br from-main to-blue-400 text-white font-black text-2xl md:text-3xl rounded-3xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300 flex items-center justify-center gap-5 group-hover:gap-8">
                            <i class="fa-solid fa-circle-play text-xl"></i>
                            <span class="tracking-wider">Lấy danh sách điểm danh</span>
                            <i class="fa-solid fa-arrow-right text-4xl opacity-90"></i>
                        </button>
                    </a>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-slate-500">
                            Điểm danh ngay để xác nhận khách đã có mặt và sẵn sàng khởi hành
                        </p>
                    </div>
                </div>
            <?php else: ?>
                <div class="py-8 text-center">
                    <button disabled class="w-full py-7 bg-gray-300 text-gray-600 font-bold text-2xl rounded-3xl cursor-not-allowed">
                        Không có tour hôm nay
                    </button>
                </div>
            <?php endif; ?>

            <!-- Thông tin thêm -->
            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 text-center">
                <p class="text-slate-600 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-circle-info text-main"></i>
                    <span>Điểm danh giúp hệ thống ghi nhận chính xác tình trạng đoàn và hỗ trợ điều hành tốt hơn</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Footer nhỏ -->
    <div class="mt-10 text-center text-slate-500 text-sm">
        <p>Chúc bạn một ngày dẫn tour thật an toàn và vui vẻ!</p>
    </div>
</div>