<?php
class AdminSupplierController
{
    public function showSupplierList()
    {
        $dataSupplier = (new SupplierModel())->getallSupplier();
        require_once "./views/Admin/admin_suppliers_list.php";
    }

    public function showSupplierTypesList()
    {
        $dataSupplierTypes = (new SupplierModel())->getallsupplier_types();
        require_once "./views/Admin/admin_suppliers_types_list.php";
    }
}
