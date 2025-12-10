<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết lịch trình – Booking #BK0023</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body class="bg-gray-50 text-slate-800">

    <div class="max-w-[1900px] mx-auto p-6">

        <!-- Breadcrumb -->
        <nav class="text-sm text-slate-500 mb-4">
            <ul class="inline-flex items-center space-x-2">
                <li>Quản trị viên</li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý Booking</li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300"><a href="#" class="hover:text-slate-700">#BK0023</a></li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300 font-medium text-slate-700">Chi tiết lịch trình</li>
            </ul>
        </nav>

        <!-- Tiêu đề + nút quay lại -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-6">
                <h1 class="text-3xl font-bold text-slate-900">
                    Lịch trình Booking: <span class="text-main">#BK0023</span>
                </h1>
                <div class="flex gap-3">
                    <span class="px-5 py-2 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">Đã phân HDV</span>
                    <span class="px-5 py-2 rounded-full text-sm font-bold bg-orange-100 text-orange-800 border border-orange-300">Đang diễn ra</span>
                </div>
            </div>
            <a href="javascript:history.back()" class="flex items-center gap-2 px-6 py-3 border border-slate-300 rounded-xl hover:bg-slate-100 transition text-main text-sm font-medium">
                Quay lại
            </a>
        </div>

        <!-- 3 card chính -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Card 1: Thông tin tour -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-5">Thông tin tour</h3>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between"><span class="text-slate-600">Tên tour</span><span class="font-semibold">Đà Lạt – Thác Datanla – Crazy House</span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Mã tour</span><span class="font-mono text-main">DL-2025-001</span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Thời gian</span><span class="font-bold text-main">15/12/2025 → 18/12/2025</span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Thời lượng</span><span>4 ngày 3 đêm</span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Số khách</span><span class="font-bold text-main">17 khách</span></div>
                </div>
            </div>

            <!-- Card 2: Hướng dẫn viên (gradient giống card “Tình trạng phân HDV”) -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold mb-6">Hướng dẫn viên phụ trách</h3>
                <div class="flex items-center gap-5 mb-6">
                    <img src="https://i.pravatar.cc/400?img=1" class="w-24 h-24 rounded-full ring-4 ring-white/30 shadow-xl object-cover">
                    <div>
                        <div class="text-2xl font-bold">Trần Thị Lan</div>
                        <div class="text-sm opacity-90">HDV #001 • 8 năm kinh nghiệm</div>
                    </div>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-3"><i class="fa-solid fa-phone"></i> 0901 234 567</div>
                    <div class="flex items-center gap-3"><i class="fa-solid fa-globe"></i> Tiếng Anh (IELTS 8.0), Tiếng Việt</div>
                    <div class="flex items-center gap-3"><i class="fa-solid fa-star text-yellow-400"></i> 4.9 stars (127 tour)</div>
                </div>
                <div class="mt-6 pt-5 border-t border-white/30">
                    <span class="inline-block px-5 py-2 bg-emerald-600 rounded-full text-sm font-bold">Đã xác nhận tham gia</span>
                </div>
            </div>

            <!-- Card 3: Khách hàng -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-5">Khách hàng đặt tour</h3>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between"><span class="text-slate-600">Họ tên</span><span class="font-semibold">Mr. John Smith</span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Điện thoại</span><span>+44 7911 123456</span></div>
                    <div class="flex justify-between"><span class="text-slate-600">Email</span><span>john.smith@travel.uk</span></div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Loại khách</span>
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-300">Khách đoàn Âu</span>
                    </div>
                    <div class="pt-3 border-t text-xs italic text-slate-500">
                        Yêu cầu: HDV nói tiếng Anh lưu loát, thích chụp ảnh, không ăn cay
                    </div>
                </div>
            </div>
        </div>

        <!-- Chi tiết lịch trình từng ngày -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            <div class="p-6 border-b border-slate-200 bg-slate-50">
                <h3 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                    <i class="fa-solid fa-route text-main"></i>
                    Chi tiết lịch trình từng ngày
                </h3>
            </div>
            <div class="divide-y divide-slate-100">
                <!-- Ngày 1 -->
                <div class="p-6 hover:bg-slate-50 transition">
                    <div class="flex items-start gap-6">
                        <div class="text-center min-w-[80px]">
                            <div class="text-3xl font-black text-main">15</div>
                            <div class="text-sm font-medium text-slate-600">Th12 2025</div>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-lg text-slate-900 mb-3">Ngày 1: TP.HCM → Đà Lạt</div>
                            <div class="space-y-3 text-sm text-slate-700">
                                <div class="flex items-center gap-3"><i class="fa-solid fa-plane-departure text-blue-600"></i> <strong>08:00</strong> – Bay VJ123 từ Tân Sơn Nhất</div>
                                <div class="flex items-center gap-3"><i class="fa-solid fa-location-dot text-emerald-600"></i> Đón tại sân bay Liên Khương</div>
                                <div class="flex items-center gap-3"><i class="fa-solid fa-van-shuttle text-purple-600"></i> Xe 16 chỗ đưa về trung tâm</div>
                                <div class="flex items-center gap-3"><i class="fa-solid fa-hotel text-orange-600"></i> Nhận phòng Khách sạn TTC Đà Lạt 4*</div>
                                <div class="flex items-center gap-3"><i class="fa-solid fa-utensils text-pink-600"></i> Ăn trưa nhà hàng Hoa Dalat</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ngày 2 -->
                <div class="p-6 hover:bg-slate-50 transition">
                    <div class="flex items-start gap-6">
                        <div class="text-center min-w-[80px]">
                            <div class="text-3xl font-black text-main">16</div>
                            <div class="text-sm font-medium text-slate-600">Th12 2025</div>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-lg text-slate-900 mb-3">Ngày 2: Khám phá Đà Lạt</div>
                            <div class="space-y-3 text-sm text-slate-700">
                                <div class="flex items-center gap-3"><i class="fa-solid fa-water text-cyan-600"></i> Thác Datanla – Trò chơi máng trượt</div>
                                <div class="flex items-center gap-3"><i class="fa-solid fa-church text-purple-600"></i> Nhà thờ Domaine de Marie</div>
                                <div class="flex items-center gap-3"><i class="fa-solid fa-cube text-indigo-600"></i> Crazy House</div>
                                <div class="flex items-center gap-3"><i class="fa-solid fa-mug-saucer text-amber-600"></i> Cà phê view đồi thông (đã đặt chỗ)</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ngày 3‑4 -->
                <div class="p-6 hover:bg-slate-50 transition">
                    <div class="flex items-start gap-6">
                        <div class="text-center min-w-[80px]">
                            <div class="text-3xl font-black text-main">17‑18</div>
                            <div class="text-sm font-medium text-slate-600">Th12 2025</div>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-lg text-slate-900 mb-3">Ngày 3‑4: Chợ đêm & Về lại TP.HCM</div>
                            <div class="text-sm text-slate-700">
                                Tham quan chợ đêm Đà Lạt • Mua sắm đặc sản • Tự do khám phá • Trả phòng • Xe đưa ra sân bay • Bay về lúc <strong>14:30</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ghi chú HDV & Quản lý (giống modal) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-amber-200 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-user-tie text-amber-700 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-amber-900 mb-2">Ghi chú từ HDV – Trần Thị Lan</h3>
                        <p class="text-amber-800 text-sm leading-relaxed">
                            Đã chuẩn bị tài liệu tiếng Anh, slide giới thiệu Đà Lạt. Khách đoàn rất thích chụp ảnh, sẽ ưu tiên các điểm view đẹp. Đã đặt thêm cà phê view đồi thông như yêu cầu.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-user-gear text-blue-700 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-900 mb-2">Ghi chú từ Quản lý</h3>
                        <p class="text-blue-800 text-sm leading-relaxed">
                            HDV Lan rất phù hợp với đoàn này. Đã gửi file lịch trình + danh sách khách. Theo dõi sát tình hình thời tiết Đà Lạt.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>