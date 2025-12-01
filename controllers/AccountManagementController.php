<?php
class AccountManagementController
{
    public function showStaffList()
    {
        $roles = ['admin', 'guide'];
        $datausers = (new UserModel())->getUsersByRoles($roles);
        require_once "./views/Admin/admin_staff_list.php";
    }

    public function showClientList()
    {
        $roles = ['client'];
        $datausers = (new UserModel())->getUsersByRoles($roles);
        require_once "./views/Admin/admin_client_list.php";
    }

    public function deleteClient()
    {
        // bắt đầu session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // kiểm tra quyền admin
        if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'admin') {
            $_SESSION['error'] = "bạn không có quyền xóa!";
            header("Location: ?mode=admin&act=listclient");
            exit;
        }

        // kiểm tra phương thức post
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "phương thức không hợp lệ!";
            header("Location: ?mode=admin&act=listclient");
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "id không hợp lệ!";
            header("Location: ?mode=admin&act=listclient");
            exit;
        }

        $userModel = new UserModel();

        // kiểm tra user có tồn tại không
        if (!$userModel->find($id)) {
            $_SESSION['error'] = "khách hàng không tồn tại!";
            header("Location: ?mode=admin&act=listclient");
            exit;
        }

        // xóa
        if ($userModel->delete($id)) {
            $_SESSION['success'] = "xóa khách hàng thành công!";
        } else {
            $_SESSION['error'] = "xóa thất bại, vui lòng thử lại!";
        }

        // quay lại trang danh sách
        header("Location: ?mode=admin&act=listclient");
        exit;
    }

    public function updateClient()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'admin') {
            $_SESSION['error'] = "không có quyền!";
            header("Location: ?mode=admin&act=listclient");
            exit;
        }

        if ($_POST['fullname'] == '' || $_POST['email'] == '' || $_POST['username'] == '') {
            $_SESSION['error'] = "vui lòng điền đầy đủ!";
            header("Location: ?mode=admin&act=listclient&edit_id=" . $_POST['id']);
            exit;
        }

        $userModel = new UserModel();
        if ($userModel->update($_POST['id'], $_POST)) {
            $_SESSION['success'] = "cập nhật thành công!";
        } else {
            $_SESSION['error'] = "cập nhật thất bại!";
        }

        header("Location: ?mode=admin&act=listclient");
        exit;
    }

    // tạo người dùng khách hàng
    public function createClient()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'admin') {
            $_SESSION['error'] = "bạn không có quyền!";
            header("Location: ?mode=admin&act=listclient");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "phương thức không hợp lệ!";
            header("Location: ?mode=admin&act=listclient");
            exit;
        }

        $data = [
            'fullname' => trim($_POST['fullname'] ?? ''),
            'email'    => trim($_POST['email'] ?? ''),
            'username' => trim($_POST['username'] ?? ''),
            'password' => password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT)
        ];

        // validate
        if (empty($data['fullname']) || empty($data['email']) || empty($data['username']) || empty($_POST['password'])) {
            $_SESSION['error'] = "vui lòng điền đầy đủ thông tin!";
            header("Location: ?mode=admin&act=listclient&create=1");
            exit;
        }

        // kiểm tra email hoặc username đã tồn tại
        $userModel = new UserModel();
        if ($userModel->exists($data['email'], $data['username'])) {
            $_SESSION['error'] = "email hoặc tên đăng nhập đã tồn tại!";
            header("Location: ?mode=admin&act=listclient&create=1");
            exit;
        }

        // tạo mới
        if ($userModel->create($data)) {
            $_SESSION['success'] = "tạo khách hàng thành công!";
        } else {
            $_SESSION['error'] = "tạo thất bại, vui lòng thử lại!";
        }

        header("Location: ?mode=admin&act=listclient");
        exit;
    }

    // tạo nhân viên (admin hoặc guide)
    public function createStaff()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'admin') {
            $_SESSION['error'] = "bạn không có quyền!";
            header("Location: ?mode=admin&act=liststaff");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "phương thức không hợp lệ!";
            header("Location: ?mode=admin&act=liststaff");
            exit;
        }

        $data = [
            'fullname' => trim($_POST['fullname'] ?? ''),
            'email'    => trim($_POST['email'] ?? ''),
            'username' => trim($_POST['username'] ?? ''),
            'password' => password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT),
            'role_id'  => (int)($_POST['role_id'] ?? 0)
        ];

        // validate
        if (empty($data['fullname']) || empty($data['email']) || empty($data['username']) || empty($_POST['password']) || !in_array($data['role_id'], [1, 2])) {
            $_SESSION['error'] = "vui lòng điền đầy đủ và chọn đúng chức vụ!";
            header("Location: ?mode=admin&act=liststaff&create=1");
            exit;
        }

        // kiểm tra trùng
        $userModel = new UserModel();
        if ($userModel->exists($data['email'], $data['username'])) {
            $_SESSION['error'] = "email hoặc tên đăng nhập đã tồn tại!";
            header("Location: ?mode=admin&act=liststaff&create=1");
            exit;
        }

        // dùng hàm trong UserModel (không dùng $conn)
        if ($userModel->createStaff($data['fullname'], $data['email'], $data['username'], $data['password'], $data['role_id'])) {
            $_SESSION['success'] = "tạo nhân viên thành công!";
        } else {
            $_SESSION['error'] = "tạo thất bại, vui lòng thử lại!";
        }

        header("Location: ?mode=admin&act=liststaff");
        exit;
    }

    // sửa nhân viên
    public function updateStaff()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'admin') {
            $_SESSION['error'] = "không có quyền!";
            header("Location: ?mode=admin&act=liststaff");
            exit;
        }

        $id = $_POST['id'] ?? 0;
        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "id không hợp lệ!";
            header("Location: ?mode=admin&act=liststaff");
            exit;
        }

        if ($_POST['fullname'] == '' || $_POST['email'] == '' || $_POST['username'] == '') {
            $_SESSION['error'] = "vui lòng điền đầy đủ!";
            header("Location: ?mode=admin&act=liststaff&edit_id=$id");
            exit;
        }

        $role_id = (int)($_POST['role_id'] ?? 0);
        if (!in_array($role_id, [1, 2])) {
            $_SESSION['error'] = "chức vụ không hợp lệ!";
            header("Location: ?mode=admin&act=liststaff&edit_id=$id");
            exit;
        }

        $data = [
            'fullname' => $_POST['fullname'],
            'email'    => $_POST['email'],
            'username' => $_POST['username'], // SỬA LỖI: $_POST793 → $_POST
            'role_id'  => $role_id
        ];

        $userModel = new UserModel();
        if ($userModel->updateStaff($id, $data)) {
            $_SESSION['success'] = "cập nhật nhân viên thành công!";
        } else {
            $_SESSION['error'] = "cập nhật thất bại!";
        }

        header("Location: ?mode=admin&act=liststaff");
        exit;
    }

    // xóa nhân viên
    public function deleteStaff()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'admin') {
            $_SESSION['error'] = "bạn không có quyền xóa!";
            header("Location: ?mode=admin&act=liststaff");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "phương thức không hợp lệ!";
            header("Location: ?mode=admin&act=liststaff");
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "id không hợp lệ!";
            header("Location: ?mode=admin&act=liststaff");
            exit;
        }

        $userModel = new UserModel();
        if (!$userModel->find($id)) {
            $_SESSION['error'] = "nhân viên không tồn tại!";
            header("Location: ?mode=admin&act=liststaff");
            exit;
        }

        if ($userModel->delete($id)) {
            $_SESSION['success'] = "xóa nhân viên thành công!";
        } else {
            $_SESSION['error'] = "xóa thất bại, vui lòng thử lại!";
        }

        header("Location: ?mode=admin&act=liststaff");
        exit;
    }
}