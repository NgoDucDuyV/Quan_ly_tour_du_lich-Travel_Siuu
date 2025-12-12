<?php
// Hàm trạng thái điểm danh - ĐÚNG MÀU + ICON NHỎ XINH
if (!function_exists('getStatusTextAndClass')) {
    function getStatusTextAndClass($status)
    {
        return match ($status) {
            'present' => [
                'text'  => 'Đã đến',
                'bg'    => 'bg-green-600',
                'hover' => 'hover:bg-green-700',
                'ring'  => 'focus:ring-green-300',
                'icon'  => 'check-circle'
            ],
            'late' => [
                'text'  => 'Đến muộn',
                'bg'    => 'bg-orange-500',
                'hover' => 'hover:bg-orange-600',
                'ring'  => 'focus:ring-orange-300',
                'icon'  => 'clock'
            ],
            'absent' => [
                'text'  => 'Vắng mặt',
                'bg'    => 'bg-red-600',
                'hover' => 'hover:bg-red-700',
                'ring'  => 'focus:ring-red-300',
                'icon'  => 'x-circle'
            ],
            default => [
                'text'  => 'Vắng mặt',
                'bg'    => 'bg-red-600',
                'hover' => 'hover:bg-red-700',
                'ring'  => 'focus:ring-red-300',
                'icon'  => 'x-circle'
            ],
        };
    }
}
?>

