<?php

// ĐỊNH NGHĨA HÀM PHP ĐỂ XỬ LÝ TRẠNG THÁI (Giữ nguyên)

if (!function_exists('getStatusTextAndClass')) {

    function getStatusTextAndClass($status)

    {

        $text = 'Vắng mặt';

        $className = 'bg-red-500 text-white hover:bg-red-600';



        if ($status === 'present') {

            $text = 'Đã đến';

            $className = 'bg-green-600 text-white hover:bg-green-700';
        } else if ($status === 'late') {

            $text = 'Đến muộn';

            $className = 'bg-yellow-500 text-white hover:bg-yellow-600';
        }



        return ['text' => $text, 'className' => $className];
    }
}

?>

<main class="flex-1 p-8 space-y-10 bg-gray-50">

    <header class="bg-white p-6 rounded-3xl shadow-md flex items-center justify-between border border-gray-100">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                📍 Check-in & Điểm danh
            </h1>
        </div>
    </header>

    <section class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-5">
        <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
            🚐 Tour hôm nay
        </h2>

        <?php if ($todayTour): ?>
            <div class="p-6 rounded-2xl border bg-gradient-to-r from-blue-50 to-indigo-100 hover:shadow-lg transition cursor-pointer">
                <div class="flex items-start justify-between">
                    <div class="space-y-2">
                        <h3 class="text-2xl font-bold text-gray-900">
                            <?= $todayTour['tour_name'] ?? 'Không rõ tên tour' ?>
                        </h3>
                        <div class="text-gray-700 text-sm space-y-1">
                            <p>📅 Ngày: <b><?= date('d/m/Y', strtotime($todayTour['start_date'])) ?></b> - <b><?= date('d/m/Y', strtotime($todayTour['end_date'])) ?></b></p>
                            <p>👥 Tổng khách: <b><?= $todayTour['total_customers'] ?? 0 ?></b></p>
                            <p>📌 Ngày hiện tại trong tour: <b class="text-indigo-800">Ngày <?= $current_day_number ?? 1 ?></b></p>
                        </div>
                    </div>

                    <button class="checkin-btn px-6 py-3 bg-green-600 text-white rounded-xl shadow hover:bg-green-700 active:scale-95 transition font-medium">
                        Điểm danh ngay
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="p-4 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl">
                Hôm nay bạn không có tour nào.
            </div>
        <?php endif; ?>
    </section>


    <section id="customerList" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-6">



        <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">

            📝 Danh sách điểm danh Ngày <?= $current_day_number ?? '?' ?>

        </h2>
        <?php if (!empty($customers) && !empty($activities)): ?>



            <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow">

                <table class="w-full min-w-[700px] text-left">

                    <thead class="bg-gray-100 text-gray-600 sticky top-0">

                        <tr>

                            <th class="w-[180px] p-3 text-sm font-medium sticky left-0 bg-gray-100 border-r">Tên khách</th>

                            <?php

                            if (!empty($activities)):

                                foreach ($activities as $a): ?>

                                    <th class="p-2 text-xs font-medium text-center border-l border-r text-gray-700 hover:bg-gray-200 transition cursor-help" title="<?= htmlspecialchars($a['location'] ?? '') ?>">

                                        <?= $a['activity_name'] ?><br><span class="text-indigo-500 font-bold"><?= date('H:i', strtotime($a['activity_time'])) ?></span>

                                    </th>

                            <?php endforeach;

                            endif; ?>

                        </tr>

                    </thead>



                    <tbody class="bg-white">

                        <?php foreach ($customers as $c): ?>

                            <tr class="border-b hover:bg-gray-50 transition">

                                <td class="w-[180px] p-3 font-semibold text-gray-900 sticky left-0 bg-white border-r">

                                    <?= htmlspecialchars($c['customer_name']) ?>

                                </td>



                                <?php

                                if (!empty($activities)):

                                    foreach ($activities as $a): ?>

                                        <?php
                                        $activityId = $a['activity_id'];
                                        // Cấu trúc mới: ['status' => 'present/late/absent', 'notes' => '...']
                                        $currentAttendance = $c['attendance'][$activityId] ?? ['status' => 'absent', 'notes' => NULL];
                                        $currentStatus = $currentAttendance['status'];
                                        $currentNotes = $currentAttendance['notes']; // Lấy ghi chú đã lưu
                                        $statusInfo = getStatusTextAndClass($currentStatus);
                                        ?>
                                        <td class="p-2 text-center border-l border-r min-w-[100px]">
                                            <button
                                                class="activity-status-btn px-2 py-1 rounded-full shadow-sm font-medium text-xs transition <?= $statusInfo['className'] ?>"
                                                data-customer-id="<?= $c['customer_id'] ?>"
                                                data-activity-id="<?= $activityId ?>"
                                                data-status="<?= $currentStatus ?>"
                                                data-notes="<?= htmlspecialchars($currentNotes ?? '') ?>">
                                                <?= $statusInfo['text'] ?> <?= $currentNotes ? '📝' : '' ?>
                                            </button>
                                        </td>

                                <?php endforeach;

                                endif; ?>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>



            <div class="text-right p-4 border-t">

                <button id="saveAttendance"

                    class="px-8 py-3 bg-blue-600 text-white rounded-2xl shadow-lg hover:bg-blue-700 active:scale-95 transition font-semibold">

                    💾 Lưu điểm danh

                </button>

            </div>
            <div id="notesModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden items-center justify-center z-50">
                <div class="bg-white p-6 rounded-xl shadow-2xl w-full max-w-md space-y-4 transform transition-all">
                    <h3 class="text-xl font-bold text-gray-800">📝 Thêm Ghi Chú</h3>
                    <p id="modalCustomerName" class="text-sm text-gray-600 font-medium"></p>

                    <input type="hidden" id="modalCustomerId">
                    <input type="hidden" id="modalActivityId">
                    <input type="hidden" id="modalStatus">

                    <div>
                        <label for="notesInput" class="block text-sm font-medium text-gray-700 mb-2">Nội dung ghi chú:</label>
                        <textarea id="notesInput" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3" placeholder="Nhập lý do vắng mặt hoặc đến muộn..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button id="cancelNotes" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Hủy</button>
                        <button id="saveNotes" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 transition">Lưu Ghi Chú</button>
                    </div>
                </div>
            </div>



        <?php else: ?>

            <div class="p-6 bg-gray-100 border border-gray-300 text-gray-700 rounded-xl text-center">

                <p class="font-semibold text-lg">Không tìm thấy khách hàng hoặc lịch trình hoạt động cho Ngày <?= $current_day_number ?? '?' ?>.</p>

                <p class="text-sm mt-1">Vui lòng kiểm tra lại dữ liệu Tour Itineraries và ngày hiện tại.</p>

            </div>

        <?php endif; ?>

    </section>
