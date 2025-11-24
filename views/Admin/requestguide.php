<main class="flex-1 p-6 space-y-6">

    <!-- HEADER -->
    <header class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Yêu cầu đặc biệt</h1>
        <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full border">
    </header>

    <!-- FORM GỬI YÊU CẦU -->
    <section class="bg-white p-6 rounded-xl shadow space-y-5">

        <h2 class="text-xl font-semibold text-gray-800">Gửi yêu cầu mới</h2>

        <!-- Tiêu đề -->
        <div>
            <label class="font-medium text-gray-700">Tiêu đề yêu cầu</label>
            <input 
                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500" 
                placeholder="Ví dụ: Xin nghỉ 1 ngày, Xin đổi tour trực tuần..."
            >
        </div>

        <!-- Loại yêu cầu -->
        <div>
            <label class="font-medium text-gray-700">Loại yêu cầu</label>
            <select class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                <option>Xin nghỉ phép</option>
                <option>Đổi tour</option>
                <option>Xin hỗ trợ khách</option>
                <option>Bổ sung thiết bị</option>
                <option>Khác…</option>
            </select>
        </div>

        <!-- Ngày mong muốn -->
        <div>
            <label class="font-medium text-gray-700">Ngày mong muốn</label>
            <input 
                type="date" 
                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Mức độ ưu tiên -->
        <div>
            <label class="font-medium text-gray-700">Mức độ ưu tiên</label>
            <select class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                <option>Thấp</option>
                <option>Trung bình</option>
                <option>Cao</option>
                <option>Khẩn cấp</option>
            </select>
        </div>

        <!-- Nội dung -->
        <div>
            <label class="font-medium text-gray-700">Nội dung chi tiết</label>
            <textarea 
                rows="5" 
                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500"
                placeholder="Mô tả rõ yêu cầu của bạn…"></textarea>
        </div>

        <!-- File đính kèm -->
        <div>
            <label class="font-medium text-gray-700">Tệp đính kèm (nếu có)</label>
            <input 
                type="file" 
                class="w-full border rounded-lg px-3 py-2 mt-1 cursor-pointer">
        </div>

        <!-- Gửi -->
        <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Gửi yêu cầu
        </button>

    </section>


    <!-- DANH SÁCH YÊU CẦU ĐÃ GỬI -->
    <section class="bg-white p-6 rounded-xl shadow space-y-5">

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Yêu cầu đã gửi</h2>
            <a href="#" class="text-sm text-blue-600 hover:underline">Xem tất cả</a>
        </div>

        <!-- ITEM -->
        <div class="p-4 border rounded-lg hover:bg-gray-50 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">Xin nghỉ ngày 22/11</h3>
                <p class="text-gray-600 text-sm">Lý do: Có việc gia đình</p>
                <p class="text-gray-400 text-xs">Gửi lúc 10:30 - 18/11/2025</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">Chờ duyệt</span>
        </div>

        <div class="p-4 border rounded-lg hover:bg-gray-50 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">Xin đổi tour trực tuần</h3>
                <p class="text-gray-600 text-sm">Đổi sang Tour Hà Giang</p>
                <p class="text-gray-400 text-xs">Gửi lúc 14:20 - 14/11/2025</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">Đã duyệt</span>
        </div>

        <div class="p-4 border rounded-lg hover:bg-gray-50 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">Bổ sung áo mưa cho đoàn</h3>
                <p class="text-gray-600 text-sm">Cần 30 áo mưa dùng 1 lần</p>
                <p class="text-gray-400 text-xs">Gửi lúc 08:12 - 10/11/2025</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">Đang xử lý</span>
        </div>

    </section>

</main>
