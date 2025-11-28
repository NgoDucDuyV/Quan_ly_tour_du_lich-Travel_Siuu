<main class="flex-1 p-6 space-y-8">

    <!-- HEADER -->
    <header class="bg-white p-6 rounded-2xl shadow flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
            Xin chào, HDV <span class="text-blue-500">Ngô Đức Duy</span> 👋
        </h1>

        <div class="flex items-center gap-3">
            <img src="https://i.pravatar.cc/40"
                class="w-12 h-12 rounded-full border shadow-sm">
        </div>
    </header>

    <!-- 3 CARD THỐNG KÊ -->
    <section class="grid md:grid-cols-3 gap-6">

        <!-- Card -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-gray-700">Tour sắp tới</h2>
            <p class="text-gray-500 mt-1">3 tour được phân công trong tuần này.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-gray-700">Lịch làm việc</h2>
            <p class="text-gray-500 mt-1">12/11 - 19/11/2025.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-gray-700">Đánh giá gần nhất</h2>
            <p class="text-gray-500 mt-1">Điểm trung bình:
                <span class="text-yellow-500 font-semibold">4.9 ⭐</span>
            </p>
        </div>

    </section>


    <!-- DANH SÁCH TOUR -->
    <section class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Danh sách tour của bạn</h2>

        <div class="overflow-hidden border rounded-xl">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 text-gray-700 text-sm">
                    <tr>
                        <th class="p-4">Tên tour</th>
                        <th class="p-4">Thời gian</th>
                        <th class="p-4">Địa điểm</th>
                        <th class="p-4 text-right">Trạng thái</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800">
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4 font-medium">Tour Hạ Long</td>
                        <td class="p-4">20/11 - 22/11/2025</td>
                        <td class="p-4">Quảng Ninh</td>
                        <td class="p-4 text-right">
                            <span class="text-green-600 font-semibold">
                                Sắp diễn ra
                            </span>
                        </td>
                    </tr>

                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4 font-medium">Tour Đà Lạt</td>
                        <td class="p-4">28/11 - 30/11/2025</td>
                        <td class="p-4">Lâm Đồng</td>
                        <td class="p-4 text-right">
                            <span class="text-yellow-600 font-semibold">
                                Đang chuẩn bị
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </section>

</main>