</main>

<script>
    // 1. Cấu trúc dữ liệu thay đổi: { customer_id: { activity_id: { status: '...', notes: '...' }, ... } }
    let attendanceChanges = {};
    const statusOrder = ['absent', 'present', 'late'];

    function getNextStatus(currentStatus) {
        const currentIndex = statusOrder.indexOf(currentStatus);
        const nextIndex = (currentIndex + 1) % statusOrder.length;
        return statusOrder[nextIndex];
    }

    function getStatusTextAndClassJS(status) {
        let text = 'Vắng mặt';
        let className = 'bg-red-500 text-white hover:bg-red-600';

        if (status === 'present') {
            text = 'Đã đến';
            className = 'bg-green-600 text-white hover:bg-green-700';
        } else if (status === 'late') {
            text = 'Đến muộn';
            className = 'bg-yellow-500 text-white hover:bg-yellow-600';
        }

        return {
            text,
            className
        };
    }

    // Biến tạm lưu trữ button đang được click
    let currentButton = null;

    // --- FIX LỖI CUỘN TRANG (Lỗi 1) ---
    // Sử dụng DOMContentLoaded để đảm bảo các phần tử đã sẵn sàng
    document.addEventListener("DOMContentLoaded", function() {
        const btnCheckin = document.querySelector(".checkin-btn");
        const customerList = document.getElementById("customerList");

        if (btnCheckin && customerList) {
            btnCheckin.addEventListener("click", function() {
                customerList.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            });
        }
    });

    // --- XỬ LÝ MODAL GHI CHÚ (Lỗi 3 & Logic Notes) ---
    const modal = document.getElementById('notesModal');
    const notesInput = document.getElementById('notesInput');
    const modalCustomerId = document.getElementById('modalCustomerId');
    const modalActivityId = document.getElementById('modalActivityId');
    const modalStatus = document.getElementById('modalStatus');
    const modalCustomerName = document.getElementById('modalCustomerName');

    function openNotesModal(customerId, activityId, status, notes, customerName) {
        // Lấy nút đang thao tác để cập nhật sau
        currentButton = document.querySelector(`[data-customer-id="${customerId}"][data-activity-id="${activityId}"]`);

        modalCustomerId.value = customerId;
        modalActivityId.value = activityId;
        modalStatus.value = status;
        notesInput.value = notes;
        modalCustomerName.textContent = `Khách hàng: ${customerName}`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        notesInput.focus();
    }

    function closeNotesModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('cancelNotes').addEventListener('click', closeNotesModal);

    document.getElementById('saveNotes').addEventListener('click', function() {
        const customerId = modalCustomerId.value;
        const activityId = modalActivityId.value;
        const newStatus = modalStatus.value;
        const notes = notesInput.value.trim() || null; // Lưu NULL nếu trống

        // Lưu thay đổi vào bộ nhớ đệm
        if (!attendanceChanges[customerId]) {
            attendanceChanges[customerId] = {};
        }
        attendanceChanges[customerId][activityId] = {
            status: newStatus,
            notes: notes
        };

        // Cập nhật giao diện nút
        if (currentButton) {
            const {
                text,
                className
            } = getStatusTextAndClassJS(newStatus);
            currentButton.dataset.status = newStatus;
            currentButton.dataset.notes = notes || ''; // Cập nhật data-notes
            currentButton.textContent = text + (notes ? ' 📝' : '');
            currentButton.className = "activity-status-btn px-2 py-1 rounded-full shadow-sm font-medium text-xs transition " + className;
        }

        closeNotesModal();
    });

    // --- LOGIC CHUYỂN TRẠNG THÁI (ĐIỂM DANH) - Đã FIX LỖI TRÙNG LẶP ---
    document.querySelectorAll(".activity-status-btn").forEach(btn => {
        btn.addEventListener("click", function() {
            const customerId = this.dataset.customerId;
            const activityId = this.dataset.activityId;
            const currentStatus = this.dataset.status;
            // Lấy ghi chú hiện tại (từ data-notes trong HTML, hoặc từ attendanceChanges nếu đã thay đổi)
            const existingNotes = this.dataset.notes || (attendanceChanges[customerId] ? attendanceChanges[customerId][activityId]?.notes : '');

            const newStatus = getNextStatus(currentStatus);

            // Lấy tên khách hàng từ ô đầu tiên của hàng
            const customerName = this.closest('tr').querySelector('td:first-child').textContent.trim();

            if (newStatus === 'late' || newStatus === 'absent') {
                // Mở Modal để nhập ghi chú
                openNotesModal(customerId, activityId, newStatus, existingNotes, customerName);
            } else {
                // Trường hợp 'present' (Đã đến) -> Notes là NULL, không cần Modal
                let notes = null;

                // Lưu thay đổi vào bộ nhớ đệm
                if (!attendanceChanges[customerId]) {
                    attendanceChanges[customerId] = {};
                }
                attendanceChanges[customerId][activityId] = {
                    status: newStatus,
                    notes: notes // Notes là NULL
                };

                // Cập nhật giao diện 
                this.dataset.status = newStatus;
                this.dataset.notes = ''; // Xóa data-notes
                const {
                    text,
                    className
                } = getStatusTextAndClassJS(newStatus);
                this.textContent = text;
                this.className = "activity-status-btn px-2 py-1 rounded-full shadow-sm font-medium text-xs transition " + className;
            }
        });
    });

    // 3. Xử lý lưu trữ khi bấm nút "Lưu điểm danh" (Lỗi 2)
    document.getElementById("saveAttendance")?.addEventListener("click", function() {
        if (Object.keys(attendanceChanges).length === 0) {
            alert("Không có thay đổi nào để lưu!");
            return;
        }

        // Gửi data theo cấu trúc mới { customerId: { activityId: { status, notes } } }
        fetch("?mode=admin&act=saveAttendanceByActivity", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(attendanceChanges)
            })
            .then(res => res.text())
            .then(data => {
                if (data.trim() === 'success') {
                    alert("Lưu điểm danh thành công!");
                    attendanceChanges = {};
                    window.location.reload();
                } else {
                    console.error("Lưu điểm danh thất bại. Phản hồi server: ", data);
                    alert("Lưu điểm danh thất bại. Vui lòng kiểm tra console.");
                }
            })
            .catch(error => {
                console.error("Lỗi khi lưu điểm danh:", error);
                alert("Đã xảy ra lỗi khi gửi dữ liệu lên server.");
            });
    });
</script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>