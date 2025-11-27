<?php
class AdminSupplierController
{
    public function showSupplierList()
    {
        $dataSupplier = (new SupplierModel())->getallSupplier();
        // echo "<pre>";
        // var_dump($dataSupplier);
        // echo "<pre>";
        // die;
        require_once "./views/Admin/admin_suppliers_list.php";
    }

    public function showSupplierTypesList()
    {
        $dataSupplierTypes = (new SupplierModel())->getallsupplier_types();
        // echo "<pre>";
        // var_dump($dataSupplierTypes);
        // echo "<pre>";
        // die;
        require_once "./views/Admin/admin_suppliers_types_list.php";
    }
}
