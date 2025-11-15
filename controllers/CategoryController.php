<?php
class CategoryController
{
    public function listCategories()
    {
        $categories = (new CategoryModel())->getAllCategories();
        // echo '<pre>';
        // var_dump($categories);
        // echo '<pre>';
        // die;
        require_once "./views/Admin/admin_category_list.php";
    }
}
