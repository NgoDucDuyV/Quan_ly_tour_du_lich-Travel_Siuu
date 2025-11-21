<main class="flex-1 p-6 space-y-6">

    <!-- Header -->
    <header class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Nhật ký tour & khách</h1>
        <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full border">
    </header>

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Form -->
        <div class="bg-white p-5 rounded-xl shadow space-y-4">
            <h2 class="text-xl font-semibold">Thêm nhật ký</h2>

            <select class="w-full border rounded-lg px-3 py-2">
                <option>Tour Hạ Long</option>
                <option>Tour Đà Nẵng</option>
            </select>

            <textarea rows="5" class="w-full border rounded-lg px-3 py-2" placeholder="Ghi chú..."></textarea>

            <button class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Lưu nhật ký</button>
        </div>

        <!-- Lịch sử -->
        <div class="bg-white p-5 rounded-xl shadow space-y-3">

            <h2 class="text-xl font-semibold">Nhật ký gần đây</h2>

            <div class="p-4 border rounded-lg hover:bg-gray-50">
                <h3 class="font-semibold text-gray-800">Tour Hạ Long</h3>
                <p class="text-gray-600 text-sm">Khách rất vui, thời tiết đẹp</p>
                <p class="text-xs text-gray-400">Hôm qua</p>
            </div>

            <div class="p-4 border rounded-lg hover:bg-gray-50">
                <h3 class="font-semibold text-gray-800">Tour Đà Nẵng</h3>
                <p class="text-gray-600 text-sm">1 khách bị say xe nhẹ</p>
                <p class="text-xs text-gray-400">2 ngày trước</p>
            </div>

        </div>

    </section>

</main>
