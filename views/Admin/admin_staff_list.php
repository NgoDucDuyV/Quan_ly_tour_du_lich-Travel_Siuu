<div class="max-w-[1800px] mx-auto p-6">

    <nav class="text-sm text-slate-800 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý tài khoản</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-500">Nhân viên</li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3 bg-">
            <h1 class="text-3xl font-[500] text-slate-900 m-0">Danh Sách Nhân Viên</h1>
            <span class="inline-flex items-center justify-center font-[500] text-white px-2 py-0.5 rounded-full bg-main">
                <?= count($datausers) ?>
            </span>
        </div>

        <div class="flex items-center space-x-3">

            <a href="?mode=admin&act=listclient&create=1" class="flex items-center gap-2 px-4 py-2 rounded-md border-[1px_solid_main] text-sm font-[300] bg-main hover:bg-hover text-white transition-all duration-200 ease-out">
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
    <!-- table -->
    <div class="overflow-x-auto bg-white border border-slate-100 rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50 text-slate-500 text-sm font-medium">
                <tr>
                    <th class="px-6 py-3 text-left w-10">
                        <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Họ Tên</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Chức vụ</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Cập nhật</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-slate-500 uppercase w-5">Hành động</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php if (empty($datausers)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-slate-500 text-center">
                            Không có nhân viên nào trong hệ thống.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($datausers as $value): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-left">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                            </td>

                            <td class="px-6 py-4 text-left font-medium text-slate-900">#<?= $value['id'] ?></td>

                            <td class="px-6 py-4 text-left font-medium text-slate-900">
                                <?= htmlspecialchars($value['fullname'] ?? '') ?>
                            </td>

                            <td class="px-6 py-4 text-left truncate max-w-xs text-slate-600">
                                <?= htmlspecialchars($value['email'] ?? '') ?>
                            </td>

                            <td class="px-6 py-4 text-left text-slate-700"><?= htmlspecialchars($value['rolename'] ?? '') ?></td>

                            <td class="px-6 py-4 text-left text-slate-500">
                                <?= $value['updated_at'] ?? '' ?>
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

                                    <a href="?mode=admin&act=viewstaff&id=<?= $value['id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-regular fa-eye w-5 mr-3"></i> Chi Tiết
                                    </a>

                                    <a href="?mode=admin&act=liststaff&edit_id=<?= $value['id'] ?>"
                                        class="flex items-center px-3 py-2 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-regular fa-pen-to-square w-5 mr-3"></i> Edit
                                    </a>

                                    <a href="?mode=admin&act=delete-staff&id=<?= $value['id'] ?>"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?')"
                                        class="flex items-center px-3 py-2 text-red-600 hover:bg-red-50 transition">
                                        <i class="fa-regular fa-trash-can w-5 mr-3"></i> Xóa
                                    </a>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>


    <!-- form tạo mới nhân viên -->
    <?php $showCreate = isset($_GET['create']) && $_GET['create'] === '1'; ?>
    <?php if ($showCreate): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <h2 class="text-xl font-semibold text-slate-900 mb-4">tạo nhân viên mới</h2>
                <form action="?mode=admin&act=create-staff" method="POST">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">họ tên *</label>
                        <input type="text" name="fullname" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">email *</label>
                        <input type="email" name="email" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">tên đăng nhập *</label>
                        <input type="text" name="username" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">mật khẩu *</label>
                        <input type="password" name="password" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">chức vụ *</label>
                        <select name="role_id" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-indigo-500">
                            <option value="">-- chọn --</option>
                            <option value="1">admin</option>
                            <option value="2">hướng dẫn viên</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="?mode=admin&act=liststaff" class="px-4 py-2 border border-slate-300 rounded-md text-slate-600 hover:bg-slate-50">hủy</a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">tạo mới</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- form sửa nhân viên -->
    <?php
    $editUser = null;
    if (isset($_GET['edit_id'])) {
        $editId = (int)$_GET['edit_id'];
        $userModel = new UserModel();
        $editUser = $userModel->find($editId);
    }
    ?>
    <?php if ($editUser): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <h2 class="text-xl font-semibold text-slate-900 mb-4">sửa nhân viên</h2>
                <form action="?mode=admin&act=update-staff" method="POST">
                    <input type="hidden" name="id" value="<?= $editUser['id'] ?>">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">họ tên</label>
                        <input type="text" name="fullname" value="<?= htmlspecialchars($editUser['fullname']) ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($editUser['email']) ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">tên đăng nhập</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($editUser['username']) ?>" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">chức vụ</label>
                        <select name="role_id" required class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-indigo-500">
                            <option value="1" <?= $editUser['role_id'] == 1 ? 'selected' : '' ?>>admin</option>
                            <option value="2" <?= $editUser['role_id'] == 2 ? 'selected' : '' ?>>hướng dẫn viên</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="?mode=admin&act=liststaff" class="px-4 py-2 border border-slate-300 rounded-md text-slate-600 hover:bg-slate-50">hủy</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>