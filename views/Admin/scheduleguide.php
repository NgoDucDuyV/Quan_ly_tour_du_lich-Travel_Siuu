<!-- Lịch trình & Tour -->
<div class="px-4">
    <div
        class="flex flex-col md:flex-row md:items-center md:justify-between mt-6 mb-4 gap-3">
        <h2 class="text-xl font-semibold text-dark">Lịch trình &amp; Tour</h2>
        <div class="flex items-center gap-2">
            <input
                type="date"
                class="w-44 border border-light rounded text-sm px-2 py-1 focus:outline-none focus:ring-1 focus:ring-main focus:border-main" />
            <button
                class="text-sm px-3 py-1.5 rounded bg-main text-white hover:bg-hover transition">
                Lọc
            </button>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg border border-light/40">
        <div class="p-4">
            <!-- Bộ lọc -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="text-sm text-dark block mb-1">Tìm theo tên tour</label>
                    <input
                        type="text"
                        placeholder="Nhập tên tour..."
                        class="w-full border border-light rounded text-sm px-2 py-1 focus:outline-none focus:ring-1 focus:ring-main focus:border-main" />
                </div>

                <div>
                    <label class="text-sm text-dark block mb-1">Loại tour</label>
                    <select
                        class="w-full border border-light rounded text-sm px-2 py-1 focus:outline-none focus:ring-1 focus:ring-main focus:border-main">
                        <option value="">Tất cả</option>
                        <option>Tour trong nước</option>
                        <option>Tour quốc tế</option>
                        <option>Tour theo yêu cầu</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-dark block mb-1">Trạng thái</label>
                    <select
                        class="w-full border border-light rounded text-sm px-2 py-1 focus:outline-none focus:ring-1 focus:ring-main focus:border-main">
                        <option value="">Tất cả</option>
                        <option>Chưa bắt đầu</option>
                        <option>Đang diễn ra</option>
                        <option>Đã kết thúc</option>
                    </select>
                </div>
            </div>

            <!-- Bảng -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-light/30">
                        <tr class="text-left text-dark">
                            <th class="py-2 px-3">#</th>
                            <th class="py-2 px-3">Tên tour</th>
                            <th class="py-2 px-3">Ngày</th>
                            <th class="py-2 px-3">Giờ</th>
                            <th class="py-2 px-3">Điểm đến chính</th>
                            <th class="py-2 px-3">Số khách</th>
                            <th class="py-2 px-3">Trạng thái</th>
                            <th class="py-2 px-3 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t border-light/60">
                            <td class="py-2 px-3">1</td>
                            <td class="py-2 px-3">City Tour Hà Nội</td>
                            <td class="py-2 px-3">20/11/2025</td>
                            <td class="py-2 px-3">07:30 - 16:30</td>
                            <td class="py-2 px-3">Lăng Bác, Văn Miếu</td>
                            <td class="py-2 px-3">18</td>
                            <td class="py-2 px-3">
                                <span
                                    class="inline-block bg-thea/10 text-thea text-xs px-2 py-1 rounded">
                                    Đang diễn ra
                                </span>
                            </td>
                            <td class="py-2 px-3 text-right space-x-2">
                                <button
                                    class="px-2 py-1 border border-main/40 text-main text-xs rounded hover:bg-main hover:text-white transition">
                                    Chi tiết
                                </button>
                                <button
                                    class="px-2 py-1 border border-light text-xs rounded hover:bg-light/40 transition text-dark">
                                    Xem khách
                                </button>
                            </td>
                        </tr>

                        <tr class="border-t border-light/60">
                            <td class="py-2 px-3">2</td>
                            <td class="py-2 px-3">Food Tour Phố Cổ</td>
                            <td class="py-2 px-3">20/11/2025</td>
                            <td class="py-2 px-3">18:00 - 22:00</td>
                            <td class="py-2 px-3">Phố cổ Hà Nội</td>
                            <td class="py-2 px-3">12</td>
                            <td class="py-2 px-3">
                                <span
                                    class="inline-block bg-accent/10 text-accent text-xs px-2 py-1 rounded">
                                    Chuẩn bị
                                </span>
                            </td>
                            <td class="py-2 px-3 text-right space-x-2">
                                <button
                                    class="px-2 py-1 border border-main/40 text-main text-xs rounded hover:bg-main hover:text-white transition">
                                    Chi tiết
                                </button>
                                <button
                                    class="px-2 py-1 border border-light text-xs rounded hover:bg-light/40 transition text-dark">
                                    Xem khách
                                </button>
                            </td>
                        </tr>

                        <tr class="border-t border-light/60">
                            <td class="py-2 px-3">3</td>
                            <td class="py-2 px-3">Tour Sapa 3N2Đ</td>
                            <td class="py-2 px-3">22/11/2025</td>
                            <td class="py-2 px-3">05:00</td>
                            <td class="py-2 px-3">Sapa, Fansipan</td>
                            <td class="py-2 px-3">25</td>
                            <td class="py-2 px-3">
                                <span
                                    class="inline-block bg-gray-200 text-dark text-xs px-2 py-1 rounded">
                                    Chưa bắt đầu
                                </span>
                            </td>
                            <td class="py-2 px-3 text-right space-x-2">
                                <button
                                    class="px-2 py-1 border border-main/40 text-main text-xs rounded hover:bg-main hover:text-white transition">
                                    Chi tiết
                                </button>
                                <button
                                    class="px-2 py-1 border border-light text-xs rounded hover:bg-light/40 transition text-dark">
                                    Xem khách
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div class="flex justify-end mt-4">
                <ul class="flex items-center space-x-1 text-sm">
                    <li>
                        <a
                            class="px-2 py-1 border rounded text-gray-400 cursor-not-allowed">«</a>
                    </li>
                    <li>
                        <a
                            class="px-3 py-1 border rounded bg-main text-white hover:bg-hover transition">1</a>
                    </li>
                    <li>
                        <a
                            class="px-3 py-1 border rounded hover:bg-light/40 cursor-pointer text-dark">2</a>
                    </li>
                    <li>
                        <a
                            class="px-2 py-1 border rounded hover:bg-light/40 cursor-pointer text-dark">»</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>