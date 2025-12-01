<div class="max-w-[1800px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý Tour</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Add Tour Mới</li>
        </ul>
    </nav>


    <form id="createTourfrom" action="?act=admin_createTour" method="POST" enctype="multipart/form-data" class="space-y-6">
        <!-- thông báo -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md border border-green-300 text-sm font-medium">
                <?= $_SESSION['success'] ?> <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md border border-red-300 text-sm font-medium">
                <?= $_SESSION['error'] ?> <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <!-- TABS HEADER -->
        <div class="sticky top-0 z-10">
            <nav class="flex gap-2 overflow-x-auto no-scrollbar px-4 py-2 border-b border-slate-200
                bg-transparent transition-colors duration-300
                [@supports(position:sticky)]:backdrop-blur-sm
                [@supports(position:sticky)]:bg-white/0
                scroll-smooth">
                <button type="button" data-tab="tab-info" class="tab-btn tab-active px-4 py-2 rounded-lg font-semibold text-gray-800 transition-colors duration-200">
                    Thông tin Tour
                </button>
                <button type="button" data-tab="tab-itinerary" class="tab-btn px-4 py-2 rounded-lg font-semibold text-gray-600 hover:text-main hover:bg-gray-100 transition-colors duration-200">
                    Lịch trình
                </button>
                <!-- <button type="button" data-tab="tab-activity" class="tab-btn px-4 py-2 rounded-lg font-semibold text-gray-600 hover:text-main hover:bg-gray-100 transition-colors duration-200">
                    Hoạt động
                </button> -->
                <button type="button" data-tab="tab-images" class="tab-btn px-4 py-2 rounded-lg font-semibold text-gray-600 hover:text-main hover:bg-gray-100 transition-colors duration-200">
                    Ảnh Tour
                </button>
                <button type="button" data-tab="tab-supplier" class="tab-btn px-4 py-2 rounded-lg font-semibold text-gray-600 hover:text-main hover:bg-gray-100 transition-colors duration-200">
                    Loại dịch vụ
                </button>
                <button type="button" data-tab="tab-version" class="tab-btn px-4 py-2 rounded-lg font-semibold text-gray-600 hover:text-main hover:bg-gray-100 transition-colors duration-200">
                    Phiên bản Giá
                </button>
                <button type="button" data-tab="tab-policy"
                    class="tab-btn px-4 py-2 rounded-lg font-semibold text-gray-600 hover:text-main hover:bg-gray-100 transition-colors duration-200">
                    Chính sách Tour
                </button>
            </nav>
        </div>

        <style>
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .tab-btn {
                padding: 10px 14px;
            }

            .tab-active {
                color: #1f55ad;
                border-bottom: 2px solid #1f55ad;
            }
        </style>


        <!-- ===================== TAB 1: THÔNG TIN TOUR ===================== -->
        <div id="tab-info" class="tab-content block">

            <div class="bg-white p-6 rounded-xl shadow-lg border border-slate-300">
                <h3 class="text-xl font-bold text-dark mb-4">Thông Tin Tour</h3>

                <div class="grid grid-cols-2 gap-4">

                    <input type="hidden" name="id" value="<?= $tour['id'] ?? '' ?>">

                    <div>
                        <label class="font-semibold text-gray-700">Tên Tour</label>
                        <input type="text" name="name" id="tourName" placeholder="Nhập tên tour"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Mã Tour</label>
                        <input type="text" name="code" id="tourCode" placeholder="Ví dụ: TOUR123"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Danh mục</label>
                        <select name="category_id" id="category_id"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?>(<?= $cat['total_tours'] ?> tour)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Thời lượng</label>
                        <div class="flex gap-2 mt-2">
                            <div class="flex-1">
                                <input type="number" name="days" min="1" placeholder="Số ngày" onchange="onchangeInputItinerary(this)"
                                    class="w-full p-3 rounded-lg border focus:ring-2 focus:ring-main focus:border-main transition" required>
                            </div>
                            <span class="flex items-center px-1 text-gray-600">ngày</span>
                            <div class="flex-1">
                                <input type="number" name="nights" min="0" placeholder="Số đêm"
                                    class="w-full p-3 rounded-lg border focus:ring-2 focus:ring-main focus:border-main transition" required>
                            </div>
                            <span class="flex items-center px-1 text-gray-600">đêm</span>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="font-semibold text-gray-700">Mô tả</label>
                        <textarea name="description" rows="4" placeholder="Nhập mô tả tour"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition resize-none" required></textarea>
                    </div>

                    <!-- <div class="md:col-span-2">
                        <label class="font-semibold text-gray-700">Chính sách</label>
                        <textarea name="policy" rows="3" placeholder="Nhập chính sách tour"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition resize-none" required></textarea>
                    </div> -->

                    <!-- Ảnh đại diện -->
                    <div class="md:col-span-2">
                        <label class="font-semibold text-gray-700">Ảnh đại diện</label>
                        <input type="file" name="image" accept="image/*"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition">
                    </div>

                    <!-- Lịch trình JSON -->
                    <!-- <div class="md:col-span-2">
                        <label class="font-semibold text-gray-700">Lịch trình (JSON)</label>
                        <textarea name="itinerary" rows="5" placeholder='Ví dụ: [{"day":1,"title":"Ngày 1"}]'
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition resize-none"></textarea>
                    </div> -->

                    <!-- Giá -->
                    <div>
                        <label class="font-semibold text-gray-700">Giá</label>
                        <input type="number" name="price" placeholder="Nhập giá tour"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <!-- Trạng thái -->
                    <div>
                        <label class="font-semibold text-gray-700">Trạng thái</label>
                        <select name="status"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                            <option value="active">Hoạt động</option>
                            <option value="inactive">Không hoạt động</option>
                        </select>
                    </div>

                </div>

            </div>

        </div>


        <!-- ===================== TAB 2: LỊCH TRÌNH TOUR ===================== -->
        <div id="tab-itinerary" class="tab-content hidden">

            <div class="bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-4">
                <h3 class="text-xl font-bold text-dark mb-4">Lịch Trình (Itinerary)</h3>

                <div id="itineraryWrap" class="space-y-4"></div>

                <button type="button" onclick="addItinerary()"
                    class="px-4 py-2 mt-5 bg-main text-white rounded-lg hover:bg-hover">
                    + Thêm ngày lịch trình
                </button>
            </div>

        </div>


        <!-- hoat dong -->
        <!-- <div id="tab-activity" class="tab-content hidden">

            <div class="bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-4">
                <h3 class="text-xl font-bold text-dark mb-4">Thêm Hoạt Động Cho Tour</h3>

                <div id="activityWrap" class="space-y-4"></div>

                <button type="button" onclick="addActivity()"
                    class="px-4 py-2 mt-5 bg-main text-white rounded-lg hover:bg-hover">
                    + Thêm hoạt động
                </button>
            </div>

        </div> -->


        <!-- abum tour  -->
        <div id="tab-images" class="tab-content hidden">

            <div class="bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-4">
                <h3 class="text-xl font-bold text-dark mb-4">Album Ảnh</h3>

                <div id="imageWrap" class="space-y-4"></div>

                <button type="button" onclick="addImage()"
                    class="px-4 py-2 bg-main mt-5 text-white rounded-lg hover:bg-hover">
                    + Thêm ảnh mới
                </button>
            </div>
        </div>


        <!-- nhà cung cấp -->
        <div id="tab-supplier" class="tab-content hidden">

            <div class="bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-4">
                <h3 class="text-xl font-bold text-dark mb-4">Chọn loại dịch vụ</h3>

                <div id="supplierWrap" class="space-y-4"></div>

                <button type="button" onclick="addSupplier()"
                    class="px-4 py-2 bg-main mt-5 text-white rounded-lg hover:bg-hover">
                    + Thêm loại dịch vụ
                </button>
            </div>

        </div>


        <!-- phiên bản giá -->
        <div id="tab-version" class="tab-content hidden">

            <div class="bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-4">
                <h3 class="text-xl font-bold text-dark mb-4">Phiên Bản Giá (tour_versions)</h3>

                <div id="versionWrap" class="space-y-4"></div>

                <button type="button" onclick="addVersion()"
                    class="px-4 py-2 bg-main mt-5 text-white rounded-lg hover:bg-hover">
                    + Thêm phiên bản giá
                </button>
            </div>
        </div>

        <!-- Chính sách tour -->
        <div id="tab-policy" class="tab-content hidden">
            <div class="bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-4">
                <h3 class="text-xl font-bold text-dark mb-4">Thêm Chính Sách Cho Tour</h3>

                <div id="policyWrap" class="space-y-4"></div>

                <button type="button" onclick="addPolicy()"
                    class="px-4 py-2 bg-main mt-5 text-white rounded-lg hover:bg-hover">
                    + Thêm chính sách
                </button>
            </div>
        </div>


        <div class="pt-6">
            <button type="submit" class="px-6 py-3 bg-main text-white rounded-lg hover:bg-hover text-lg font-semibold">
                Lưu Tour
            </button>
        </div>

    </form>

    <script>
        // TAB CHUYỂN ĐỔI
        const tabs = document.querySelectorAll(".tab-btn");
        const contents = document.querySelectorAll(".tab-content");

        tabs.forEach(btn => {
            btn.onclick = () => {
                tabs.forEach(t => t.classList.remove("tab-active"));
                btn.classList.add("tab-active");

                contents.forEach(c => c.classList.add("hidden"));
                const tabId = btn.dataset.tab;
                const content = document.getElementById(tabId);
                content.classList.remove("hidden");
            };
        });
        let day = 1;

        // Thêm ngày
        function addItinerary() {
            const wrap = document.getElementById("itineraryWrap");
            const dayNumber = day;

            wrap.insertAdjacentHTML("beforeend", `
                <div class="relative z-0 bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-6 group" data-day="${dayNumber}">
                    <button 
                        class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                        onclick="this.parentElement.remove()" 
                        title="Xóa ngày">
                        <i class="fas fa-times"></i>
                    </button>

                    <h3 class="text-xl font-bold text-dark mb-4 flex items-center gap-2">
                        <span>Ngày</span>
                        <input
                            onchange=""
                            type="number"
                            name="day_number[]" 
                            value="${dayNumber}"
                            required
                            min="1" 
                            class="w-20 p-1.5 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-main focus:border-main text-center">
                    </h3>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="font-semibold text-gray-700">Tiêu đề</label>
                            <input type="text" name="itinerary_title[]" placeholder="Nhập tiêu đề cho ngày này"
                                class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Mô tả</label>
                            <textarea name="itinerary_desc[]" rows="4" placeholder="Nhập mô tả chi tiết cho ngày này"
                                class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition resize-none" required></textarea>
                        </div>
                    </div>

                    <!-- wrap hoạt động riêng cho ngày này -->
                    <div id="activityWrap-${dayNumber}" class="space-y-4 mt-4"></div>

                    <button type="button" onclick="addActivity(${dayNumber})"
                        class="px-4 py-2 mt-5 bg-main text-white rounded-lg hover:bg-hover">
                        + Thêm hoạt động
                    </button>
                </div>
            `);
            day++;
        }

        // Thêm hoạt động vào ngày cụ thể
        function addActivity(dayNumber) {
            const wrap = document.getElementById(`activityWrap-${dayNumber}`);
            wrap.insertAdjacentHTML("beforeend", `
                <div class="relative z-0 bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-6 group">
                    <button 
                        class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                        onclick="this.parentElement.remove()" 
                        title="Xóa hoạt động">
                        <i class="fas fa-times"></i>
                    </button>

                    <!-- Ẩn ngày thực tế cho PHP gom dữ liệu -->
                    <input type="hidden" name="activity_day[]" value="${dayNumber}">

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="font-semibold text-gray-700">Tên hoạt động</label>
                            <input type="text" name="activity_name[]" placeholder="Nhập tên hoạt động"
                                class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Thời gian</label>
                            <input type="time" name="activity_time[]"
                                class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" 
                                required>
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Địa điểm</label>
                            <input type="text" name="activity_location[]" placeholder="Nhập địa điểm"
                                class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Mô tả</label>
                            <textarea name="activity_desc[]" rows="3" placeholder="Mô tả chi tiết hoạt động"
                                class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition resize-none" required></textarea>
                        </div>
                    </div>
                </div>
            `);
        }

        let image = 1;

        function addImage() {
            const wrap = document.getElementById("imageWrap");
            console.log(wrap);
            wrap.insertAdjacentHTML("beforeend", `
            <div class="relative z-0 bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-6 group">
                <button 
                    class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                    onclick="this.parentElement.remove()" 
                    title="Xóa ngày">
                    <i class="fas fa-times"></i>
                </button>
                <h3 class="text-xl font-bold text-dark mb-4">Ảnh Tour ${image}</h3>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Chọn ảnh -->
                    <div>
                        <label class="font-semibold text-gray-700">Chọn ảnh</label>
                        <input type="file" name="tour_images[]" 
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <!-- Mô tả ảnh -->
                    <div>
                        <label class="font-semibold text-gray-700">Mô tả ảnh</label>
                        <input type="text" name="image_desc[]" placeholder="Nhập mô tả ảnh"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <!-- Liên kết hoạt động / hành trình (nếu muốn chọn) -->
                </div>
            </div>
    `);
            image++;
        }

        let supplier = 1;

        const supplierTypes = <?php echo json_encode($datasupplier_types); ?>;

        function addSupplier() {
            const wrap = document.getElementById("supplierWrap");
            wrap.insertAdjacentHTML("beforeend", `
            <div class="relative z-0 bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-6 group">
                <!-- Nút Xóa -->
                <button 
                    class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                    onclick="this.parentElement.remove()"
                    title="Xóa">
                    <i class="fas fa-times"></i>
                </button>

                <h3 class="text-xl font-bold text-dark mb-4">Dịch vụ ${supplier}</h3>

                <!-- Chọn loại dịch vụ -->
                <div>
                    <label class="font-semibold text-gray-700">Chọn loại dịch vụ</label>
                    <select name="supplier_types_id[]" class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required onchange="showServiceDetail(this)">
                        <option value="">-- Chọn loại dịch vụ --</option>
                        <?php foreach ($datasupplier_types as $type): ?>
                            <option value="<?= $type['id'] ?>"><?= htmlspecialchars($type['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Chi tiết dịch vụ -->
                <div class="service-detail mt-3 p-4 bg-gradient-to-r from-blue-50 to-white rounded-xl border border-blue-200 shadow-sm hidden">
                    <h4 class="text-lg font-semibold text-blue-700 mb-2">Thông tin chi tiết</h4>
                    <div class="space-y-1">
                        <p><span class="font-semibold text-gray-700">Mô tả:</span> <span class="desc text-gray-600"></span></p>
                        <p><span class="font-semibold text-gray-700">Số sao:</span> 
                            <span class="stars text-yellow-500"></span> ⭐
                        </p>
                        <p><span class="font-semibold text-gray-700">Chất lượng:</span> <span class="quality text-green-600 font-medium"></span></p>
                    </div>
                </div>

                <!-- Ghi chú -->
                <div class="mt-3">
                    <label class="font-semibold text-gray-700">Ghi chú</label>
                    <input type="text" name="notes[]" placeholder="Nhập ghi chú nếu có"
                        class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition">
                </div>
            </div>
    `);
            supplier++;
        }

        function showServiceDetail(select) {
            const detailDiv = select.closest('div').nextElementSibling; // Lấy div chi tiết đúng
            const typeId = select.value;
            if (!typeId) {
                detailDiv.classList.add('hidden');
                return;
            }
            const type = supplierTypes.find(t => t.id == typeId);
            if (type) {
                detailDiv.querySelector('.desc').innerText = type.description;
                detailDiv.querySelector('.stars').innerText = type.stars;
                detailDiv.querySelector('.quality').innerText = type.quality;
                detailDiv.classList.remove('hidden');
            }
        }


        let version = 1;

        function addVersion() {
            const wrap = document.getElementById("versionWrap");
            wrap.insertAdjacentHTML("beforeend", `
        <div class="relative z-0 bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-6 group">
            <button 
                    class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                    onclick="this.parentElement.remove()" 
                    title="Xóa ngày">
                    <i class="fas fa-times"></i>
                </button>
            <h3 class="text-xl font-bold text-dark mb-4">Phiên bản ${version}</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Tên phiên bản -->
                <div>
                    <label class="font-semibold text-gray-700">Tên phiên bản</label>
                    <input type="text" name="version_name[]" placeholder="Nhập tên phiên bản"
                        class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                </div>

                <!-- Mùa -->
                <div>
                    <label class="font-semibold text-gray-700">Mùa</label>
                    <select name="version_season[]" 
                        class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                        <option value="high">high</option>
                        <option value="low">low</option>
                        <option value="promotion">promotion</option>
                        <option value="special">special</option>
                    </select>
                </div>

                <!-- Giá -->
                <div>
                    <label class="font-semibold text-gray-700">Giá</label>
                    <input type="number" name="version_price[]" placeholder="Nhập giá"
                        class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                </div>

                <!-- Ngày bắt đầu -->
                <div>
                    <label class="font-semibold text-gray-700">Ngày bắt đầu</label>
                    <input type="date" name="version_start[]" 
                        class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                </div>

                <!-- Ngày kết thúc -->
                <div>
                    <label class="font-semibold text-gray-700">Ngày kết thúc</label>
                    <input type="date" name="version_end[]" 
                        class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                </div>

                <!-- Trạng thái -->
                <div>
                    <label class="font-semibold text-gray-700">Trạng thái</label>
                    <select name="version_status[]" 
                        class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                    </select>
                </div>
            </div>
        </div>
    `);
            version++;
        }

        let policyCount = 1;

        function addPolicy() {
            const wrap = document.getElementById("policyWrap");
            wrap.insertAdjacentHTML("beforeend", `
            <div class="relative z-0 bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-6 group">
                <button 
                    class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                    onclick="this.parentElement.remove()" 
                    title="Xóa chính sách">
                    <i class="fas fa-times"></i>
                </button>
                <h3 class="text-xl font-bold text-dark mb-4">Chính sách ${policyCount}</h3>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Loại chính sách -->
                    <div>
                        <label class="font-semibold text-gray-700">Loại chính sách</label>
                        <input type="text" name="policy_type[]" placeholder="VD: Hủy tour, Đặt cọc..."
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <!-- Nội dung chính sách -->
                    <div>
                        <label class="font-semibold text-gray-700">Nội dung</label>
                        <textarea name="description[]" rows="3" placeholder="Nhập nội dung chi tiết"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required></textarea>
                    </div>
                </div>
            </div>
    `);
            policyCount++;
        }
        addItinerary();

        // function onchangeInputItinerary(el) {
        //     day = 1;
        //     console.log(el.value);
        //     for (let i = 1; i <= Number(el.value); i++) {
        //         addItinerary();
        //     }
        // }
        addActivity(1);
        addImage();
        addSupplier();
        addVersion();
        addPolicy();
    </script>
</div>