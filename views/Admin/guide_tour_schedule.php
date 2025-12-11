<div class="max-w-[1900px] mx-auto p-6">

    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý Booking</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 font-medium text-slate-700">Phân hướng dẫn viên</li>
        </ul>
    </nav>

    <!-- Tiêu đề + nút quay lại -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-6">
            <h1 class="text-3xl font-bold text-slate-900">
                Phân hướng dẫn viên cho Booking: <span class="text-main">#<?= $databooking['booking_code'] ?></span>
            </h1>
            <div class="flex gap-3">
                <span class="px-5 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">Đang phân HDV</span>
                <span class="px-5 py-2 rounded-full text-sm font-bold <?= $databooking['payment_type_color'] ?>">
                    <?= $databooking['payment_type_name'] ?>
                </span>
            </div>
        </div>
        <a href="?mode=admin&act=bookinglist" class="flex items-center gap-2 px-6 py-3 border border-slate-300 rounded-xl hover:bg-light hover:text-hover transition text-main text-sm font-medium">
            Danh sách booking
        </a>
    </div>

    <!-- 3 card thông tin -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <!-- Card 1: Thông tin khách hàng -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-5">Thông tin khách hàng</h3>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between"><span class="text-slate-600">Họ tên</span><span class="font-semibold"><?= htmlspecialchars($databooking['customer_name']) ?></span></div>
                <div class="flex justify-between"><span class="text-slate-600">Điện thoại</span><span class="font-medium"><?= $databooking['customer_phone'] ?></span></div>
                <div class="flex justify-between"><span class="text-slate-600">Email</span><span class="text-slate-700"><?= $databooking['customer_email'] ?></span></div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-600">Loại khách</span>
                    <span class="px-4 py-1.5 rounded-full text-xs font-bold <?= $databooking['group_color'] ?>">
                        <?= $databooking['group_name'] ?>
                    </span>
                </div>
                <div class="flex justify-between pt-3 border-t">
                    <span class="text-slate-600">Số khách</span>
                    <span class="text-2xl font-bold text-main"><?= $databooking['number_of_people'] ?> khách</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Thông tin tour -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-5">Thông tin tour</h3>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between"><span class="text-slate-600">Tên tour</span><span class="font-semibold"><?= htmlspecialchars($tourDetail['name']) ?></span></div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Ngày đi → về</span>
                    <span class="font-bold text-main">
                        <?= date('d/m/Y', strtotime($databooking['start_date'])) ?> → <?= date('d/m/Y', strtotime($databooking['end_date'])) ?>
                    </span>
                </div>
                <div class="flex justify-between"><span class="text-slate-600">Thời gian</span><span><?= $tourDetail['duration'] ?></span></div>
                <div class="flex justify-between"><span class="text-slate-600">Mô tả</span><span class="text-right max-w-[200px]"><?= htmlspecialchars($tourDetail['description']) ?></span></div>
            </div>
        </div>

        <!-- Card 3: Tình trạng phân HDV -->
        <div class="bg-main text-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold mb-6">Tình trạng phân HDV</h3>
            <?php
            $daysUntilStart = (strtotime($databooking['start_date']) - time()) / 86400;
            $daysUntilStart = max(0, ceil($daysUntilStart));
            ?>
            <div class="text-5xl font-black mb-2"><?= $daysUntilStart ?> ngày</div>
            <p class="opacity-90 mb-8">Đến ngày khởi hành tour</p>
            <div class="pt-6 border-t border-white/30">
                <p class="opacity-90 mb-2">Hướng dẫn viên hiện tại</p>
                <p class="text-2xl font-bold">Chưa phân công</p>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="mb-5 p-4 bg-green-50 border border-green-200 text-red rounded-lg text-sm flex items-center gap-2">
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
    <!--tìm kiếm -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Tìm tên, số điện thoại, email hướng dẫn viên..." id="searchGuide"
                    class="w-full pl-12 pr-6 py-4 rounded-lg border border-slate-300 focus:outline-none focus:ring-4 focus:ring-main/20 focus:border-main text-lg">
            </div>
            <div class="flex gap-4">
                <select id="filterLanguage" class="w-48 px-5 py-4 rounded-lg border border-slate-300">
                    <option value="">Tất cả ngôn ngữ</option>
                    <option>Tiếng Anh</option>
                    <option>Tiếng Pháp</option>
                    <option>Tiếng Trung</option>
                    <option>Tiếng Nhật</option>
                </select>
                <select id="filterExperience" class="w-48 px-5 py-4 rounded-lg border border-slate-300">
                    <option value="">Tất cả kinh nghiệm</option>
                    <option value="3">≥ 3 năm</option>
                    <option value="5">≥ 5 năm</option>
                    <option value="10">≥ 10 năm</option>
                </select>
            </div>
        </div>
    </div>

    <!-- danh achs hdv -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6" id="guideList">
        <?php
        $bookingStart = $databooking['start_date'];
        $bookingEnd   = $databooking['end_date'];

        foreach ($dataguide as $g):
            $schedules = (new SchedulesModel())->getSchedulesByGuideId($g['id']);

            // Kiểm tra trùng lịch
            $hasConflict = false;
            $conflictInfo = null;
            if (!empty($schedules)) {
                foreach ($schedules as $sch) {
                    if ($bookingStart <= $sch['end_date'] && $bookingEnd >= $sch['start_date']) {
                        $hasConflict = true;
                        $conflictInfo = $sch;
                        break;
                    }
                }
            }

            // Xác định trạng thái
            $isAvailable = !$hasConflict;
            $statusText  = $isAvailable ? 'RẢNH – CÓ THỂ CHỌN' : 'TRÙNG LỊCH';
            $statusColor = $isAvailable ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300';
            $btnClass    = $isAvailable
                ? 'bg-main hover:bg-hover text-white font-semibold'
                : 'bg-gray-200 text-gray-600 cursor-not-allowed';
            $btnText     = $isAvailable ? 'CHỌN HƯỚNG DẪN VIÊN' : 'KHÔNG THỂ CHỌN';
        ?>

            <!-- Card HDV -->
            <div class="guide-card bg-white rounded-xl border <?= $isAvailable ? 'border-slate-200 hover:border-main' : 'border-slate-200 opacity-90' ?> shadow-sm hover:shadow-md transition flex flex-col h-full"
                data-name="<?= strtolower($g['name']) ?>"
                data-phone="<?= $g['phone'] ?>"
                data-email="<?= strtolower($g['email']) ?>"
                data-language="<?= $g['language'] ?>"
                data-experience="<?= $g['experience_years'] ?>">

                <!-- Header -->
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-lg text-slate-900"><?= htmlspecialchars($g['name']) ?></h3>
                        <p class="text-sm text-slate-500">HDV #<?= str_pad($g['id'], 3, '0', STR_PAD_LEFT) ?> • <?= $g['experience_years'] ?> năm kinh nghiệm</p>
                    </div>
                    <span class="px-4 py-1.5 rounded-full text-xs font-bold border <?= $isAvailable ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300' ?>">
                        <?= $isAvailable ? 'RẢNH – CÓ THỂ CHỌN' : 'TRÙNG LỊCH' ?>
                    </span>
                </div>

                <!-- Nội dung chính (có thể rất dài) -->
                <div class="p-6 flex-1">
                    <div class="flex items-center gap-4 mb-5">
                        <img src="<?= htmlspecialchars($g['image']) ?>"
                            class="w-16 h-16 rounded-full ring-4 ring-white shadow object-cover">
                        <div>
                            <div class="text-2xl font-bold text-slate-800">
                                <?= number_format($g['performance_score'], 1) ?> stars
                            </div>
                            <div class="text-xs text-slate-500">Đánh giá hiệu suất</div>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-slate-700">
                        <div class="flex items-center gap-3"><i class="fa-solid fa-phone text-green-600"></i> <?= $g['phone'] ?></div>
                        <div class="flex items-center gap-3"><i class="fa-solid fa-envelope text-blue-600"></i> <?= $g['email'] ?></div>
                        <div class="flex items-center gap-3"><i class="fa-solid fa-globe text-purple-600"></i> <?= htmlspecialchars($g['language']) ?></div>
                        <?php if (!empty($g['note'])): ?>
                            <div class="text-xs text-slate-500 italic pt-2">Ghi chú: <?= htmlspecialchars($g['note']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Thông tin trùng lịch (nếu có) -->
                    <?php if ($hasConflict && $conflictInfo): ?>
                        <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg text-xs">
                            <div class="font-semibold text-red-700">
                                Trùng: <?= date('d/m', strtotime($conflictInfo['start_date'])) ?> → <?= date('d/m/Y', strtotime($conflictInfo['end_date'])) ?>
                            </div>
                            <div class="text-red-600 mt-1">
                                Booking #<?= str_pad($conflictInfo['booking_id'], 4, '0', STR_PAD_LEFT) ?>
                                <?= $conflictInfo['schedule_status_type_name'] ?? '' ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer: 2 nút luôn dính đáy -->
                <div class="mt-auto border-t border-slate-100 bg-slate-50/50 px-6 py-4">
                    <div class="flex gap-3">
                        <!-- Xem chi tiết -->
                        <a href="?mode=admin&act=guide_tour_schedule_detail&guide_id=<?= $g['id'] ?>"
                            class="flex-1 flex items-center justify-center gap-2 py-3 px-4 border border-slate-300 rounded-lg text-slate-700 font-medium text-sm hover:bg-white hover:border-slate-400 transition">
                            <i class="fa-solid fa-eye"></i>
                            Xem chi tiết
                        </a>

                        <!-- Chọn HDV -->
                        <button <?= $isAvailable ? '' : 'disabled' ?>
                            class="select-guide flex-1 py-3 rounded-lg <?= $isAvailable ? 'bg-main hover:bg-hover text-white' : 'bg-gray-200 text-gray-600 cursor-not-allowed' ?> font-medium text-sm transition flex items-center justify-center gap-2"
                            data-guide-id="<?= $g['id'] ?>"
                            data-guide-name="<?= htmlspecialchars($g['name']) ?>"
                            data-guide-phone="<?= $g['phone'] ?>"
                            data-guide-email="<?= $g['email'] ?>"
                            data-guide-image="<?= htmlspecialchars($g['image']) ?>">
                            <i class="fa-solid <?= $isAvailable ? 'fa-check' : 'fa-ban' ?>"></i>
                            <?= $isAvailable ? 'CHỌN HDV' : 'KHÔNG THỂ CHỌN' ?>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal xác nhận phân công -->
    <div id="confirmAssignModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black bg-opacity-70 px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-user-check text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Xác nhận phân công</h2>
                            <p class="opacity-90">Hướng dẫn viên sẽ nhận thông báo ngay</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal()" class="text-white bg-[#0000] hover:text-gray-200 text-5xl">×</button>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="font-bold text-slate-800 mb-4">Hướng dẫn viên được chọn</h3>
                        <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl p-5 border border-emerald-200" id="selectedGuideInfo">
                            <!-- JS sẽ fill vào đây -->
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 mb-4">Thông tin Booking</h3>
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-5 border border-indigo-200">
                            <p class="text-lg font-bold text-slate-800 mb-3">#<?= $databooking['booking_code'] ?></p>
                            <div class="space-y-2 text-sm">
                                <p><strong>Tour:</strong> <?= htmlspecialchars($tourDetail['name']) ?></p>
                                <p><strong>Thời gian:</strong> <span class="text-main font-bold">
                                        <?= date('d/m', strtotime($databooking['start_date'])) ?> → <?= date('d/m/Y', strtotime($databooking['end_date'])) ?>
                                    </span></p>
                                <p><strong>Số khách:</strong> <?= $databooking['number_of_people'] ?> người</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-8">
                    <label class="flex items-center gap-4 cursor-pointer">
                        <input type="checkbox" checked class="w-6 h-6 text-main rounded focus:ring-main">
                        <span class="text-slate-700 font-medium">Gửi thông báo ngay cho HDV qua Zalo + Email</span>
                    </label>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeModal()" class="px-8 py-4 border border-slate-300 rounded-xl hover:bg-slate-50 font-medium transition">
                        Hủy bỏ
                    </button>
                    <form action="?act=createguideschedule&booking_id=<?= $databooking['booking_id'] ?>"
                        method="POST"
                        class="inline"
                        onsubmit="return confirm('Bạn có chắc chắn muốn phân công hướng dẫn viên này không?');">

                        <input type="hidden" name="guide_id" id="final_guide_id">
                        <input type="hidden" name="booking_id" value="<?= $databooking['booking_id'] ?>">

                        <button type="submit"
                            class="px-10 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold text-lg rounded-xl shadow-lg transition flex items-center gap-3">
                            XÁC NHẬN PHÂN CÔNG NGAY
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tìm kiếm + lọc HDV
    document.getElementById('searchGuide').addEventListener('input', filterGuides);
    document.getElementById('filterLanguage').addEventListener('change', filterGuides);
    document.getElementById('filterExperience').addEventListener('change', filterGuides);

    function filterGuides() {
        const search = document.getElementById('searchGuide').value.toLowerCase();
        const lang = document.getElementById('filterLanguage').value;
        const exp = document.getElementById('filterExperience').value;

        document.querySelectorAll('.guide-card').forEach(card => {
            const name = card.dataset.name;
            const phone = card.dataset.phone;
            const email = card.dataset.email;
            const language = card.dataset.language;
            const experience = parseInt(card.dataset.experience);

            const matchesSearch = name.includes(search) || phone.includes(search) || email.includes(search);
            const matchesLang = !lang || language.includes(lang);
            const matchesExp = !exp || experience >= parseInt(exp);

            card.style.display = (matchesSearch && matchesLang && matchesExp) ? '' : 'none';
        });
    }

    document.querySelectorAll('.select-guide').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.disabled) return;

            const guideId = this.dataset.guideId;
            const name = this.dataset.guideName;
            const phone = this.dataset.guidePhone;
            const email = this.dataset.guideEmail;
            const image = this.dataset.guideImage;

            document.getElementById('final_guide_id').value = guideId;
            document.getElementById('selectedGuideInfo').innerHTML = `
            <div class="flex items-center gap-4 mb-4">
                <img src="${image}" class="w-20 h-20 rounded-full ring-4 ring-white shadow-lg object-cover">
                <div>
                    <p class="text-xl font-bold text-slate-800">${name}</p>
                    <p class="text-sm text-slate-600">Mã HDV: <strong>GV${String(guideId).padStart(3, '0')}</strong></p>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <p> ${phone}</p>
                <p> ${email}</p>
            </div>
        `;

            document.getElementById('confirmAssignModal').classList.remove('hidden');
            document.getElementById('confirmAssignModal').classList.add('flex');
        });
    });

    function closeModal() {
        document.getElementById('confirmAssignModal').classList.add('hidden');
        document.getElementById('confirmAssignModal').classList.remove('flex');
    }

    // Đóng khi bấm ngoài
    document.getElementById('confirmAssignModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>