<form method="POST" action="?mode=admin&act=saveAttendanceByActivity" class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="container mx-auto px-4 py-8 max-w-7xl">

        <!-- Header Tour Hôm Nay -->
        <?php if ($todayTour): ?>
            <div class="mb-10 bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-white">
                    <h1 class="text-4xl font-bold flex items-center gap-3">
                        <i data-lucide="check-square" class="w-10 h-10"></i>
                        Check-in & Điểm danh
                    </h1>
                    <p class="text-indigo-100 mt-2">Hôm nay: <span class="font-bold"><?= date('d/m/Y') ?></span></p>
                </div>
                <div class="p-8 bg-gradient-to-r from-blue-50 to-indigo-100">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-3">
                                <?= htmlspecialchars($todayTour['tour_name']) ?>
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-gray-700">
                                <div class="flex items-center gap-3">
                                    <i data-lucide="calendar" class="w-9 h-9 text-indigo-600"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Thời gian tour</p>
                                        <p class="font-bold"><?= date('d/m', strtotime($todayTour['start_date'])) ?> → <?= date('d/m/Y', strtotime($todayTour['end_date'])) ?></p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i data-lucide="users" class="w-9 h-9 text-indigo-600"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Tổng khách</p>
                                        <p class="font-bold text-2xl"><?= $todayTour['total_customers'] ?? 0 ?> khách</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i data-lucide="sun" class="w-9 h-9 text-yellow-500"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Ngày hiện tại</p>
                                        <p class="font-bold text-3xl text-indigo-700">Ngày <?= $current_day_number ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white px-8 py-5 rounded-2xl shadow-lg border-4 border-green-500">
                            <a href="">
                                <p class="text-green-700 font-bold text-2xl text-center">
                                    SẴN SÀNG ĐIỂM DANH
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Bảng điểm danh -->
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-8 py-6 text-white">
                <h2 class="text-2xl font-bold flex items-center gap-3">
                    <i data-lucide="list-checks" class="w-8 h-8"></i>
                    Điểm danh – Ngày <?= $current_day_number ?>
                </h2>
            </div>

            <?php if (!empty($customers) && !empty($activities)): ?>
                <div class="p-8">
                    <div class="overflow-x-auto rounded-2xl border border-gray-200">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-gray-900 to-gray-800 text-white">
                                <tr>
                                    <th class="px-8 py-5 text-left font-bold text-lg sticky left-0 bg-gray-900 z-10 border-r border-gray-700">
                                        Khách hàng
                                    </th>
                                    <?php foreach ($activities as $a): ?>
                                        <th class="px-6 py-5 text-center border-l border-gray-700">
                                            <div class="text-sm font-bold"><?= htmlspecialchars($a['activity_name']) ?></div>
                                            <div class="text-indigo-300 font-bold text-lg">
                                                <?= date('H:i', strtotime($a['activity_time'])) ?>
                                            </div>
                                            <?php if (!empty($a['location'])): ?>
                                                <div class="text-xs text-gray-300 mt-1">
                                                    <i data-lucide="map-pin" class="w-3 h-3 inline"></i>
                                                    <?= htmlspecialchars($a['location']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($customers as $c): ?>
                                    <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                                        <td class="px-8 py-6 font-bold text-gray-800 sticky left-0 bg-white z-10 border-r border-gray-300">
                                            <div class="flex items-center gap-3">
                                                <div class="w-11 h-11 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                    <?= strtoupper(substr($c['customer_name'], 0, 2)) ?>
                                                </div>
                                                <div class="text-base">
                                                    <?= htmlspecialchars($c['customer_name']) ?>
                                                </div>
                                            </div>
                                        </td>
                                        <?php foreach ($activities as $a):
                                            $actId = $a['activity_id'];
                                            $att = $c['attendance'][$actId] ?? ['status' => 'absent', 'notes' => ''];
                                            $info = getStatusTextAndClass($att['status']);
                                        ?>
                                            <td class="px-4 py-5 text-center border-l border-gray-200">
                                                <div class="space-y-3">
                                                    <!-- Select với icon nhỏ bên trái -->
                                                    <div class="relative">
                                                        <select name="att[<?= $c['customer_id'] ?>][<?= $actId ?>][status]"
                                                            class="w-full pl-10 pr-4 py-3 rounded-xl font-bold text-white text-sm
                                                                   <?= $info['bg'] ?> <?= $info['hover'] ?>
                                                                   focus:ring-4 <?= $info['ring'] ?> focus:outline-none cursor-pointer
                                                                   appearance-none transition-all duration-200"
                                                            onchange="toggleNote(this)">
                                                            <option value="present" <?= $att['status'] === 'present' ? 'selected' : '' ?>>Đã đến</option>
                                                            <option value="late" <?= $att['status'] === 'late' ? 'selected' : '' ?>>Đến muộn</option>
                                                            <option value="absent" <?= $att['status'] === 'absent' ? 'selected' : '' ?>>Vắng mặt</option>
                                                        </select>
                                                        <!-- Icon nhỏ bên trái -->
                                                        <i data-lucide="<?= $info['icon'] ?>"
                                                            class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-white pointer-events-none"></i>
                                                        <!-- Mũi tên dropdown -->
                                                        <i data-lucide="chevron-down"
                                                            class="w-4 h-4 absolute right-3 top-1/2 transform -translate-y-1/2 text-white pointer-events-none"></i>
                                                    </div>

                                                    <!-- Ghi chú -->
                                                    <textarea name="att[<?= $c['customer_id'] ?>][<?= $actId ?>][notes]"
                                                        rows="2"
                                                        placeholder="Ghi chú..."
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm 
                                                               focus:border-indigo-500 focus:ring focus:ring-indigo-200 
                                                               transition <?= $att['status'] === 'present' ? 'hidden' : '' ?>">
                                                        <?= htmlspecialchars($att['notes'] ?? '') ?>
                                                    </textarea>
                                                </div>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Nút Lưu -->
                    <div class="mt-10 text-center">
                        <button type="submit"
                            class="inline-flex items-center gap-3 px-16 py-6 bg-gradient-to-r from-indigo-600 to-purple-700 
                                   text-white text-2xl font-bold rounded-2xl shadow-2xl 
                                   hover:shadow-purple-500/50 transform hover:scale-105 
                                   transition-all duration-300">
                            <i data-lucide="save" class="w-9 h-9"></i>
                            LƯU ĐIỂM DANH
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-24">
                    <i data-lucide="calendar-x" class="w-24 h-24 text-gray-400 mx-auto mb-4"></i>
                    <p class="text-2xl font-bold text-gray-600">Chưa có lịch trình hôm nay</p>
                    <p class="text-gray-500 mt-2">Vui lòng quay lại khi có tour mới</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</form>

<!-- JS xử lý + khởi tạo icon -->
<script>
    function toggleNote(select) {
        const textarea = select.closest('div.space-y-3').querySelector('textarea');
        if (select.value === 'present') {
            textarea.classList.add('hidden');
            textarea.value = '';
        } else {
            textarea.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        document.querySelectorAll('select').forEach(sel => {
            toggleNote(sel);
            sel.addEventListener('change', function() {
                toggleNote(this);
                lucide.createIcons(); // Cập nhật icon khi đổi trạng thái
            });
        });
    });
</script>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>