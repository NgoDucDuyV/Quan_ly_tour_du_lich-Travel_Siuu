<div class="max-w-4xl mx-auto p-2 space-y-6">

    <!-- Header giống dashboard -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white rounded-3xl p-8 shadow-lg">
        <h1 class="text-3xl font-bold">Thông báo</h1>
        <p class="mt-2 text-blue-100">Bạn có <span class="font-black">3</span> thông báo mới</p>
    </div>

    <!-- Thông báo phân tour – Chưa đọc -->
    <a href="?act=mesageguidedetail&id=123" class="block bg-white rounded-2xl shadow hover:shadow-xl transition group border border-gray-200 hover:border-blue-300">
        <div class="p-6 flex items-center gap-5">
            <div class="relative flex-shrink-0">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition">
                    <i data-lucide="bus" class="w-8 h-8 text-orange-600"></i>
                </div>
                <span class="absolute -top-2 -right-2 w-5 h-5 bg-red-600 rounded-full border-4 border-white shadow-lg animate-pulse"></span>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900">Bạn được phân tour mới!</h3>
                <p class="text-gray-700 mt-1">Đà Lạt – Crazy House – Thác Datanla 4N3Đ</p>
                <div class="flex items-center gap-4 mt-3 text-sm">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-medium">#BK-2025-1208</span>
                    <span class="text-gray-600">15-18/12/2025</span>
                </div>
                <p class="text-xs text-gray-500 mt-2">10 phút trước</p>
            </div>
            <i data-lucide="chevron-right" class="w-6 h-6 text-gray-400 group-hover:text-blue-600 transition"></i>
        </div>
    </a>

    <!-- Thông báo khác – Chưa đọc -->
    <a href="?act=mesageguidedetail&id=124" class="block bg-white rounded-2xl shadow hover:shadow-xl transition group border border-gray-200 hover:border-blue-300">
        <div class="p-6 flex items-center gap-5">
            <div class="relative flex-shrink-0">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition">
                    <i data-lucide="calendar-check" class="w-8 h-8 text-purple-600"></i>
                </div>
                <span class="absolute -top-2 -right-2 w-5 h-5 bg-red-600 rounded-full border-4 border-white shadow-lg animate-pulse"></span>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900">Phân tour mới – Khách VIP</h3>
                <p class="text-gray-700 mt-1">Phú Quốc 5N4Đ – Đoàn 20 khách</p>
                <div class="flex items-center gap-4 mt-3 text-sm">
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full font-medium">#BK-2025-1215</span>
                    <span class="text-gray-600">20-24/12/2025</span>
                </div>
                <p class="text-xs text-gray-500 mt-2">1 giờ trước</p>
            </div>
            <i data-lucide="chevron-right" class="w-6 h-6 text-gray-400 group-hover:text-blue-600 transition"></i>
        </div>
    </a>

    <!-- Thông báo đã đọc -->
    <a href="?act=tour_detail&id=1199" class="block bg-white rounded-2xl shadow hover:shadow-xl transition group">
        <div class="p-6 flex items-center gap-5">
            <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition">
                <i data-lucide="circle-check" class="w-8 h-8 text-green-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900">Khách đã thanh toán đủ</h3>
                <p class="text-gray-700 mt-1">Booking #BK-2025-1199 – Nha Trang</p>
                <p class="text-xs text-gray-500 mt-3">Hôm qua, 14:30</p>
            </div>
            <i data-lucide="chevron-right" class="w-6 h-6 text-gray-400 group-hover:text-blue-600 transition"></i>
        </div>
    </a>

</div>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>