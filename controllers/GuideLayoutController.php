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
    public function index()
    {
        require_once "./models/AdminModel.php";
        $guides = (new AdminModel())->getguides();
        include "./views/Admin/managerguide.php";
    }
    public function clientList()
    {
        require_once "./models/AdminModel.php";
        $clients = (new AdminModel())->getClients();

        include "./views/Admin/managerclient.php";
    }
}
