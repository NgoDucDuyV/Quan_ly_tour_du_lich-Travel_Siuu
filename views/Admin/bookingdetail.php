<div class="max-w-[1600px] mx-auto p-6 space-y-6 font-sans text-slate-800">

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
        <span class="px-4 py-2 rounded-full bg-indigo-600 text-white font-medium text-sm shadow">BK2025-10023</span>
    </div>

    <!-- Status badges -->
    <div class="flex flex-wrap gap-3 text-xs mt-2">
        <span class="inline-flex items-center px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">Chờ xác nhận</span>
        <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 text-blue-800">Đã cọc</span>
        <span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-800">Hoàn tất</span>
        <span class="inline-flex items-center px-2 py-1 rounded-full bg-purple-100 text-purple-800">Đoàn</span>
        <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-50 text-blue-800">Lẻ</span>
    </div>

    <!-- 1. Thông tin Booking -->
    <div class="bg-white rounded-xl shadow-md p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900 mb-2">1. Thông tin Booking</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-slate-700">
            <p><b>Mã Booking:</b> BK2025-10023</p>
            <p><b>Ngày tạo:</b> 28/11/2025 13:00</p>
            <p><b>Trạng thái:</b> <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Chờ xác nhận</span></p>
            <p><b>Loại Booking:</b> Khách lẻ</p>
            <p><b>Nguồn tạo:</b> Website</p>
            <p><b>Nhân viên phụ trách:</b> Nguyễn Văn B</p>
            <p class="col-span-1 sm:col-span-3"><b>Ghi chú:</b> Khách muốn phòng gần biển</p>
        </div>
    </div>

    <!-- 2. Thông tin người đặt -->
    <div class="bg-white rounded-xl shadow-md p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900 mb-2">2. Thông tin người đặt</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-slate-700">
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
    <div class="bg-white rounded-xl shadow-md border border-slate-100 p-6 space-y-4 overflow-x-auto">
        <h2 class="text-lg font-semibold text-slate-900 mb-2">3. Danh sách hành khách</h2>

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
    <div class="bg-white rounded-xl shadow-md p-6 space-y-4 border border-slate-100">
        <h2 class="text-lg font-semibold text-slate-900 mb-2">4. Thông tin Tour</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-slate-700">
            <p><b>Tên tour:</b> Tour Hạ Long 3N2Đ – Du thuyền 5 sao</p>
            <p><b>Mã tour:</b> T-HL-3001</p>
            <p><b>Ngày khởi hành:</b> 05/12/2025 07:00</p>
            <p><b>Ngày kết thúc:</b> 07/12/2025 15:30</p>
            <p><b>Điểm đón:</b> 233 Thái Hà</p>
            <p><b>Điểm trả:</b> Nội thành Hà Nội</p>
            <p><b>Phương tiện:</b> Xe 29 chỗ + Du thuyền 5 sao</p>
        </div>

        <!-- Hình ảnh Tour -->
        <h3 class="font-semibold mt-4 text-slate-700">Hình ảnh Tour</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <img src="https://picsum.photos/300" class="rounded-lg shadow-md w-full object-cover">
            <img src="https://picsum.photos/301" class="rounded-lg shadow-md w-full object-cover">
            <img src="https://picsum.photos/302" class="rounded-lg shadow-md w-full object-cover">
        </div>

        <!-- Lịch trình -->
        <h3 class="font-semibold mt-4 text-slate-700">Lịch trình theo ngày</h3>
        <div class="space-y-3">
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h4 class="font-semibold">Ngày 1: Hà Nội – Hạ Long</h4>
                <ul class="list-disc ml-6 text-sm space-y-1">
                    <li>05:30 – Đón khách tại Hà Nội</li>
                    <li>09:30 – Check-in du thuyền</li>
                    <li>12:00 – Ăn trưa buffet</li>
                    <li>14:00 – Tham quan hang Sửng Sốt</li>
                    <li>19:00 – Gala Dinner</li>
                </ul>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h4 class="font-semibold">Ngày 2: Vịnh Lan Hạ</h4>
                <ul class="list-disc ml-6 text-sm space-y-1">
                    <li>06:00 – Tập Tai Chi</li>
                    <li>08:00 – Kayak</li>
                    <li>12:00 – Ăn trưa</li>
                    <li>15:00 – Tắm biển</li>
                </ul>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h4 class="font-semibold">Ngày 3: Trở về Hà Nội</h4>
                <ul class="list-disc ml-6 text-sm space-y-1">
                    <li>06:30 – Ăn sáng</li>
                    <li>08:30 – Tham quan làng chài</li>
                    <li>11:00 – Trả phòng</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto my-8 p-6 bg-white rounded-2xl shadow-lg">
    <!-- Header Booking -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Chi tiết Booking</h2>
        <span class="px-3 py-1 rounded-full font-semibold text-white 
                    bg-green-500">Trạng thái: <span id="booking-status">DRAFT</span></span>
    </div>

    <!-- Thông tin cơ bản -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="space-y-2">
            <p class="font-semibold text-gray-600">Mã Booking:</p>
            <p class="text-gray-800" id="booking-code">BK-ABC12345</p>
        </div>
        <div class="space-y-2">
            <p class="font-semibold text-gray-600">Ngày tạo:</p>
            <p class="text-gray-800" id="booking-created">01/12/2025</p>
        </div>
    </div>

    <!-- Thông tin khách hàng -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Thông tin khách hàng</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="font-medium text-gray-600">Họ tên:</p>
                <p class="text-gray-800" id="customer-name">Ngô Đức Duy</p>
            </div>
            <div>
                <p class="font-medium text-gray-600">Số điện thoại:</p>
                <p class="text-gray-800" id="customer-phone">0987654321</p>
            </div>
            <div>
                <p class="font-medium text-gray-600">Email:</p>
                <p class="text-gray-800" id="customer-email">duy@example.com</p>
            </div>
        </div>
    </div>

    <!-- Thông tin Tour -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Thông tin Tour</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="font-medium text-gray-600">Tên Tour:</p>
                <p class="text-gray-800" id="tour-name">Tour Hà Nội - Hạ Long 3N2Đ</p>
            </div>
            <div>
                <p class="font-medium text-gray-600">Phiên bản:</p>
                <p class="text-gray-800" id="tour-version">VIP</p>
            </div>
            <div>
                <p class="font-medium text-gray-600">Ngày khởi hành:</p>
                <p class="text-gray-800" id="departure-date">05/12/2025</p>
            </div>
            <div>
                <p class="font-medium text-gray-600">Ngày kết thúc:</p>
                <p class="text-gray-800" id="end-date">08/12/2025</p>
            </div>
        </div>
    </div>

    <!-- Danh sách dịch vụ -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Dịch vụ đã chọn</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2 text-left">Dịch vụ</th>
                        <th class="border px-3 py-2 text-right">Số lượng</th>
                        <th class="border px-3 py-2 text-right">Đơn giá</th>
                        <th class="border px-3 py-2 text-right">Tổng</th>
                    </tr>
                </thead>
                <tbody id="service-list">
                    <tr>
                        <td class="border px-3 py-2">Vé xe VIP</td>
                        <td class="border px-3 py-2 text-right">2</td>
                        <td class="border px-3 py-2 text-right">2,000,000 VND</td>
                        <td class="border px-3 py-2 text-right">4,000,000 VND</td>
                    </tr>
                    <tr>
                        <td class="border px-3 py-2">Khách sạn 3 sao</td>
                        <td class="border px-3 py-2 text-right">2</td>
                        <td class="border px-3 py-2 text-right">1,500,000 VND</td>
                        <td class="border px-3 py-2 text-right">3,000,000 VND</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Ghi chú & Thanh toán -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <p class="font-medium text-gray-600">Ghi chú:</p>
            <p class="text-gray-800" id="booking-note">Khách yêu cầu phòng hướng biển.</p>
        </div>
        <div>
            <p class="font-medium text-gray-600">Trạng thái thanh toán:</p>
            <p class="text-gray-800" id="payment-status">Chưa thanh toán</p>
        </div>
    </div>

    <!-- Tổng tiền -->
    <div class="flex justify-end items-center">
        <p class="text-lg font-semibold text-gray-700 mr-4">Tổng thanh toán:</p>
        <p class="text-xl font-bold text-blue-700" id="total-amount">7,000,000 VND</p>
    </div>
</div>