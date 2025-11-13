<!-- Sidebar -->
<aside id="sidebar" class="w-72 h-[100vh] overflow-y-auto bg-white border-r shadow-lg p-4 flex flex-col fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-40">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-dark">HDV Panel</h1>
        <button id="btnCloseSidebar" class="md:hidden text-gray-500 hover:text-gray-800">
            <i data-lucide="x"></i>
        </button>
    </div>
    <nav class="space-y-2 flex-1 overflow-y-auto">
        <a href="?mode=admin&act=homeguide" class="flex items-center gap-2 p-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium"><i data-lucide="home"></i>Trang chủ</a>
        <a href="?mode=admin&act=scheduleguide" class="flex items-center gap-2 p-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium"><i data-lucide="calendar"></i>Lịch trình & Tour</a>
        <a href="?mode=admin&act=listguide" class="flex items-center gap-2 p-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium"><i data-lucide="users"></i>Danh sách khách</a>
        <a href="?mode=admin&act=diaryguide" class="flex items-center gap-2 p-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium"><i data-lucide="book-open"></i>Nhật ký tour</a>
        <a href="?mode=admin&act=checkguide" class="flex items-center gap-2 p-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium"><i data-lucide="check-square"></i>Check-in & Điểm danh</a>
        <a href="?mode=admin&act=requestguide" class="flex items-center gap-2 p-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium"><i data-lucide="alert-circle"></i>Yêu cầu đặc biệt</a>
    </nav>
    <button class="mt-4 bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 transition">
        Đăng xuất
    </button>
</aside>