<?php if (isset($dataTourDetai)) { ?>
    <div class="space-y-6">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-start gap-5 p-4 bg-white border rounded-xl shadow-sm">
            <img id="detailThumb"
                src="<?= BASE_URL . $dataOneTour['images'] ?>"
                alt="<?= $dataOneTour['name'] ?>"
                class="w-full lg:w-52 lg:h-40 md:h-[350px] object-cover rounded-lg shadow" />

            <div class="flex-1 space-y-2">
                <h3 class="text-2xl font-semibold text-gray-900"><?= $dataOneTour['name'] ?></h3>

                <p class="text-gray-500 text-sm">Mã Tour: <span class="font-medium text-gray-700"><?= $dataOneTour['code'] ?></span></p>
                <p class="text-gray-500 text-sm">Giá cơ bản:
                    <span class="text-main font-semibold"><?= number_format($dataOneTour['price']) ?> VND</span>
                </p>

                <!-- Tabs -->
                <div class="flex gap-2 pt-2">
                    <button onclick="showTab('info')"
                        class="px-3 py-1.5 text-sm border rounded-lg hover:bg-gray-100 transition">
                        Thông tin
                    </button>
                    <button onclick="showTab('versions')"
                        class="px-3 py-1.5 text-sm border rounded-lg hover:bg-gray-100 transition">
                        Phiên bản
                    </button>
                    <button onclick="showTab('images')"
                        class="px-3 py-1.5 text-sm border rounded-lg hover:bg-gray-100 transition">
                        Hình ảnh
                    </button>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div id="tabs" class="bg-white p-4 border rounded-xl shadow-sm">

            <!-- Tab 1: Thông tin -->
            <div id="tab-info" class="tab-pane">
                <h4 class="text-lg font-semibold text-gray-800">Lịch trình - <?= $dataOneTour['name'] ?></h4>

                <div class="mt-3">
                    <?php if (!empty($dataTourDetai)) : ?>
                        <ul class="relative border-l border-gray-300 pl-4 space-y-8">

                            <?php
                            $currentDay = null;
                            foreach ($dataTourDetai as $item):
                                if ($currentDay !== $item['day_number']):
                                    if ($currentDay !== null) echo "</ul></div></li>";
                                    $currentDay = $item['day_number'];
                            ?>
                                    <li class="relative">
                                        <span class="absolute -left-5 top-0 bg-main text-white w-8 h-8 rounded-full flex items-center justify-center font-semibold shadow">
                                            <?= $currentDay ?>
                                        </span>

                                        <div class="bg-gray-50 border rounded-lg p-4 shadow-sm">
                                            <h5 class="text-gray-800 font-medium mb-2">
                                                Ngày <?= $currentDay ?> – <?= htmlspecialchars($item['itinerary_title']) ?>
                                            </h5>

                                            <p class="text-gray-600 text-sm mb-3">
                                                <?= htmlspecialchars($item['itinerary_description']) ?>
                                            </p>

                                            <ul class="space-y-1 text-sm text-gray-700">
                                            <?php endif; ?>

                                            <li>
                                                <span class="font-medium"><?= htmlspecialchars($item['activity_time']) ?></span> –
                                                <?= htmlspecialchars($item['activity']) ?>
                                                (<?= htmlspecialchars($item['location']) ?>):
                                                <?= htmlspecialchars($item['activity_description']) ?>
                                            </li>

                                        <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>
                        </ul>
                    <?php else: ?>
                        <div class="text-center bg-gray-50 p-5 rounded-xl border">
                            <p class="text-gray-600">Chưa có dữ liệu lịch trình.</p>
                            <button class="mt-2 px-3 py-1.5 bg-main text-white rounded-lg hover:bg-hover transition">
                                Xem chi tiết tour
                            </button>
                        </div>
                    <?php endif; ?>
                </div>

                <h4 class="mt-6 font-semibold text-gray-800">Chính sách</h4>
                <p class="text-gray-600 text-sm mt-2">
                    Hủy sau 7 ngày trước ngày khởi hành mất 50%, hủy trong 3 ngày mất 100%...
                </p>

                <!-- Supplier -->
                <h4 class="mt-6 font-semibold text-gray-800">Nhà cung cấp</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mt-2">
                    <?php foreach ($dataTourSupplier as $value) { ?>
                        <div class="p-3 bg-gray-50 border rounded-lg hover:bg-gray-100 transition text-sm">
                            <div class="font-medium text-gray-800"><?= ucfirst($value['role']) ?>:</div>
                            <div class="text-gray-600"><?= $value['supplier_name'] ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Tab 2: Phiên bản -->
            <div id="tab-versions" class="tab-pane hidden">
                <h4 class="text-lg font-semibold text-gray-800">Phiên bản Tour</h4>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="p-4 border rounded-xl bg-gray-50 hover:shadow transition">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-800">Mùa Hè (Cao điểm)</span>
                            <span class="text-gray-500"><?= number_format($dataOneTour['price']) ?> VND</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Lịch trình: Thêm hoạt động biển</p>
                    </div>

                    <div class="p-4 border rounded-xl bg-gray-50 hover:shadow transition">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-800">Phiên bản Khuyến mãi</span>
                            <span class="text-gray-500">2.200.000 VND</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Ưu đãi: Giảm 12% + bữa trưa miễn phí</p>
                    </div>

                </div>
            </div>

            <!-- Tab 3: Hình ảnh -->
            <div id="tab-images" class="tab-pane hidden">
                <h4 class="text-lg font-semibold text-gray-800">Bộ ảnh minh họa</h4>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-4">
                    <?php foreach ($dataTourImages as $value) { ?>
                        <img src="<?= $value['image_url'] ?>" alt="<?= $value['description'] ?>"
                            class="w-full h-32 object-cover rounded-lg shadow-sm">
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
<?php } ?>
<script>
    // Simple UI interactions (demo purposes)
    function openTourDetail(btn) {
        // find the closest article and extract data (demo static)
        const article = btn.closest('article');
        document.getElementById('detailTitle').innerText = article.querySelector('h4').innerText;
        document.getElementById('detailPrice').innerText = 'Giá cơ bản: ' + (article.querySelector('.font-semibold')?.innerText || '-');
        document.getElementById('detailThumb').src = article.querySelector('img').src.replace('80x60', '400x300');
        showTab('info');
    }

    function cloneTour(btn) {
        alert('Clone tour: chức năng demo — sẽ sao chép tour để tạo tour mới (thực hiện ở backend).');
    }

    function generateQuote(btn) {
        alert('Báo giá nhanh: mở form chọn số khách và xuất PDF/Email (demo).');
    }

    function showTab(name) {
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));
        document.getElementById('tab-' + name).classList.remove('hidden');
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        el.classList.add('hidden');
        el.classList.remove('flex');
    }

    function openEditBooking(id) {
        alert('Mở form chỉnh sửa cho ' + id + ' (demo).');
    }

    function changeStatus(id, status) {
        alert('Thay đổi trạng thái ' + id + ' -> ' + status + ' (demo).');
    }
</script>