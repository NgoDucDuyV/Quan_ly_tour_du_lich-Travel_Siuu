<?php
class AdminSupplierController
{
    private $model; // Thêm dòng này

    public function __construct()
    {
        $this->model = new SupplierModel(); 
    }

    public function showSupplierList()
    {
        $dataSupplier = $this->model->getallSupplier(); 
        require_once "./views/Admin/admin_suppliers_list.php";
    }

    public function showSupplierTypesList()
    {
        $dataSupplierTypes = $this->model->getallsupplier_types();
        require_once "./views/Admin/admin_suppliers_types_list.php";
    }

    // Thêm loại dịch vụ
    public function addSupplierType()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?mode=admin&act=supplier-list-types");
            exit;
        }

        $name        = trim($_POST['name'] ?? '');
        $description = $_POST['description'] ?? null;
        $stars       = (int)($_POST['stars'] ?? 0);
        $quality     = $_POST['quality'] ?? 'Tốt';

        if (empty($name)) {
            $_SESSION['error'] = "Tên loại dịch vụ không được để trống!";
        } else {
            $result = $this->model->addSupplierType($name, $description, $stars, $quality);
            if ($result) {
                $_SESSION['success'] = "Thêm loại dịch vụ thành công!";
            } else {
                $_SESSION['error'] = "Tên loại dịch vụ đã tồn tại hoặc có lỗi!";
            }
        }
        header("Location: ?mode=admin&act=supplier-list-types");
        exit;
    }

    // Cập nhật loại dịch vụ
    public function updateSupplierType()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?mode=admin&act=supplier-list-types");
            exit;
        }

        $id          = (int)$_POST['id'];
        $name        = trim($_POST['name'] ?? '');
        $description = $_POST['description'] ?? null;
        $stars       = (int)($_POST['stars'] ?? 0);
        $quality     = $_POST['quality'] ?? 'Tốt';

        if (empty($name) || $id <= 0) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
        } else {
            $result = $this->model->updateSupplierType($id, $name, $description, $stars, $quality);
            if ($result) {
                $_SESSION['success'] = "Cập nhật thành công!";
            } else {
                $_SESSION['error'] = "Cập nhật thất bại! (có thể tên đã tồn tại)";
            }
        }
        header("Location: ?mode=admin&act=supplier-list-types");
        exit;
    }
    //xóa dịch vụ
    public function deleteSupplierType()
{
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['error'] = "ID không hợp lệ!";
        header("Location: ?mode=admin&act=supplier-list-types");
        exit;
    }

    $id = (int)$_GET['id'];
    $result = $this->model->deleteSupplierType($id); // hàm này mình gửi dưới

    if ($result) {
        $_SESSION['success'] = "Xóa loại dịch vụ thành công!";
    } else {
        $_SESSION['error'] = "Không thể xóa (đang có nhà cung cấp sử dụng hoặc lỗi)!";
    }

    header("Location: ?mode=admin&act=supplier-list-types");
    exit;
}

   
    //1.thêm nhà cung cấp
    public function addSupplier()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?mode=admin&act=supplier-list");
            exit;
        }

        $name              = trim($_POST['name'] ?? '');
        $supplier_types_id = (int)($_POST['supplier_types_id'] ?? 0);

        if (empty($name) || $supplier_types_id <= 0) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ Tên nhà cung cấp và Loại dịch vụ!";
        } else {
            $data = [
                'name'              => $name,
                'supplier_types_id' => $supplier_types_id,
                'contact_name'      => trim($_POST['contact_name'] ?? ''),
                'contact_email'     => trim($_POST['contact_email'] ?? ''),
                'contact_phone'     => trim($_POST['contact_phone'] ?? ''),
                'address'           => trim($_POST['address'] ?? ''),
                'description'       => trim($_POST['description'] ?? '')
            ];

            if ($this->model->addSupplier($data)) {
                $_SESSION['success'] = "Thêm nhà cung cấp thành công!";
            } else {
                $_SESSION['error'] = "Thêm thất bại! Vui lòng thử lại.";
            }
        }

        header("Location: ?mode=admin&act=supplier-list");
        exit;
    }

    // 2.sửa nhà cung cấp
    public function updateSupplier()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?mode=admin&act=supplier-list");
            exit;
        }

        $id                = (int)($_POST['id'] ?? 0);
        $name              = trim($_POST['name'] ?? '');
        $supplier_types_id = (int)($_POST['supplier_types_id'] ?? 0);

        if ($id <= 0 || empty($name) || $supplier_types_id <= 0) {
            $_SESSION['error'] = "Dữ liệu không hợp lệ!";
        } else {
            $data = [
                'name'              => $name,
                'supplier_types_id' => $supplier_types_id,
                'contact_name'      => trim($_POST['contact_name'] ?? ''),
                'contact_email'     => trim($_POST['contact_email'] ?? ''),
                'contact_phone'     => trim($_POST['contact_phone'] ?? ''),
                'address'           => trim($_POST['address'] ?? ''),
                'description'       => trim($_POST['description'] ?? '')
            ];

            if ($this->model->updateSupplier($id, $data)) {
                $_SESSION['success'] = "Cập nhật nhà cung cấp thành công!";
            } else {
                $_SESSION['error'] = "Cập nhật thất bại! Vui lòng thử lại.";
            }
        }

        header("Location: ?mode=admin&act=supplier-list");
        exit;
    }

    // 3.xóa nhà cung cấp
    public function deleteSupplier()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "ID không hợp lệ!";
            header("Location: ?mode=admin&act=supplier-list");
            exit;
        }

        $id = (int)$_GET['id'];

        if ($this->model->deleteSupplier($id)) {
            $_SESSION['success'] = "Xóa nhà cung cấp thành công!";
        } else {
            $_SESSION['error'] = "Xóa thất bại! Có thể đang được sử dụng trong tour.";
        }

        header("Location: ?mode=admin&act=supplier-list");
        exit;
    }
}

