<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chi tiết hướng dẫn viên - HDV #001</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        .tab-button.active {
            @apply border-main text-main font-semibold;
        }

        .tab-button {
            @apply border-b-2 border-transparent text-slate-600 hover:text-slate-900 pb-3 px-1 transition;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <div class="max-w-[1900px] mx-auto p-6">

        <!-- Breadcrumb -->
        <nav class="text-sm text-slate-500 mb-4">
            <ul class="inline-flex items-center space-x-2">
                <li><a href="#" class="hover:text-slate-700">Quản trị viên</a></li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300"><a href="#" class="hover:text-slate-700">Quản lý HDV</a></li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300 font-medium text-slate-700">Chi tiết HDV</li>
            </ul>
        </nav>

        <!-- Tiêu đề + nút quay lại -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-6">
                <h1 class="text-3xl font-bold text-slate-900">
                    Hướng dẫn viên: <span class="text-main">Trần Thị Lan</span>
                </h1>
                <div class="flex gap-3">
                    <span class="px-5 py-2 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800">Rảnh</span>
                    <span class="px-5 py-2 rounded-full text-sm font-bold bg-blue-100 text-blue-800">8 năm kinh nghiệm</span>
                </div>
            </div>
            <a href="javascript:history.back()" class="flex items-center gap-2 px-6 py-3 border border-slate-300 rounded-xl hover:bg-slate-50 transition text-main text-sm font-medium">
                Quay lại
            </a>
        </div>

        <!-- Tabs -->
        <div class="border-b border-slate-200 mb-8">
            <div class="flex gap-10">
                <button class="tab-button active" data-tab="info">Thông tin cá nhân</button>
                <button class="tab-button" data-tab="schedules">Lịch trình đang dẫn <span class="text-main">(3)</span></button>
                <button class="tab-button" data-tab="history">Lịch sử tour đã dẫn <span class="text-main">(48)</span></button>
                <button class="tab-button" data-tab="stats">Thống kê hiệu suất</button>
            </div>
        </div>

        <!-- Tab: Thông tin cá nhân -->
        <div id="tab-info" class="tab-content">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Ảnh + thông tin nhanh -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center">
                        <img src="https://i.pravatar.cc/400?img=1" class="w-48 h-48 rounded-full mx-auto mb-6 ring-8 ring-white shadow-xl object-cover">
                        <h2 class="text-2xl font-bold text-slate-900">Trần Thị Lan</h2>
                        <p class="text-lg text-main font-medium">HDV #001</p>

                        <div class="mt-8 space-y-5 text-sm">
                            <div class="flex items-center justify-center gap-3">
                                <i class="fa-solid fa-phone text-green-600"></i>
                                <span>0901 234 567</span>
                            </div>
                            <div class="flex items-center justify-center gap-3">
                                <i class="fa-solid fa-envelope text-blue-600"></i>
                                <span>lan@guidetour.vn</span>
                            </div>
                            <div class="flex items-center justify-center gap-3">
                                <i class="fa-solid fa-calendar text-purple-600"></i>
                                <span>Sinh nhật: 15/03/1990</span>
                            </div>
                        </div>

                        <div class="mt-10 pt-8 border-t border-slate-200">
                            <div class="text-6xl font-black text-slate-800">4.9 <span class="text-4xl text-yellow-500">stars</span></div>
                            <p class="text-sm text-slate-600 mt-2">Đánh giá trung bình từ 127 tour</p>
                        </div>
                    </div>
                </div>

                <!-- Thông tin chi tiết -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-5 flex items-center gap-3">
                            <i class="fa-solid fa-id-card text-main"></i> Thông tin chuyên môn
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                            <div>
                                <div class="text-slate-600">Ngôn ngữ</div>
                                <div class="font-semibold text-slate-800">Tiếng Anh (IELTS 8.0), Tiếng Việt</div>
                            </div>
                            <div>
                                <div class="text-slate-600">Chứng chỉ</div>
                                <div class="font-semibold text-slate-800">HDV Quốc tế 2023 - Bộ VH-TT-DL</div>
                            </div>
                            <div>
                                <div class="text-slate-600">Kinh nghiệm</div>
                                <div class="font-semibold text-slate-800">8 năm</div>
                            </div>
                            <div>
                                <div class="text-slate-600">Sức khỏe</div>
                                <div class="font-semibold text-emerald-700">Tốt</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                        <div class="flex items-start gap-4">
                            <i class="fa-solid fa-sticky-note text-amber-600 text-2xl mt-1"></i>
                            <div>
                                <p class="font-semibold text-amber-900">Ghi chú từ quản lý</p>
                                <p class="text-amber-800 mt-1">Luôn đúng giờ, giao tiếp cực tốt với khách Âu - Mỹ. Đặc biệt được khách đánh giá cao về sự nhiệt tình và am hiểu văn hóa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab: Lịch trình đang dẫn -->
        <div id="tab-schedules" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-xl font-bold text-slate-800">Lịch trình đang đảm nhận</h3>
                </div>
                <div class="divide-y divide-slate-100">
                    <!-- Tour 1 -->
                    <div class="p-6 hover:bg-slate-50 transition flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-slate-900">
                                Booking #BK0023 <span class="text-main">• Tour Đà Lạt 4N3Đ</span>
                            </div>
                            <div class="text-sm text-slate-600 mt-1">
                                <i class="fa-solid fa-calendar"></i> 15/12/2025 → 18/12/2025 •
                                <span class="text-emerald-700 font-medium">Đang hướng dẫn</span>
                            </div>
                        </div>
                        <a href="#" class="px-5 py-2.5 bg-main text-white rounded-lg text-sm font-medium hover:bg-hover transition">
                            Xem chi tiết
                        </a>
                    </div>
                    <!-- Tour 2 -->
                    <div class="p-6 hover:bg-slate-50 transition flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-slate-900">
                                Booking #BK0041 <span class="text-main">• Tour Phú Quốc 5N4Đ</span>
                            </div>
                            <div class="text-sm text-slate-600 mt-1">
                                <i class="fa-solid fa-calendar"></i> 22/12/2025 → 26/12/2025 •
                                <span class="text-orange-700 font-medium">Chờ xác nhận</span>
                            </div>
                        </div>
                        <a href="#" class="px-5 py-2.5 bg-main text-white rounded-lg text-sm font-medium hover:bg-hover transition">
                            Xem chi tiết
                        </a>
                    </div>
                    <!-- Tour 3 -->
                    <div class="p-6 hover:bg-slate-50 transition flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-slate-900">
                                Booking #BK0059 <span class="text-main">• Tour Hà Nội - Hạ Long</span>
                            </div>
                            <div class="text-sm text-slate-600 mt-1">
                                <i class="fa-solid fa-calendar"></i> 05/01/2026 → 08/01/2026 •
                                <span class="text-purple-700 font-medium">Đã lên kế hoạch</span>
                            </div>
                        </div>
                        <a href="#" class="px-5 py-2.5 bg-main text-white rounded-lg text-sm font-medium hover:bg-hover transition">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab: Lịch sử tour đã dẫn -->
        <div id="tab-history" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center">
                <i class="fa-solid fa-history text-8xl text-slate-200 mb-6"></i>
                <p class="text-2xl font-bold text-slate-500">48 tour đã hoàn thành</p>
                <p class="text-slate-500 mt-2">Dữ liệu lịch sử sẽ được hiển thị dạng bảng hoặc timeline ở đây</p>
            </div>
        </div>

        <!-- Tab: Thống kê hiệu suất -->
        <div id="tab-stats" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center">
                    <div class="text-5xl font-black text-main">48</div>
                    <p class="text-slate-600 mt-3 text-lg">Tour đã dẫn</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center">
                    <div class="text-5xl font-black text-emerald-600">1.247</div>
                    <p class="text-slate-600 mt-3 text-lg">Khách đã phục vụ</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center">
                    <div class="text-5xl font-black text-blue-600">98.2%</div>
                    <p class="text-slate-600 mt-3 text-lg">Tỷ lệ đúng giờ</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center">
                    <div class="text-5xl font-black text-purple-600">4.9 stars</div>
                    <p class="text-slate-600 mt-3 text-lg">Đánh giá trung bình</p>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Tab switching
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.addEventListener('click', function() {
                // Xóa active cũ
                document.querySelectorAll('.tab-button').forEach(b => {
                    b.classList.remove('active');
                    b.classList.add('border-transparent', 'text-slate-600');
                });
                // Active tab mới
                this.classList.add('active');
                this.classList.remove('border-transparent', 'text-slate-600');

                // Ẩn/hiện nội dung
                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
                document.getElementById('tab-' + this.dataset.tab).classList.remove('hidden');
            });
        });
    </script>

</body>

</html>