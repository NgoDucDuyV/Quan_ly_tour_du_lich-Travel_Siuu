<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Booking Tour Đa Bước</title>
    <!-- Tải Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Thiết lập font Inter */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f9;
        }

        .step-content {
            transition: all 0.3s ease-in-out;
        }
    </style>
    <script>
        // Cấu hình Tailwind cho màu sắc tùy chỉnh
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'main': '#3b82f6',
                        /* blue-500 */
                        'hover': '#2563eb',
                        /* blue-600 */
                        'success': '#10b981',
                        /* emerald-500 */
                        'warning': '#f59e0b',
                        /* amber-500 */
                    },
                }
            }
        }
    </script>
</head>

<body>

    <div id="app" class="max-w-[1800px] mx-auto  p-6 md:p-10">
        <!-- Breadcrumb -->
        <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
            <ul class="inline-flex items-center space-x-2">
                <li>Quản trị viên</li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300">Đối Tác Nhà cung cấp</li>
                <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-500">Tạo Booking</li>
            </ul>
        </nav>
        <!-- Step Indicator -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-[#0f2b57]">
                Bước <span id="step-display">1</span>/3: <span id="step-title">Lựa chọn Tour & Thông tin cơ bản</span>
            </h3>
            <div class="w-full h-3 mt-2 bg-[#a8c4f0] rounded-full">
                <div id="progress-bar" class="h-3 rounded-full transition-all duration-500" style="background: linear-gradient(to right, #1f55ad, #5288e0); width: 33%;"></div>
            </div>
        </div>

        <!-- Thông báo -->
        <div id="message-container" class="mb-4 hidden p-3 rounded-lg text-white font-medium bg-[#37d4d9]"></div>

        <!-- Form -->
        <form id="multi-step-booking-form" onsubmit="event.preventDefault(); handleFormSubmit();" class="space-y-10">

            <input type="hidden" name="booking_id" id="booking-id-input" value="">

            <!-- STEP 1 -->
            <div id="step-1-content" class="step-content">
                <div class="p-6 rounded-2xl border border-[#5288e0] shadow-md space-y-6 bg-[#ffffff]">
                    <h4 class="text-xl font-bold text-[#1f55ad]">1. Thông Tin Tour & Liên Hệ</h4>

                    <div class="space-y-4">
                        <div>
                            <label for="tour_id" class="block text-sm font-medium text-[#0f2b57] mb-1">
                                Chọn Tour Gốc <span class="text-[#37d4d9]">*</span>
                            </label>
                            <select id="tour_id" name="tour_id" required class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-[#1f55ad] focus:border-[#1f55ad] transition">
                                <option value="">-- Chọn Tour --</option>
                                <option value="1">Tour Hà Nội - Sapa 4N3Đ (Trong nước)</option>
                                <option value="2">Tour Thái Lan: Bangkok - Pattaya 5N4Đ (Quốc tế)</option>
                                <option value="3">Tour CEO Team Building 3 Ngày (Theo yêu cầu)</option>
                            </select>
                        </div>

                        <div>
                            <label for="tour_version_id" class="block text-sm font-medium text-[#0f2b57] mb-1">
                                Chọn Phiên bản Tour/Ngày khởi hành <span class="text-[#37d4d9]">*</span>
                            </label>
                            <select id="tour_version_id" name="tour_version_id" required class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-[#1f55ad] focus:border-[#1f55ad] transition">
                                <option value="">-- Chọn Phiên bản (Ngày/Giá) --</option>
                                <option value="101" data-price="8500000">01/12/2025 - 8.500.000 VND</option>
                                <option value="102" data-price="9000000">15/12/2025 - 9.000.000 VND (Mùa cao điểm)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-[#0f2b57] mb-1">
                                    Tên Khách hàng <span class="text-[#37d4d9]">*</span>
                                </label>
                                <input type="text" id="customer_name" name="customer_name" required class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-[#1f55ad] focus:border-[#1f55ad] transition">
                            </div>
                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-[#0f2b57] mb-1">
                                    Số điện thoại <span class="text-[#37d4d9]">*</span>
                                </label>
                                <input type="tel" id="customer_phone" name="customer_phone" required class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-[#1f55ad] focus:border-[#1f55ad] transition">
                            </div>
                        </div>

                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-[#0f2b57] mb-1">
                                Email Khách hàng <span class="text-[#37d4d9]">*</span>
                            </label>
                            <input type="email" id="customer_email" name="customer_email" required class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-[#1f55ad] focus:border-[#1f55ad] transition">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" onclick="handleStep1Submit()" class="px-8 py-3 bg-[#1f55ad] text-white font-semibold rounded-2xl shadow-lg hover:bg-[#0f2b90] transition">
                            Tiếp theo (Bước 2)
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div id="step-2-content" class="step-content hidden">
                <div class="p-6 rounded-2xl border border-[#5288e0] shadow-md space-y-6 bg-[#ffffff]">
                    <h4 class="text-xl font-bold text-[#1f55ad]">2. Số Lượng & Trạng Thái</h4>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <label for="number_of_people" class="block text-sm font-medium text-[#0f2b57] mb-1">Số lượng khách <span class="text-[#37d4d9]">*</span></label>
                            <input type="number" id="number_of_people" name="number_of_people" min="1" required class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-[#1f55ad] focus:border-[#1f55ad] transition">
                        </div>
                        <div>
                            <label for="group_type" class="block text-sm font-medium text-[#0f2b57] mb-1">Loại nhóm <span class="text-[#37d4d9]">*</span></label>
                            <select id="group_type" name="group_type" required class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-[#1f55ad] focus:border-[#1f55ad] transition">
                                <option value="le">Khách lẻ</option>
                                <option value="doan">Khách đoàn</option>
                            </select>
                        </div>
                        <div>
                            <label for="initial_status" class="block text-sm font-medium text-[#0f2b57] mb-1">Trạng thái Khởi tạo <span class="text-[#37d4d9]">*</span></label>
                            <select id="initial_status" name="initial_status" required class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-[#1f55ad] focus:border-[#1f55ad] transition">
                                <option value="cho_xac_nhan" selected>Chờ xác nhận</option>
                                <option value="da_coc">Đã cọc</option>
                                <option value="hoan_tat">Hoàn tất</option>
                                <option value="huy">Hủy</option>
                            </select>
                        </div>
                    </div>

                    <div id="total-price-display" class="bg-[#a8c4f0] p-4 rounded-xl text-[#0f2b57] font-bold hidden">
                        Tổng Giá Tạm Tính: <span id="calculated-price" class="text-[#1f55ad]">0 VND</span>
                    </div>

                    <div>
                        <label for="note" class="block text-sm font-medium text-[#0f2b57] mb-1">Ghi chú / Yêu cầu đặc biệt</label>
                        <textarea id="note" name="note" rows="3" placeholder="Ví dụ: Yêu cầu phòng đôi, ăn chay, khách VIP..." class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-[#1f55ad] focus:border-[#1f55ad] transition"></textarea>
                    </div>

                    <div class="flex justify-between">
                        <button type="button" onclick="handleStep2Submit('prev')" class="px-6 py-3 bg-[#5288e0] text-white rounded-2xl hover:bg-[#0f2b90] transition">Quay lại</button>
                        <button type="button" onclick="handleStep2Submit('next')" class="px-8 py-3 bg-[#1f55ad] text-white rounded-2xl shadow-lg hover:bg-[#0f2b90] transition">Tiếp theo</button>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div id="step-3-content" class="step-content hidden">
                <div class="p-6 rounded-2xl border border-[#37d4d9] shadow-md space-y-6 bg-[#ffffff]">
                    <h4 class="text-xl font-bold text-[#1f55ad]">3. Thông tin bổ sung & Hoàn tất</h4>
                    <div id="dynamic-step-3-content" class="p-4 rounded-xl border border-[#a8c4f0] bg-[#f9faff] text-[#0f2b57]"></div>

                    <div class="flex justify-between">
                        <button type="button" onclick="handleStep3Submit('prev')" class="px-6 py-3 bg-[#5288e0] text-white rounded-2xl hover:bg-[#0f2b90] transition">Quay lại</button>
                        <button type="button" onclick="handleStep3Submit('finish')" class="px-8 py-3 bg-[#37d4d9] text-white rounded-2xl shadow-lg hover:bg-[#0fa2a5] transition">HOÀN TẤT</button>
                    </div>
                </div>
            </div>

        </form>

        <!-- SUCCESS VIEW -->
        <div id="success-view" class="hidden text-center p-10 bg-[#37d4d9]/10 border border-[#37d4d9] rounded-2xl">
            <svg class="mx-auto h-12 w-12 text-[#37d4d9]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h2 class="text-3xl font-bold text-[#0f2b57] mt-4">Tạo Booking Thành Công!</h2>
            <p class="mt-2 text-[#0f2b57]">Booking <span id="final-booking-id" class="font-bold"></span> đã được lưu và chuyển trạng thái sang <span id="final-status" class="font-bold"></span>.</p>
            <p class="mt-4 text-sm text-[#0f2b57]/70">Dữ liệu Booking tạm thời được lưu trong phiên làm việc.</p>
            <button onclick="window.location.reload();" class="mt-6 px-8 py-3 bg-[#1f55ad] text-white rounded-2xl shadow-lg hover:bg-[#0f2b90] transition">Tạo Booking Mới</button>
        </div>
    </div>
    <script src="<?= BASE_URL . "assets/Js/admin/admin_booking.js" ?>"></script>
</body>

</html>