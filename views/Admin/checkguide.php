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

                                        $currentStatus = $c['attendance'][$activityId] ?? 'absent';

                                        $statusInfo = getStatusTextAndClass($currentStatus);

                                        ?>

                                        <td class="p-2 text-center border-l border-r min-w-[100px]">

                                            <button

                                                class="activity-status-btn px-2 py-1 rounded-full shadow-sm font-medium text-xs transition <?= $statusInfo['className'] ?>"

                                                data-customer-id="<?= $c['customer_id'] ?>"

                                                data-activity-id="<?= $activityId ?>"

                                                data-status="<?= $currentStatus ?>">

                                                <?= $statusInfo['text'] ?>

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



        <?php else: ?>

            <div class="p-6 bg-gray-100 border border-gray-300 text-gray-700 rounded-xl text-center">

                <p class="font-semibold text-lg">Không tìm thấy khách hàng hoặc lịch trình hoạt động cho Ngày <?= $current_day_number ?? '?' ?>.</p>

                <p class="text-sm mt-1">Vui lòng kiểm tra lại dữ liệu Tour Itineraries và ngày hiện tại.</p>

            </div>

        <?php endif; ?>

    </section>
</main>

<script>
    // 1. Dữ liệu thay đổi: { customer_id: { activity_id: new_status, ... } }
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

    // Scroll to customer list
    document.querySelector(".checkin-btn")?.addEventListener("click", () => {
        document.getElementById("customerList").scrollIntoView({
            behavior: "smooth"
        });
    });

    // 2. Xử lý click nút điểm danh theo Activity (.activity-status-btn)
    document.querySelectorAll(".activity-status-btn").forEach(btn => {
        btn.addEventListener("click", function() {

            const customerId = this.dataset.customerId;
            const activityId = this.dataset.activityId;
            const currentStatus = this.dataset.status;

            const newStatus = getNextStatus(currentStatus);

            // Cập nhật cấu trúc dữ liệu thay đổi
            if (!attendanceChanges[customerId]) {
                attendanceChanges[customerId] = {};
            }
            attendanceChanges[customerId][activityId] = newStatus;

            // Cập nhật giao diện 
            this.dataset.status = newStatus;
            const {
                text,
                className
            } = getStatusTextAndClassJS(newStatus);
            this.textContent = text;
            this.className = "activity-status-btn px-2 py-1 rounded-full shadow-sm font-medium text-xs transition " + className;
        });
    });

    // 3. Xử lý lưu trữ khi bấm nút "Lưu điểm danh"
    document.getElementById("saveAttendance")?.addEventListener("click", function() {
        if (Object.keys(attendanceChanges).length === 0) {
            alert("Không có thay đổi nào để lưu!");
            return;
        }

        // Gửi dữ liệu đến endpoint mới (saveAttendanceByActivity)
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
                    // Tùy chọn: reload trang để tải lại trạng thái mới nhất
                    window.location.reload();
                } else {
                    alert("Lưu điểm danh thất bại. Phản hồi server: " + data);
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