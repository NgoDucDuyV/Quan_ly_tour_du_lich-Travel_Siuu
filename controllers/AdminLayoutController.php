<?php
class AdminLayoutController
{
    public function Header()
    {
        require_once PATH_ROOT . "views/Admin/layout/header.php";
    }
    public function Sidebar()
    {
        require_once PATH_ROOT . "views/Admin/layout/sidebar.php";
    }
    public function Footer()
    {
        require_once PATH_ROOT . "views/Admin/layout/footer.php";
    }
}
