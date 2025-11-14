<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Quản trị viên - Danh mục Tour</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        ::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 9999px;
        }
    </style>
</head>

<body class="bg-white text-slate-800 antialiased">
    <div class="max-w-6xl mx-auto p-6">
        <!-- Breadcrumb -->
        <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li>Quản trị viên</li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300">Bảng điều khiển</li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Danh mục Tour</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <h1 class="text-2xl font-semibold text-slate-900">Danh mục Tour</h1>
                <span class="inline-block bg-slate-100 text-slate-600 px-2 py-0.5 text-sm rounded-full">5</span>
            </div>

            <div class="flex items-center space-x-3">
                <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-md text-sm text-slate-600 bg-white hover:bg-slate-50">
                    Lọc
                </button>

                <a href="?mode=admin&act=add_category" class="flex items-center gap-2 px-4 py-2 bg-white border border-indigo-600 text-indigo-600 rounded-md text-sm hover:bg-indigo-50">
    Tạo mới
</a>
            </div>
        </div>

        <!-- Card / Table container -->
        <div class="bg-white border border-slate-100 rounded-lg shadow-sm">
            <!-- Table header row -->
            <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 border-b border-slate-100 text-slate-500 text-sm font-medium">
                <div class="col-span-1 flex items-center">
                    <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                </div>
                <div class="col-span-1">ID</div>
                <div class="col-span-4">Tên danh mục</div>
                <div class="col-span-4">Mô tả</div>
                <div class="col-span-2 text-right">Cập nhật</div>
            </div>

            <!-- Table body -->
            <div class="divide-y divide-slate-100">
                <!-- Row template (ví dụ dữ liệu) -->
                <div class="grid grid-cols-12 items-center gap-4 px-6 py-4">
                    <div class="col-span-1">
                        <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                    </div>
                    <div class="col-span-1 text-sm text-slate-600">1</div>
                    <div class="col-span-4 text-sm text-slate-800">Tour trong nước</div>
                    <div class="col-span-4 text-sm text-slate-700">Các tour du lịch tham quan trong nước</div>
                    <div class="col-span-2 text-right text-sm text-slate-500">2024-08-28 17:50</div>
                </div>

                <div class="grid grid-cols-12 items-center gap-4 px-6 py-4">
                    <div class="col-span-1">
                        <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                    </div>
                    <div class="col-span-1 text-sm text-slate-600">2</div>
                    <div class="col-span-4 text-sm text-slate-800">Tour quốc tế</div>
                    <div class="col-span-4 text-sm text-slate-700">Các tour du lịch nước ngoài</div>
                    <div class="col-span-2 text-right text-sm text-slate-500">2024-08-28 17:50</div>
                </div>

                <div class="grid grid-cols-12 items-center gap-4 px-6 py-4">
                    <div class="col-span-1">
                        <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                    </div>
                    <div class="col-span-1 text-sm text-slate-600">3</div>
                    <div class="col-span-4 text-sm text-slate-800">Tour theo yêu cầu</div>
                    <div class="col-span-4 text-sm text-slate-700">Tour thiết kế riêng theo nhu cầu khách hàng</div>
                    <div class="col-span-2 text-right text-sm text-slate-500">2024-08-28 17:50</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>