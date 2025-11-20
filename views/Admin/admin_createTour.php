<div class="max-w-[1800px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý Tour</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Add Tour Mới</li>
        </ul>
    </nav>


    <form id="createTourfrom" action="" method="POST" enctype="multipart/form-data" class="space-y-6">
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
        <div class="sticky top-0 z-5">
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
                <button type="button" data-tab="tab-activity" class="tab-btn px-4 py-2 rounded-lg font-semibold text-gray-600 hover:text-main hover:bg-gray-100 transition-colors duration-200">
                    Hoạt động
                </button>
                <button type="button" data-tab="tab-images" class="tab-btn px-4 py-2 rounded-lg font-semibold text-gray-600 hover:text-main hover:bg-gray-100 transition-colors duration-200">
                    Ảnh Tour
                </button>
                <button type="button" data-tab="tab-supplier" class="tab-btn px-4 py-2 rounded-lg font-semibold text-gray-600 hover:text-main hover:bg-gray-100 transition-colors duration-200">
                    Nhà cung cấp
                </button>
                <button type="button" data-tab="tab-version" class="tab-btn px-4 py-2 rounded-lg font-semibold text-gray-600 hover:text-main hover:bg-gray-100 transition-colors duration-200">
                    Phiên bản Giá
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
                    <!-- Tên Tour -->
                    <div>
                        <label class="font-semibold text-gray-700">Tên Tour</label>
                        <input type="text" name="name" placeholder="Nhập tên tour"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <!-- Mã Tour -->
                    <div>
                        <label class="font-semibold text-gray-700">Mã Tour</label>
                        <input type="text" name="code" placeholder="Ví dụ: TOUR123"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <!-- Danh mục -->
                    <div>
                        <label class="font-semibold text-gray-700">Danh mục</label>
                        <select name="category_id"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition"
                            required>
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
                                <input type="number" name="days" min="1" placeholder="Số ngày"
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

                    <!-- Mô tả -->
                    <div class="md:col-span-2">
                        <label class="font-semibold text-gray-700">Mô tả</label>
                        <textarea name="description" rows="4" placeholder="Nhập mô tả tour"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition resize-none" required></textarea>
                    </div>

                    <!-- Chính sách -->
                    <div class="md:col-span-2">
                        <label class="font-semibold text-gray-700">Chính sách</label>
                        <textarea name="policy" rows="3" placeholder="Nhập chính sách tour"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition resize-none" required></textarea>
                    </div>

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
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition"
                            required>
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


        <!-- ===================== TAB 3: HOẠT ĐỘNG ===================== -->
        <div id="tab-activity" class="tab-content hidden">

            <div class="bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-4">
                <h3 class="text-xl font-bold text-dark mb-4">Thêm Hoạt Động Cho Tour</h3>

                <div id="activityWrap" class="space-y-4"></div>

                <button type="button" onclick="addActivity()"
                    class="px-4 py-2 mt-5 bg-main text-white rounded-lg hover:bg-hover">
                    + Thêm hoạt động
                </button>
            </div>

        </div>


        <!-- ===================== TAB 4: ẢNH TOUR ===================== -->
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


        <!-- ===================== TAB 5: NHÀ CUNG CẤP ===================== -->
        <div id="tab-supplier" class="tab-content hidden">

            <div class="bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-4">
                <h3 class="text-xl font-bold text-dark mb-4">Thêm Nhà Cung Cấp Cho Tour</h3>

                <div id="supplierWrap" class="space-y-4"></div>

                <button type="button" onclick="addSupplier()"
                    class="px-4 py-2 bg-main mt-5 text-white rounded-lg hover:bg-hover">
                    + Thêm nhà cung cấp
                </button>
            </div>

        </div>


        <!-- ===================== TAB 6: PHIÊN BẢN GIÁ ===================== -->
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

        // Flags để kiểm tra lần đầu mở tab
        let init = {
            itinerary: false,
            activity: false,
            image: false,
            supplier: false,
            version: false
        };

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

        function addItinerary() {
            const wrap = document.getElementById("itineraryWrap");
            wrap.insertAdjacentHTML("beforeend", `
            <div class="relative bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-6 group">
                <button 
                    class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                    onclick="this.parentElement.remove()" 
                    title="Xóa ngày">
                    <i class="fas fa-times"></i>
                </button>

                <h3 class="text-xl font-bold text-dark mb-4 flex items-center gap-2">
                    <span>Ngày</span>
                    <input 
                        type="number" 
                        name="day_number[]" 
                        value="${day}" 
                        required
                        min="1" 
                        class="w-20 p-1.5 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-main focus:border-main text-center">
                </h3>
                <input type="hidden" name="day_number[]" value="${day}" required>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Tiêu đề -->
                    <div>
                        <label class="font-semibold text-gray-700">Tiêu đề</label>
                        <input type="text" name="itinerary_title[]" placeholder="Nhập tiêu đề cho ngày này"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <!-- Mô tả -->
                    <div>
                        <label class="font-semibold text-gray-700">Mô tả</label>
                        <textarea name="itinerary_desc[]" rows="4" placeholder="Nhập mô tả chi tiết cho ngày này"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition resize-none" required></textarea>
                    </div>
                </div>
                <div id="activityWrap" class="space-y-4"></div>

                <button type="button" onclick="addActivity()"
                    class="px-4 py-2 mt-5 bg-main text-white rounded-lg hover:bg-hover">
                    + Thêm hoạt động
                </button>
            </div>
    `);
            day++;
        }

        let activity = 1;
        const handleDayChange = (el) => {
            activity = Number(el.value) + 1;
        }

        function addActivity() {
            const wrap = document.getElementById("activityWrap");
            wrap.insertAdjacentHTML("beforeend", `
            <div class="relative bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-6 group">
                <button 
                    class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                    onclick="this.parentElement.remove()" 
                    title="Xóa ngày">
                    <i class="fas fa-times"></i>
                </button>
                <h3 class="text-xl font-bold text-dark mb-4 flex items-center gap-2">
                    <span>Hoạt động </span>
                    <input
                        onchange="handleDayChange(this)"
                        type="number" 
                        name="day_number[]" 
                        value="${activity}" 
                        required
                        min="1" 
                        class="w-20 p-1.5 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-main focus:border-main text-center">
                </h3>
                
                <div class="grid grid-cols-1 gap-4">
                    <!-- Tên hoạt động -->
                    <div>
                        <label class="font-semibold text-gray-700">Tên hoạt động</label>
                        <input type="text" name="activity_name[]" placeholder="Nhập tên hoạt động"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <!-- Thời gian -->
                    <div>
                        <label class="font-semibold text-gray-700">Thời gian</label>
                        <input type="text" name="activity_time[]" placeholder="Ví dụ: 08:00 - 10:00"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <!-- Địa điểm -->
                    <div>
                        <label class="font-semibold text-gray-700">Địa điểm</label>
                        <input type="text" name="activity_location[]" placeholder="Nhập địa điểm"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>

                    <!-- Mô tả -->
                    <div>
                        <label class="font-semibold text-gray-700">Mô tả</label>
                        <textarea name="activity_desc[]" rows="3" placeholder="Mô tả chi tiết hoạt động"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition resize-none" required></textarea>
                    </div>
                </div>
            </div>
    `);
            activity++;
        }

        let image = 1;

        function addImage() {
            const wrap = document.getElementById("imageWrap");
            wrap.insertAdjacentHTML("beforeend", `
            <div class="relative bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-6 group">
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
                    <div>
                        <label class="font-semibold text-gray-700">Liên kết</label>
                        <select name="image_link[]" class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                            <option value="">-- Chọn liên kết hoạt động/hành trình (nếu có) --</option>
                            <!-- Tự load activity / itinerary -->
                        </select>
                    </div>
                </div>
            </div>
    `);
            image++;
        }

        let supplier = 1;

        function addSupplier() {
            const wrap = document.getElementById("supplierWrap");
            wrap.insertAdjacentHTML("beforeend", `
            <div class="relative bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-6 group">
                <button 
                    class="absolute top-[-10px] left-[-10px] w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-800 shadow-xl hover:bg-red-500 hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100"
                    onclick="this.parentElement.remove()" 
                    title="Xóa ngày">
                    <i class="fas fa-times"></i>
                </button>
                <h3 class="text-xl font-bold text-dark mb-4">Nhà cung cấp ${supplier}</h3>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Chọn nhà cung cấp -->
                    <div>
                        <label class="font-semibold text-gray-700">Chọn nhà cung cấp</label>
                        <select name="supplier_id[]" 
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                            <option>-- Chọn nhà cung cấp --</option>
                            <!-- Load từ DB -->
                        </select>
                    </div>

                    <!-- Vai trò -->
                    <div>
                        <label class="font-semibold text-gray-700">Vai trò</label>
                        <select name="supplier_role[]" 
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                            <option>khách sạn</option>
                            <option>xe</option>
                            <option>nhà hàng</option>
                            <option>dịch vụ khác</option>
                        </select>
                    </div>

                    <!-- Ghi chú -->
                    <div>
                        <label class="font-semibold text-gray-700">Ghi chú</label>
                        <input type="text" name="supplier_notes[]" placeholder="Nhập ghi chú nếu có"
                            class="mt-2 w-full p-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-main focus:border-main transition" required>
                    </div>
                </div>
            </div>
    `);
            supplier++;
        }

        let version = 1;

        function addVersion() {
            const wrap = document.getElementById("versionWrap");
            wrap.insertAdjacentHTML("beforeend", `
        <div class="relative bg-white p-6 rounded-xl shadow-lg border border-slate-300 mt-6 group">
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
        addItinerary();
        addActivity();
        addImage();
        addSupplier();
        addVersion();
    </script>
</div>