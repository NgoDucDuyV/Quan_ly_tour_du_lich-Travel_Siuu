<!-- views/Admin/checkguide.php -->
<div class="px-4">
    <!-- Header -->
    <div class="mt-6 mb-3">
        <h2 class="text-xl font-semibold">Check khách / Điểm danh</h2>
        <p class="text-xs text-gray-500">Đánh dấu tình trạng khách trong từng tour</p>
    </div>

    <!-- Card -->
    <div class="bg-white shadow rounded-lg">
        <!-- Card header -->
        <div class="px-4 py-3 border-b border-gray-100 flex flex-col md:flex-row md:justify-between md:items-center gap-3">
            <div>
                <h6 class="text-sm font-semibold">Tour đang chọn</h6>
                <p class="text-xs text-gray-500">City Tour Hà Nội - 20/11/2025</p>
            </div>

            <div class="flex items-center gap-2">
                <select
                    class="border border-gray-300 text-sm rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option>City Tour Hà Nội - 20/11/2025</option>
                    <option>Food Tour Phố Cổ - 20/11/2025</option>
                    <option>Tour Sapa 3N2Đ - 22/11/2025</option>
                </select>

                <button
                    class="px-3 py-1.5 text-sm border border-blue-300 text-blue-600 rounded hover:bg-blue-50 transition">
                    Tải danh sách
                </button>
            </div>
        </div>

        <!-- Card body -->
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-gray-100">
                        <tr class="text-left">
                            <th class="py-2 px-3">#</th>
                            <th class="py-2 px-3">Họ tên khách</th>
                            <th class="py-2 px-3">Quốc tịch</th>
                            <th class="py-2 px-3">Ghi chú</th>
                            <th class="py-2 px-3">Check-in</th>
                            <th class="py-2 px-3">Lên xe</th>
                            <th class="py-2 px-3">Đang tham gia</th>
                            <th class="py-2 px-3 text-right">Trạng thái chung</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Row 1 -->
                        <tr class="border-t">
                            <td class="py-2 px-3">1</td>
                            <td class="py-2 px-3">Nguyễn Văn A</td>
                            <td class="py-2 px-3">Việt Nam</td>
                            <td class="py-2 px-3">Không ăn hải sản</td>
                            <td class="py-2 px-3"><input type="checkbox" checked class="w-4 h-4"></td>
                            <td class="py-2 px-3"><input type="checkbox" checked class="w-4 h-4"></td>
                            <td class="py-2 px-3"><input type="checkbox" checked class="w-4 h-4"></td>
                            <td class="py-2 px-3 text-right">
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">
                                    Đủ
                                </span>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="border-t">
                            <td class="py-2 px-3">2</td>
                            <td class="py-2 px-3">Kim Ji Soo</td>
                            <td class="py-2 px-3">Hàn Quốc</td>
                            <td class="py-2 px-3">Đến trễ 10 phút</td>
                            <td class="py-2 px-3"><input type="checkbox" checked class="w-4 h-4"></td>
                            <td class="py-2 px-3"><input type="checkbox" checked class="w-4 h-4"></td>
                            <td class="py-2 px-3"><input type="checkbox" checked class="w-4 h-4"></td>
                            <td class="py-2 px-3 text-right">
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">
                                    Đủ
                                </span>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="border-t">
                            <td class="py-2 px-3">3</td>
                            <td class="py-2 px-3">John Smith</td>
                            <td class="py-2 px-3">USA</td>
                            <td class="py-2 px-3">Đang bị say xe</td>
                            <td class="py-2 px-3"><input type="checkbox" checked class="w-4 h-4"></td>
                            <td class="py-2 px-3"><input type="checkbox" checked class="w-4 h-4"></td>
                            <td class="py-2 px-3"><input type="checkbox" class="w-4 h-4"></td>
                            <td class="py-2 px-3 text-right">
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">
                                    Kiểm tra lại
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Ghi chú + nút lưu -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mt-4 gap-3">
                <div class="text-xs text-gray-600">
                    ✔ <span class="font-semibold">Check-in:</span> Khách đến điểm tập trung<br>
                    ✔ <span class="font-semibold">Lên xe:</span> Khách đã lên xe / vào đoàn<br>
                    ✔ <span class="font-semibold">Đang tham gia:</span> Khách đang đi cùng đoàn
                </div>

                <button
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                    Lưu kết quả điểm danh
                </button>
            </div>
        </div>
    </div>
</div>