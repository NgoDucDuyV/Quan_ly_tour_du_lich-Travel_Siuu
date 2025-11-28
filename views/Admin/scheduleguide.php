<main class="flex-1 p-6 space-y-6">

    <!-- ========== HEADER ========== -->
    <header class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Lịch Trình & Tour</h1>
        <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full border">
    </header>


    <!-- ========== 3 KHỐI THỐNG KÊ ========== -->
    <section class="grid md:grid-cols-3 gap-4">

        <div class="bg-white p-5 rounded-xl shadow flex flex-col gap-1">
            <h2 class="text-lg font-semibold text-gray-700">Tour đang phụ trách</h2>
            <p class="text-gray-500">4 tour tuần này</p>
            <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded w-max">
                Còn 2 tour chưa bắt đầu
            </span>
        </div>

        <div class="bg-white p-5 rounded-xl shadow flex flex-col gap-1">
            <h2 class="text-lg font-semibold text-gray-700">Số giờ làm</h2>
            <p class="text-gray-500">32 giờ / tuần</p>
            <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded w-max">
                +8 giờ so với tuần trước
            </span>
        </div>

        <div class="bg-white p-5 rounded-xl shadow flex flex-col gap-1">
            <h2 class="text-lg font-semibold text-gray-700">Đánh giá hiệu suất</h2>
            <p class="text-gray-500">96%</p>
            <span class="text-sm bg-purple-100 text-purple-700 px-3 py-1 rounded w-max">
                Top 5 hướng dẫn viên
            </span>
        </div>

    </section>


    <!-- ========== LỊCH SỬ TOUR GẦN ĐÂY ========== -->
    <section class="bg-white p-5 rounded-xl shadow space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-700">Lịch sử tour gần đây</h2>
            <a href="#" class="text-blue-600 text-sm hover:underline">Xem tất cả</a>
        </div>

        <div class="space-y-4">

            <?php foreach ($recentTours as $tour): ?>
                <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                    <div>
                        <h3 class="font-semibold text-gray-800"><?= $tour['tour_name'] ?></h3>
                        <p class="text-gray-500 text-sm">
                            Hoàn thành ngày <?= date("d/m/Y", strtotime($tour['end_date'])) ?>
                            – <?= $tour['total_customers'] ?> khách
                        </p>
                    </div>

                    <?php
                    $badge = '<span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">Đã nhận xét</span>';

                    if ($tour['guide_status'] === "pending")
                        $badge = '<span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-medium">Đợi đánh giá</span>';

                    if ($tour['guide_status'] === "completed")
                        $badge = '<span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-medium">Hoàn thành</span>';
                    ?>

                    <?= $badge ?>
                </div>
            <?php endforeach; ?>

        </div>
    </section>


    <!-- ========== BẢNG TOUR TRONG TUẦN ========== -->
    <section class="bg-white p-5 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Tour trong tuần này</h2>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100 text-sm text-gray-600">
                    <th class="p-3">Tên tour</th>
                    <th class="p-3">Ngày đi</th>
                    <th class="p-3">Số khách</th>
                    <th class="p-3">Trạng thái</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($weekTours as $tour): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3"><?= $tour['tour_name'] ?></td>

                        <td class="p-3">
                            <?= date("d/m/Y", strtotime($tour['start_date'])) ?>
                        </td>

                        <td class="p-3"><?= $tour['total_customers'] ?> khách</td>

                        <td class="p-3">
                            <?php if ($tour['guide_status'] == "confirmed"): ?>
                                <span class="text-green-600 font-medium">Đã xác nhận</span>
                            <?php else: ?>
                                <span class="text-yellow-600 font-medium">Chưa xác nhận</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </section>


    <!-- ========== THÔNG BÁO ========== -->
    <section class="bg-white p-5 rounded-xl shadow space-y-4">

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-700">Thông báo dành cho bạn</h2>
            <button class="text-sm text-indigo-600 hover:underline">Đánh dấu đã đọc</button>
        </div>

        <div class="space-y-3">

            <div class="flex items-start gap-3 p-4 border rounded-lg hover:bg-gray-50">
                <div class="w-10 h-10 flex items-center justify-center bg-indigo-100 text-indigo-600 rounded-full">
                    <i class="fa-solid fa-bell text-lg"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">Cập nhật lịch họp tuần này</p>
                    <p class="text-gray-500 text-sm">Thứ 4 – 14:00. Nhớ tham dự.</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 border rounded-lg hover:bg-gray-50">
                <div class="w-10 h-10 flex items-center justify-center bg-green-100 text-green-600 rounded-full">
                    <i class="fa-solid fa-check text-lg"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">Tour mới được phân công</p>
                    <p class="text-gray-500 text-sm">Phú Quốc 3N2Đ bắt đầu ngày 25/11.</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 border rounded-lg hover:bg-gray-50">
                <div class="w-10 h-10 flex items-center justify-center bg-red-100 text-red-600 rounded-full">
                    <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">Chưa nộp báo cáo</p>
                    <p class="text-gray-500 text-sm">Bạn còn 1 báo cáo tour chưa nộp.</p>
                </div>
            </div>

        </div>
    </section>

</main>