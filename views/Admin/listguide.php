<main class="flex-1 p-8 space-y-6 bg-gray-50 min-h-screen">

        <header class="p-4 bg-white rounded-2xl shadow-sm border border-indigo-200">
                <?php if ($todayTour): ?>
                        <div class="text-indigo-800">
                                <p class="font-bold text-xl flex items-center gap-2">
                                        <i data-lucide="map" class="w-5 h-5"></i>
                                        Tour hôm nay: <?= htmlspecialchars($todayTour['tour_name'] ?? 'N/A') ?>
                                    </p>
                                <p class="text-sm mt-1">Ngày đi: <?= date("d/m/Y", strtotime($todayTour['start_date'] ?? 'now')) ?></p>
                            </div>
                    <?php else: ?>
                        <div class="text-yellow-800">
                                <p class="font-semibold text-xl">
                                        <i data-lucide="calendar-x" class="w-5 h-5 inline mr-2"></i>
                                        Hôm nay bạn không có tour nào đang diễn ra.
                                    </p>
                                <p class="text-sm mt-1">Danh sách khách hàng đang trống.</p>
                            </div>
                    <?php endif; ?>
            </header>

    <form method="GET" class="flex items-center w-full gap-3 bg-white p-4 rounded-2xl shadow-sm">
        <input type="hidden" name="mode" value="admin">
        <input type="hidden" name="act" value="listguide">

        <input
            id="searchKeyword"
            name="keyword"
            value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
            class="flex-1 border border-gray-300 rounded-xl px-4 py-3 shadow-inner focus:ring-2 focus:ring-blue-500 outline-none transition"
            placeholder="Tìm kiếm theo tên hoặc passport...">

        <button class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 duration-150">
            <i data-lucide="search" class="w-5 h-5"></i>
        </button>
    </form>

    <section class="bg-white p-6 rounded-2xl shadow-xl">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Danh sách Khách đặt Tour</h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left min-w-[900px]">
                <thead>
                    <tr class="bg-indigo-50 text-indigo-700 text-sm border-b border-indigo-200">
                        <th class="p-3 font-semibold">Tên Khách</th>
                        <th class="p-3 font-semibold">Năm Sinh</th>
                        <th class="p-3 font-semibold">Loại Khách</th>
                        <th class="p-3 font-semibold">Passport/CMND</th>
                        <th class="p-3 font-semibold">Tour Đặt</th>
                        <th class="p-3 font-semibold">Ngày Đi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800 divide-y divide-gray-100">

                    <?php if (!empty($datacustomers)): ?>
                        <?php foreach ($datacustomers as $c): ?>

                            <?php
                            // Chuyển đổi và xử lý NULL (FIXED: Đã dùng toán tử ?? và kiểm tra strtotime)
                            $typeId = $c['customer_type_id'] ?? 0;
                            $typeName = match ($typeId) {
                                1 => 'Người lớn',
                                2 => 'Trẻ em',
                                3 => 'Em bé',
                                default => 'Không rõ'
                            };
                            $typeColor = match ($typeId) {
                                1 => 'bg-blue-100 text-blue-700',
                                2 => 'bg-orange-100 text-orange-700',
                                3 => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700'
                            };

                            // Lỗi Deprecated: Đảm bảo kiểm tra NULL trước khi gọi date/strtotime
                            $birthYear = ($c['birth_year'] && strtotime($c['birth_year']))
                                ? date('Y', strtotime($c['birth_year']))
                                : 'N/A';

                            $passport = htmlspecialchars($c['passport'] ?? 'Không rõ');
                            $fullName = htmlspecialchars($c['customer_full_name'] ?? 'N/A');
                            $tourName = htmlspecialchars($c['tour_name'] ?? 'N/A');
                            $bookingStart = ($c['booking_start'] && strtotime($c['booking_start']))
                                ? date("d/m/Y", strtotime($c['booking_start']))
                                : 'N/A';
                            ?>

                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 font-medium text-gray-900"><?= $fullName ?></td>
                                <td class="p-3 text-gray-700"><?= $birthYear ?></td>
                                <td class="p-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $typeColor ?>">
                                        <?= $typeName ?>
                                    </span>
                                </td>
                                <td class="p-3 text-gray-700"><?= $passport ?></td>
                                <td class="p-3 font-semibold text-indigo-600"><?= $tourName ?></td>
                                <td class="p-3 text-gray-700"><?= $bookingStart ?></td>
                            </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">
                                Không tìm thấy khách hàng nào phù hợp với bộ lọc.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<script>
    // ... (Script tìm kiếm giữ nguyên logic sửa lỗi trước đó) ...
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('searchKeyword');
        const allRows = Array.from(document.querySelectorAll('.overflow-x-auto tbody tr'));

        if (!input) return;

        input.addEventListener("input", function() {
            const keyword = this.value.toLowerCase().trim();
            let visibleRowCount = 0;

            allRows.forEach(row => {
                const nameCell = row.querySelector("td:nth-child(1)");
                const passportCell = row.querySelector("td:nth-child(4)");

                if (row.querySelector('td') && row.querySelector('td').getAttribute('colspan')) {
                    row.style.display = 'none';
                    return;
                }

                if (nameCell && passportCell) {
                    const name = nameCell.textContent.toLowerCase().trim();
                    const passport = passportCell.textContent.toLowerCase().trim();

                    if (name.includes(keyword) || passport.includes(keyword)) {
                        row.style.display = "";
                        visibleRowCount++;
                    } else {
                        row.style.display = "none";
                    }
                }
            });

            const noResultsRow = document.getElementById('no-results-row');
            if (!noResultsRow) {
                const tbody = document.querySelector('.overflow-x-auto tbody');
                const newRow = document.createElement('tr');
                newRow.id = 'no-results-row';
                newRow.innerHTML = `<td colspan="6" class="p-6 text-center text-gray-500">
                    Không tìm thấy khách hàng nào phù hợp với từ khóa: "${keyword}"
                 </td>`;
                if (tbody && visibleRowCount === 0) tbody.appendChild(newRow);
            } else {
                noResultsRow.querySelector('td').textContent = `Không tìm thấy khách hàng nào phù hợp với từ khóa: "${keyword}"`;
            }

            if (visibleRowCount === 0) {
                if (document.getElementById('no-results-row')) document.getElementById('no-results-row').style.display = "";
            } else {
                if (document.getElementById('no-results-row')) document.getElementById('no-results-row').style.display = "none";
            }
        });

        // Loại bỏ hàng thông báo lỗi ban đầu nếu có dữ liệu
        const existingErrorRow = document.getElementById('no-results-row');
        if (existingErrorRow && allRows.length > 0) existingErrorRow.remove();

    });
</script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>