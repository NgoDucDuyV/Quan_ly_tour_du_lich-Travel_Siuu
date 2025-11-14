    <div class="min-h-screen flex">
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
    <script>
        // Simple UI interactions (demo purposes)
        function openTourDetail(btn) {
            // find the closest article and extract data (demo static)
            const article = btn.closest('article');
            document.getElementById('detailTitle').innerText = article.querySelector('h4').innerText;
            document.getElementById('detailPrice').innerText = 'Giá cơ bản: ' + (article.querySelector('.font-semibold')?.innerText || '-');
            document.getElementById('detailThumb').src = article.querySelector('img').src.replace('80x60', '400x300');
            showTab('info');
        }

        function cloneTour(btn) {
            alert('Clone tour: chức năng demo — sẽ sao chép tour để tạo tour mới (thực hiện ở backend).');
        }

        function generateQuote(btn) {
            alert('Báo giá nhanh: mở form chọn số khách và xuất PDF/Email (demo).');
        }

        function showTab(name) {
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));
            document.getElementById('tab-' + name).classList.remove('hidden');
        }

        document.getElementById('btnNewBooking').addEventListener('click', () => {
            document.getElementById('modalNewBooking').classList.remove('hidden');
            document.getElementById('modalNewBooking').classList.add('flex');
        });

        function closeModal(id) {
            const el = document.getElementById(id);
            el.classList.add('hidden');
            el.classList.remove('flex');
        }

        document.getElementById('formBooking').addEventListener('submit', function(e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(this).entries());
            // simple insert to table (demo only)
            const tbody = document.getElementById('bookingTable');
            const newId = 'BKG-' + String(Math.floor(Math.random() * 900 + 100));
            const tr = document.createElement('tr');
            tr.className = 'border-b hover:bg-slate-50';
            tr.innerHTML = `\n        <td class="p-2">${newId}</td>\n        <td class="p-2">${data.customer}</td>\n        <td class="p-2">${data.tour}</td>\n        <td class="p-2">${data.date}</td>\n        <td class="p-2">${data.qty}</td>\n        <td class="p-2"><span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">Chờ xác nhận</span></td>\n        <td class="p-2"><div class="flex gap-2">\n          <button class="text-xs px-2 py-1 border rounded" onclick="openEditBooking('${newId}')">Sửa</button>\n          <button class="text-xs px-2 py-1 border rounded" onclick="changeStatus('${newId}','Đã cọc')">Đã cọc</button>\n        </div></td>\n      `;
            tbody.prepend(tr);
            // update total
            document.getElementById('totalBookings').innerText = parseInt(document.getElementById('totalBookings').innerText) + 1;
            closeModal('modalNewBooking');
            alert('Booking được tạo (demo). Bạn có thể xuất báo giá hoặc gửi email ở bước tiếp theo.');
        });

        function openEditBooking(id) {
            alert('Mở form chỉnh sửa cho ' + id + ' (demo).');
        }

        function changeStatus(id, status) {
            alert('Thay đổi trạng thái ' + id + ' -> ' + status + ' (demo).');
        }
    </script>