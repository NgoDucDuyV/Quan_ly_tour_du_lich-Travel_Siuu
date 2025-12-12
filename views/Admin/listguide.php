<main class="flex-1 p-4 space-y-4 bg-gray-50 min-h-screen md:p-8 md:space-y-6">

    <header class="p-5 bg-gradient-to-br from-main to-blue-400 text-white rounded-2xl shadow-lg overflow-hidden relative md:p-6">
        <?php if (!empty($datatour) && is_array($datatour) && !empty($datatour['name'])): ?>
            <div class="relative z-10 space-y-5">

                <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                    <div class="flex-1">
                        <h2 class="font-black text-white text-shadow-xl text-2xl leading-tight md:text-3xl drop-shadow-md">
                            <?= htmlspecialchars($datatour['name']) ?>
                        </h2>
                        <div class="flex flex-wrap items-center gap-3 mt-3 text-sm">
                            <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm rounded-full font-bold border border-white/30">
                                #<?= htmlspecialchars($datatour['code']) ?>
                            </span>
                            <span class="px-4 py-1.5 bg-emerald-400/30 backdrop-blur-sm rounded-full font-bold border border-emerald-300/50">
                                <?= htmlspecialchars($datatour['duration']) ?>
                            </span>
                        </div>
                    </div>

                    <?php if (!empty($datatour['images'])): ?>
                        <div class="flex-shrink-0 mt-4 md:mt-0">
                            <img src="<?= BASE_URL ?><?= htmlspecialchars($datatour['images']) ?>"
                                alt="Tour hôm nay"
                                class="w-full h-40 object-cover rounded-xl shadow-2xl border-4 border-white/30 md:w-64 md:h-44">
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Thông tin nhanh dạng icon – cực dễ đọc trên mobile -->
                <div class="grid grid-cols-2 gap-4 text-sm md:grid-cols-4">
                    <div class="flex items-center gap-3 bg-white/15 backdrop-blur-sm rounded-xl p-3">
                        <div class="w-10 h-10 bg-white/25 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-sun text-yellow-300"></i>
                        </div>
                        <div>
                            <p class="text-white/70 text-shadow-xl text-xs">Số ngày</p>
                            <p class="font-bold text-lg"><?= $datatour['days'] ?> ngày</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 bg-white/15 backdrop-blur-sm rounded-xl p-3">
                        <div class="w-10 h-10 bg-white/25 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-moon text-blue-200"></i>
                        </div>
                        <div>
                            <p class="text-white/70 text-shadow-xl text-xs">Số đêm</p>
                            <p class="font-bold text-lg"><?= $datatour['nights'] ?> đêm</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 bg-white/15 backdrop-blur-sm rounded-xl p-3">
                        <div class="w-10 h-10 bg-white/25 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-location-dot text-pink-300"></i>
                        </div>
                        <div>
                            <p class="text-white/70 text-shadow-xl text-xs">Điểm đến</p>
                            <p class="font-bold text-base">Phú Quốc</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 bg-white/15 backdrop-blur-sm rounded-xl p-3">
                        <div class="w-10 h-10 bg-white/25 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-flag text-emerald-300"></i>
                        </div>
                        <div>
                            <p class="text-white/70 text-shadow-xl text-xs">Danh mục</p>
                            <p class="font-bold text-sm"><?= htmlspecialchars($datatour['categoriesname']) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Nút hành động nổi bật (nếu cần) -->
                <div class="flex justify-center md:justify-start">
                    <button class="px-8 py-3 bg-white text-main font-bold rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
                        <i class="fa-solid fa-play"></i>
                        Bắt đầu dẫn tour
                    </button>
                </div>

            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-32 translate-x-20"></div>

        <?php else: ?>
            <div class="text-center py-12 from-accent to-light">
                <div class="text-8xl mb-6 opacity-30">
                    <i class="fa-regular fa-calendar"></i>
                </div>
                <h2 class="font-bold text-2xl md:text-3xl mb-3">
                    Hôm nay bạn được nghỉ ngơi
                </h2>
                <p class="text-white/80 text-sm max-w-md mx-auto">
                    Hiện tại chưa có tour nào được phân công cho hôm nay. Hãy tận hưởng ngày tự do và sẵn sàng cho hành trình tiếp theo nhé!
                </p>
                <div class="mt-8">
                    <i class="fa-solid fa-heart text-red-400 text-4xl animate-pulse"></i>
                </div>
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

        <button class="px-4 py-3 bg-main text-white font-semibold rounded-xl shadow hover:bg-hover duration-150 md:px-6">
            <i data-lucide="search" class="w-5 h-5"></i>
        </button>
    </form>

    <section class="bg-white p-4 rounded-2xl shadow-xl md:p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 md:text-xl">Danh sách Khách đặt Tour</h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left min-w-[900px]">
                <thead>
                    <tr class="bg-indigo-50 text-main text-sm border-b border-indigo-200">
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
                            // Chuyển đổi và xử lý NULL
                            $typeId = $c['customer_type_id'] ?? 0;
                            $typeName = match ($typeId) {
                                1 => 'Người lớn',
                                2 => 'Trẻ em',
                                3 => 'Em bé',
                                default => 'Không rõ'
                            };
                            $typeColor = match ($typeId) {
                                1 => 'bg-blue-100 text-hover',
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
                                <td class="p-3 font-semibold text-main"><?= $tourName ?></td>
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