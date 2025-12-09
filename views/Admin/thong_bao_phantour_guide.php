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