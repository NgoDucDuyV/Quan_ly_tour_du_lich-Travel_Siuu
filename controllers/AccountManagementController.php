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
    // Bắt đầu session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Kiểm tra quyền admin (dựa trên hệ thống bạn đang dùng)
    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'admin') {
        $_SESSION['error'] = "Bạn không có quyền xóa!";
        header("Location: ?mode=admin&act=listclient");
        exit;
    }

    // Kiểm tra phương thức POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = "Phương thức không hợp lệ!";
        header("Location: ?mode=admin&act=listclient");
        exit;
    }

    $id = $_POST['id'] ?? null;
    if (!$id || !is_numeric($id)) {
        $_SESSION['error'] = "ID không hợp lệ!";
        header("Location: ?mode=admin&act=listclient");
        exit;
    }

    $userModel = new UserModel();

    // Kiểm tra user có tồn tại không
    if (!$userModel->find($id)) {
        $_SESSION['error'] = "Khách hàng không tồn tại!";
        header("Location: ?mode=admin&act=listclient");
        exit;
    }

    // Xóa
    if ($userModel->delete($id)) {
        $_SESSION['success'] = "Xóa khách hàng thành công!";
    } else {
        $_SESSION['error'] = "Xóa thất bại, vui lòng thử lại!";
    }

    // Quay lại trang danh sách
    header("Location: ?mode=admin&act=listclient");
    exit;
}

public function updateClient()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_role'] !== 'admin') {
        $_SESSION['error'] = "Không có quyền!";
        header("Location: ?mode=admin&act=listclient");
        exit;
    }

    if ($_POST['fullname'] == '' || $_POST['email'] == '' || $_POST['username'] == '') {
        $_SESSION['error'] = "Vui lòng điền đầy đủ!";
        header("Location: ?mode=admin&act=listclient&edit_id=" . $_POST['id']);
        exit;
    }

    $userModel = new UserModel();
    if ($userModel->update($_POST['id'], $_POST)) {
        $_SESSION['success'] = "Cập nhật thành công!";
    } else {
        $_SESSION['error'] = "Cập nhật thất bại!";
    }

    header("Location: ?mode=admin&act=listclient");
    exit;
}
}