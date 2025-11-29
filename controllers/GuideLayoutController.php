<?php
class GuideLayoutController
{
    public function Header()
    {
        require_once "./views/Admin/layout_guide/header.php";
    }
    public function Sidebar()
    {
        require_once "./views/Admin/layout_guide/sidebar.php";
    }
    public function Footer()
    {
        require_once "./views/Admin/layout_guide/footer.php";
    }
}
