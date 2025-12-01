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
                    <button data-tab="info"
                        class="btnshow_tab px-3 py-1.5 text-sm border rounded-lg hover:bg-gray-100 transition">
                        Thông tin
                    </button>
                    <button data-tab="versions"
                        class="btnshow_tab px-3 py-1.5 text-sm border rounded-lg hover:bg-gray-100 transition">
                        Phiên bản
                    </button>
                    <button data-tab="images"
                        class="btnshow_tab px-3 py-1.5 text-sm border rounded-lg hover:bg-gray-100 transition">
                        Hình ảnh
                    </button>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div id="tabs" class="bg-white p-4 border rounded-xl shadow-xl">

            <div id="tab-info" class="tab-pane">
                <h4 class="text-lg font-semibold text-gray-800">Lịch trình - <?= $dataOneTour['name'] ?></h4>

                <div class="mt-4 space-y-8">

                    <!-- Timeline lịch trình -->
                    <div class="bg-white rounded-xl border shadow-sm p-6 mt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6">Lịch trình tour</h3>

                        <?php if (!empty($dataTourDetai)) : ?>
                            <?php
                            $groupedData = [];
                            // Nhóm dữ liệu theo day_number
                            foreach ($dataTourDetai as $item) {
                                $day = $item['day_number'];
                                $groupedData[$day][] = $item;
                            }
                            ?>

                            <?php foreach ($groupedData as $dayNumber => $activities) :
                                $firstItem = $activities[0]; // Lấy thông tin title, description chung của ngày
                            ?>
                                <div class="border border-gray-200 rounded-xl overflow-hidden mb-4">
                                    <button type="button"
                                        class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 transition focus:outline-none"
                                        onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180');">
                                        <div class="flex items-center gap-4">
                                            <span class="bg-main text-white w-10 h-10 flex items-center justify-center rounded-full font-bold shadow-md">
                                                <?= $dayNumber ?>
                                            </span>
                                            <span class="text-gray-800 font-medium text-base">
                                                <?= htmlspecialchars($firstItem['itinerary_title']) ?>
                                            </span>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <!-- Nội dung ngày -->
                                    <div class="p-4 text-gray-600 text-sm sm:text-base hidden">
                                        <?php if (!empty($firstItem['itinerary_description'])): ?>
                                            <p class="mb-4"><?= htmlspecialchars($firstItem['itinerary_description']) ?></p>
                                        <?php endif; ?>

                                        <ul class="space-y-3">
                                            <?php foreach ($activities as $act): ?>
                                                <li class="flex items-start gap-3">
                                                    <span class="flex-shrink-0 text-main font-medium w-16">
                                                        <?= htmlspecialchars($act['activity_time']) ?>
                                                    </span>
                                                    <div>
                                                        <span class="font-medium text-gray-800"><?= htmlspecialchars($act['activity']) ?></span>
                                                        <?php if (!empty($act['location'])): ?>
                                                            — <span class="text-gray-600"><?= htmlspecialchars($act['location']) ?></span>
                                                        <?php endif; ?>
                                                        <?php if (!empty($act['activity_description'])): ?>
                                                            <div class="text-gray-500 text-sm mt-1"><?= htmlspecialchars($act['activity_description']) ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <div class="text-center bg-gray-50 p-6 rounded-xl border shadow-sm mt-6">
                                <p class="text-gray-600">Chưa có dữ liệu lịch trình.</p>
                                <button class="mt-3 px-5 py-2 bg-main text-white rounded-lg hover:bg-hover transition">
                                    Xem chi tiết tour
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Chính sách Tour -->
                    <div class="bg-white rounded-xl border shadow-sm p-5 mt-6">
                        <h4 class="text-xl font-semibold text-gray-800 mb-5">Chính sách tour</h4>

                        <?php if (!empty($dataTourPolicies)): ?>
                            <div class="space-y-3">
                                <?php foreach ($dataTourPolicies as $policy): ?>
                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                        <!-- Header clickable -->
                                        <button type="button"
                                            class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 transition focus:outline-none"
                                            onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-180');">
                                            <span class="text-gray-800 font-medium text-sm sm:text-base">
                                                <?= htmlspecialchars($policy['policy_type']) ?>
                                            </span>
                                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <!-- Nội dung -->
                                        <div class="p-4 text-gray-600 text-sm sm:text-base hidden">
                                            <?= htmlspecialchars($policy['description']) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-sm">Chưa có chính sách cho tour này.</p>
                        <?php endif; ?>
                    </div>


                    <!-- Nhà cung cấp / Dịch vụ Tour -->
                    <div class="bg-white rounded-xl border shadow-sm p-5">
                        <h4 class="text-lg font-semibold text-gray-800 mb-3">Nhà cung cấp / Dịch vụ</h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <?php foreach ($dataTourSupplier as $value) { ?>
                                <div class="p-4 bg-gray-50 border rounded-xl shadow-sm hover:shadow-md transition text-sm">

                                    <!-- Tên dịch vụ -->
                                    <div class="font-semibold text-gray-800 mb-1"><?= htmlspecialchars($value['name']) ?></div>

                                    <!-- Mô tả -->
                                    <div class="text-gray-600 mb-2"><?= htmlspecialchars($value['description']) ?></div>

                                    <!-- Stars -->
                                    <div class="flex items-center mb-1">
                                        <span class="text-yellow-500 mr-2">
                                            <?php for ($i = 0; $i < $value['stars']; $i++) { ?>
                                                ★
                                            <?php } ?>
                                            <?php for ($i = $value['stars']; $i < 5; $i++) { ?>
                                                ☆
                                            <?php } ?>
                                        </span>
                                        <span class="text-gray-500 text-xs"><?= $value['stars'] ?>/5</span>
                                    </div>

                                    <!-- Chất lượng -->
                                    <div class="text-gray-700 text-sm mb-1"><strong>Chất lượng:</strong> <?= htmlspecialchars($value['quality']) ?></div>

                                    <!-- Thời gian tạo / cập nhật -->
                                    <div class="text-gray-400 text-xs">
                                        <div>Ngày tạo: <?= $value['created_at'] ?></div>
                                        <div>Cập nhật: <?= $value['updated_at'] ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Tab 2: Phiên bản -->
            <div id="tab-versions" class="tab-pane hidden">

                <h4 class="text-xl font-semibold text-gray-800 mb-4">Phiên bản Tour</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <?php foreach ($dataTourVersions as $ver): ?>

                        <div class="border rounded-lg bg-white p-4 shadow-sm hover:shadow-md transition">

                            <!-- Tên phiên bản -->
                            <div class="flex justify-between items-center mb-3">
                                <span class="font-semibold text-gray-800 text-base">
                                    <?= htmlspecialchars($ver['name']) ?>
                                </span>

                                <!-- Season -->
                                <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-600 border">
                                    <?= ucfirst($ver['season']) ?>
                                </span>
                            </div>

                            <!-- Giá -->
                            <div class="mb-2 flex justify-between">
                                <span class="text-gray-600">Giá:</span>
                                <span class="font-semibold text-gray-800">
                                    <?= number_format($ver['price']) ?> VND
                                </span>
                            </div>

                            <!-- Ngày -->
                            <div class="mb-2 flex justify-between">
                                <span class="text-gray-600">Thời gian:</span>
                                <span class="text-gray-700">
                                    <?= $ver['start_date'] ?> → <?= $ver['end_date'] ?>
                                </span>
                            </div>

                            <!-- Status -->
                            <div class="flex justify-between">
                                <span class="text-gray-600">Trạng thái:</span>
                                <span class="px-2 py-1 rounded text-xs 
                        <?= $ver['status'] == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' ?>">
                                    <?= ucfirst($ver['status']) ?>
                                </span>
                            </div>

                        </div>

                    <?php endforeach; ?>

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