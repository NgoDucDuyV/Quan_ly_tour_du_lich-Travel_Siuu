<?php
class AdminLayoutController
{
    public function Header()
    {
        // var_dump($_SESSION['admin_logged']);
        // die;
        require_once "./views/Admin/layout/header.php";
    }
    public function Sidebar()
    {
        require_once "./views/Admin/layout/sidebar.php";
    }
    public function Footer()
    {
        require_once "./views/Admin/layout/footer.php";
    }
}
