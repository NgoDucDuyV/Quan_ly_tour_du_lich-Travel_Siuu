<main class="flex-1 p-6 space-y-6">

    <!-- HEADER -->
    <header class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Yêu cầu đặc biệt</h1>
        <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full border">
    </header>

    <!-- FORM GỬI YÊU CẦU -->
    <section class="bg-white p-5 rounded-xl shadow space-y-4">
        <h2 class="text-xl font-semibold">Gửi yêu cầu mới</h2>

        <input class="w-full border rounded-lg px-3 py-2" placeholder="Tiêu đề yêu cầu">

        <textarea rows="5" class="w-full border rounded-lg px-3 py-2" placeholder="Nội dung yêu cầu..."></textarea>

        <button class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Gửi yêu cầu</button>
    </section>

    <!-- LỊCH SỬ YÊU CẦU -->
    <section class="bg-white p-5 rounded-xl shadow space-y-4">

        <h2 class="text-xl font-semibold">Yêu cầu đã gửi</h2>

        <div class="p-4 border rounded-lg hover:bg-gray-50 flex items-center justify-between">
            <div>
                <p class="font-semibold text-gray-800">Xin nghỉ ngày 22/11</p>
                <p class="text-gray-500 text-sm">Đang chờ duyệt</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">Chờ duyệt</span>
        </div>

        <div class="p-4 border rounded-lg hover:bg-gray-50 flex items-center justify-between">
            <div>
                <p class="font-semibold text-gray-800">Xin đổi tour trực tuần</p>
                <p class="text-gray-500 text-sm">Đã được phê duyệt</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">Đã duyệt</span>
        </div>

    </section>

</main>