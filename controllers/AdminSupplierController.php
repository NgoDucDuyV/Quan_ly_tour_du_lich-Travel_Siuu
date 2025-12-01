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

    /* ================== CRUD NHÀ CUNG CẤP ================== */

    // Xử lý form thêm mới (POST)
    public function storeSupplier()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list");
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list&error=empty_name");
            exit;
        }

        $data = [
            'name' => $name,
            'supplier_types_id' => $_POST['supplier_types_id'] ?? '',
            'contact_name' => $_POST['contact_name'] ?? '',
            'contact_phone' => $_POST['contact_phone'] ?? '',
            'contact_email' => $_POST['contact_email'] ?? '',
            'address' => $_POST['address'] ?? '',
            'description' => $_POST['description'] ?? '',
        ];

        (new SupplierModel())->createSupplier($data);

        header("Location: " . BASE_URL . "?mode=admin&act=supplier-list&msg=created");
        exit;
    }

    // Hiển thị form sửa nhà cung cấp
    public function editSupplier()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list");
            exit;
        }

        $model = new SupplierModel();
        $supplier = $model->getSupplierById($id);
        $supplierTypes = $model->supplier_types();

        if (!$supplier) {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list&error=not_found");
            exit;
        }

        // Tự tạo view: views/Admin/admin_suppliers_edit.php
        require_once "./views/Admin/admin_suppliers_edit.php";
    }

    // Xử lý cập nhật nhà cung cấp (POST)
    public function updateSupplier()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list");
            exit;
        }

        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');

        if (!$id || $name === '') {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list&error=invalid_data");
            exit;
        }

        $data = [
            'name' => $name,
            'supplier_types_id' => $_POST['supplier_types_id'] ?? '',
            'contact_name' => $_POST['contact_name'] ?? '',
            'contact_phone' => $_POST['contact_phone'] ?? '',
            'contact_email' => $_POST['contact_email'] ?? '',
            'address' => $_POST['address'] ?? '',
            'description' => $_POST['description'] ?? '',
        ];

        (new SupplierModel())->updateSupplier($id, $data);

        header("Location: " . BASE_URL . "?mode=admin&act=supplier-list&msg=updated");
        exit;
    }

    // Xoá nhà cung cấp
    public function deleteSupplier()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            (new SupplierModel())->deleteSupplier($id);
        }

        header("Location: " . BASE_URL . "?mode=admin&act=supplier-list&msg=deleted");
        exit;
    }

    /* =============== CRUD LOẠI DỊCH VỤ NHÀ CUNG CẤP =============== */

    // Thêm loại dịch vụ
    public function storeSupplierType()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list-types");
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list-types&error=empty_name");
            exit;
        }

        $data = [
            'name' => $name,
            'description' => $_POST['description'] ?? '',
            'stars' => $_POST['stars'] ?? 0,
            'quality' => $_POST['quality'] ?? 'Tốt',
        ];

        (new SupplierModel())->createSupplierType($data);

        header("Location: " . BASE_URL . "?mode=admin&act=supplier-list-types&msg=created");
        exit;
    }

    // Hiển thị form sửa loại dịch vụ
    public function editSupplierType()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list-types");
            exit;
        }

        $model = new SupplierModel();
        $supplierType = $model->getSupplierTypeById($id);

        if (!$supplierType) {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list-types&error=not_found");
            exit;
        }

        // Tự tạo view: views/Admin/admin_suppliers_types_edit.php
        require_once "./views/Admin/admin_suppliers_types_edit.php";
    }

    // Xử lý cập nhật loại dịch vụ
    public function updateSupplierType()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list-types");
            exit;
        }

        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');

        if (!$id || $name === '') {
            header("Location: " . BASE_URL . "?mode=admin&act=supplier-list-types&error=invalid_data");
            exit;
        }

        $data = [
            'name' => $name,
            'description' => $_POST['description'] ?? '',
            'stars' => $_POST['stars'] ?? 0,
            'quality' => $_POST['quality'] ?? 'Tốt',
        ];

        (new SupplierModel())->updateSupplierType($id, $data);

        header("Location: " . BASE_URL . "?mode=admin&act=supplier-list-types&msg=updated");
        exit;
    }

    // Xoá loại dịch vụ
    public function deleteSupplierType()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            (new SupplierModel())->deleteSupplierType($id);
        }

        header("Location: " . BASE_URL . "?mode=admin&act=supplier-list-types&msg=deleted");
        exit;
    }
}
