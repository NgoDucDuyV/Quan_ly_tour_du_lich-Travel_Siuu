<?php
require_once 'models/CategoryModel.php';

class CategoryController
{
    private $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function list()
    {
        $categories = $this->model->getAllCategories();
        require_once "./views/Admin/admin_category_list.php";
    }

    public function add()
    {
        require_once "./views/Admin/admin_category_form.php";
    }

    public function store()
    {
        if ($_POST['name'] ?? '' == '') {
            $_SESSION['error'] = 'Tên danh mục không được để trống!';
        } else {
            $this->model->create($_POST['name'], $_POST['description'] ?? '');
            $_SESSION['success'] = 'Thêm danh mục thành công!';
        }
        header("Location: ?mode=admin&act=categoriestour");
        exit;
    }

    public function edit($id)
    {
        $category = $this->model->getById($id);
        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy danh mục!';
            header("Location: ?mode=admin&act=categoriestour");
            exit;
        }
        require_once "./views/Admin/admin_category_form.php";
    }

    public function update()
    {
        if ($_POST['name'] ?? '' == '') {
            $_SESSION['error'] = 'Tên danh mục không được để trống!';
        } else {
            $this->model->update($_POST['id'], $_POST['name'], $_POST['description'] ?? '');
            $_SESSION['success'] = 'Cập nhật thành công!';
        }
        header("Location: ?mode=admin&act=categoriestour");
        exit;
    }

    public function delete($id)
    {
        $this->model->delete($id);
        $_SESSION['success'] = 'Xóa thành công!';
        header("Location: ?mode=admin&act=categoriestour");
        exit;
    }
}