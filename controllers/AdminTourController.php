<?php
class AdminTourController
{

    public function ShowAdminTour()
    {
        $datatour = (new TourMedel())->getall();
        // echo '<pre>';
        // var_dump($datatour);
        // echo '<pre>';
        // die;
        require_once "./views/Admin/admin_tours.php";
    }
}
