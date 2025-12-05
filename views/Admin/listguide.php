<main class="flex-1 p-6 space-y-6 bg-gray-50">

    <header class="bg-white p-6 rounded-2xl shadow-sm flex items-center justify-between border-b border-gray-100">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
            Danh sách khách đặt tour
        </h1>
    </header>

    <?php if ($todayTour): ?>
        <div class="p-4 bg-indigo-100 border border-indigo-300 text-indigo-800 rounded-xl shadow-md">
            <p class="font-semibold text-lg">
                Tour đang hiển thị: **<?= $todayTour['tour_name'] ?>**
                (Ngày đi: <?= date("d/m/Y", strtotime($todayTour['start_date'])) ?>)
            </p>
            <p class="text-sm">Danh sách này bao gồm tất cả khách hàng có Booking khớp với Tour và Ngày bắt đầu trên.</p>
        </div>
    <?php else: ?>
        <div class="p-4 bg-yellow-100 border border-yellow-300 text-yellow-800 rounded-xl shadow-md">
            <p class="font-semibold text-lg">
                Hôm nay bạn không có tour nào đang diễn ra (Ngày khởi hành trùng với ngày hôm nay).
            </p>
            <p class="text-sm">Danh sách khách hàng đang trống.</p>
        </div>
    <?php endif; ?>

    <form method="GET" class="flex items-center w-full gap-3">
        <input type="hidden" name="mode" value="admin">
        <input type="hidden" name="act" value="listguide">

        <input
            name="keyword"
            value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
            class="flex-1 border border-gray-300 rounded-xl px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 outline-none"
            placeholder="Tìm kiếm khách hàng...">

        <button class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 duration-150">
            Tìm
        </button>
    </form>

    <section class="bg-white p-6 rounded-2xl shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left min-w-[800px]">
                <thead>
                    <tr class="bg-gray-100/70 text-gray-600 text-sm border-b">
                        <th class="p-3 font-medium">Tên khách</th>
                        <th class="p-3 font-medium">Năm sinh</th>
                        <th class="p-3 font-medium">Loại</th>
                        <th class="p-3 font-medium">Passport</th>
                        <th class="p-3 font-medium">Tour</th>
                        <th class="p-3 font-medium">Ngày đi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800">

                    <?php if (!empty($datacustomers)): ?>
                        <?php foreach ($datacustomers as $c): ?>

                            <?php
                            $typeName = match ($c['customer_type_id'] ?? 0) {
                                1 => 'Người lớn',
                                2 => 'Trẻ em',
                                3 => 'Em bé',
                                default => 'Không rõ'
                            };
                            $typeColor = match ($c['customer_type_id'] ?? 0) {
                                1 => 'bg-blue-100 text-blue-700',
                                2 => 'bg-orange-100 text-orange-700',
                                3 => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                            $birthYear = date('Y-m-d', strtotime($c['birth_year'])) ?? 'N/A'; // Lấy định dạng yyyy-mm-dd
                            ?>

                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-3 font-medium text-gray-900">
                                    <?= htmlspecialchars($c['customer_full_name']) ?>
                                </td>

                                <td class="p-3">
                                    <?= $birthYear ?>
                                </td>

                                <td class="p-3">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $typeColor ?>">
                                        <?= $typeName ?>
                                    </span>
                                </td>

                                <td class="p-3">
                                    <?= htmlspecialchars($c['passport']) ?>
                                </td>

                                <td class="p-3 font-semibold text-blue-700">
                                    <?= htmlspecialchars($c['tour_name']) ?>
                                </td>

                                <td class="p-3">
                                    <?= date("d/m/Y", strtotime($c['booking_start'])) ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td colspan="6" class="p-3 text-center text-gray-500">
                                Không có khách nào được đặt cho tour này trong ngày hôm nay.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<script>
    // Giữ lại script tìm kiếm khách hàng
    const input = document.querySelector('input[name="keyword"]');
    const rows = document.querySelectorAll("tbody tr");

    input.addEventListener("input", function() {
        const keyword = this.value.toLowerCase().trim();

        rows.forEach(row => {
            // Đảm bảo hàng không phải là hàng thông báo "Không có khách"
            if (row.querySelector("td:first-child") && row.querySelector("td:first-child").textContent.trim() !== "Không có danh sách khách tour hôm nay") {
                const name = row.querySelector("td:first-child").textContent.toLowerCase();
                row.style.display = name.includes(keyword) ? "" : "none";
            }
        });

        if (keyword === "") rows.forEach(r => r.style.display = "");
    });
</script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>