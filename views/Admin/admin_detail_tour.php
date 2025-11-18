<?php if (isset($dataTourDetai)) { ?>
    <div class="space-y-6">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row items-start gap-5 p-4 bg-white border rounded-xl shadow-xl">
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
        <div id="tabs" class="bg-white p-4 border rounded-xl shadow-xl">

            <!-- Tab 1: Thông tin -->
            <div id="tab-info" class="tab-pane">
                <h4 class="text-lg font-semibold text-gray-800">Lịch trình - <?= $dataOneTour['name'] ?></h4>

                <div class="mt-4 space-y-8">

                    <!-- Timeline lịch trình -->
                    <?php if (!empty($dataTourDetai)) : ?>
                        <div class="bg-white rounded-xl border shadow-sm p-5">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Lịch trình tour</h3>

                            <ul class="relative border-l-2 border-main/40 pl-6 space-y-10">

                                <?php
                                $currentDay = null;
                                foreach ($dataTourDetai as $item):
                                    if ($currentDay !== $item['day_number']):
                                        if ($currentDay !== null) echo "</ul></div></li>";
                                        $currentDay = $item['day_number'];
                                ?>

                                        <li class="relative">
                                            <span class="absolute -left-4 top-0 bg-main text-white w-10 h-10 rounded-full 
                                flex items-center justify-center font-bold shadow-md text-sm">
                                                <?= $currentDay ?>
                                            </span>

                                            <div class="bg-gray-50 border rounded-xl p-5 shadow-sm">
                                                <h5 class="text-gray-800 font-semibold text-base mb-1">
                                                    Ngày <?= $currentDay ?> – <?= htmlspecialchars($item['itinerary_title']) ?>
                                                </h5>

                                                <p class="text-gray-600 text-sm mb-3 leading-relaxed">
                                                    <?= htmlspecialchars($item['itinerary_description']) ?>
                                                </p>

                                                <ul class="space-y-2 text-sm text-gray-700">
                                                <?php endif; ?>

                                                <li class="flex items-start gap-2">
                                                    <span class="font-medium text-main"><?= htmlspecialchars($item['activity_time']) ?></span>
                                                    <div>
                                                        <span class="font-medium"><?= htmlspecialchars($item['activity']) ?></span>
                                                        — <span class="text-gray-700"><?= htmlspecialchars($item['location']) ?></span>
                                                        <div class="text-gray-600"><?= htmlspecialchars($item['activity_description']) ?></div>
                                                    </div>
                                                </li>

                                            <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </li>
                            </ul>
                        </div>

                    <?php else: ?>
                        <div class="text-center bg-gray-50 p-6 rounded-xl border shadow-sm">
                            <p class="text-gray-600">Chưa có dữ liệu lịch trình.</p>
                            <button class="mt-3 px-4 py-2 bg-main text-white rounded-lg hover:bg-hover transition">
                                Xem chi tiết tour
                            </button>
                        </div>
                    <?php endif; ?>


                    <!-- Chính sách -->
                    <div class="bg-white rounded-xl border shadow-sm p-5">
                        <h4 class="text-lg font-semibold text-gray-800">Chính sách</h4>
                        <p class="text-gray-600 text-sm mt-2 leading-relaxed">
                            Hủy sau 7 ngày trước ngày khởi hành mất 50%, hủy trong 3 ngày mất 100%...
                        </p>
                    </div>

                    <!-- Nhà cung cấp -->
                    <div class="bg-white rounded-xl border shadow-sm p-5">
                        <h4 class="text-lg font-semibold text-gray-800 mb-3">Nhà cung cấp</h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <?php foreach ($dataTourSupplier as $value) { ?>
                                <div class="p-4 bg-gray-50 border rounded-xl shadow-sm hover:shadow-md transition text-sm">
                                    <div class="font-semibold text-gray-800"><?= ucfirst($value['role']) ?>:</div>
                                    <div class="text-gray-600 mt-1"><?= $value['supplier_name'] ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
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