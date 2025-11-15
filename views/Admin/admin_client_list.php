<div class="max-w-[1800px] mx-auto p-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-500 mb-4" aria-label="Breadcrumb">
        <ul class="inline-flex items-center space-x-2">
            <li>Quản trị viên</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300">Quản lý Tài khoản</li>
            <li class="before:content-['/'] before:px-2 before:text-slate-300 text-slate-400">Khách hàng</li>
        </ul>
    </nav>

    <!-- === THÔNG BÁO THÀNH CÔNG / LỖI === -->
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

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-semibold text-slate-900">Danh sách khách hàng</h1>
            <span class="inline-block bg-slate-100 text-slate-600 px-2 py-0.5 text-sm rounded-full">
                <?= count($datausers) ?>
            </span>
        </div>

        <div class="flex items-center space-x-3">
            <button class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-md text-sm text-slate-600 bg-white hover:bg-slate-50">
                Lọc
            </button>

            <button class="flex items-center gap-2 px-4 py-2 bg-white border border-indigo-600 text-indigo-600 rounded-md text-sm hover:bg-indigo-50">
                Tạo mới
            </button>
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
                    <th class="px-6 py-3 text-left">Họ Tên</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Tên đăng nhập</th>
                    <th class="px-6 py-3 text-right w-36">Cập nhật</th>
                    <th class="px-6 py-3 text-right w-36">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                <?php if (empty($datausers)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-slate-500 text-center">
                            Không có khách hàng nào trong hệ thống.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($datausers as $value): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-slate-200 rounded" />
                            </td>
                            <td class="px-6 py-4"><?= $value['id'] ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($value['fullname'] ?? '') ?></td>
                            <td class="px-6 py-4 truncate max-w-xs"><?= htmlspecialchars($value['email'] ?? '') ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($value['username'] ?? '') ?></td>
                            <td class="px-6 py-4 text-right"><?= $value['updated_at'] ?? '' ?></td>
                            <td class="px-6 py-4 text-right w-36">
                                <div class="flex items-center justify-end gap-2">

                                    <!-- NÚT SỬA: DÙNG LINK GET -->
                                    <a href="?mode=admin&act=listclient&edit_id=<?= $value['id'] ?>"
                                        class="p-1.5 text-indigo-600 hover:bg-indigo-50 rounded-md transition inline-block"
                                        title="Sửa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <!-- NÚT XÓA: DÙNG FORM + PHP THUẦN -->
                                    <form
                                        action="?mode=admin&act=delete-client"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?')">
                                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                        <button type="submit"
                                            class="p-1.5 text-red-600 hover:bg-red-50 rounded-md transition"
                                            title="Xóa">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

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
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 animate-fadeIn">
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