<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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
            <div class="flex items-center space-x-3 bg-">
                <h1 class="text-3xl font-[500] text-slate-900 m-0">Quản lý tour</h1>
                <span class="inline-flex items-center justify-center font-[500] text-white px-2 py-0.5 rounded-full bg-main">
                    <?= count($datatour) ?>
                </span>
            </div>

            <div class="flex items-center space-x-3">

                <a href="?act=admin_createTourfrom" class="flex items-center gap-2 px-4 py-2 rounded-md border-[1px_solid_main] text-sm font-[300] bg-main hover:bg-hover text-white transition-all duration-200 ease-out">
                    <i class="fa-solid fa-plus"></i>
                    Tạo mới
                </a>

                <button class="flex items-center gap-2 px-4 py-2 border rounded-md
                text-sm text-dark hover:bg-main hover:text-white transition-all duration-200 ease-out">
                    <i class="fa-solid fa-filter"></i>
                    Lọc
                </button>
            </div>
        </div>
        <div class="w-full mb-10">
            <main class="w-full">
                <section class="
                        flex 
                        flex-col 
                        md:flex-col md:justify-start 
                        lg:flex-row lg:justify-between w-full mb-10">
                    <div class="col-span-1 lg:mr-5 bg-white rounded-lg p-4 border border-gray-200 shadow-sm flex flex-col">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-5 gap-3">

                            <h3 class="text-lg font-semibold text-gray-800">
                                Danh sách Tour
                            </h3>

                            <div class="flex-1 flex sm:justify-center">
                                <div class="relative w-full max-w-xs">
                                    <input
                                        type="text"
                                        id="searchTour"
                                        placeholder="Tìm kiếm tour..."
                                        name="tour_name"
                                        class="w-full px-3 py-2 pl-9 border border-gray-300 rounded-lg text-sm
                                        focus:outline-none focus:ring-2 focus:ring-main transition" />
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
                                </div>
                            </div>

                            <a href="?act=admin_createTourfrom"
                                class="px-4 py-2 bg-main text-white text-sm rounded-lg shadow 
                                hover:bg-hover transition flex items-center gap-1">
                                <i class="fa fa-plus text-xs"></i>
                                Tạo tour
                            </a>

                        </div>


                        <div class="space-y-3 overflow-y-auto max-h-[800px] scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 hide-scrollbar">
                            <!-- danh sacsh tour -->
                            <?php foreach ($datatour as $value) { ?>
                                <article class="p-3 rounded-lg border hover:shadow-md transition-shadow bg-gray-50">
                                    <div class="flex items-start gap-3">
                                        <img src="<?= BASE_URL . $value['images'] ?> ?>" alt="thumb" class="w-20 h-14 object-cover rounded">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-medium text-gray-800"><?= $value['name'] ?></h4>
                                                <div class="text-sm text-gray-500">

                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Giá từ <span class="font-semibold text-gray-800"><?= number_format($value['price']) ?> VND</span></p>

                                            <div class="flex flex-wrap gap-2 pt-1">
                                                <button href="?act=admintour&tour_id=<?= $value['id'] ?>"
                                                    class="clickloadAdmindetailtour text-xs px-3 py-1.5 rounded-md bg-main text-white hover:bg-hover transition">
                                                    Chi tiết
                                                </button>
                                                <button onclick="cloneTour(this)"
                                                    class="text-xs px-3 py-1.5 rounded-md bg-accent text-white hover:bg-hover transition">
                                                    Clone
                                                </button>
                                                <a href="?act=newBooking&tour_id=<?= $value['id'] ?>" onclick="generateQuote(this)"
                                                    class="text-xs px-3 py-1.5 rounded-md bg-dark text-white hover:bg-hover transition">
                                                    Báo giá nhanh
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Dropdown -->
                                        <div class="relative group">
                                            <button class="py-1 px-2 rounded-lg text-slate-600 hover:bg-slate-200 transition">
                                                <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                                            </button>
                                            <div class="absolute right-0 mt-2 w-40 bg-white border rounded-md shadow-lg text-sm py-1
                                                    opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                                    transition-all duration-200 z-20 overflow-hidden">
                                                <a href="?act=admintour&tour_id=<?= $value['id'] ?>"
                                                    class="clickloadAdmindetailtour flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                                    <i class="fa-regular fa-eye w-5 mr-3"></i> Chi Tiết
                                                </a>

                                                <a href="?act=newBooking&tour_id=<?= $value['id'] ?>"
                                                    class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                                    <i class="fa-solid fa-plus w-5 mr-3"></i> tạo booking
                                                </a>

                                                <a href="?act=edittour&id=<?= $value['id'] ?>"
                                                    class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                                    <i class="fa-regular fa-pen-to-square w-5 mr-3"></i> Edit
                                                </a>
                                                <a href="?act=admin_deleteTour&tour_id=<?= $value['id'] ?>"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa ?')"
                                                    class="flex items-center px-3 py-2 text-red-600 hover:bg-red-50 transition">
                                                    <i class="fa-regular fa-trash-can w-5 mr-3"></i> Xóa bỏ
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            <?php } ?>

                        </div>
                    </div>

                    <div id="viewsdetailtour"
                        class="mt-5 md:mt-0 flex-1 col-span-1 lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-100 shadow-md">

                        <div class="mx-auto bg-white text-center">

                            <!-- Header image with gradient overlay -->
                            <div class="relative w-full max-w-3xl mx-auto">
                                <img src="https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?q=80&w=800"
                                    alt="Tour Placeholder"
                                    class="w-full h-64 object-cover rounded-2xl shadow">

                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent rounded-2xl"></div>

                                <h2 class="absolute bottom-4 left-4 text-3xl font-bold text-white drop-shadow">
                                    Chi tiết Tour
                                </h2>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-600 mt-6 max-w-2xl mx-auto leading-relaxed">
                                Đây là khu vực hiển thị <b>toàn bộ nội dung chi tiết của tour du lịch</b> như:
                                <span class="text-main font-semibold">lịch trình – hình ảnh – nhà cung cấp – giá – chính sách – phiên bản</span>.
                                Vui lòng chọn một tour trong danh sách để bắt đầu xem chi tiết.
                            </p>

                            <!-- Modern Icon Highlight Section -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-3xl mx-auto mt-8">

                                <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 shadow-sm">
                                    <div class="text-main text-3xl mb-2">
                                        <i class="fa-solid fa-map-marked-alt text-xl"></i>
                                    </div>
                                    <h3 class="font-semibold text-gray-800">Lịch trình rõ ràng</h3>
                                    <p class="text-gray-500 text-sm mt-1">Xem chi tiết từng ngày trong tour.</p>
                                </div>

                                <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 shadow-sm">
                                    <div class="text-main text-3xl mb-2">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                    <h3 class="font-semibold text-gray-800">Hình ảnh trực quan</h3>
                                    <p class="text-gray-500 text-sm mt-1">Xem ảnh thực tế hoặc ảnh minh hoạ.</p>
                                </div>

                                <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 shadow-sm">
                                    <div class="text-main text-3xl mb-2">
                                        <i class="fa-solid fa-boxes-packing"></i>
                                    </div>
                                    <h3 class="font-semibold text-gray-800">Nhà cung cấp uy tín</h3>
                                    <p class="text-gray-500 text-sm mt-1">Thông tin đơn vị tổ chức tour.</p>
                                </div>

                            </div>

                            <!-- Button -->
                            <div class="mt-8">
                                <button
                                    class="px-6 py-3 bg-main text-white rounded-xl shadow hover:bg-hover transition font-semibold">
                                    Chọn một tour để xem chi tiết
                                </button>
                            </div>

                        </div>
                    </div>

                </section>

                <!-- Table -->
                <div class="overflow-x-auto bg-white border border-slate-100 rounded-lg shadow-sm">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50 text-slate-500 text-sm font-medium">
                            <tr>
                                <th class="px-6 py-3 text-left w-10">
                                    <input type="checkbox" id="selectAllTours" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Tên Tour</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Mã Tour</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Giá</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Trạng thái</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase w-5">Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            <?php if (empty($datatour)): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-xs font-medium text-slate-500 uppercase">
                                        Không có tour nào trong hệ thống.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($datatour as $value): ?>
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-3 text-left w-10">
                                            <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                                        </td>

                                        <td class="px-6 py-4 font-medium text-slate-900">#<?= $value['id'] ?></td>

                                        <td class="px-6 py-4 font-medium text-slate-900">
                                            <?= htmlspecialchars($value['name']) ?>
                                        </td>

                                        <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($value['code']) ?></td>

                                        <td class="px-6 py-4 text-slate-600"><?= number_format($value['price']) ?> VND</td>

                                        <td class="px-6 py-4 text-slate-500">
                                            <?= $value['status'] == 'active' ? 'Đang diễn ra' : 'Đã kết thúc' ?>
                                        </td>

                                        <td class="px-6 py-4 text-center relative flex justify-end group">

                                            <button class="py-1 px-2 flex items-center justify-center rounded-lg text-slate-600 
                                                hover:bg-slate-200 transition duration-150 focus:outline-none">
                                                <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                                            </button>

                                            <div class="absolute right-0 top-0 mt-2 w-40 bg-white border border-slate-200 
                                                rounded-md shadow-lg text-sm py-1 
                                                opacity-0 invisible 
                                                group-hover:opacity-100 group-hover:visible 
                                                transition-all duration-200 z-20 overflow-hidden">

                                                <a href="?act=admintour&tour_id=<?= $value['id'] ?>"
                                                    class="clickloadAdmindetailtour flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                                    <i class="fa-regular fa-eye w-5 mr-3"></i> Chi Tiết
                                                </a>

                                                <a href="?act=newBooking&tour_id=<?= $value['id'] ?>"
                                                    class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                                    <i class="fa-solid fa-plus w-5 mr-3"></i> tạo booking
                                                </a>

                                                <a href="?act=edittour&id=<?= $value['id'] ?>"
                                                    class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                                    <i class="fa-regular fa-pen-to-square w-5 mr-3"></i> Edit
                                                </a>

                                                <a href="?act=admin_deleteTour&tour_id=<?= $value['id'] ?>"
                                                    onclick=" return confirm('Bạn có chắc chắn muốn xóa ?')"
                                                    class=" flex items-center px-3 py-2 text-red-600 hover:bg-red-50 transition">
                                                    <i class="fa-regular fa-trash-can w-5 mr-3"></i> Xóa bỏ
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- JS chọn tất cả tour -->
                <script>
                    document.getElementById('selectAllTours').addEventListener('change', function() {
                        document.querySelectorAll('tbody input[type="checkbox"]').forEach(cb => cb.checked = this.checked);
                    });
                </script>


            </main>
        </div>
    </div>
    <script src="<?= BASE_URL ?>assets\Js\admin\admin_tours.js"></script>
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
</body>

</html>