<!-- views/Admin/diaryguide.php -->
<div class="max-w-6xl mx-auto px-4 py-6">

    <!-- Tiêu đề + mô tả -->
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-1 mb-5">
        <div>
            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                Nhật ký tour &amp; khách
            </h2>
            <p class="text-xs md:text-sm text-gray-500">
                Ghi lại tình hình tour, khách, sự cố, cảm nhận...
            </p>
        </div>
    </div>

    <!-- 2 cột: Form + danh sách -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">

        <!-- Form nhập nhật ký (trái) -->
        <section class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-5">
            <h3 class="text-sm font-bold text-gray-700 mb-4">
                Thêm nhật ký mới
            </h3>

            <form class="space-y-3 text-sm">
                <!-- Chọn tour -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-600">
                        Chọn tour
                    </label>
                    <select
                        class="w-full bg-white border border-gray-300 rounded-md px-3 py-2 text-sm
                               focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">Tất cả Tour</option>
                        <option>City Tour Hà Nội - 20/11/2025</option>
                        <option>Food Tour Phố Cổ - 20/11/2025</option>
                        <option>Tour Sapa 3N2Đ - 22/11/2025</option>
                    </select>
                </div>

                <!-- Tiêu đề nhật ký -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-600">
                        Tiêu đề nhật ký
                    </label>
                    <input
                        type="text"
                        placeholder="VD: Ngày 1 - Sapa trời đẹp, khách rất hào hứng"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm
                               focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                </div>

                <!-- Mức độ tour hôm nay -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-600">
                        Mức độ tour hôm nay
                    </label>
                    <select
                        class="w-full bg-white border border-gray-300 rounded-md px-3 py-2 text-sm
                               focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <option>Rất tốt</option>
                        <option>Tốt</option>
                        <option>Bình thường</option>
                        <option>Khó khăn</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-600">
                        Đánh giá mức hài lòng (1–5 sao)
                    </label>

                    <div class="flex flex-row-reverse justify-end">

                        <!-- 5 sao -->
                        <input type="radio" id="star5" name="rating" value="5" class="hidden peer/star5" />
                        <label for="star5"
                            class="text-gray-300 peer-checked/star5:text-yellow-400 cursor-pointer text-2xl 
                   hover:text-yellow-300 peer-hover/star5:text-yellow-300">
                            ★
                        </label>

                        <!-- 4 sao -->
                        <input type="radio" id="star4" name="rating" value="4" class="hidden peer/star4" />
                        <label for="star4"
                            class="text-gray-300 cursor-pointer text-2xl
                   peer-checked/star4:text-yellow-400 peer-checked/star5:text-yellow-400
                   hover:text-yellow-300 peer-hover/star4:text-yellow-300">
                            ★
                        </label>

                        <!-- 3 sao -->
                        <input type="radio" id="star3" name="rating" value="3" class="hidden peer/star3" />
                        <label for="star3"
                            class="text-gray-300 cursor-pointer text-2xl
                   peer-checked/star3:text-yellow-400 peer-checked/star4:text-yellow-400 peer-checked/star5:text-yellow-400
                   hover:text-yellow-300 peer-hover/star3:text-yellow-300">
                            ★
                        </label>

                        <!-- 2 sao -->
                        <input type="radio" id="star2" name="rating" value="2" class="hidden peer/star2" />
                        <label for="star2"
                            class="text-gray-300 cursor-pointer text-2xl
                   peer-checked/star2:text-yellow-400 peer-checked/star3:text-yellow-400 peer-checked/star4:text-yellow-400 peer-checked/star5:text-yellow-400
                   hover:text-yellow-300 peer-hover/star2:text-yellow-300">
                            ★
                        </label>

                        <!-- 1 sao -->
                        <input type="radio" id="star1" name="rating" value="1" class="hidden peer/star1" />
                        <label for="star1"
                            class="text-gray-300 cursor-pointer text-2xl
                   peer-checked/star1:text-yellow-400 peer-checked/star2:text-yellow-400 peer-checked/star3:text-yellow-400 peer-checked/star4:text-yellow-400 peer-checked/star5:text-yellow-400
                   hover:text-yellow-300 peer-hover/star1:text-yellow-300">
                            ★
                        </label>
                    </div>
                </div>



                <!-- Nội dung chi tiết -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-600">
                        Nội dung chi tiết
                    </label>
                    <textarea
                        rows="5"
                        placeholder="Ghi lại lịch trình thực tế, tâm trạng khách, sự cố nếu có, xử lý thế nào..."
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm resize-y
                               focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"></textarea>
                </div>

                <!-- Ghi chú riêng -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-600">
                        Ghi chú riêng (nếu có)
                    </label>
                    <textarea
                        rows="3"
                        placeholder="Ghi chú nội bộ cho điều hành (không gửi cho khách)..."
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm resize-y
                               focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"></textarea>
                </div>

                <!-- Nút -->
                <div class="flex items-center gap-2 pt-2">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-md
                               bg-orange-500 text-white text-sm font-medium hover:bg-orange-600
                               transition-colors">
                        Lưu nhật ký
                    </button>
                    <button
                        type="reset"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-md
                               border border-gray-300 text-gray-700 text-sm font-medium
                               hover:bg-gray-50 transition-colors">
                        Làm mới
                    </button>
                </div>
            </form>
        </section>

        <!-- Danh sách nhật ký (phải) -->
        <section class="lg:col-span-3 bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-5 flex flex-col">
            <div class="flex items-center justify-between gap-3 mb-3">
                <h3 class="text-sm font-semibold text-gray-700">
                    Nhật ký gần đây
                </h3>
                <select
                    class="w-44 bg-white border border-gray-300 rounded-md px-3 py-1.5 text-xs
                           focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                    <option>Tất cả tour</option>
                    <option>City Tour Hà Nội</option>
                    <option>Food Tour Phố Cổ</option>
                    <option>Tour Sapa 3N2Đ</option>
                </select>
            </div>

            <!-- List -->
            <div class="flex-1 overflow-y-auto space-y-3 text-sm">

                <article class="border-b border-gray-100 pb-3 last:border-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="font-semibold text-gray-800 text-sm">
                            City Tour Hà Nội - 19/11/2025
                        </h4>
                        <span class="text-xs text-gray-500">19/11/2025 - 18:30</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                        Khách rất hào hứng với chương trình, thời tiết đẹp, không có sự cố lớn.
                        Một khách bị say xe nhẹ, đã hỗ trợ kịp thời...
                    </p>
                    <div class="mt-1 text-xs text-green-600 font-medium">
                        Mức độ: Rất tốt
                    </div>
                </article>

                <article class="border-b border-gray-100 pb-3 last:border-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="font-semibold text-gray-800 text-sm">
                            Tour Sapa 3N2Đ - Ngày 1
                        </h4>
                        <span class="text-xs text-gray-500">15/11/2025 - 21:00</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                        Thời tiết mưa nhẹ, đường hơi trơn, đã nhắc nhở khách cẩn thận.
                        Một khách bị đau đầu, đã đưa đi khám và ổn định...
                    </p>
                    <div class="mt-1 text-xs text-yellow-600 font-medium">
                        Mức độ: Khó khăn
                    </div>
                </article>

                <article class="border-b border-gray-100 pb-3 last:border-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="font-semibold text-gray-800 text-sm">
                            Food Tour Phố Cổ - 17/11/2025
                        </h4>
                        <span class="text-xs text-gray-500">17/11/2025 - 22:15</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                        Khách thích đồ ăn đường phố, phản hồi tích cực.
                        Một khách không ăn được cay, đã đổi món phù hợp...
                    </p>
                    <div class="mt-1 text-xs text-blue-600 font-medium">
                        Mức độ: Tốt
                    </div>
                </article>
            </div>

            <!-- Phân trang -->
            <div class="flex justify-end gap-1 mt-4 text-xs">
                <button class="px-2.5 py-1 rounded border border-gray-300 text-gray-500 hover:bg-gray-50">«</button>
                <button class="px-2.5 py-1 rounded bg-orange-500 text-white font-medium">1</button>
                <button class="px-2.5 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">2</button>
                <button class="px-2.5 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">»</button>
            </div>
        </section>
    </div>
</div>