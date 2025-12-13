<div class="max-w-[1800px] mx-auto p-6">

    <nav class="text-sm text-slate-800 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Bảng điều khiển</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-500">Danh mục Tour</li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <h1 class="text-3xl font-[500] text-slate-900 m-0">Danh mục Tour</h1>
            <span
                class="inline-flex items-center justify-center font-[500] text-white px-2 py-0.5 rounded-full bg-main">
                <?= count($categories) ?>
            </span>
        </div>

        <div class="flex items-center space-x-3">

            <!-- TẠO MỚI -->
            <button type="button"
                class="flex items-center gap-2 px-4 py-2 rounded-md text-sm font-[300] bg-main hover:bg-hover text-white transition-all duration-200 ease-out btn-open-add-category">
                <i class="fa-solid fa-plus"></i>
                Tạo mới
            </button>

            <button class="flex items-center gap-2 px-4 py-2 border rounded-md
                text-sm text-dark hover:bg-main hover:text-white transition-all duration-200 ease-out">
                <i class="fa-solid fa-filter"></i>
                Lọc
            </button>
        </div>
    </div>

    <!-- Thông báo -->
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="mb-4 px-4 py-2 rounded-md bg-red-50 text-red-700 text-sm">
            <?= $_SESSION['error'];
            unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="mb-4 px-4 py-2 rounded-md bg-emerald-50 text-emerald-700 text-sm">
            <?= $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Table -->
    <div class="overflow-x-auto bg-white border border-slate-100 rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50 text-slate-500 text-sm font-medium">
                <tr>
                    <th class="px-6 py-3 text-left w-10">
                        <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Tên danh mục</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Mô tả</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Số tour</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Cập nhật</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase w-5">Hành động</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-xs font-medium text-slate-500 uppercase">
                            Không có danh mục nào trong hệ thống.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $value): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-3 text-left w-10">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                            </td>

                            <td class="px-6 py-4">#<?= $value['id'] ?></td>

                            <td class="px-6 py-4 font-medium text-slate-900">
                                <?= $value['name'] ?>
                            </td>

                            <td class="px-6 py-4 truncate max-w-xs text-slate-600">
                                <?= $value['description'] ?>
                            </td>

                            <td class="px-6 py-4"><?= $value['total_tours'] ?></td>

                            <td class="px-6 py-4 text-left text-slate-500">
                                <?= $value['updated_at'] ?>
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

                                    <!-- SỬA -->
                                    <button type="button"
                                        class="w-full text-left flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition btn-open-edit-category"
                                        data-id="<?= $value['id'] ?>" data-name="<?= htmlspecialchars($value['name']) ?>"
                                        data-description="<?= htmlspecialchars($value['description']) ?>">
                                        <i class="fa-regular fa-pen-to-square w-5 mr-3"></i> Sửa
                                    </button>

                                    <!-- XÓA -->
                                    <a href="<?= BASE_URL ?>?mode=admin&act=category_delete&id=<?= $value['id'] ?>"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa ?')"
                                        class="flex items-center px-3 py-2 text-red-600 hover:bg-red-50 transition">
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
</div>

<!-- ================= MODAL THÊM ================= -->
<div id="modalAddCategory" class="fixed inset-0 z-50 hidden">
    <div id="overlayAddCategory" class="absolute inset-0 bg-black/40"></div>

    <div class="relative max-w-xl mx-auto mt-20 bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-slate-900">Thêm danh mục</h2>
            <button type="button" class="text-slate-500 hover:text-slate-700 btn-close-add-category">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form action="<?= BASE_URL ?>?mode=admin&act=category_store" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tên danh mục *</label>
                <input type="text" name="name" required class="w-full rounded-md border px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Mô tả</label>
                <textarea name="description" rows="3" class="w-full rounded-md border px-3 py-2 text-sm"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button"
                    class="px-4 py-2 text-sm rounded-md border text-slate-600 hover:bg-slate-50 btn-close-add-category">
                    Hủy
                </button>
                <button type="submit" class="px-4 py-2 text-sm rounded-md bg-main text-white">
                    Tạo mới
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL SỬA ================= -->
<div id="modalEditCategory" class="fixed inset-0 z-50 hidden">
    <div id="overlayEditCategory" class="absolute inset-0 bg-black/40"></div>

    <div class="relative max-w-xl mx-auto mt-20 bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-slate-900">Sửa danh mục</h2>
            <button type="button" class="text-slate-500 hover:text-slate-700 btn-close-edit-category">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form action="<?= BASE_URL ?>?mode=admin&act=category_update" method="POST" class="space-y-4">
            <input type="hidden" name="id" id="edit_category_id">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tên danh mục *</label>
                <input type="text" id="edit_category_name" name="name" required
                    class="w-full rounded-md border px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Mô tả</label>
                <textarea id="edit_category_desc" name="description" rows="3"
                    class="w-full rounded-md border px-3 py-2 text-sm"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button"
                    class="px-4 py-2 text-sm rounded-md border text-slate-600 hover:bg-slate-50 btn-close-edit-category">
                    Hủy
                </button>
                <button type="submit" class="px-4 py-2 text-sm rounded-md bg-main text-white">
                    Lưu lại
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ================= ADD =================
        const modalAdd = document.getElementById('modalAddCategory');
        const overlayAdd = document.getElementById('overlayAddCategory');
        const btnOpenAdd = document.querySelector('.btn-open-add-category');
        const btnCloseAddList = document.querySelectorAll('.btn-close-add-category');

        if (btnOpenAdd) {
            btnOpenAdd.addEventListener('click', () => {
                modalAdd.classList.remove('hidden');
            });
        }

        btnCloseAddList.forEach(btn => {
            btn.addEventListener('click', () => {
                modalAdd.classList.add('hidden');
            });
        });

        if (overlayAdd) {
            overlayAdd.addEventListener('click', () => {
                modalAdd.classList.add('hidden');
            });
        }

        // ================= EDIT =================
        const modalEdit = document.getElementById('modalEditCategory');
        const overlayEdit = document.getElementById('overlayEditCategory');
        const btnCloseEditList = document.querySelectorAll('.btn-close-edit-category');

        const inputId = document.getElementById('edit_category_id');
        const inputName = document.getElementById('edit_category_name');
        const inputDesc = document.getElementById('edit_category_desc');

        document.querySelectorAll('.btn-open-edit-category').forEach(btn => {
            btn.addEventListener('click', () => {

                inputId.value = btn.dataset.id || '';
                inputName.value = btn.dataset.name || '';
                inputDesc.value = btn.dataset.description || '';

                modalEdit.classList.remove('hidden');
            });
        });

        btnCloseEditList.forEach(btn => {
            btn.addEventListener('click', () => {
                modalEdit.classList.add('hidden');
            });
        });

        if (overlayEdit) {
            overlayEdit.addEventListener('click', () => {
                modalEdit.classList.add('hidden');
            });
        }

    });
</script>