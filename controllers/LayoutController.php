<?php
class LayoutController
{
    public function HeaderController()
    {
        require_once "./views/Admin/layout/header.php";
    }

    public function FooterController()
    {
        require_once "./views/Admin/layout/footer.php";
    }

    public function SideberController()
    {
        require_once "./views/Admin/layout/Sidebar.php";
    }
}
