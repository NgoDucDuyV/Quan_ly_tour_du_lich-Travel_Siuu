<div class="max-w-[1800px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Đối Tác Nhà cung cấp</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Nhà cung cấp</li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-semibold text-slate-900">Danh mục Tour</h1>
            <span class="inline-block bg-slate-100 text-slate-600 px-2 py-0.5 text-sm rounded-full">
                <?= count($datatour) ?>
            </span>
        </div>

        <div class="flex items-center space-x-3">
            <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-md text-sm text-slate-600 bg-white hover:bg-slate-50">
                Lọc
            </button>

            <a href="?act=from_add_tour" class="flex items-center gap-2 px-4 py-2 bg-white border border-indigo-600 text-indigo-600 rounded-md text-sm hover:bg-indigo-50">
                Tạo mới
            </a>
        </div>
    </div>
    <div class="min-h-screen flex mb-10">
        <!-- Main -->
        <main class="flex-1">
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Left: tour list / quick actions -->
                <div class="col-span-1 bg-white rounded-lg p-4 border border-gray-200 shadow-sm flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-800">Danh sách Tour</h3>
                        <div class="flex items-center gap-2">
                            <!-- Input tìm kiếm -->
                            <input
                                type="text"
                                id="searchTour"
                                placeholder="Tìm kiếm tour..."
                                class="px-3 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-main" />
                            <!-- Button tạo tour -->
                        </div>
                        <a href="?act=from_add_tour"
                            class="text-xs text-white bg-main hover:bg-hover px-3 py-1 rounded transition-colors"
                            id="btnCreateTour">
                            + Tạo tour
                        </a>
                    </div>


                    <div class="space-y-3 overflow-auto  scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 hide-scrollbar">
                        <!-- tour card -->
                        <?php foreach ($datatour as $value) { ?>
                            <article class="p-3 rounded-lg border hover:shadow-md transition-shadow bg-gray-50">
                                <div class="flex items-start gap-3">
                                    <img src="https://placehold.co/80x60" alt="thumb" class="w-20 h-14 object-cover rounded">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-medium text-gray-800"><?= $value['name'] ?></h4>
                                            <div class="text-sm text-gray-500">VN</div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Giá từ <span class="font-semibold text-gray-800"><?= number_format($value['price']) ?> VND</span></p>

                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <a href="?act=admintour&tour_id=<?= $value['id'] ?>" class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="openTourDetail(this)">Chi tiết</a>
                                            <a href="#" class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="cloneTour(this)">Clone</a>
                                            <a href="#" class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="generateQuote(this)">Báo giá nhanh</a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php } ?>

                        <!-- <article class="p-3 rounded-lg border hover:shadow-md transition-shadow bg-white">
                        <div class="flex items-start gap-3">
                            <img src="https://placehold.co/80x60" alt="thumb" class="w-20 h-14 object-cover rounded">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-medium text-gray-800">Tour Bali 5N4Đ - Quốc tế</h4>
                                    <div class="text-sm text-gray-500">INT</div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Giá từ <span class="font-semibold text-gray-800">7.800.000 đ</span></p>

                                <div class="mt-2 flex flex-wrap gap-2">
                                    <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="openTourDetail(this)">Chi tiết</button>
                                    <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="cloneTour(this)">Clone</button>
                                    <button class="text-xs px-2 py-1 border border-gray-200 rounded hover:bg-gray-100 transition" onclick="generateQuote(this)">Báo giá nhanh</button>
                                </div>
                            </div>
                        </div>
                    </article> -->
                    </div>
                </div>

                <!-- Center: tour detail & versions -->
                <div class="col-span-1 lg:col-span-2 bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                    <?php if (isset($dataTourDetai)) { ?>
                        <div id="tourDetailArea">
                            <div class="flex flex-col lg:flex-row items-start gap-4">
                                <img id="detailThumb" src="<?= BASE_URL . $dataOneTour['images'] ?>" alt="<?= $dataOneTour['name'] ?>" class="w-full lg:w-48 h-36 object-cover rounded shadow-sm">
                                <div class="flex-1">
                                    <h3 id="detailTitle" class="text-xl font-semibold text-gray-800">Chọn một tour để xem chi tiết</h3>
                                    <p id="detailPrice" class="text-gray-500 mt-1">Mã Tour: - <?= $dataOneTour['code'] ?></p>
                                    <h3 id="detailTitle" class="text-xl font-semibold text-gray-800">Tour : <?= $dataOneTour['name'] ?></h3>
                                    <p id="detailPrice" class="text-gray-500 mt-1">Giá cơ bản: - <?= number_format($dataOneTour['price']) ?>VND</p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <button class="px-3 py-1 border border-gray-200 rounded text-sm hover:bg-gray-100 transition" onclick="showTab('info')">Thông tin</button>
                                        <button class="px-3 py-1 border border-gray-200 rounded text-sm hover:bg-gray-100 transition" onclick="showTab('versions')">Phiên bản</button>
                                        <button class="px-3 py-1 border border-gray-200 rounded text-sm hover:bg-gray-100 transition" onclick="showTab('images')">Hình ảnh</button>
                                    </div>
                                </div>
                            </div>

                            <div id="tabs" class="mt-4">
                                <div id="tab-info" class="tab-pane">
                                    <h4 class="font-semibold text-gray-800">Lịch trình : <?= $dataOneTour['name'] ?></h4>
                                    <div class="mt-2 bg-gray-50 p-3 rounded border">
                                        <ul class="relative border-l border-gray-300">
                                            <?php if (!empty($dataTourDetai)) : ?>
                                                <ul class="relative border-l border-gray-300">
                                                    <?php
                                                    $currentDay = null;
                                                    foreach ($dataTourDetai as $item) :
                                                        // Nếu chuyển sang ngày mới
                                                        if ($currentDay !== $item['day_number']) :
                                                            if ($currentDay !== null) :
                                                                echo '</ul></div></li>'; // đóng ngày trước đó
                                                            endif;
                                                            $currentDay = $item['day_number'];
                                                    ?>
                                                            <li class="mb-10 ml-6">
                                                                <span class="absolute -left-3 top-1 bg-main w-6 h-6 rounded-full flex items-center justify-center text-white font-semibold">
                                                                    <?= $currentDay ?>
                                                                </span>
                                                                <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                                                                    <h4 class="font-semibold text-gray-800 mb-2">
                                                                        Ngày <?= $currentDay ?> - <?= htmlspecialchars($item['itinerary_title']) ?>
                                                                    </h4>
                                                                    <p class="text-gray-600 mb-2"><?= htmlspecialchars($item['itinerary_description']) ?></p>
                                                                    <ul class="space-y-1 text-gray-700 text-sm">
                                                                    <?php endif; ?>
                                                                    <li>
                                                                        <?= htmlspecialchars($item['activity_time']) ?> - <?= htmlspecialchars($item['activity']) ?> (<?= htmlspecialchars($item['location']) ?>): <?= htmlspecialchars($item['activity_description']) ?>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                </ul>
                                            <?php else: ?>
                                                <div class="bg-light text-dark p-4 rounded-lg shadow text-center">
                                                    Chưa có dữ liệu.
                                                    <button class="text-white bg-main hover:bg-hover px-3 py-1 rounded ml-2 transition-colors">Xem chi tiết tour</button>
                                                </div>
                                            <?php endif; ?>
                                        </ul>

                                    </div>

                                    <h4 class="mt-4 font-semibold text-gray-800">Chính sách</h4>
                                    <p class="text-sm text-gray-600 mt-2">Hủy sau 7 ngày trước ngày khởi hành mất 50% phí, hủy trong 3 ngày mất 100%...</p>

                                    <!-- nhà cung cap  -->
                                    <h4 class="mt-4 font-semibold text-gray-800">Nhà cung cấp</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                        <?php foreach ($dataTourSupplier as $value) { ?>
                                            <div class="supplier-item bg-gray-50 p-3 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">
                                                <span class="font-medium text-gray-800"><?= ucfirst($value['role']) ?>:</span>
                                                <span class="text-gray-600"><?= $value['supplier_name'] ?></span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div id="tab-versions" class="tab-pane hidden">
                                    <h4 class="font-semibold text-gray-800">Phiên bản tour</h4>
                                    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div class="p-3 border rounded hover:shadow-md transition">
                                            <div class="flex items-center justify-between">
                                                <div class="font-medium text-gray-800">Mùa Hè (Cao điểm)</div>
                                                <div class="text-sm text-gray-500">Giá:<?= number_format($dataOneTour['price']) ?>VND</div>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-2">Lịch trình: Thêm hoạt động biển</div>
                                        </div>
                                        <div class="p-3 border rounded hover:shadow-md transition">
                                            <div class="flex items-center justify-between">
                                                <div class="font-medium text-gray-800">Phiên bản Khuyến mãi</div>
                                                <div class="text-sm text-gray-500">Giá: 2.200.000 đ</div>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-2">Ưu đãi: Giảm 12% + bữa trưa miễn phí</div>
                                        </div>
                                    </div>
                                </div>

                                <div id="tab-images" class="tab-pane hidden">
                                    <h4 class="font-semibold text-gray-800">Bộ ảnh minh họa</h4>
                                    <div class="mt-3 grid grid-cols-2 sm:grid-cols-3 gap-2">
                                        <?php foreach ($dataTourImages as $value) { ?>
                                            <img src="<?= $value['image_url'] ?>" alt="<?= $value['description'] ?>" class="w-full h-28 object-cover rounded">
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="max-w-md mx-auto mt-6">
                            <div class="flex flex-col items-center justify-center border-l-4 border-main p-6 rounded-xl space-y-3">
                                <!-- Icon -->
                                <div class="w-12 h-12 flex items-center justify-center bg-main text-white rounded-full text-2xl">
                                    ⚠️
                                </div>

                                <!-- Thông báo -->
                                <p class="text-gray-800 text-center font-medium">
                                    Chưa có dữ liệu lịch trình cho tour này.
                                    Chọn tour để xem chi tiết
                                </p>

                                <!-- Nút xem chi tiết tour -->
                                <button class="px-4 py-2 bg-main text-white rounded-lg hover:bg-hover transition-colors font-semibold shadow-md">
                                    Xem chi tiết tour
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>


            <!-- Modal: New Booking -->
            <div id="modalNewBooking" class="fixed inset-0 hidden items-center justify-center bg-black/40">
                <div class="bg-white w-11/12 max-w-2xl p-4 rounded">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold">Tạo booking mới</h3>
                        <button onclick="closeModal('modalNewBooking')">✖</button>
                    </div>

                    <form id="formBooking" class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs">Tên khách</label>
                                <input name="customer" class="w-full p-2 border rounded text-sm" placeholder="Họ và tên" />
                            </div>
                            <div>
                                <label class="text-xs">Số điện thoại</label>
                                <input name="phone" class="w-full p-2 border rounded text-sm" placeholder="098..." />
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="text-xs">Chọn tour</label>
                                <select name="tour" class="w-full p-2 border rounded text-sm">
                                    <option value="HN-HL">Hà Nội - Hạ Long (3N2Đ)</option>
                                    <option value="BALI">Bali 5N4Đ</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs">Ngày khởi hành</label>
                                <input type="date" name="date" class="w-full p-2 border rounded text-sm" />
                            </div>
                            <div>
                                <label class="text-xs">Số khách</label>
                                <input type="number" name="qty" class="w-full p-2 border rounded text-sm" value="1" min="1" />
                            </div>
                        </div>

                        <div>
                            <label class="text-xs">Yêu cầu đặc biệt</label>
                            <textarea name="note" class="w-full p-2 border rounded text-sm" rows="3"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <button type="button" class="px-4 py-2 border rounded" onclick="closeModal('modalNewBooking')">Hủy</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Lưu & Xác nhận</button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- Table -->
            <div class="overflow-x-auto bg-white border border-slate-100 rounded-lg shadow-sm">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-slate-500 text-sm font-medium">
                        <tr>
                            <th class="px-6 py-3 text-left w-10">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                            </th>
                            <th class="px-6 py-3 text-left w-16">ID</th>
                            <th class="px-6 py-3 text-left">Tên Tour</th>
                            <th class="px-6 py-3 text-left">Mã Tour</th>
                            <th class="px-6 py-3 text-left">Danh mục</th>
                            <th class="px-6 py-3 text-left">Thời lượng</th>
                            <th class="px-6 py-3 text-left">Giá (VNĐ)</th>
                            <th class="px-6 py-3 text-left">Trạng thái</th>
                            <th class="px-6 py-3 text-left">Ngày tạo</th>
                            <th class="px-6 py-3 text-right w-36">Hành động</th>

                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        <?php if (empty($datatour)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-slate-500 text-center">
                                    Không có danh mục nào trong hệ thống.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($datatour as $value): ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                                    </td>
                                    <th class="px-6 py-3 text-left w-16"><?= $value['id'] ?></th>
                                    <th class="px-6 py-3 text-left"><?= $value['name'] ?></th>
                                    <th class="px-6 py-3 text-left"><?= $value['code'] ?></th>
                                    <th class="px-6 py-3 text-left"><?= $value['categoriesname'] ?></th>
                                    <th class="px-6 py-3 text-left"><?= $value['duration'] ?></th>
                                    <th class="px-6 py-3 text-left"><?= $value['price'] ?> (VNĐ)</th>
                                    <th class="px-6 py-3 text-left">Đang diễn ra</th>
                                    <th class="px-6 py-3 text-left"><?= $value['created_at'] ?></th>
                                    <th class="px-6 py-3 text-right w-40 space-x-1">
                                        <a href="?act=admintour&tour_id=<?= $value['id'] ?>"
                                            class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition">
                                            Chi tiết
                                        </a>
                                        <a href="#"
                                            onclick="cloneTour(this)"
                                            class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                                            Clone
                                        </a>
                                        <a href="#"
                                            onclick="generateQuote(this)"
                                            class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg hover:bg-emerald-100 transition">
                                            Báo giá
                                        </a>
                                    </th>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>

</div>




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

    document.getElementById('btnNewBooking').addEventListener('click', () => {
        document.getElementById('modalNewBooking').classList.remove('hidden');
        document.getElementById('modalNewBooking').classList.add('flex');
    });

    function closeModal(id) {
        const el = document.getElementById(id);
        el.classList.add('hidden');
        el.classList.remove('flex');
    }

    document.getElementById('formBooking').addEventListener('submit', function(e) {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(this).entries());
        // simple insert to table (demo only)
        const tbody = document.getElementById('bookingTable');
        const newId = 'BKG-' + String(Math.floor(Math.random() * 900 + 100));
        const tr = document.createElement('tr');
        tr.className = 'border-b hover:bg-slate-50';
        tr.innerHTML = `\n        <td class="p-2">${newId}</td>\n        <td class="p-2">${data.customer}</td>\n        <td class="p-2">${data.tour}</td>\n        <td class="p-2">${data.date}</td>\n        <td class="p-2">${data.qty}</td>\n        <td class="p-2"><span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">Chờ xác nhận</span></td>\n        <td class="p-2"><div class="flex gap-2">\n          <button class="text-xs px-2 py-1 border rounded" onclick="openEditBooking('${newId}')">Sửa</button>\n          <button class="text-xs px-2 py-1 border rounded" onclick="changeStatus('${newId}','Đã cọc')">Đã cọc</button>\n        </div></td>\n      `;
        tbody.prepend(tr);
        // update total
        document.getElementById('totalBookings').innerText = parseInt(document.getElementById('totalBookings').innerText) + 1;
        closeModal('modalNewBooking');
        alert('Booking được tạo (demo). Bạn có thể xuất báo giá hoặc gửi email ở bước tiếp theo.');
    });

    function openEditBooking(id) {
        alert('Mở form chỉnh sửa cho ' + id + ' (demo).');
    }

    function changeStatus(id, status) {
        alert('Thay đổi trạng thái ' + id + ' -> ' + status + ' (demo).');
    }
</script>