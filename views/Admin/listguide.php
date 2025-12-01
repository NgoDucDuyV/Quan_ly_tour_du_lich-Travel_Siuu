    <!-- Danh sách booking -->
    <main class="flex-1 p-6 space-y-6">

        <!-- HEADER -->
        <header class="bg-white p-6 rounded-2xl shadow-sm flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                Danh sách khách đặt tour
            </h1>
        </header>

        <!-- SEARCH BOX -->
        <form method="GET" class="flex items-center w-full gap-3">
            <input type="hidden" name="mode" value="admin">
            <input type="hidden" name="act" value="listguide">

            <input
                name="keyword"
                value="<?= $_GET['keyword'] ?? '' ?>"
                class="flex-1 border border-gray-300 rounded-xl px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-500 outline-none"
                placeholder="Tìm kiếm khách hàng...">

            <button class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 duration-150">
                Tìm
            </button>
        </form>

        <!-- TABLE -->
        <section class="bg-white p-6 rounded-2xl shadow-sm">
            <table class="w-full border-collapse text-left">
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
                            // Màu theo loại khách
                            $typeColor = match ($c['customer_type_id'] ?? 'default') {
                                1 => 'bg-blue-100 text-blue-700',   // adult
                                2 => 'bg-orange-100 text-orange-700', // child
                                3 => 'bg-red-100 text-red-700',     // infant
                                default => 'bg-gray-100 text-gray-700'
                            };
                            ?>

                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-3 font-medium text-gray-900"><?= $c['customer_full_name'] ?></td>
                                <td class="p-3"><?= $c['birth_year'] ?></td>

                                <!-- TYPE HIỆN MÀU -->
                                <td class="p-3">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $typeColor ?>">
                                        <?= ucfirst($c['type'] ?? 'Unknown') ?>
                                    </span>
                                </td>

                                <td class="p-3"><?= $c['passport'] ?></td>
                                <td class="p-3 font-semibold text-blue-700 hover:underline cursor-pointer">
                                    <?= $c['tour_name'] ?? '-' ?>
                                </td>
                                <td class="p-3"><?= !empty($c['start_date']) ? date('d/m/Y', strtotime($c['start_date'])) : '-' ?></td>
                            </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td colspan="6" class="p-3 text-center text-gray-500">Không có danh sách khách tour hôm nay</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script>
        const input = document.querySelector('input[name="keyword"]');
        const rows = document.querySelectorAll("tbody tr");

        input.addEventListener("input", function() {
            const keyword = this.value.toLowerCase().trim();

            rows.forEach(row => {
                const name = row.querySelector("td:first-child").textContent.toLowerCase();
                row.style.display = name.includes(keyword) ? "" : "none";
            });

            if (keyword === "") rows.forEach(r => r.style.display = "");
        });
    </script>