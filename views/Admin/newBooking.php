<!-- Main content -->
<main class="flex-1 p-6 overflow-auto">
    <!-- Dashboard -->
    <section id="dashboard" class="mb-10">
        <h2 class="text-3xl font-bold mb-6">Dashboard</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded shadow">Tổng tour: <span class="font-bold">12</span></div>
            <div class="bg-white p-6 rounded shadow">Tổng khách: <span class="font-bold">120</span></div>
            <div class="bg-white p-6 rounded shadow">Doanh thu: <span class="font-bold">1.200.000.000₫</span></div>
        </div>
    </section>

    <!-- Danh mục tour -->
    <section id="categories" class="mb-10">
        <h2 class="text-2xl font-bold mb-4">Danh mục tour</h2>
        <div class="mb-4 flex justify-between">
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Thêm danh mục</button>
            <input type="text" placeholder="Tìm kiếm..." class="border rounded px-2 py-1">
        </div>
        <table class="min-w-full bg-white rounded shadow overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Tên danh mục</th>
                    <th class="p-3 text-left">Mô tả</th>
                    <th class="p-3 text-left">Ngày tạo</th>
                    <th class="p-3 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">1</td>
                    <td class="p-3">Tour trong nước</td>
                    <td class="p-3">Tour tham quan trong nước</td>
                    <td class="p-3">2025-01-01</td>
                    <td class="p-3">
                        <button class="text-blue-600 hover:underline">Sửa</button>
                        <button class="text-red-600 hover:underline ml-2">Xóa</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <!-- Quản lý Tour -->
    <section id="tours" class="mb-10">
        <h2 class="text-2xl font-bold mb-4">Quản lý Tour</h2>
        <form class="bg-white p-6 rounded shadow space-y-4">
            <div>
                <label class="block mb-1 font-medium">Tên tour</label>
                <input type="text" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block mb-1 font-medium">Danh mục tour</label>
                <select class="w-full border rounded px-3 py-2">
                    <option>Tour trong nước</option>
                    <option>Tour quốc tế</option>
                    <option>Theo yêu cầu</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium">Mã tour</label>
                <input type="text" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block mb-1 font-medium">Giá cơ bản</label>
                <input type="number" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block mb-1 font-medium">Lịch trình tour (JSON)</label>
                <textarea class="w-full border rounded px-3 py-2" rows="4"></textarea>
            </div>
            <div>
                <label class="block mb-1 font-medium">Hình ảnh tour</label>
                <input type="file" multiple class="w-full">
            </div>
            <div>
                <label class="block mb-1 font-medium">Chính sách tour</label>
                <textarea class="w-full border rounded px-3 py-2" rows="3"></textarea>
            </div>
            <div>
                <label class="block mb-1 font-medium">Nhà cung cấp</label>
                <select class="w-full border rounded px-3 py-2">
                    <option>Khách sạn ABC</option>
                    <option>Nhà hàng XYZ</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lưu Tour</button>
            </div>
        </form>
    </section>

    <!-- Booking -->
    <section id="bookings" class="mb-10">
        <h2 class="text-2xl font-bold mb-4">Tạo Booking mới</h2>
        <form class="bg-white p-6 rounded shadow space-y-4">
            <div>
                <label class="block mb-1 font-medium">Tour</label>
                <select class="w-full border rounded px-3 py-2">
                    <option>Tour Hạ Long</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium">Phiên bản tour</label>
                <select class="w-full border rounded px-3 py-2">
                    <option>Mùa hè 2025</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium">Tên khách hàng</label>
                <input type="text" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block mb-1 font-medium">Số điện thoại</label>
                <input type="text" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block mb-1 font-medium">Nhóm/loại</label>
                <select class="w-full border rounded px-3 py-2">
                    <option>Lẻ</option>
                    <option>Đoàn</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium">Số lượng khách</label>
                <input type="number" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block mb-1 font-medium">Dịch vụ kèm theo</label>
                <select multiple class="w-full border rounded px-3 py-2">
                    <option>Xe đưa đón</option>
                    <option>Khách sạn 4 sao</option>
                    <option>Nhà hàng 3 bữa</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium">Ghi chú/ yêu cầu đặc biệt</label>
                <textarea class="w-full border rounded px-3 py-2" rows="3"></textarea>
            </div>
            <div class="flex justify-end">
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Tạo Booking</button>
            </div>
        </form>
    </section>

    <!-- Guides -->
    <section id="guides" class="mb-10">
        <h2 class="text-2xl font-bold mb-4">Quản lý Hướng dẫn viên</h2>
        <table class="min-w-full bg-white rounded shadow overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Tên HDV</th>
                    <th class="p-3 text-left">Ngôn ngữ</th>
                    <th class="p-3 text-left">Kinh nghiệm</th>
                    <th class="p-3 text-left">Trạng thái</th>
                    <th class="p-3 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">Nguyễn Văn A</td>
                    <td class="p-3">Việt, Anh</td>
                    <td class="p-3">5 năm</td>
                    <td class="p-3">Available</td>
                    <td class="p-3">
                        <button class="text-blue-600 hover:underline">Sửa</button>
                        <button class="text-red-600 hover:underline ml-2">Xóa</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <!-- Schedules -->
    <section id="schedules" class="mb-10">
        <h2 class="text-2xl font-bold mb-4">Lịch khởi hành & Phân bổ dịch vụ</h2>
        <form class="bg-white p-6 rounded shadow space-y-4">
            <div>
                <label class="block mb-1 font-medium">Tour</label>
                <select class="w-full border rounded px-3 py-2">
                    <option>Tour Hạ Long</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium">HDV</label>
                <select class="w-full border rounded px-3 py-2">
                    <option>Nguyễn Văn A</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium">Ngày khởi hành</label>
                <input type="date" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block mb-1 font-medium">Ngày kết thúc</label>
                <input type="date" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block mb-1 font-medium">Điểm tập trung</label>
                <input type="text" class="w-full border rounded px-3 py-2">
            </div>
            <div class="flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lưu lịch khởi hành</button>
            </div>
        </form>
    </section>

    <!-- Notes -->
    <section id="notes" class="mb-10">
        <h2 class="text-2xl font-bold mb-4">Nhật ký & Ghi chú</h2>
        <form class="bg-white p-6 rounded shadow space-y-4">
            <div>
                <label class="block mb-1 font-medium">Loại ghi chú</label>
                <select class="w-full border rounded px-3 py-2">
                    <option>Yêu cầu khác</option>
                    <option>Ăn chay</option>
                    <option>Bệnh lý</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium">Nội dung</label>
                <textarea class="w-full border rounded px-3 py-2" rows="4"></textarea>
            </div>
            <div class="flex justify-end">
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ghi chú</button>
            </div>
        </form>
    </section>

    <!-- Revenues -->
    <section id="revenues" class="mb-10">
        <h2 class="text-2xl font-bold mb-4">Báo cáo & Doanh thu</h2>
        <table class="min-w-full bg-white rounded shadow overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Tour</th>
                    <th class="p-3 text-left">Doanh thu</th>
                    <th class="p-3 text-left">Chi phí</th>
                    <th class="p-3 text-left">Lợi nhuận</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">Tour Hạ Long</td>
                    <td class="p-3">500.000.000₫</td>
                    <td class="p-3">300.000.000₫</td>
                    <td class="p-3">200.000.000₫</td>
                </tr>
            </tbody>
        </table>
    </section>

</main>