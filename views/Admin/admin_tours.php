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
                                        class="w-full px-3 py-2 pl-9 border border-gray-300 rounded-lg text-sm
                                        focus:outline-none focus:ring-2 focus:ring-main transition" />

                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
                                </div>
                            </div>

                            <a href="?act=from_add_tour"
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

                                            <div class="mt-2 flex flex-wrap gap-2">
                                                <!-- Chi tiết -->
                                                <a href="?act=admintour&tour_id=<?= $value['id'] ?>"
                                                    class="clickloadAdmindetailtour text-xs px-2 py-1 rounded font-medium transition"
                                                    style="background-color:#1f55ad; color:#ffffff;"
                                                    onmouseover="this.style.backgroundColor='#0f2b90';"
                                                    onmouseout="this.style.backgroundColor='#1f55ad';">
                                                    Chi tiết
                                                </a>

                                                <!-- Clone -->
                                                <a href="#" onclick="cloneTour(this)"
                                                    class="text-xs px-2 py-1 rounded font-medium transition"
                                                    style="background-color:#5288e0; color:#ffffff;"
                                                    onmouseover="this.style.backgroundColor='#0f2b90';"
                                                    onmouseout="this.style.backgroundColor='#5288e0';">
                                                    Clone
                                                </a>

                                                <!-- Báo giá nhanh -->
                                                <a href="#" onclick="generateQuote(this)"
                                                    class="text-xs px-2 py-1 rounded font-medium transition"
                                                    style="background-color:#0f2b57; color:#ffffff;"
                                                    onmouseover="this.style.backgroundColor='#1f55ad';"
                                                    onmouseout="this.style.backgroundColor='#0f2b57';">
                                                    Báo giá nhanh
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            <?php } ?>

                        </div>
                    </div>

                    <div id="viewsdetailtour" class="flex-1 col-span-1 lg:col-span-2 bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                        <div class="mx-auto bg-white p-6 text-center py-auto">
                            <img
                                src="https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?q=80&w=800"
                                alt="Tour Placeholder"
                                class="w-full max-w-md h-60 object-cover rounded-lg mx-auto shadow-sm mb-5">

                            <h2 class="text-2xl font-semibold text-gray-800">Xem chi tiết tour</h2>

                            <p class="text-gray-600 mt-3 max-w-xl mx-auto">
                                Đây là khu vực hiển thị <b>nội dung chi tiết của từng tour</b> như lịch trình, hình ảnh, nhà cung cấp,
                                giá, phiên bản,...
                                Vui lòng chọn một tour ở danh sách bên trái để xem chi tiết tại đây.
                            </p>

                            <div class="mt-6">
                                <button
                                    class="px-4 py-2 bg-main text-white rounded-lg shadow hover:bg-hover transition">
                                    Chọn một tour để xem
                                </button>
                            </div>

                        </div>

                    </div>
                </section>

                <!-- Table -->
                <div class="overflow-x-auto bg-white border border-slate-200 rounded-lg shadow-sm">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-gray-50 text-gray-600 text-sm font-medium">
                            <tr>
                                <th class="px-4 py-2 text-left w-10">
                                    <input type="checkbox" class="h-4 w-4 border-gray-300 rounded" />
                                </th>
                                <th class="px-4 py-2 text-left w-12">ID</th>
                                <th class="px-4 py-2 text-left">Tên Tour</th>
                                <th class="px-4 py-2 text-left w-24">Mã Tour</th>
                                <th class="px-4 py-2 text-left w-28">Giá</th>
                                <th class="px-4 py-2 text-left w-28">Trạng thái</th>
                                <th class="px-4 py-2 text-right w-40">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-sm text-gray-700">
                            <?php if (empty($datatour)): ?>
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                        Không có tour nào trong hệ thống.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($datatour as $value): ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-2">
                                            <input type="checkbox" class="h-4 w-4 border-gray-300 rounded" />
                                        </td>
                                        <td class="px-4 py-2 font-medium"><?= $value['id'] ?></td>
                                        <td class="px-4 py-2"><?= $value['name'] ?></td>
                                        <td class="px-4 py-2"><?= $value['code'] ?></td>
                                        <td class="px-4 py-2"><?= number_format($value['price']) ?> VND</td>
                                        <td class="px-4 py-2"><?= $value['status'] == 'active' ? 'Đang diễn ra' : 'Đã kết thúc' ?></td>
                                        <td class="px-4 py-2 text-right space-x-1">
                                            <a href="?act=admintour&tour_id=<?= $value['id'] ?>"
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium border border-gray-300 rounded hover:bg-gray-100 transition">
                                                Chi tiết
                                            </a>

                                            <a href="#" onclick="cloneTour(this)"
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium border border-gray-300 rounded hover:bg-gray-100 transition">
                                                Clone
                                            </a>

                                            <a href="#" onclick="generateQuote(this)"
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium border border-gray-300 rounded hover:bg-gray-100 transition">
                                                Báo giá
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

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