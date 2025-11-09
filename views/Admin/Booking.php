    <div class="min-h-screen flex">
        <!-- Main -->
        <main class="flex-1 p-6">
            <!-- Topbar -->
            <header class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold">Quản lý Booking</h2>
                    <p class="text-sm text-slate-500">Tạo, theo dõi và quản lý đặt chỗ cho tour</p>
                </div>
                <div class="flex items-center gap-3">
                    <button id="btnNewBooking" class="px-4 py-2 bg-indigo-600 text-white rounded shadow">Tạo booking mới</button>
                    <div class="text-sm text-slate-500">Admin</div>
                </div>
            </header>

            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-4">
                <!-- Left: tour list / quick actions -->
                <div class="col-span-1 bg-white rounded-lg p-4 border border-gray-200 shadow-sm flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-800">Danh sách Tour</h3>
                        <button class="text-xs text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1 rounded transition-colors" id="btnCreateTour">+ Tạo tour</button>
                    </div>

                    <div class="space-y-3 overflow-auto max-h-[28rem] scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        <!-- tour card -->
                        <article class="p-3 rounded-lg border hover:shadow-md transition-shadow bg-gray-50">
                            <div class="flex items-start gap-3">
                                <img src="https://placehold.co/80x60" alt="thumb" class="w-20 h-14 object-cover rounded">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-medium text-gray-800">Hành trình Hà Nội - Hạ Long (3N2Đ)</h4>
                                        <div class="text-sm text-gray-500">VN</div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Giá từ <span class="font-semibold text-gray-800">2.500.000 đ</span></p>

                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="openTourDetail(this)">Chi tiết</button>
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="cloneTour(this)">Clone</button>
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="generateQuote(this)">Báo giá nhanh</button>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="p-3 rounded-lg border hover:shadow-md transition-shadow bg-white">
                            <div class="flex items-start gap-3">
                                <img src="https://placehold.co/80x60" alt="thumb" class="w-20 h-14 object-cover rounded">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-medium text-gray-800">Tour Bali 5N4Đ - Quốc tế</h4>
                                        <div class="text-sm text-gray-500">INT</div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Giá từ <span class="font-semibold text-gray-800">7.800.000 đ</span></p>

                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="openTourDetail(this)">Chi tiết</button>
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="cloneTour(this)">Clone</button>
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="generateQuote(this)">Báo giá nhanh</button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>

                <!-- Center: tour detail & versions -->
                <div class="col-span-1 lg:col-span-2 bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                    <div id="tourDetailArea">
                        <div class="flex flex-col lg:flex-row items-start gap-4">
                            <img id="detailThumb" src="https://placehold.co/200x140" alt="thumb" class="w-full lg:w-48 h-36 object-cover rounded shadow-sm">
                            <div class="flex-1">
                                <h3 id="detailTitle" class="text-xl font-semibold text-gray-800">Chọn một tour để xem chi tiết</h3>
                                <p id="detailPrice" class="text-gray-500 mt-1">Giá cơ bản: -</p>

                                <div class="mt-3 flex flex-wrap gap-2">
                                    <button class="px-3 py-1 border border-gray-200 rounded text-sm hover:bg-gray-100 transition" onclick="showTab('info')">Thông tin</button>
                                    <button class="px-3 py-1 border border-gray-200 rounded text-sm hover:bg-gray-100 transition" onclick="showTab('versions')">Phiên bản</button>
                                    <button class="px-3 py-1 border border-gray-200 rounded text-sm hover:bg-gray-100 transition" onclick="showTab('images')">Hình ảnh</button>
                                </div>
                            </div>
                        </div>

                        <div id="tabs" class="mt-4">
                            <div id="tab-info" class="tab-pane">
                                <h4 class="font-semibold text-gray-800">Lịch trình</h4>
                                <div class="mt-2 bg-gray-50 p-3 rounded border">
                                    <ol class="list-decimal pl-4 text-sm text-gray-600">
                                        <li>Ngày 1 - Hà Nội: Đón khách, tham quan phố cổ.</li>
                                        <li>Ngày 2 - Hạ Long: Du thuyền, hang động, hải sản.</li>
                                        <li>Ngày 3 - Trở về, tiễn khách.</li>
                                    </ol>
                                </div>

                                <h4 class="mt-4 font-semibold text-gray-800">Chính sách</h4>
                                <p class="text-sm text-gray-600 mt-2">Hủy sau 7 ngày trước ngày khởi hành mất 50% phí, hủy trong 3 ngày mất 100%...</p>

                                <h4 class="mt-4 font-semibold text-gray-800">Nhà cung cấp</h4>
                                <p class="text-sm text-gray-600 mt-2">Khách sạn XYZ, Công ty vận chuyển ABC.</p>
                            </div>

                            <div id="tab-versions" class="tab-pane hidden">
                                <h4 class="font-semibold text-gray-800">Phiên bản tour</h4>
                                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="p-3 border rounded hover:shadow-md transition">
                                        <div class="flex items-center justify-between">
                                            <div class="font-medium text-gray-800">Mùa Hè (Cao điểm)</div>
                                            <div class="text-sm text-gray-500">Giá: 3.000.000 đ</div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-2">Lịch trình: Thêm hoạt động biển</div>
                                    </div>
                                    <div class="p-3 border rounded hover:shadow-md transition">
                                        <div class="flex items-center justify-between">
                                            <div class="font-medium text-gray-800">Phiên bản Khuyến mãi</div>
                                            <div class="text-sm text-gray-500">Giá: 2.200.000 đ</div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-2">Ưu đãi: Giảm 12% + bữa trưa miễn phí</div>
                                    </div>
                                </div>
                            </div>

                            <div id="tab-images" class="tab-pane hidden">
                                <h4 class="font-semibold text-gray-800">Bộ ảnh minh họa</h4>
                                <div class="mt-3 grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    <img src="https://placehold.co/200x120" class="w-full h-28 object-cover rounded">
                                    <img src="https://placehold.co/200x120" class="w-full h-28 object-cover rounded">
                                    <img src="https://placehold.co/200x120" class="w-full h-28 object-cover rounded">
                                    <img src="https://placehold.co/200x120" class="w-full h-28 object-cover rounded">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>



            <!-- Booking list -->
            <section class="mt-6 bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-2">
                    <h3 class="font-semibold text-gray-800">Danh sách Booking</h3>
                    <div class="text-sm text-gray-500">Tổng: <span id="totalBookings">3</span></div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm table-auto border-collapse">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-xs text-gray-500 border-b">
                                <th class="p-2">Mã</th>
                                <th class="p-2">Khách</th>
                                <th class="p-2">Tour</th>
                                <th class="p-2">Ngày khởi hành</th>
                                <th class="p-2">Số khách</th>
                                <th class="p-2">Trạng thái</th>
                                <th class="p-2">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="bookingTable">
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="p-2">BKG-001</td>
                                <td class="p-2">Nguyễn Văn A</td>
                                <td class="p-2">Hà Nội - Hạ Long</td>
                                <td class="p-2">2025-12-15</td>
                                <td class="p-2">4</td>
                                <td class="p-2">
                                    <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">Chờ xác nhận</span>
                                </td>
                                <td class="p-2">
                                    <div class="flex flex-wrap gap-2">
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="openEditBooking('BKG-001')">Sửa</button>
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="changeStatus('BKG-001','Đã cọc')">Đã cọc</button>
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="changeStatus('BKG-001','Hủy')">Hủy</button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="p-2">BKG-002</td>
                                <td class="p-2">Công ty XYZ</td>
                                <td class="p-2">Bali 5N4Đ</td>
                                <td class="p-2">2026-01-10</td>
                                <td class="p-2">20</td>
                                <td class="p-2">
                                    <span class="px-2 py-1 rounded text-xs bg-indigo-100 text-indigo-700">Đã cọc</span>
                                </td>
                                <td class="p-2">
                                    <div class="flex flex-wrap gap-2">
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="openEditBooking('BKG-002')">Sửa</button>
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="changeStatus('BKG-002','Hoàn tất')">Hoàn tất</button>
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="changeStatus('BKG-002','Hủy')">Hủy</button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="p-2">BKG-003</td>
                                <td class="p-2">Trần Thị B</td>
                                <td class="p-2">Hà Nội - Hạ Long</td>
                                <td class="p-2">2025-11-20</td>
                                <td class="p-2">2</td>
                                <td class="p-2">
                                    <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">Hoàn tất</span>
                                </td>
                                <td class="p-2">
                                    <div class="flex flex-wrap gap-2">
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="openEditBooking('BKG-003')">Sửa</button>
                                        <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="changeStatus('BKG-003','Hủy')">Hủy</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal: New Booking -->
    <div id="modalNewBooking" class="fixed inset-0 hidden items-center justify-center bg-black/40">
        <div class="bg-white w-11/12 max-w-2xl p-4 rounded">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold">Tạo booking mới</h3>
                <button onclick="closeModal('modalNewBooking')">✖</button>
            </div>

            <form id="formBooking" class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs">Tên khách</label>
                        <input name="customer" class="w-full p-2 border rounded text-sm" placeholder="Họ và tên" />
                    </div>
                    <div>
                        <label class="text-xs">Số điện thoại</label>
                        <input name="phone" class="w-full p-2 border rounded text-sm" placeholder="098..." />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="text-xs">Chọn tour</label>
                        <select name="tour" class="w-full p-2 border rounded text-sm">
                            <option value="HN-HL">Hà Nội - Hạ Long (3N2Đ)</option>
                            <option value="BALI">Bali 5N4Đ</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs">Ngày khởi hành</label>
                        <input type="date" name="date" class="w-full p-2 border rounded text-sm" />
                    </div>
                    <div>
                        <label class="text-xs">Số khách</label>
                        <input type="number" name="qty" class="w-full p-2 border rounded text-sm" value="1" min="1" />
                    </div>
                </div>

                <div>
                    <label class="text-xs">Yêu cầu đặc biệt</label>
                    <textarea name="note" class="w-full p-2 border rounded text-sm" rows="3"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button" class="px-4 py-2 border rounded" onclick="closeModal('modalNewBooking')">Hủy</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Lưu & Xác nhận</button>
                </div>
            </form>
        </div>
    </div>