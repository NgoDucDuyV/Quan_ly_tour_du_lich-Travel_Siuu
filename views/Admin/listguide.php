<main class="flex-1 p-6 space-y-6">

    <!-- Header -->
    <header class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Danh sách đặt tour</h1>
        <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full border">
    </header>

    <!-- Khối tìm kiếm + lọc -->
    <form method="GET" class="flex items-center justify-between w-full">
        <input type="hidden" name="mode" value="admin">
        <input type="hidden" name="act" value="listguide">

        <input
            name="keyword"
            value="<?= $_GET['keyword'] ?? '' ?>"
            class="w-1/3 border rounded-lg px-3 py-2"
            placeholder="Tìm kiếm khách hàng...">

        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
            Tìm
        </button>
    </form>


    <!-- Danh sách booking -->
    <section class="bg-white p-5 rounded-xl shadow space-y-4">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100 text-gray-600">
                    <th class="p-3">Tên khách</th>
                    <th class="p-3">SĐT</th>
                    <th class="p-3">Loại nhóm</th>
                    <th class="p-3">Số người</th>
                    <th class="p-3">Trạng thái</th>
                    <th class="p-3 text-right">Thao tác</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($bookings as $booking): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3"><?= $booking['customer_name'] ?></td>

                        <td class="p-3"><?= $booking['customer_phone'] ?></td>

                        <td class="p-3">
                            <?= $booking['group_type'] == 'le' ? 'Cá nhân' : 'Đoàn' ?>
                        </td>

                        <td class="p-3"><?= $booking['number_of_people'] ?></td>

                        <td class="p-3">
                            <?php if ($booking['status'] == 'cho_xac_nhan'): ?>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-sm">
                                    Chờ xác nhận
                                </span>
                            <?php elseif ($booking['status'] == 'da_coc'): ?>
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm">
                                    Đã cọc
                                </span>
                            <?php elseif ($booking['status'] == 'hoan_tat'): ?>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-sm">
                                    Hoàn tất
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-sm">
                                    Hủy
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="p-3 text-right text-blue-600 cursor-pointer">
                            Xem chi tiết
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </section>

</main>
<script>
    const input = document.querySelector('input[name="keyword"]');
    const rows = document.querySelectorAll("tbody tr");

    input.addEventListener("input", function () {
        const keyword = this.value.toLowerCase().trim();

        rows.forEach(row => {
            const customerName = row.querySelector("td:first-child").textContent.toLowerCase();

            // Nếu tên chứa từ khóa -> hiển thị
            if (customerName.includes(keyword)) {
                row.style.display = "";
            }
            // Nếu không khớp -> ẩn
            else {
                row.style.display = "none";
            }
        });

        // Khi xoá hết input → hiện lại toàn bộ danh sách
        if (keyword === "") {
            rows.forEach(row => row.style.display = "");
        }
    });
</script>
