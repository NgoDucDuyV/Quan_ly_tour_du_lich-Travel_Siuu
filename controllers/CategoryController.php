<?php
require_once 'models/CategoryModel.php';

class CategoryController
{
    private $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    // Hiển thị list danh mục (trang bạn đang dùng)
    public function list()
    {
        $categories = $this->model->getAllCategories();
        require_once "./views/Admin/admin_category_list.php";
    }

    // (Không còn dùng, nhưng giữ lại nếu router còn gọi)
    public function add()
    {
        require_once "./views/Admin/admin_category_form.php";
    }

    // Xử lý thêm mới (modal "Thêm danh mục")
    public function store()
    {
        // Lấy dữ liệu an toàn
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($name === '') {
            $_SESSION['error'] = 'Tên danh mục không được để trống!';
            $this->redirectToList();
        }

        try {
            $ok = $this->model->create($name, $description);
            if ($ok) {
                $_SESSION['success'] = 'Thêm danh mục thành công!';
            } else {
                $_SESSION['error'] = 'Không thể thêm danh mục (lỗi không xác định).';
            }
        } catch (Throwable $e) {
            $_SESSION['error'] = 'Lỗi SQL khi thêm danh mục: ' . $e->getMessage();
        }

        $this->redirectToList();
    }

    public function edit($id)
    {
        $category = $this->model->getById($id);
        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy danh mục!';
            $this->redirectToList();
        }
        require_once "./views/Admin/admin_category_form.php";
    }

    // Xử lý cập nhật (modal "Sửa danh mục")
    public function update()
    {
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($id <= 0) {
            $_SESSION['error'] = 'ID danh mục không hợp lệ!';
            $this->redirectToList();
        }
        if ($name === '') {
            $_SESSION['error'] = 'Tên danh mục không được để trống!';
            $this->redirectToList();
        }

        try {
            $ok = $this->model->update($id, $name, $description);
            if ($ok) {
                $_SESSION['success'] = 'Cập nhật danh mục thành công!';
            } else {
                $_SESSION['error'] = 'Không thể cập nhật danh mục (lỗi không xác định).';
            }
        } catch (Throwable $e) {
            $_SESSION['error'] = 'Lỗi SQL khi cập nhật danh mục: ' . $e->getMessage();
        }

        $this->redirectToList();
    }

    // Xóa danh mục
    public function delete($id)
    {
        $id = (int) $id;
        if ($id <= 0) {
            $_SESSION['error'] = 'ID danh mục không hợp lệ!';
            $this->redirectToList();
        }

        try {
            $this->model->delete($id);
            $_SESSION['success'] = 'Xóa danh mục thành công!';
        } catch (Throwable $e) {
            $_SESSION['error'] = 'Lỗi SQL khi xóa danh mục: ' . $e->getMessage();
        }

        $this->redirectToList();
    }

    // Hàm tiện ích redirect về list cho thống nhất
    private function redirectToList()
    {
        header("Location: " . BASE_URL . "?mode=admin&act=categoriestour");
        exit;
    }
}
