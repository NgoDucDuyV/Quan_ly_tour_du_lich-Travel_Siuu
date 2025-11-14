<?php
class AccountManagementController
{
    public function showStaffList()
    {
        $roles = ['admin', 'guide']; // Mảng role hợp lệ
        $datausers = (new UserModel())->getUsersByRoles($roles);
        require_once "./views/Admin/admin_staff_list.php";
    }

    public function showClientList()
    {
        $roles = ['client']; // Mảng role hợp lệ
        $datausers = (new UserModel())->getUsersByRoles($roles);
        require_once "./views/Admin/admin_client_list.php";
    }
}
