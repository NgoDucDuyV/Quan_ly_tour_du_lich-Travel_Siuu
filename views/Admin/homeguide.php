<!-- Main content -->
<main class="flex-1 p-6 space-y-6">
    <!-- Header -->
    <header class="flex items-center justify-between bg-white p-4 rounded-xl shadow">
        <h1 class="text-2xl font-semibold text-gray-800">Xin chào, HDV <span class="text-orange-500">Ngô Đức Duy</span> 👋</h1>
        <div class="flex items-center gap-3">
            <img src="https://i.pravatar.cc/40" alt="Avatar" class="w-10 h-10 rounded-full border">
        </div>
    </header>

    <!-- Thông tin tổng quan -->
    <section class="grid md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-lg font-semibold mb-2 text-gray-700">Tour sắp tới</h2>
            <p class="text-gray-500">3 tour được phân công trong tuần này.</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-lg font-semibold mb-2 text-gray-700">Lịch làm việc</h2>
            <p class="text-gray-500">Làm việc từ 12/11 - 19/11/2025.</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-lg font-semibold mb-2 text-gray-700">Đánh giá gần nhất</h2>
            <p class="text-gray-500">Điểm trung bình: 4.9 ⭐</p>
        </div>
    </section>

    <!-- Danh sách tour -->
    <section class="bg-white p-4 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Danh sách tour của bạn</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="p-3">Tên tour</th>
                    <th class="p-3">Thời gian</th>
                    <th class="p-3">Địa điểm</th>
                    <th class="p-3 text-right">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">Tour Hạ Long</td>
                    <td class="p-3">20/11 - 22/11/2025</td>
                    <td class="p-3">Quảng Ninh</td>
                    <td class="p-3 text-right text-green-600 font-medium">Sắp diễn ra</td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">Tour Đà Lạt</td>
                    <td class="p-3">28/11 - 30/11/2025</td>
                    <td class="p-3">Lâm Đồng</td>
                    <td class="p-3 text-right text-yellow-600 font-medium">Đang chuẩn bị</td>
                </tr>
            </tbody>
        </table>
    </section>
</main>