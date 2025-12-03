<main class="flex-1 p-8 space-y-10 bg-gray-50">

    <!-- HEADER -->
    <header class="bg-white p-6 rounded-3xl shadow-md flex items-center justify-between border border-gray-100">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                📍 Check-in & Điểm danh
            </h1>
            <p class="text-gray-500 text-sm mt-1">Quản lý khách trong tour bạn đang phụ trách</p>
        </div>
    </header>

    <!-- TOUR HÔM NAY -->
    <section class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-5">
        <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
            🚐 Tour hôm nay
        </h2>

        <?php if ($todayTour): ?>
            <div class="p-6 rounded-2xl border bg-gradient-to-r from-gray-50 to-gray-100 hover:shadow transition cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            <?= $todayTour['tour_name'] ?>
                        </h3>

                        <div class="text-gray-600 text-sm space-y-1">
                            <p>👥 <b><?= $todayTour['total_customers'] ?></b> khách tham gia</p>
                            <p>🕒 Bắt đầu lúc: <b><?= $todayTour['start_time'] ?? '' ?></b></p>
                        </div>
                    </div>

                    <button class="checkin-btn px-6 py-3 bg-green-600 text-white rounded-xl shadow hover:bg-green-700 active:scale-95 transition font-medium">
                        Check-in ngay
                    </button>

                </div>
            </div>
        <?php else: ?>
            <div class="p-4 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl">
                Hôm nay bạn không có tour nào.
            </div>
        <?php endif; ?>
    </section>

    <!-- DANH SÁCH KHÁCH -->
    <section id="customerList" class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-6">
        <h2 class="text-xl font-semibold text-gray-700 flex items-center gap-2">
            📝 Danh sách khách
        </h2>

        <div class="overflow-hidden rounded-2xl border border-gray-200 shadow">
            <table class="w-full text-left">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-4 text-sm font-medium">Tên khách</th>
                        <th class="p-4 text-sm font-medium">Trạng thái</th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $c): ?>

                            <?php
                            $currentStatus = $c['attendance_status'] ?? 'absent';
                            $statusText = $currentStatus === 'present' ? 'Đã đến' : 'Chưa đến';
                            $statusColor = $currentStatus === 'present'
                                ? 'bg-green-600 text-white'
                                : 'bg-red-500 text-white';
                            ?>

                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-4 font-medium text-gray-900">
                                    <?= htmlspecialchars($c['customer_name'] ?? $c['full_name'] ?? 'Không tên') ?>

                                </td>

                                <td class="p-4">
                                    <button
                                        class="status-btn px-4 py-1.5 rounded-full shadow-sm font-medium text-sm transition <?= $statusColor ?>"
                                        data-id="<?= $c['attendance_id'] ?>"
                                        data-status="<?= $currentStatus ?>">
                                        <?= $statusText ?>
                                    </button>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="p-5 text-center text-gray-500">
                                Không có khách trong tour này.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- NÚT LƯU -->
            <div class="text-right">
                <button id="saveAttendance"
                    class="px-8 py-3 bg-blue-600 text-white rounded-2xl shadow hover:bg-blue-700 active:scale-95 transition font-semibold">
                    💾 Lưu điểm danh
                </button>
            </div>


        </div>

    </section>
</main>

<script>
    let attendanceChanges = {};
    // Scroll to customer list
    document.querySelector(".checkin-btn")?.addEventListener("click", () => {
        document.getElementById("customerList").scrollIntoView({
            behavior: "smooth"
        });
    });


    document.querySelectorAll(".status-btn").forEach(btn => {
        btn.addEventListener("click", function() {

            let id = this.dataset.id;
            let current = this.dataset.status;

            let newStatus = current === "present" ? "absent" : "present";
            attendanceChanges[id] = newStatus;

            this.dataset.status = newStatus;
            this.textContent = newStatus === "present" ? "Đã đến" : "Chưa đến";

            this.className =
                "status-btn px-4 py-1.5 rounded-full shadow font-medium text-sm transition " +
                (newStatus === "present" ?
                    "bg-green-600 text-white" :
                    "bg-red-500 text-white");
        });
    });

    document.getElementById("saveAttendance").addEventListener("click", function() {
        fetch("?mode=admin&act=saveAttendance", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(attendanceChanges)
            })
            .then(res => res.text())
            .then(data => {
                alert("Lưu điểm danh thành công!");
                attendanceChanges = {};
            });
    });
</script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>