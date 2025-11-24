<div class="max-w-[1800px] mx-auto p-6">

    <nav class="text-sm text-slate-800 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý Tài khoản</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-500">Khách hàng</li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3 bg-">
            <h1 class="text-3xl font-[500] text-slate-900 m-0">Danh Sách Khách Hàng</h1>
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
            <?= $_SESSION['success'] ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md border border-red-300 text-sm font-medium">
            <?= $_SESSION['error'] ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Table  -->
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



    <!-- === FORM TẠO MỚI KHÁCH HÀNG (Modal) === -->
    <?php
    $showCreateForm = isset($_GET['create']) && $_GET['create'] === '1';
    ?>

    <?php if ($showCreateForm): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <h2 class="text-xl font-semibold text-slate-900 mb-4">Tạo khách hàng mới</h2>

                <form action="?mode=admin&act=create-client" method="POST">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Họ tên *</label>
                        <input type="text" name="fullname"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email *</label>
                        <input type="email" name="email"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tên đăng nhập *</label>
                        <input type="text" name="username"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Mật khẩu *</label>
                        <input type="password" name="password"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="?mode=admin&act=listclient"
                            class="px-4 py-2 border border-slate-300 rounded-md text-slate-600 hover:bg-slate-50">
                            Hủy
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Tạo mới
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- === FORM SỬA KHÁCH HÀNG (Modal) === -->
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
                <h2 class="text-xl font-semibold text-slate-900 mb-4">Sửa khách hàng</h2>

                <form action="?mode=admin&act=update-client" method="POST">
                    <input type="hidden" name="id" value="<?= $editUser['id'] ?>">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Họ tên</label>
                        <input type="text" name="fullname" value="<?= htmlspecialchars($editUser['fullname']) ?>"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($editUser['email']) ?>"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tên đăng nhập</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($editUser['username']) ?>"
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="?mode=admin&act=listclient"
                            class="px-4 py-2 border border-slate-300 rounded-md text-slate-600 hover:bg-slate-50">
                            Hủy
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>