<!-- Sidebar -->
<aside id="sidebar"
        class="w-72 h-[100vh] overflow-y-auto bg-white border-r shadow-lg p-4 flex flex-col fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-40">
        <div class="flex items-center justify-between mb-6">
                <button id="btnCloseSidebar" class="md:hidden text-gray-500 hover:text-gray-800">
                        <i data-lucide="x"></i>
                </button>

        </div>
        <div class="flex items-center gap-3 mb-8 px-2">
                <div
                        class="w-12 h-12 bg-gradient-to-br from-[#0f2b57] to-[#a8c4f0] text-white rounded-xl flex items-center justify-center font-bold shadow-md">
                        HDV
                </div>
                <div>
                        <h1 class="text-lg font-bold text-slate-800">Vận hành tour</h1>
                        <p class="text-xs text-slate-500 tracking-wide">HDV Dashboard</p>
                </div>
        </div>
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-4">Điều hướng</div>
        <nav class="space-y-2 flex-1 overflow-y-auto">
                <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fa-solid fa-house"></i>Trang chủ</a>
                <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fa-solid fa-route text-slate-600"></i>Lịch trình & Tour</a>
                <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm text-slate-700 hover:bg-slate-50">
                        <i data-lucide="users" class="w-5 h-5"></i>Danh sách khách</a>
                <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm text-slate-700 hover:bg-slate-50">
                        <i data-lucide="book-open-text" class="w-5 h-5"></i>Nhật ký tour</a>
                <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm text-slate-700 hover:bg-slate-50">
                        <i data-lucide="scan" class="w-5 h-5"></i>Check-in & Điểm danh</a>
                <!-- <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm text-slate-700 hover:bg-slate-50">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>Yêu cầu đặc biệt</a> -->
        </nav>
        <button class="bg-main text-white px-6 py-2 rounded-lg shadow-md hover:bg-hover transition">
                Đăng xuất
        </button>
</aside>
<script>
        lucide.createIcons();
</script>