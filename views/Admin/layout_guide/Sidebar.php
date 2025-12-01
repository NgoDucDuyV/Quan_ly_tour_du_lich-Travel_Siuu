<aside
    id="sidebarHDV"
    class="flex flex-col z-[100]  bg-white border-r border-slate-200 shadow-lg top-0 transition-all duration-200 ease-in-out absolute top-0 bottom-0 h-full min-w-[300px]
    sm:min-w-[350px] sm:overflow-y-auto sm:overflow-x-hidden
    md:hide-scrollbar md:max-w-[80px] md:min-w-[80px] md:px-2 md:items-center md:w-full md:overflow-visible  
    xl:min-w-[350px] xl:w-full xl:items-stretch xl:py-6 xl:px-4 xl:overflow-y-auto xl:overflow-x-hidden sm:sticky
    min-w-[280px] py-6 px-4 w-0">

    <!-- Header -->
    <div class="flex items-center gap-3 mt-4 mb-8 px-2">
        <div
            class="w-12 h-12 bg-gradient-to-br from-[#0f2b57] to-[#a8c4f0] text-white rounded-xl flex items-center justify-center font-bold shadow-md">
            HD
        </div>
        <div class="flex-col justify-center xl:flex md:hidden">
            <h1 class="text-lg m-0 font-bold text-slate-800"><?= $_SESSION['admin_logged']['fullname'] ?></h1>
            <p class="text-xs m-0 text-slate-500 tracking-wide">(<?= $_SESSION['admin_logged']['description'] ?>)</p>
        </div>
    </div>

    <div class="xl:block md:hidden text-xs font-semibold text-slate-500 uppercase tracking-wide mb-4">Điều hướng</div>

    <!-- Navigation -->
    <nav class="font-[500] w-full
        [&_a]:relative *:mb-1
        xl:[&_a_span]:block
        md:[&_a_span]:hidden
        xl:[&_a]:justify-stretch
        md:[&_a]:justify-center
        md:[&_details_summary]:justify-center
        xl:[&_details_summary]:justify-stretch
        md:[&_details_summary_.detailstext]:hidden md:[&_details_.detailsitems]:hidden
        xl:[&_details_summary_.detailstext]:flex xl:[&_details_.detailsitems]:flex
        [&_details_summary_.detailstext]:flex
    ">

        <!-- Nav items -->
        <a href="?mode=admin&act=homeguide" class="clickloadHDVPage relative group flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50 transition">
            <i class="fa-solid fa-house"></i>
            <span>Trang chủ</span>
            <p class="absolute left-[120%] top-1/2 -translate-y-1/2 w-48 bg-white text-black rounded-md shadow-lg p-2 text-sm
                opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-opacity duration-300">
                Trang chủ
            </p>
        </a>

        <a href="?mode=admin&act=scheduleguide" class="clickloadHDVPage relative group flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50 transition">
            <i class="fa-solid fa-calendar-alt"></i>
            <span>Lịch trình & Tour</span>
            <p class="absolute left-[120%] top-1/2 -translate-y-1/2 w-48 bg-white text-black rounded-md shadow-lg p-2 text-sm
                opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-opacity duration-300">
                Lịch trình & Tour
            </p>
        </a>

        <a href="?mode=admin&act=listguide" class="clickloadHDVPage relative group flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50 transition">
            <i data-lucide="users"></i>
            <span>Danh sách khách</span>
        </a>

        <a href="?mode=admin&act=diaryguide" class="clickloadHDVPage relative group flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50 transition">
            <i data-lucide="book-open"></i>
            <span>Nhật ký tour</span>
        </a>

        <a href="?mode=admin&act=checkguide" class="clickloadHDVPage relative group flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50 transition">
            <i data-lucide="check-square"></i>
            <span>Check-in & Điểm danh</span>
        </a>

        <a href="?mode=admin&act=requestguide" class="clickloadHDVPage relative group flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50 transition">
            <i data-lucide="alert-circle"></i>
            <span>Yêu cầu đặc biệt</span>
        </a>
    </nav>

    <!-- Card / info at bottom -->
    <div class="max-w-xs mx-auto xl:block md:hidden mt-6">
        <div class="relative min-h-[300px] bg-white rounded-2xl shadow-lg p-6 pt-10" style="background: linear-gradient(180deg, rgba(238,246,255,0.8), rgba(255,255,255,0.95));">
            <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-main" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.45a1 1 0 00-.364 1.118l1.286 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.45a1 1 0 00-1.176 0l-3.37 2.45c-.784.57-1.84-.197-1.54-1.118l1.286-3.955a1 1 0 00-.364-1.118L2.063 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.955z" />
                </svg>
            </div>
            <h3 class="text-center text-lg font-semibold text-slate-800 mt-2">HDV Panel</h3>
            <p class="text-center text-sm text-slate-500 mt-3 leading-6 px-2">
                Quản lý tour, khách và nhật ký HDV.
            </p>
            <div class="mt-6 flex justify-center">
                <a href="<?= BASE_URL ?>?mode=admin&act=logout"
                    onclick="return confirm('Bạn có chắc muốn đăng xuất?')"
                    class="flex items-center gap-2 px-5 py-2.5 
              bg-blue-600 text-white font-medium rounded-xl 
              shadow-md hover:bg-blue-700 active:scale-95 
              transition duration-200">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    Đăng Xuất
                </a>
            </div>

            <div class="absolute inset-x-4 bottom-4 h-20 rounded-lg" style="background: linear-gradient(180deg, transparent, rgba(99,102,241,0.06)); filter: blur(12px); opacity: 0.9;"></div>
        </div>
    </div>
</aside>