<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sidebar</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">
  <!-- Sidebar -->
  <aside
    class="flex flex-col bg-white border-r border-slate-200 shadow-lg py-6 px-4 sticky top-0 min-w-[280px] h-screen overflow-y-auto transition-all duration-200 ease-in-out">

    <!-- Logo -->
    <div class="flex items-center gap-3 mb-8 px-2">
      <div
        class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-violet-500 text-white rounded-xl flex items-center justify-center font-bold shadow-md">
        DT
      </div>
      <div>
        <h1 class="text-lg font-bold text-slate-800">Điều hành tour</h1>
        <p class="text-xs text-slate-500 tracking-wide">ADMIN Dashboard</p>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="space-y-1">
      <a href="<?= BASE_URL ?>?mode=admin&act=addtour"
        class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
        <span class="text-lg">📁</span>
        <span>Danh mục tour</span>
      </a>

      <a href="<?= BASE_URL ?>?act=booking"
        class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
        <span class="text-lg">🧾</span>
        <span>Quản lý booking</span>
      </a>

      <a href="<?= BASE_URL ?>?act=promotion"
        class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
        <span class="text-lg">⚙️</span>
        <span>Phiên bản & khuyến mãi</span>
      </a>

      <a href="<?= BASE_URL ?>?act=qrlink"
        class="flex items-center gap-3 px-4 py-2 rounded-lg text-slate-700 hover:bg-indigo-100 hover:text-indigo-600 transition">
        <span class="text-lg">🔗</span>
        <span>Mã QR / Link đặt tour</span>
      </a>
    </nav>

    <!-- Divider -->
    <div class="my-6 border-t border-slate-200"></div>

    <!-- Category -->
    <div>
      <h3 class="text-xs uppercase text-slate-400 mb-3 tracking-wide font-semibold">Danh mục tour</h3>
      <ul class="space-y-2">

        <li>
          <a href="<?= BASE_URL ?>?act=tourTrongNuoc"
            class="flex items-center justify-between px-4 py-3 rounded-lg shadow-sm bg-indigo-50 hover:bg-indigo-100 transition">
            <div>
              <div class="text-sm font-medium text-slate-800">Tour trong nước</div>
              <div class="text-xs text-slate-500">Trải nghiệm trong nước</div>
            </div>
            <div class="text-indigo-600 font-semibold text-sm">12</div>
          </a>
        </li>

        <li>
          <a href="<?= BASE_URL ?>?act=tourQuocTe"
            class="flex items-center justify-between px-4 py-3 rounded-lg shadow-sm bg-white hover:bg-slate-50 transition">
            <div>
              <div class="text-sm font-medium text-slate-800">Tour quốc tế</div>
              <div class="text-xs text-slate-500">Khách nước ngoài</div>
            </div>
            <div class="text-slate-500 font-semibold text-sm">8</div>
          </a>
        </li>

        <li>
          <a href="<?= BASE_URL ?>?act=tourTheoYeuCau"
            class="flex items-center justify-between px-4 py-3 rounded-lg shadow-sm bg-white hover:bg-slate-50 transition">
            <div>
              <div class="text-sm font-medium text-slate-800">Tour theo yêu cầu</div>
              <div class="text-xs text-slate-500">Customized tour</div>
            </div>
            <div class="text-slate-500 font-semibold text-sm">5</div>
          </a>
        </li>

      </ul>
    </div>
  </aside>
</body>

</html>
