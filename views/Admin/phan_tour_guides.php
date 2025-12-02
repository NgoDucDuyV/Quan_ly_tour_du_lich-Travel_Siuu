<!-- File: phan_tour_guide.php -->
<!-- Giao diện phân tour lịch trình dành cho hướng dẫn viên - Đồng bộ phong cách với trang Cập nhật trạng thái Booking -->
<div class="max-w-[1600px] mx-auto p-6 space-y-8 font-sans">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-2" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-gray-300 text-gray-400">Phân tour & lịch trình</li>
        </ul>
    </nav>

    <!-- Title -->
    <h1 class="text-3xl font-semibold text-gray-900">Phân tour cho hướng dẫn viên</h1>

    <!-- MAIN CARD -->
    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200 space-y-8">

        <!-- Thông tin tour -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-800">Thông tin tour</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Mã tour</label>
                    <input value="TOUR-2024-001" disabled class="w-full p-3 bg-gray-100 rounded-xl border text-gray-700 shadow-sm">
                </div>
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Tên tour</label>
                    <input value="Tour Hà Nội - Sapa 3N2Đ" disabled class="w-full p-3 bg-gray-100 rounded-xl border text-gray-700 shadow-sm">
                </div>
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Ngày khởi hành</label>
                    <input value="10/12/2025" disabled class="w-full p-3 bg-gray-100 rounded-xl border text-gray-700 shadow-sm">
                </div>
                <div>
                    <label class="block font-semibold mb-2 text-gray-600">Số lượng khách</label>
                    <input value="25 khách" disabled class="w-full p-3 bg-gray-100 rounded-xl border text-gray-700 shadow-sm">
                </div>
            </div>
        </div>

        <!-- Danh sách hướng dẫn viên -->
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Danh sách hướng dẫn viên</h2>
                <input type="text" placeholder="Tìm hướng dẫn viên..." class="p-3 border rounded-xl shadow-sm w-64">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                <!-- HDV item -->
                <div class="p-5 bg-white border rounded-2xl shadow hover:shadow-lg transition">
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/150?img=12" class="w-16 h-16 rounded-xl shadow" />
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg">Nguyễn Văn An</h3>
                            <p class="text-gray-500 text-sm">Kinh nghiệm: 5 năm</p>
                            <p class="text-gray-500 text-sm">SĐT: 0987 123 456</p>
                        </div>
                    </div>
                    <button class="w-full mt-4 py-3 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 font-semibold">Phân công</button>
                </div>

                <div class="p-5 bg-white border rounded-2xl shadow hover:shadow-lg transition">
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/150?img=45" class="w-16 h-16 rounded-xl shadow" />
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg">Trần Quang Minh</h3>
                            <p class="text-gray-500 text-sm">Kinh nghiệm: 3 năm</p>
                            <p class="text-gray-500 text-sm">SĐT: 0902 888 111</p>
                        </div>
                    </div>
                    <button class="w-full mt-4 py-3 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 font-semibold">Phân công</button>
                </div>

                <div class="p-5 bg-white border rounded-2xl shadow hover:shadow-lg transition">
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/150?img=32" class="w-16 h-16 rounded-xl shadow" />
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg">Phạm Thị Hương</h3>
                            <p class="text-gray-500 text-sm">Kinh nghiệm: 2 năm</p>
                            <p class="text-gray-500 text-sm">SĐT: 0915 222 333</p>
                        </div>
                    </div>
                    <button class="w-full mt-4 py-3 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 font-semibold">Phân công</button>
                </div>

            </div>
        </div>

        <!-- Lịch trình tour -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-800">Lịch trình tour</h2>

            <div class="space-y-4">
                <div class="p-5 bg-gray-50 border rounded-xl shadow-sm">
                    <h3 class="font-semibold text-gray-900">Ngày 1: Hà Nội → Sapa</h3>
                    <p class="text-gray-600 text-sm">Xe đón khách tại điểm hẹn — Dùng bữa trưa — Tham quan Cat Cat — Nhận phòng khách sạn</p>
                </div>

                <div class="p-5 bg-gray-50 border rounded-xl shadow-sm">
                    <h3 class="font-semibold text-gray-900">Ngày 2: Fansipan</h3>
                    <p class="text-gray-600 text-sm">Di chuyển cáp treo — Chinh phục đỉnh Fansipan — Tham quan thị trấn Sapa</p>
                </div>

                <div class="p-5 bg-gray-50 border rounded-xl shadow-sm">
                    <h3 class="font-semibold text-gray-900">Ngày 3: Sapa → Hà Nội</h3>
                    <p class="text-gray-600 text-sm">Dùng sáng — Mua sắm — Trả khách về Hà Nội</p>
                </div>
            </div>
        </div>

        <!-- Button submit -->
        <button class="w-full md:w-auto px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 transition">Lưu phân công</button>

    </div>
