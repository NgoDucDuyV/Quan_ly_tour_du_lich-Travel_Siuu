<div class="max-w-[1800px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý Tour</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Add Tour Mới</li>
        </ul>
    </nav>


    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-semibold mb-6">Thêm Tour Mới</h2>
        <form action="add_tour.php" method="post" enctype="multipart/form-data">
            <!-- Chọn danh mục -->
            <div class="mb-4">
                <label class="block mb-2 font-medium">Danh mục</label>
                <select name="category_id" class="w-full border rounded p-2">
                    <?php
                    // Kết nối DB và lấy categories
                    $conn = new mysqli("localhost", "root", "", "travel_siuu");
                    $categories = $conn->query("SELECT id, name FROM categories");
                    while ($cat = $categories->fetch_assoc()) {
                        echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Tên Tour -->
            <div class="mb-4">
                <label class="block mb-2 font-medium">Tên Tour</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>

            <!-- Mã Tour -->
            <div class="mb-4">
                <label class="block mb-2 font-medium">Mã Tour</label>
                <input type="text" name="code" class="w-full border rounded p-2" required>
            </div>

            <!-- Thời lượng -->
            <div class="mb-4">
                <label class="block mb-2 font-medium">Thời lượng</label>
                <input type="text" name="duration" class="w-full border rounded p-2">
            </div>

            <!-- Giá Tour -->
            <div class="mb-4">
                <label class="block mb-2 font-medium">Giá</label>
                <input type="number" name="price" class="w-full border rounded p-2" step="1000">
            </div>

            <!-- Mô tả -->
            <div class="mb-4">
                <label class="block mb-2 font-medium">Mô tả</label>
                <textarea name="description" class="w-full border rounded p-2" rows="4"></textarea>
            </div>

            <!-- Ảnh Tour -->
            <div class="mb-4">
                <label class="block mb-2 font-medium">URL Ảnh</label>
                <input type="text" name="images" class="w-full border rounded p-2" placeholder="https://example.com/image.jpg">
            </div>

            <!-- Chính sách -->
            <div class="mb-4">
                <label class="block mb-2 font-medium">Chính sách</label>
                <textarea name="policy" class="w-full border rounded p-2" rows="3"></textarea>
            </div>

            <!-- Trạng thái -->
            <div class="mb-4">
                <label class="block mb-2 font-medium">Trạng thái</label>
                <select name="status" class="w-full border rounded p-2">
                    <option value="active">Hoạt động</option>
                    <option value="inactive">Không hoạt động</option>
                </select>
            </div>

            <button type="submit" class="bg-main text-white px-4 py-2 rounded hover:bg-dark">Thêm Tour</button>
        </form>
    </div>
</div>