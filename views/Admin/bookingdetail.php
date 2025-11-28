<div class="max-w-[1600px] mx-auto p-6 space-y-6">

    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Chi tiết Booking</li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <h1 class="text-3xl font-semibold text-slate-900">Chi Tiết Booking</h1>
        <span class="px-3 py-1 rounded-full bg-main text-white font-medium text-sm">BK2025-10023</span>
    </div>

    <!-- Status badges -->
    <div class="flex flex-wrap gap-3 text-xs">
        <span class="inline-flex items-center px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">Chờ xác nhận</span>
        <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 text-blue-800">Đã cọc</span>
        <span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-800">Hoàn tất</span>
        <span class="inline-flex items-center px-2 py-1 rounded-full bg-purple-100 text-purple-800">Đoàn</span>
        <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-50 text-blue-800">Lẻ</span>
    </div>

    <!-- 1. Thông tin Booking -->
    <div class="bg-white rounded-xl shadow p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900">1. Thông tin Booking</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700">
            <p><b>Mã Booking:</b> BK2025-10023</p>
            <p><b>Ngày tạo:</b> 28/11/2025 13:00</p>
            <p><b>Trạng thái:</b> <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Chờ xác nhận</span></p>
            <p><b>Loại Booking:</b> Khách lẻ</p>
            <p><b>Nguồn tạo:</b> Website</p>
            <p><b>Nhân viên phụ trách:</b> Nguyễn Văn B</p>
            <p class="col-span-1 sm:col-span-2"><b>Ghi chú:</b> Khách muốn phòng gần biển</p>
        </div>
    </div>

    <!-- 2. Thông tin người đặt -->
    <div class="bg-white rounded-xl shadow p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900">2. Thông tin người đặt</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700">
            <p><b>Họ tên:</b> Trần Minh Hoàng</p>
            <p><b>SĐT:</b> 0912445778</p>
            <p><b>Email:</b> hoangtm@example.com</p>
            <p><b>CCCD:</b> 012345678901</p>
            <p><b>Địa chỉ:</b> 25 Lê Duẩn, Hoàn Kiếm, Hà Nội</p>
            <p><b>Quốc tịch:</b> Việt Nam</p>
            <p><b>Liên hệ qua:</b> Zalo</p>
        </div>
    </div>

    <!-- 3. Danh sách hành khách -->
    <div class="bg-white rounded-xl shadow border border-slate-100 p-6 space-y-4 overflow-x-auto">
        <h2 class="text-lg font-semibold text-slate-900">3. Danh sách hành khách</h2>

        <h3 class="font-semibold text-slate-700 mt-2 mb-1">Người lớn</h3>
        <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700 mb-4">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left">STT</th>
                    <th class="px-4 py-3 text-left">Họ tên</th>
                    <th class="px-4 py-3 text-left">Ngày sinh</th>
                    <th class="px-4 py-3 text-left">CCCD</th>
                    <th class="px-4 py-3 text-left">Giới tính</th>
                    <th class="px-4 py-3 text-left">Ghi chú</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">Nguyễn Thị Thu</td>
                    <td class="px-4 py-3">1990</td>
                    <td class="px-4 py-3">012345678901</td>
                    <td class="px-4 py-3">Nữ</td>
                    <td class="px-4 py-3">Ăn chay</td>
                </tr>
            </tbody>
        </table>

        <h3 class="font-semibold text-slate-700 mt-2 mb-1">Trẻ em</h3>
        <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700 mb-4">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left">STT</th>
                    <th class="px-4 py-3 text-left">Họ tên</th>
                    <th class="px-4 py-3 text-left">Năm sinh</th>
                    <th class="px-4 py-3 text-left">Ghi chú</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">Trần Gia Bảo</td>
                    <td class="px-4 py-3">2015</td>
                    <td class="px-4 py-3">Mang xe đẩy</td>
                </tr>
            </tbody>
        </table>

        <h3 class="font-semibold text-slate-700 mt-2 mb-1">Em bé</h3>
        <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left">STT</th>
                    <th class="px-4 py-3 text-left">Họ tên</th>
                    <th class="px-4 py-3 text-left">Năm sinh</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">Trần Nhật Minh</td>
                    <td class="px-4 py-3">2023</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 4. Thông tin Tour -->
    <div class="bg-white rounded-xl shadow p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900">4. Thông tin Tour</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700">
            <p><b>Tên tour:</b> Tour Hạ Long 3N2Đ – Du thuyền 5 sao</p>
            <p><b>Mã tour:</b> T-HL-3001</p>
            <p><b>Ngày khởi hành:</b> 05/12/2025 07:00</p>
            <p><b>Ngày kết thúc:</b> 07/12/2025 15:30</p>
            <p><b>Điểm đón:</b> 233 Thái Hà</p>
            <p><b>Điểm trả:</b> Nội thành Hà Nội</p>
            <p><b>Phương tiện:</b> Xe 29 chỗ + Du thuyền 5 sao</p>
        </div>

        <!-- Hình ảnh -->
        <h3 class="font-semibold mt-4 text-slate-700">Hình ảnh Tour</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <img src="https://picsum.photos/200" class="rounded-lg shadow">
            <img src="https://picsum.photos/201" class="rounded-lg shadow">
            <img src="https://picsum.photos/202" class="rounded-lg shadow">
        </div>

        <!-- Lịch trình -->
        <h3 class="font-semibold mt-4 text-slate-700">Lịch trình theo ngày</h3>
        <div class="space-y-3">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold">Ngày 1: Hà Nội – Hạ Long</h4>
                <ul class="list-disc ml-6 text-sm">
                    <li>05:30 – Đón khách tại Hà Nội</li>
                    <li>09:30 – Check-in du thuyền</li>
                    <li>12:00 – Ăn trưa buffet</li>
                    <li>14:00 – Tham quan hang Sửng Sốt</li>
                    <li>19:00 – Gala Dinner</li>
                </ul>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold">Ngày 2: Vịnh Lan Hạ</h4>
                <ul class="list-disc ml-6 text-sm">
                    <li>06:00 – Tập Tai Chi</li>
                    <li>08:00 – Kayak</li>
                    <li>12:00 – Ăn trưa</li>
                    <li>15:00 – Tắm biển</li>
                </ul>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold">Ngày 3: Trở về Hà Nội</h4>
                <ul class="list-disc ml-6 text-sm">
                    <li>06:30 – Ăn sáng</li>
                    <li>08:30 – Tham quan làng chài</li>
                    <li>11:00 – Trả phòng</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 5. Giá tour & Dịch vụ thêm -->
    <div class="bg-white rounded-xl shadow p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900">5. Giá tour & Dịch vụ thêm</h2>
        <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700 mb-4">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left">Loại khách</th>
                    <th class="px-4 py-3 text-left">Giá</th>
                    <th class="px-4 py-3 text-left">Số lượng</th>
                    <th class="px-4 py-3 text-left">Thành tiền</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">Người lớn</td>
                    <td class="px-4 py-3">3,500,000</td>
                    <td class="px-4 py-3">2</td>
                    <td class="px-4 py-3">7,000,000</td>
                </tr>
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">Trẻ em</td>
                    <td class="px-4 py-3">2,400,000</td>
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">2,400,000</td>
                </tr>
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">Em bé</td>
                    <td class="px-4 py-3">500,000</td>
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">500,000</td>
                </tr>
            </tbody>
        </table>

        <h3 class="font-semibold text-slate-700">Dịch vụ thêm</h3>
        <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left">Tên dịch vụ</th>
                    <th class="px-4 py-3 text-left">SL</th>
                    <th class="px-4 py-3 text-left">Giá</th>
                    <th class="px-4 py-3 text-left">Tổng</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">Kayak</td>
                    <td class="px-4 py-3">2</td>
                    <td class="px-4 py-3">150,000</td>
                    <td class="px-4 py-3">300,000</td>
                </tr>
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">Spa</td>
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">600,000</td>
                    <td class="px-4 py-3">600,000</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 6. Thanh toán -->
    <div class="bg-white rounded-xl shadow p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900">6. Thanh toán</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700">
            <p><b>Tổng vé người lớn:</b> 7,000,000</p>
            <p><b>Tổng vé trẻ em:</b> 2,400,000</p>
            <p><b>Em bé:</b> 500,000</p>
            <p><b>Dịch vụ thêm:</b> 900,000</p>
            <p><b>Phụ thu phòng đơn:</b> 900,000</p>
            <p><b>Ưu đãi:</b> -450,000</p>
            <p><b>VAT (10%):</b> 540,000</p>
            <p class="col-span-1 sm:col-span-2 text-lg font-bold text-blue-700">Tổng thanh toán: 11,990,000 VNĐ</p>
            <p><b>Đã thanh toán:</b> 5,000,000 (Chuyển khoản)</p>
            <p class="text-red-600 font-semibold">Còn lại: 6,990,000 VNĐ</p>
        </div>
    </div>

    <!-- 7. Hóa đơn -->
    <div class="bg-white rounded-xl shadow p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900">7. Hóa đơn</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700">
            <p><b>Xuất hóa đơn:</b> Có</p>
            <p><b>Công ty:</b> Công ty TNHH ABC</p>
            <p><b>MST:</b> 0101223344</p>
            <p><b>Địa chỉ:</b> Cầu Giấy - Hà Nội</p>
            <p><b>Người nhận:</b> Nguyễn Thu</p>
        </div>
    </div>

    <!-- 8. Nhà cung cấp -->
    <div class="bg-white rounded-xl shadow p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900">8. Nhà cung cấp</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700">
            <p><b>Tên:</b> Khách sạn 5 sao Hạ Long</p>
            <p><b>Người liên hệ:</b> Mr. A</p>
            <p><b>SĐT:</b> 0911222333</p>
            <p><b>Email:</b> hotelHN@example.com</p>
            <p><b>Địa chỉ:</b> 12 Vịnh Hạ Long</p>
        </div>
    </div>

    <!-- 9. File đính kèm -->
    <div class="bg-white rounded-xl shadow p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900">9. File đính kèm</h2>
        <ul class="list-disc ml-6 text-sm text-slate-700">
            <li><a href="#" class="text-blue-600 hover:underline">Hợp đồng_2025.pdf</a></li>
            <li><a href="#" class="text-blue-600 hover:underline">Danh sách hành khách.xlsx</a></li>
        </ul>
    </div>

    <!-- 10. Lịch sử cập nhật -->
    <div class="bg-white rounded-xl shadow p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900">10. Lịch sử cập nhật</h2>
        <ul class="text-sm text-slate-700 space-y-2">
            <li>28/11/2025 13:05 - Tạo booking bởi admin</li>
            <li>28/11/2025 14:20 - Khách cọc 5,000,000 VNĐ</li>
            <li>28/11/2025 15:00 - Chờ xác nhận</li>
            <li>28/11/2025 16:10 - Thanh toán 5,000,000 VNĐ</li>
        </ul>
    </div>

</div>