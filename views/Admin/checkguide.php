<?php
// Hàm trạng thái điểm danh - giữ nguyên, chỉ dùng màu chuẩn
if (!function_exists('getStatusTextAndClass')) {
    function getStatusTextAndClass($status)
    {
        switch ($status) {
            case 'present':
                return ['bg' => 'bg-emerald-500', 'hover' => 'hover:bg-emerald-600'];
            case 'late':
                return ['bg' => 'bg-amber-500', 'hover' => 'hover:bg-amber-600'];
            case 'absent':
            default:
                return ['bg' => 'bg-red-500', 'hover' => 'hover:bg-red-600'];
        }
    }
}
?>
<form method="POST" id="attendanceForm" action="?mode=admin&act=saveAttendanceByActivity" class="min-h-screen bg-gray-50 max-w-[1900px] mx-auto">
    <div class="max-w-[1800px] mx-auto p-4 md:p-6 space-y-8">

        <!-- HEADER TOUR HÔM NAY – ĐỒNG BỘ VỚI DASHBOARD -->
        <?php if ($todayTour): ?>
            <div class="bg-gradient-to-br from-main to-blue-500 rounded-2xl shadow-lg hover:shadow-xl transition border border-blue-300 p-6 md:p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">

                    <!-- LEFT -->
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white drop-shadow-xl">
                            <?= htmlspecialchars($todayTour['tour_name']) ?>
                        </h1>

                        <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-white/90">
                            <span class="font-mono font-bold bg-white/20 px-2 py-1 rounded-lg">
                                #<?= $todayTour['tour_id'] ?>
                            </span>

                            <span class="opacity-60">•</span>

                            <span class="font-semibold">
                                <?= date('d/m', strtotime($todayTour['start_date'])) ?> →
                                <?= date('d/m/Y', strtotime($todayTour['end_date'])) ?>
                            </span>

                            <span class="opacity-60">•</span>

                            <span class="font-bold text-emerald-200">
                                <?= $todayTour['total_customers'] ?? 0 ?> khách
                            </span>
                        </div>
                    </div>


                    <!-- RIGHT -->
                    <div class="text-right min-w-[160px] bg-white/20 backdrop-blur-sm px-5 py-4 rounded-2xl shadow-md">
                        <p class="text-sm text-white/90">Điểm danh ngày</p>
                        <p class="text-4xl font-extrabold text-white drop-shadow-lg">
                            Ngày <?= $current_day_number ?>
                        </p>
                    </div>
                </div>
            </div>

        <?php endif; ?>
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

        <?php
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $current_time_str = nowTime();  // Ví dụ: "14:35"
        ?>

        <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-br from-main to-blue-400 text-white px-6 py-4 
            flex flex-col md:flex-row items-center justify-between gap-3">

                <!-- Tiêu đề -->
                <h2 class="text-2xl md:text-xl font-bold text-white text-shadow">
                    Điểm danh – Ngày <?= $current_day_number ?>
                </h2>

                <!-- Khu vực bên phải -->
                <div class="flex items-center gap-4">

                    <!-- Giờ hiện tại -->
                    <div class="text-sm font-medium whitespace-nowrap">
                        <i class="fa-solid fa-clock"></i> Giờ hiện tại:
                        <strong><?= $current_time_str ?></strong>
                    </div>

                    <!-- Input tìm kiếm -->
                    <div>
                        <input type="text"
                            id="search-input"
                            placeholder="Tìm kiếm khách..."
                            class="px-3 py-2 rounded-lg text-sm bg-white/20 placeholder-white/70
                            border border-white/30 focus:outline-none focus:ring-2 
                            focus:ring-white/60 text-white">
                    </div>

                </div>
            </div>


            <?php if (!empty($customers) && !empty($activities)): ?>

                <?php
                $visible_activities = [];
                foreach ($activities as $a) {
                    $act_time = date('H:i', strtotime($a['activity_time']));

                    // Thời gian được phép điểm danh: từ 15 phút trước đến 60 phút sau giờ hoạt động
                    $start_allow = date('H:i', strtotime($a['activity_time']) - 900);  // -15 phút
                    $end_allow   = date('H:i', strtotime($a['activity_time']) + 3600); // +60 phút

                    // Chỉ hiển thị nếu giờ hiện tại nằm trong khoảng cho phép điểm danh
                    if ($current_time_str >= $start_allow && $current_time_str <= $end_allow) {
                        $visible_activities[] = $a;
                    }
                }
                ?>

                <?php if (empty($visible_activities)): ?>
                    <div class="text-center py-20 text-slate-500">
                        <i class="fa-solid fa-calendar-xmark text-6xl text-slate-300 mb-4"></i>
                        <p class="text-2xl font-bold text-slate-600">Không có buổi nào đang mở điểm danh</p>
                        <p class="mt-3 text-lg">Giờ hiện tại: <strong class="text-main"><?= $current_time_str ?></strong></p>
                        <p class="text-sm text-slate-400 mt-4">
                            Các buổi sẽ tự động xuất hiện khi đến giờ (từ 15 phút trước).<br>
                            Các buổi đã kết thúc quá 1 tiếng sẽ tự động ẩn.
                        </p>
                    </div>

                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-100 border-b-2 border-slate-300 text-sm">
                                <tr>
                                    <th class="px-6 py-4 font-bold sticky left-0 bg-slate-100 z-10">Khách hàng</th>
                                    <th class="px-4 py-3 text-center">Năm sinh</th>
                                    <th class="px-4 py-3 text-center">Hộ chiếu</th>
                                    <th class="px-4 py-3 text-center">Loại khách</th>

                                    <?php foreach ($visible_activities as $a):
                                        $act_time = date('H:i', strtotime($a['activity_time']));
                                        $is_current = ($current_time_str >= $act_time) &&
                                            ($current_time_str <= date('H:i', strtotime($a['activity_time']) + 3600));
                                    ?>
                                        <th class="px-4 py-4 text-center max-w-[60px] relative">
                                            <?php if ($is_current): ?>
                                                <div class="top-2 right-2 bg-emerald-500 text-white text-xs px-3 py-1 rounded-full shadow-lg animate-pulse">
                                                    ĐANG DIỄN RA
                                                </div>
                                            <?php else: ?>
                                                <div class="top-2 right-2 bg-amber-500 text-white text-xs px-3 py-1 rounded-full shadow">
                                                    SẮP DIỄN RA
                                                </div>
                                            <?php endif; ?>
                                            <div class="font-bold text-main mt-4"><?= htmlspecialchars($a['activity_name']) ?></div>
                                            <div class="text-lg font-bold <?= $is_current ? 'text-emerald-600 animate-pulse' : 'text-amber-600' ?>">
                                                <?= $act_time ?>
                                            </div>
                                            <?php if (!empty($a['location'])): ?>
                                                <div class="text-xs text-slate-500 mt-1 truncate max-w-[140px] mx-auto">
                                                    <?= htmlspecialchars($a['location']) ?>
                                                </div>
                                            <?php endif; ?>

                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-200">
                                <?php foreach ($customers as $c): ?>
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-5 font-semibold sticky left-0 min-w-[100px] bg-white z-10">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-main to-blue-600 rounded-full text-white flex items-center justify-center font-bold text-sm">
                                                    <?= strtoupper(mb_substr($c['customer_name'], 0, 2)) ?>
                                                </div>
                                                <div class="font-bold"><?= htmlspecialchars($c['customer_name']) ?></div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-5 text-center text-sm text-slate-600">
                                            <?= date('d/m/Y', strtotime($c['birth_year'])) ?>
                                        </td>
                                        <td class="px-4 py-5 text-center text-sm font-mono text-slate-700">
                                            <?= htmlspecialchars($c['passport']) ?>
                                        </td>
                                        <td class="px-4 py-5 text-center min-w-[160px]">
                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <?= htmlspecialchars($c['customer_types_name']) ?>
                                            </span>
                                        </td>

                                        <?php foreach ($visible_activities as $a):
                                            $actId = $a['activity_id'];
                                            $att = $c['attendance'][$actId] ?? ['status' => 'absent', 'notes' => ''];
                                            $info = getStatusTextAndClass($att['status']);
                                            $is_current = ($current_time_str >= date('H:i', strtotime($a['activity_time'])));
                                        ?>
                                            <td class="px-4 py-5 text-center min-w-[160px] border-l">
                                                <select name="att[<?= $c['customer_id'] ?>][<?= $actId ?>][status]"
                                                    class="attendance-select w-full px-4 py-3 rounded-lg text-white font-medium text-sm 
                                                        transition-all duration-200 focus:outline-none"
                                                    data-current="<?= $att['status'] ?? 'absent' ?>">
                                                    <option value="present" <?= ($att['status'] ?? 'absent') === 'present' ? 'selected' : '' ?>>Đã đến</option>
                                                    <option value="late" <?= ($att['status'] ?? 'absent') === 'late'    ? 'selected' : '' ?>>Đi muộn</option>
                                                    <option value="absent" <?= ($att['status'] ?? 'absent') === 'absent'  ? 'selected' : '' ?>>Vắng</option>
                                                </select>
                                                <textarea name="att[<?= $c['customer_id'] ?>][<?= $actId ?>][notes]"
                                                    rows="2"
                                                    placeholder="Ghi chú..."
                                                    class="note-field w-full mt-2 px-3 py-2 border border-gray-300 rounded-lg text-sm 
                                                        focus:ring-1 focus:ring-blue-400 resize-none transition-all 
                                                        <?= ($att['status'] ?? 'absent') === 'present' ? 'hidden' : '' ?>">
                                                    <?= htmlspecialchars($att['notes'] ?? '') ?>
                                                </textarea>
                                            </td>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {

                                                    document.querySelectorAll('.attendance-select').forEach(select => {
                                                        applyColor(select);

                                                        select.addEventListener('change', function() {
                                                            applyColor(this);

                                                            const notes = this.closest('td').querySelector('.note-field');
                                                            if (this.value === 'present') {
                                                                notes.classList.add('hidden');
                                                                notes.value = "";
                                                            } else {
                                                                notes.classList.remove('hidden');
                                                            }
                                                        });
                                                    });

                                                    function applyColor(el) {
                                                        el.classList.remove(
                                                            'bg-green-500', 'bg-green-600',
                                                            'bg-amber-500', 'bg-amber-600',
                                                            'bg-red-500', 'bg-red-600'
                                                        );

                                                        if (el.value === 'present') {
                                                            el.classList.add('bg-green-500', 'hover:bg-green-600');
                                                        } else if (el.value === 'late') {
                                                            el.classList.add('bg-amber-500', 'hover:bg-amber-600');
                                                        } else if (el.value === 'absent') {
                                                            el.classList.add('bg-red-500', 'hover:bg-red-600');
                                                        }
                                                    }
                                                });
                                            </script>

                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 border-t bg-slate-50 text-right">
                        <button type="submit"
                            class="px-12 py-4 bg-main hover:bg-hover text-white font-bold text-lg rounded-xl shadow-lg transition hover:shadow-xl hover:-translate-y-1">
                            <i class="fa-solid fa-save mr-2"></i> Lưu điểm danh
                        </button>
                    </div>

                <?php endif; ?>

            <?php else: ?>
                <div class="text-right py-20 text-slate-400">
                    <p class="text-2xl font-semibold">Chưa có dữ liệu điểm danh</p>
                </div>
            <?php endif; ?>
        </div>
</form>
<script>
    document.getElementById('attendanceForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Ngăn form submit ngay lập tức

        if (confirm('Bạn có chắc chắn muốn lưu điểm danh không?')) {
            this.submit(); // Nếu xác nhận, gửi form
        }
    });
</script>

<!-- JS ẩn/hiện ghi chú – cực nhẹ -->
<script>
    function toggleNote(select) {
        const textarea = select.parentElement.querySelector('textarea');
        if (select.value === 'present') {
            textarea.classList.add('hidden');
            textarea.value = '';
        } else {
            textarea.classList.remove('hidden');
        }
    }

    // Khởi tạo khi load trang
    document.querySelectorAll('select').forEach(sel => {
        toggleNote(sel);
        sel.addEventListener('change', () => toggleNote(sel));
    });
</script>