<main class="flex-1 p-6 space-y-6">

    <!-- Header -->
    <header class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Check-in & Điểm danh</h1>
        <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full border">
    </header>

    <!-- Tour hôm nay -->
    <section class="bg-white p-5 rounded-xl shadow space-y-3">
        <h2 class="text-xl font-semibold text-gray-700">Tour hôm nay</h2>

        <div class="p-4 border rounded-lg flex items-center justify-between hover:bg-gray-50">
            <div>
                <h3 class="text-gray-800 font-semibold">Tour Hạ Long – 25 khách</h3>
                <p class="text-gray-500 text-sm">Bắt đầu lúc 7:30</p>
            </div>

            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Check-in ngay
            </button>
        </div>

    </section>

    <!-- Danh sách khách -->
    <section class="bg-white p-5 rounded-xl shadow space-y-4">

        <h2 class="text-xl font-semibold text-gray-700">Danh sách khách</h2>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100 text-gray-600">
                    <th class="p-3">Tên khách</th>
                    <th class="p-3">Trạng thái</th>
                    <th class="p-3 text-right">Điểm danh</th>
                </tr>
            </thead>

            <tbody>

                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">Phạm Quốc Hưng</td>
                    <td class="p-3 text-green-600 font-medium">Đã đến</td>
                    <td class="p-3 text-right text-blue-600 cursor-pointer">Cập nhật</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">Lê Thị Thu</td>
                    <td class="p-3 text-yellow-600 font-medium">Chưa đến</td>
                    <td class="p-3 text-right text-blue-600 cursor-pointer">Cập nhật</td>
                </tr>

            </tbody>
        </table>

    </section>

</main>
