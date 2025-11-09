<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <!-- Sidebar -->
    <aside style="scrollbar-width:none; -ms-overflow-style:none;" class="w-72 bg-white border-r p-4 md:sticky absolute top-0 bottom-0 md:top-0 md:w-[300px] md:min-w-[300px] w-[50px] hover:w-[300px] overflow-hidden z-[1] transition-all duration-150 ease-in-out
        md:h-[100vh] overflow-y-auto">
        <div class="mb-6 flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-500 text-white rounded flex items-center justify-center font-bold">DT</div>
            <div>
                <h1 class="text-lg font-semibold">Điều hành tour</h1>
                <p class="text-sm text-slate-500">ADMIN dashboard</p>
            </div>
        </div>

        <nav class="space-y-2 text-sm">
            <button class="w-full text-left px-3 py-2 rounded hover:bg-slate-100 flex items-center gap-2">
                <span>📁</span> Danh mục tour
            </button>
            <button class="w-full text-left px-3 py-2 rounded hover:bg-slate-100 flex items-center gap-2">
                <span>🧾</span> Quản lý booking
            </button>
            <button class="w-full text-left px-3 py-2 rounded hover:bg-slate-100 flex items-center gap-2">
                <span>⚙️</span> Phiên bản & Khuyến mãi
            </button>
            <button class="w-full text-left px-3 py-2 rounded hover:bg-slate-100 flex items-center gap-2">
                <span>🔗</span> Mã QR / Link đặt tour
            </button>
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