<?php
class CategoryController
{
    public function listCategories()
    {
        $categories = (new CategoryModel()) -> getAllCategories();
       

        require_once "./views/Admin/admin_category_list.php";
    }
}
?>