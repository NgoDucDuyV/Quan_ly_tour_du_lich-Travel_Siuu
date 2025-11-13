<!-- views/Admin/requestguide.php -->
<div class="px-4">
    <!-- Header -->
    <div class="mt-6 mb-3 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
        <div>
            <h2 class="text-xl font-semibold">Yêu cầu từ điều hành &amp; khách</h2>
            <p class="text-xs text-gray-500">
                Xem và cập nhật trạng thái các yêu cầu liên quan đến tour
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Danh sách yêu cầu -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg h-full flex flex-col">
                <!-- Card header -->
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <h6 class="text-sm font-semibold">Yêu cầu mới / đang xử lý</h6>
                    <select
                        class="w-48 border border-gray-300 rounded text-sm px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option>Tất cả loại yêu cầu</option>
                        <option>Yêu cầu từ điều hành</option>
                        <option>Yêu cầu từ khách</option>
                    </select>
                </div>

                <!-- Card body -->
                <div class="p-4 flex-1 flex flex-col">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border-collapse">
                            <thead class="bg-gray-100">
                                <tr class="text-left">
                                    <th class="py-2 px-3">#</th>
                                    <th class="py-2 px-3">Loại</th>
                                    <th class="py-2 px-3">Tour</th>
                                    <th class="py-2 px-3">Nội dung</th>
                                    <th class="py-2 px-3">Ngày</th>
                                    <th class="py-2 px-3">Trạng thái</th>
                                    <th class="py-2 px-3 text-right">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Row 1 -->
                                <tr class="border-t">
                                    <td class="py-2 px-3">1</td>
                                    <td class="py-2 px-3">
                                        <span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">
                                            Điều hành
                                        </span>
                                    </td>
                                    <td class="py-2 px-3">City Tour Hà Nội</td>
                                    <td class="py-2 px-3">Chụp thêm ảnh đoàn và gửi lại trong ngày.</td>
                                    <td class="py-2 px-3">20/11/2025</td>
                                    <td class="py-2 px-3">
                                        <span class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">
                                            Đang xử lý
                                        </span>
                                    </td>
                                    <td class="py-2 px-3 text-right">
                                        <button
                                            class="px-2 py-1 border border-green-300 text-green-600 text-xs rounded hover:bg-green-50"
                                        >
                                            Đã hoàn thành
                                        </button>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="border-t">
                                    <td class="py-2 px-3">2</td>
                                    <td class="py-2 px-3">
                                        <span class="inline-block bg-green-100 text-green-700 text-xs px-2 py-1 rounded">
                                            Khách
                                        </span>
                                    </td>
                                    <td class="py-2 px-3">Food Tour Phố Cổ</td>
                                    <td class="py-2 px-3">Một khách muốn đổi món không cay.</td>
                                    <td class="py-2 px-3">20/11/2025</td>
                                    <td class="py-2 px-3">
                                        <span class="inline-block bg-red-100 text-red-700 text-xs px-2 py-1 rounded">
                                            Khẩn
                                        </span>
                                    </td>
                                    <td class="py-2 px-3 text-right">
                                        <button
                                            class="px-2 py-1 border border-blue-300 text-blue-600 text-xs rounded hover:bg-blue-50"
                                        >
                                            Xử lý
                                        </button>
                                    </td>
                                </tr>

                                <!-- Row 3 -->
                                <tr class="border-t">
                                    <td class="py-2 px-3">3</td>
                                    <td class="py-2 px-3">
                                        <span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">
                                            Điều hành
                                        </span>
                                    </td>
                                    <td class="py-2 px-3">Tour Sapa 3N2Đ</td>
                                    <td class="py-2 px-3">
                                        Cập nhật tình hình thời tiết và tình trạng khách ngày 1.
                                    </td>
                                    <td class="py-2 px-3">19/11/2025</td>
                                    <td class="py-2 px-3">
                                        <span class="inline-block bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded">
                                            Đã hoàn thành
                                        </span>
                                    </td>
                                    <td class="py-2 px-3 text-right">
                                        <button
                                            class="px-2 py-1 border border-gray-300 text-gray-600 text-xs rounded hover:bg-gray-50"
                                        >
                                            Chi tiết
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
                                <a class="px-2 py-1 border rounded text-gray-400 cursor-not-allowed">«</a>
                            </li>
                            <li>
                                <a class="px-3 py-1 border rounded bg-blue-600 text-white">1</a>
                            </li>
                            <li>
                                <a class="px-3 py-1 border rounded hover:bg-gray-100 cursor-pointer">2</a>
                            </li>
                            <li>
                                <a class="px-2 py-1 border rounded hover:bg-gray-100 cursor-pointer">»</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gửi yêu cầu ngược lại -->
        <div>
            <div class="bg-white shadow rounded-lg h-full flex flex-col">
                <div class="px-4 py-3 border-b border-gray-100">
                    <h6 class="text-sm font-semibold">Gửi yêu cầu đến điều hành</h6>
                </div>
                <div class="p-4 flex-1">
                    <form class="space-y-3">
                        <div>
                            <label class="text-sm text-gray-600 block mb-1">Chọn tour</label>
                            <select
                                class="w-full border border-gray-300 rounded text-sm px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            >
                                <option>City Tour Hà Nội</option>
                                <option>Food Tour Phố Cổ</option>
                                <option>Tour Sapa 3N2Đ</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm text-gray-600 block mb-1">Tiêu đề yêu cầu</label>
                            <input
                                type="text"
                                placeholder="VD: Xin thêm chi phí ăn tối cho đoàn"
                                class="w-full border border-gray-300 rounded text-sm px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>

                        <div>
                            <label class="text-sm text-gray-600 block mb-1">Nội dung chi tiết</label>
                            <textarea
                                rows="4"
                                placeholder="Mô tả rõ nội dung yêu cầu, lý do, mức độ khẩn..."
                                class="w-full border border-gray-300 rounded text-sm px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            class="w-full text-sm px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition"
                        >
                            Gửi yêu cầu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
