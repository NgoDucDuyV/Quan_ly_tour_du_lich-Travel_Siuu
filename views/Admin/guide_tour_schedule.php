<div class="max-w-[1900px] mx-auto p-6">

    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý Booking</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 font-medium text-slate-700">Phân hướng dẫn viên</li>
        </ul>
    </nav>

    <!-- Tiêu đề + nút quay lại -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-6">
            <h1 class="text-3xl font-bold text-slate-900">
                Phân hướng dẫn viên cho Booking: <span class="text-main">#BK-2025-1208</span>
            </h1>
            <div class="flex gap-3">
                <span class="px-5 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">Đang phân HDV</span>
                <span class="px-5 py-2 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800">Đã đặt cọc</span>
            </div>
        </div>
        <a href="?mode=admin&act=bookinglist" class="flex items-center gap-2 px-6 py-3 border border-slate-300 rounded-xl hover:bg-light hover:text-hover transition text-main text-sm font-medium">
            ← Danh sách booking
        </a>
    </div>

    <!-- 3 card thông tin -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-5">Thông tin khách hàng</h3>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between"><span class="text-slate-600">Họ tên</span><span class="font-semibold">Nguyễn Văn An</span></div>
                <div class="flex justify-between"><span class="text-slate-600">Điện thoại</span><span class="font-medium">0908 901 234 567</span></div>
                <div class="flex justify-between"><span class="text-slate-600">Email</span><span class="text-slate-700">an@gmail.com</span></div>
                <div class="flex justify-between items-center"><span class="text-slate-600">Loại khách</span><span class="px-4 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">Khách lẻ</span></div>
                <div class="flex justify-between pt-3 border-t"><span class="text-slate-600">Số khách</span><span class="text-2xl font-bold text-main">15 khách</span></div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-5">Thông tin tour</h3>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between"><span class="text-slate-600">Tên tour</span><span class="font-semibold">Đà Lạt – Thác Datanla – Crazy House 4N3Đ</span></div>
                <div class="flex justify-between"><span class="text-slate-600">Ngày đi → về</span><span class="font-bold text-main">15/12/2025 → 18/12/2025</span></div>
                <div class="flex justify-between"><span class="text-slate-600">Số ngày</span><span>4 ngày 3 đêm</span></div>
                <div class="flex justify-between"><span class="text-slate-600">Điểm đón</span><span>Sân bay Tân Sơn Nhất</span></div>
                <div class="flex justify-between"><span class="text-slate-600">Ngôn ngữ yêu cầu</span><span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-bold">Tiếng Anh + Tiếng Việt</span></div>
            </div>
        </div>

        <div class="bg-main text-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold mb-6">Tình trạng phân HDV</h3>
            <div class="text-5xl font-black mb-2">7 ngày</div>
            <p class="opacity-90 mb-8">Đến ngày khởi hành tour</p>
            <div class="pt-6 border-t border-white/30">
                <p class="opacity-90 mb-2">Hướng dẫn viên hiện tại</p>
                <p class="text-2xl font-bold">Chưa phân công</p>
            </div>
        </div>
    </div>

    <!-- Tìm kiếm + lọc -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Tìm tên, số điện thoại, email hướng dẫn viên..."
                    class="w-full pl-12 pr-6 py-4 rounded-lg border border-slate-300 focus:outline-none focus:ring-4 focus:ring-main/20 focus:border-main text-lg">
            </div>
            <div class="flex gap-4">
                <select class="w-48 px-5 py-4 rounded-lg border border-slate-300">
                    <option>Tất cả ngôn ngữ</option>
                    <option>Tiếng Anh</option>
                    <option>Tiếng Pháp</option>
                    <option>Tiếng Trung</option>
                    <option>Tiếng Nhật</option>
                    <option>Tiếng Hàn</option>
                </select>
                <select class="w-48 px-5 py-4 rounded-lg border border-slate-300">
                    <option>Kinh nghiệm</option>
                    <option>≥ 3 năm</option>
                    <option>≥ 5 năm</option>
                    <option>≥ 10 năm</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Danh sách HDV -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">

        <!-- HDV Rảnh -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden hover:shadow-2xl hover:border-main transition">
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-40 relative">
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="absolute top-4 right-4 bg-emerald-700 text-white px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2">
                    RẢNH – CÓ THỂ CHỌN
                </div>
                <div class="absolute bottom-6 left-6 text-white">
                    <h3 class="text-2xl font-bold">Trần Thị Lan</h3>
                    <p class="text-sm opacity-90">Mã HDV: <strong>GV001</strong> • 8 năm kinh nghiệm</p>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <img src="https://i.pravatar.cc/100?img=1" class="w-20 h-20 rounded-full ring-4 ring-white shadow-lg">
                    <div>
                        <p class="text-3xl font-black text-slate-800">4.9 <span class="text-yellow-500">★★★★★</span></p>
                        <p class="text-sm text-slate-600">127 tour • 632 khách</p>
                    </div>
                </div>
                <div class="space-y-3 text-sm">
                    <p>0901 234 567</p>
                    <p>lan@guidetour.vn</p>
                    <p>Tiếng Anh (IELTS 8.0), Tiếng Việt</p>
                    <p>Chứng chỉ HDV Quốc tế 2023</p>
                </div>
                <button class="mt-8 w-full py-4 bg-main hover:bg-hover text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition flex items-center justify-center gap-3">
                    CHỌN HƯỚNG DẪN VIÊN NÀY
                </button>
            </div>
        </div>

        <!-- HDV Bận -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden opacity-85">
            <div class="bg-gradient-to-r from-red-500 to-pink-600 h-40 relative">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="absolute top-4 right-4 bg-red-700 text-white px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2">
                    ĐÃ CÓ TOUR
                </div>
                <div class="absolute bottom-6 left-6 text-white">
                    <h3 class="text-2xl font-bold">Lê Văn Hùng</h3>
                    <p class="text-sm opacity-90">Mã HDV: <strong>GV002</strong> • 12 năm kinh nghiệm</p>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <img src="https://i.pravatar.cc/100?img=2" class="w-20 h-20 rounded-full ring-4 ring-white shadow-lg">
                    <div>
                        <p class="text-3xl font-black text-slate-800">4.8 <span class="text-yellow-500">★★★★★</span></p>
                        <p class="text-sm text-slate-600">289 tour • 1.245 khách</p>
                    </div>
                </div>
                <div class="space-y-3 text-sm">
                    <p>0902 345 678</p>
                    <p>Tiếng Pháp (DELF B2), Tiếng Việt</p>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="font-bold text-red-700">Trùng lịch: 14 → 19/12/2025</p>
                        <p class="text-xs mt-2 bg-red-100 text-red-700 px-3 py-1.5 rounded-full inline-block">
                            Booking #BK-2025-1199 – Nha Trang 6N5Đ
                        </p>
                    </div>
                </div>
                <button disabled class="mt-8 w-full py-4 bg-gray-300 text-gray-600 font-bold text-lg rounded-xl cursor-not-allowed">
                    KHÔNG THỂ CHỌN (ĐÃ CÓ TOUR)
                </button>
            </div>
        </div>

        <!-- Thêm các HDV khác ở đây -->

    </div>

    <!-- Không tìm thấy -->
    <div class="text-center py-20 hidden">
        <p class="text-8xl text-slate-200 mb-6"></p>
        <p class="text-2xl font-bold text-slate-400">Không tìm thấy hướng dẫn viên phù hợp</p>
        <p class="text-slate-500 mt-2">Thử thay đổi bộ lọc hoặc liên hệ quản lý để thêm HDV mới</p>
    </div>

    <!-- Modal xác nhận phân HDV (hiện ngay khi bấm chọn) -->
    <div id="confirmAssignModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-70 px-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden animate-in fade-in zoom-in duration-300">

            <!-- Header xanh lá -->
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-user-check text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Xác nhận phân công</h2>
                            <p class="opacity-90">Hướng dẫn viên sẽ nhận thông báo ngay</p>
                        </div>
                    </div>
                    <button onclick="closeModal()" class="text-white hover:text-gray-200 text-3xl">×</button>
                </div>
            </div>

            <!-- Nội dung -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Bên trái: Thông tin HDV được chọn -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-id-badge text-main"></i> Hướng dẫn viên được chọn
                        </h3>
                        <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl p-5 border border-emerald-200">
                            <div class="flex items-center gap-4 mb-4">
                                <img src="https://i.pravatar.cc/100?img=1" class="w-20 h-20 rounded-full ring-4 ring-white shadow-lg">
                                <div>
                                    <p class="text-xl font-bold text-slate-800">Trần Thị Lan</p>
                                    <p class="text-sm text-slate-600">Mã HDV: <strong>GV001</strong></p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm">
                                <p><i class="fa-solid fa-phone text-green-600"></i> 0901 234 567</p>
                                <p><i class="fa-solid fa-envelope text-blue-600"></i> lan@guidetour.vn</p>
                                <p><i class="fa-solid fa-globe text-purple-600"></i> Tiếng Anh (IELTS 8.0), Tiếng Việt</p>
                                <p><i class="fa-solid fa-star text-yellow-500"></i> 4.9 ★★★★★ (127 tour)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bên phải: Thông tin Booking -->
                    <div>
                        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-clipboard-list text-main"></i> Thông tin Booking
                        </h3>
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-5 border border-indigo-200">
                            <p class="text-lg font-bold text-slate-800 mb-3">#BK-2025-1208</p>
                            <div class="space-y-2 text-sm">
                                <p><strong>Tour:</strong> Đà Lạt – Thác Datanla – Crazy House 4N3Đ</p>
                                <p><strong>Thời gian:</strong> <span class="text-main font-bold">15/12 → 18/12/2025</span></p>
                                <p><strong>Số khách:</strong> 15 người lớn + 3 trẻ em</p>
                                <p><strong>Điểm đón:</strong> Sân bay Tân Sơn Nhất</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkbox tùy chọn gửi thông báo -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-8">
                    <label class="flex items-center gap-4 cursor-pointer">
                        <input type="checkbox" checked class="w-6 h-6 text-main rounded focus:ring-main">
                        <span class="text-slate-700 font-medium">
                            Gửi thông báo ngay cho hướng dẫn viên qua Zalo + Email
                        </span>
                    </label>
                </div>

                <!-- Nút hành động -->
                <div class="flex justify-end gap-4">
                    <button onclick="closeModal()" class="px-8 py-4 border border-slate-300 rounded-xl hover:bg-slate-50 font-medium transition">
                        Hủy bỏ
                    </button>
                    <form method="POST" class="inline">
                        <input type="hidden" name="guide_id" value="1">
                        <input type="hidden" name="booking_id" value="1208">
                        <button type="submit" name="confirm_assign_guide"
                            class="px-10 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition flex items-center gap-3">
                            <i class="fa-solid fa-check-double"></i>
                            XÁC NHẬN PHÂN CÔNG NGAY
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Đóng modal khi bấm nút X hoặc nền đen
        function closeModal() {
            document.getElementById('confirmAssignModal').remove();
        }
        // Đóng khi bấm ngoài
        document.getElementById('confirmAssignModal').addEventListener('click', function(e) {
            if (e.target === this) this.remove();
        });
    </script>

</div>