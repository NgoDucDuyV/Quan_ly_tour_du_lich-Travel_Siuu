<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>

<body>
    <!-- Sidebar -->
    <aside style="scrollbar-width:none; -ms-overflow-style:none;" class="flex flex-col items-start bg-white border-r shadow-xl py-4 px-2 sticky top-0 min-w-[300px] overflow-hidden z-[1] transition-all duration-150 ease-in-out group
        md:h-[100vh] overflow-y-auto ">
        <div class="mb-6 flex gap-3">
            <div class="w-10 min-w-10 h-10 bg-indigo-500 text-white rounded flex items-center justify-center font-bold">DT</div>
            <div class="hidden md:inline hidden group-hover:inline">
                <h1 class="text-lg font-semibold">Điều hành tour</h1>
                <p class="text-sm text-slate-500">ADMIN dashboard</p>
            </div>
        </div>

        <nav class="space-y-2 text-sm">
            <a href="<?= BASE_URL ?>?mode=admin&act=addtour"
                class="flex items-center gap-2 px-3 py-2 rounded hover:bg-indigo-50 transition">
                <span>📁</span>
                <span class="">Danh mục tour</span>
            </a>

            <a href="<?= BASE_URL ?>?act=booking"
                class="flex items-center gap-2 px-3 py-2 rounded hover:bg-indigo-50 transition">
                <span>🧾</span>
                <span class="">Quản lý booking</span>
            </a>

            <a href="<?= BASE_URL ?>?act=promotion"
                class="flex items-center gap-2 px-3 py-2 rounded hover:bg-indigo-50 transition">
                <span>⚙️</span>
                <span class="">Phiên bản & khuyến mãi</span>
            </a>

            <a href="<?= BASE_URL ?>?act=qrlink"
                class="flex items-center gap-2 px-3 py-2 rounded hover:bg-indigo-50 transition">
                <span>🔗</span>
                <span class="hidden md:inline">Mã QR / Link đặt tour</span>
            </a>
        </nav>

        <div class="mt-6">
            <h3 class="text-xs uppercase text-slate-400 mb-2">Danh mục tour</h3>
            <ul class="space-y-2">
                <li class="flex items-center justify-between bg-indigo-50 px-3 py-2 rounded">
                    <div>
                        <div class="text-sm font-medium">Tour trong nước</div>
                        <div class="text-xs text-slate-500">Trải nghiệm trong nước</div>
                    </div>
                    <div class="text-indigo-600 text-sm">12</div>
                </li>
                <li class="flex items-center justify-between bg-white px-3 py-2 rounded">
                    <div>
                        <div class="text-sm font-medium">Tour quốc tế</div>
                        <div class="text-xs text-slate-500">Khách nước ngoài</div>
                    </div>
                    <div class="text-slate-500 text-sm">8</div>
                </li>
                <li class="flex items-center justify-between bg-white px-3 py-2 rounded">
                    <div>
                        <div class="text-sm font-medium">Tour theo yêu cầu</div>
                        <div class="text-xs text-slate-500">Customized tour</div>
                    </div>
                    <div class="text-slate-500 text-sm">5</div>
                </li>
            </ul>
        </div>
    </aside>
</body>

</html>