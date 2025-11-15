<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sidebar</title>
</head>

<body>

  <aside
    class="flex flex-col relative bg-white border-r overflow-x-hidden border-slate-200 shadow-lg sticky top-0 h-screen overflow-y-auto transition-all duration-200 ease-in-out hide-scrollbar xl:max-w-[350px] xl:w-full xl:items-stretch xl:py-6 xl:px-4
    md:max-w-[80px] md:min-w-[80px] md:px-2 md:items-center md:w-full  
    sm:max-w-[350px] 
    min-w-[280px] py-6 px-4 w-0">

    <div class="flex items-center gap-3 mt-4 mb-8 px-2">
      <div
        class="w-12 h-12 bg-gradient-to-br from-[#0f2b57] to-[#a8c4f0] text-white rounded-xl flex items-center justify-center font-bold shadow-md">
        DT
      </div>
      <div class="flex-col justify-center xl:flex md:hidden">
        <h1 class="text-lg m-0 font-bold text-slate-800"><?= $_SESSION['admin_logged']['fullname'] ?></h1>
        <p class="text-xs m-0 text-slate-500 tracking-wide">(<?= $_SESSION['admin_logged']['description'] ?>)</p>
      </div>
    </div>
    <div class="xl:block md:hidden text-xs font-semibold text-slate-500 uppercase tracking-wide mb-4 ">Điều hướng</div>
    <nav class="space-y-1 font-[500] w-full
    [&_a]:relative

    xl:[&_a_span]:block 
    md:[&_a_span]:hidden

    xl:[&_a]:justify-stretch
    md:[&_a]:justify-center

    xl:[&_a_i]:mt-0;
    md:[&_a_i]:mt-5;
    <!-- details -->
    xl:[&_details_summary]:justify-stretch
    md:[&_details_summary]:justify-center

    xl:[&_details_summary_.detailstext]:flex xl:[&_details_.detailsitems]:flex 
    md:[&_details_summary_.detailstext]:hidden md:[&_details_.detailsitems]:hidden
    
    [&_details_summary_.detailstext]:flex [&_details_.detailsitems]:flex
    ">
      <!-- Nav item -->
      <a href="?act=home" class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50">
        <i class="fa-solid fa-house"></i>
        <span>Bảng điều khiển</span>
      </a>

      <a href="<?= BASE_URL ?>?act=categoriestour" class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50">
        <i class="fa-solid fa-list"></i>
        <span>Quản Lý Danh Mục Tour</span>
      </a>

      <a href="?act=admintour" class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50">
        <i class="fa-solid fa-map-marked-alt text-xl"></i>
        <span>quản lý tour</span>
      </a>

      <!-- Đối tác & nhà cung cấp -->
      <details class="group">
        <summary class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50 list-none cursor-pointer">
          <i class="fa-solid fa-handshake"></i>
          <div class="detailstext flex-1 items-center justify-between">
            <span>Đối tác & nhà cung cấp</span>
            <svg class="ml-auto h-4 w-4 text-slate-400 transition-transform duration-150 group-open:rotate-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </div>
        </summary>
        <div class="detailsitems mt-1 ml-8 flex flex-col gap-1 group-open:w-auto w-0">
          <a href="?act=supplier-list" class="px-3 py-2 rounded-md text-slate-600 hover:bg-indigo-50">Nhà cung cấp</a>
          <a href="?act=supplier-list-types" class="px-3 py-2 rounded-md text-slate-600 hover:bg-indigo-50">Loại dịch vụ</a>
        </div>
      </details>

      <!-- Quản lý tài khoản -->
      <details class="group">
        <summary class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50 list-none cursor-pointer">
          <i class="fa-solid fa-users"></i>
          <div class="detailstext flex-1 items-center justify-between">
            <span>Quản lý tài khoản</span>
            <svg class="ml-auto h-4 w-4 text-slate-400 transition-transform duration-150 group-open:rotate-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </div>
        </summary>

        <div class="detailsitems mt-1 ml-8 flex flex-col gap-1 group-open:w-auto w-0">
          <a href="?act=listclient" class="px-3 py-2 rounded-md text-slate-600 hover:bg-indigo-50">khách Hàng</a>
          <a href="?act=liststaff" class="px-3 py-2 rounded-md text-slate-600 hover:bg-indigo-50">Nhân viên</a>
        </div>
      </details>

      <!-- Active item (Thể loại) -->
      <a href="<?= BASE_URL ?>?act=booking" class="flex items-center gap-3 px-3 py-2 rounded-md text-hover bg-indigo-50">
        <i class="fa-solid fa-calendar-check text-xl"></i>
        <span>Quản lý booking</span>
      </a>

      <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50">
        <i class="fa-solid fa-chart-simple"></i>
        <span>Báo cáo & thống kê</span>
      </a>

      <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-slate-700 hover:bg-indigo-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h18M12 3v18" />
        </svg>
        <span>Travel_Siuu mạnh vãi chưởng</span>
      </a>
    </nav>


    <div class="mb-10 xl:block md:hidden">
      <h3 class="text-xs uppercase text-slate-400 mb-3 tracking-wide font-semibold">Danh mục tour</h3>
      <ul class="space-y-2 p-0">
        <li>
          <a href="<?= BASE_URL ?>?act=tourTrongNuoc"
            class="flex items-center justify-between px-4 py-3 rounded-lg shadow-sm text-slate-700 bg-indigo-50 hover:bg-slate-100 transition">
            <div>
              <div class="text-sm font-medium text-slate-800">Tour trong nước</div>
              <div class="text-xs text-slate-500">Trải nghiệm trong nước</div>
            </div>
            <div class="text-main font-semibold text-sm">12</div>
          </a>
        </li>

        <li>
          <a href="<?= BASE_URL ?>?act=tourQuocTe"
            class="flex items-center justify-between px-4 py-3 rounded-lg shadow-sm text-slate-700 bg-white hover:bg-indigo-50 transition">
            <div>
              <div class="text-sm font-medium text-slate-800">Tour quốc tế</div>
              <div class="text-xs text-slate-500">Khách nước ngoài</div>
            </div>
            <div class="text-slate-500 font-semibold text-sm">8</div>
          </a>
        </li>

        <li>
          <a href="<?= BASE_URL ?>?act=tourTheoYeuCau"
            class="flex items-center justify-between px-4 py-3 rounded-lg shadow-sm text-slate-700 bg-white hover:bg-indigo-50 transition">
            <div>
              <div class="text-sm font-medium text-slate-800">Tour theo yêu cầu</div>
              <div class="text-xs text-slate-500">Customized tour</div>
            </div>
            <div class="text-slate-500 font-semibold text-sm">5</div>
          </a>
        </li>

      </ul>
    </div>


    <div class="max-w-xs mx-auto xl:block md:hidden">
      <div class="relative min-h-[300px] bg-white rounded-2xl shadow-lg p-6 pt-10" style="background: linear-gradient(180deg, rgba(238,246,255,0.8), rgba(255,255,255,0.95));">
        <!-- top icon -->
        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 ">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-main" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.45a1 1 0 00-.364 1.118l1.286 3.955c.3.921-.755 1.688-1.54 1.118l-3.37-2.45a1 1 0 00-1.176 0l-3.37 2.45c-.784.57-1.84-.197-1.54-1.118l1.286-3.955a1 1 0 00-.364-1.118L2.063 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.955z" />
          </svg>
        </div>

        <!-- Card content -->
        <h3 class="text-center text-lg font-semibold text-slate-800 mt-2">Doanh nghiệp</h3>
        <p class="text-center text-sm text-slate-500 mt-3 leading-6 px-2">
          Thích hợp cho những người có tầm nhìn xa nhưng không có năng lực phát triển.
        </p>

        <div class="mt-6 flex justify-center">
          <button class="bg-main text-white px-6 py-2 rounded-lg shadow-md hover:bg-hover transition">
            Hãy trò chuyện
          </button>
        </div>

        <!-- subtle rounded gradient overlay bottom -->
        <div class="absolute inset-x-4 bottom-4 h-20 rounded-lg" style="background: linear-gradient(180deg, transparent, rgba(99,102,241,0.06)); filter: blur(12px); opacity: 0.9;"></div>
      </div>
    </div>

  </aside>
</body>

</html>