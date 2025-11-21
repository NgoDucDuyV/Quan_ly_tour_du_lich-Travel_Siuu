<main class="flex-1 p-6 space-y-6">

    <!-- Header -->
    <header class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Danh sách hướng dẫn viên</h1>
        <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full border">
    </header>

    <!-- Khối tìm kiếm + lọc -->
    <div class="bg-white p-4 rounded-xl shadow flex items-center justify-between">
        <input class="w-1/3 border rounded-lg px-3 py-2" placeholder="Tìm kiếm hướng dẫn viên...">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Thêm mới</button>
    </div>

    <!-- Danh sách HDV -->
    <section class="bg-white p-5 rounded-xl shadow space-y-4">

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100 text-gray-600">
                    <th class="p-3">Tên</th>
                    <th class="p-3">SĐT</th>
                    <th class="p-3">Kinh nghiệm</th>
                    <th class="p-3 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>

                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">Nguyễn Văn A</td>
                    <td class="p-3">0981 234 567</td>
                    <td class="p-3">5 năm</td>
                    <td class="p-3 text-right text-blue-600 cursor-pointer">Xem chi tiết</td>
                </tr>

                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">Trần Thị B</td>
                    <td class="p-3">0912 345 678</td>
                    <td class="p-3">3 năm</td>
                    <td class="p-3 text-right text-blue-600 cursor-pointer">Xem chi tiết</td>
                </tr>

            </tbody>
        </table>

    </section>

</main>