</div>

<!-- Kiểm tra trùng lịch HDV -->
<div class="space-y-4 mt-10">
    <h2 class="text-xl font-semibold text-gray-800">Kiểm tra trùng lịch hướng dẫn viên</h2>

    <div class="p-5 bg-white border rounded-2xl shadow-xl space-y-4">
        <p class="text-gray-600 text-sm">Khi chọn hướng dẫn viên, hệ thống sẽ kiểm tra xem HDV có đang dẫn tour khác trong thời gian này hay không.</p>

        <div class="space-y-3">
            <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                <h3 class="font-semibold text-red-700">Nguyễn Văn An đang bận</h3>
                <p class="text-red-600 text-sm">Tour: Hạ Long 2N1Đ — Từ 08/12/2025 đến 11/12/2025</p>
            </div>

            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                <h3 class="font-semibold text-yellow-700">Trần Quang Minh có lịch gần trùng</h3>
                <p class="text-yellow-600 text-sm">Vừa kết thúc tour ngày 09/12/2025 — Có thể phân công nhưng cần kiểm tra thời gian di chuyển.</p>
            </div>

            <div class="p-4 bg-green-50 border border-green-200 rounded-xl">
                <h3 class="font-semibold text-green-700">Phạm Thị Hương rảnh</h3>
                <p class="text-green-600 text-sm">Không có tour nào trong khoảng 09–13/12/2025.</p>
            </div>
        </div>
    </div>
</div>


<script>
    // ===============================
    // LOGIC KIỂM TRA TRÙNG LỊCH HDV
    // ===============================
    // Demo dữ liệu lịch đã có của hướng dẫn viên
    const guideSchedules = [{
            id: 1,
            name: "Nguyễn Văn An",
            busy: [{
                from: "2025-12-08",
                to: "2025-12-11",
                tour: "Hạ Long 2N1Đ"
            }]
        },
        {
            id: 2,
            name: "Trần Quang Minh",
            busy: [{
                from: "2025-12-09",
                to: "2025-12-09",
                tour: "Ninh Bình 1N"
            }]
        },
        {
            id: 3,
            name: "Phạm Thị Hương",
            busy: []
        }
    ];

    // Ngày khởi hành của tour cần phân công
    const currentTour = {
        from: "2025-12-10",
        to: "2025-12-13"
    };

    // Hàm kiểm tra trùng lịch
    function isOverlap(date1Start, date1End, date2Start, date2End) {
        return !(date1End < date2Start || date1Start > date2End);
    }

    // Hàm check và hiển thị trạng thái của từng HDV
    function checkGuideAvailability() {
        console.log("=== KIỂM TRA TRÙNG LỊCH ===");

        guideSchedules.forEach(guide => {
            if (guide.busy.length === 0) {
                console.log(`${guide.name} → Rảnh hoàn toàn`);
                return;
            }

            let status = "free";
            let message = "";

            guide.busy.forEach(schedule => {
                const isConflict = isOverlap(
                    currentTour.from,
                    currentTour.to,
                    schedule.from,
                    schedule.to
                );

                if (isConflict) {
                    status = "busy";
                    message = `Đang bận tour: ${schedule.tour} (${schedule.from} → ${schedule.to})`;
                } else {
                    // Ngày gần trùng (kết thúc 1 ngày trước hoặc bắt đầu 1 ngày sau)
                    const endDiff = Math.abs(new Date(schedule.to) - new Date(currentTour.from)) / (1000 * 3600 * 24);

                    if (endDiff <= 1) {
                        status = "near";
                        message = `Gần trùng lịch: vừa kết thúc tour ${schedule.tour} vào ${schedule.to}`;
                    }
                }
            });

            // Xuất kết quả ra console
            if (status === "busy") {
                console.log(`❌ ${guide.name} → Bận | ${message}`);
            } else if (status === "near") {
                console.log(`⚠️ ${guide.name} → Lịch gần trùng | ${message}`);
            } else {
                console.log(`✅ ${guide.name} → Rảnh`);
            }
        });
    }

    // Gọi khi trang load
    checkGuideAvailability();
</script>