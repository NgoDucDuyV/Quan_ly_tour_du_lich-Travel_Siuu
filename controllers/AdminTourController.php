<?php
class AdminTourController
{

    public function ShowAdminTour()
    {
        $datatour = (new TourModel())->getAll();
        // echo '<pre>';
        // var_dump($datatour);
        // echo '<pre>';
        // die;
        require_once "./views/Admin/admin_tours.php";
    }

    public function showTourDetail($tour_id)
    {
        $datatour = (new TourModel())->getAll();

        $dataTourDetai = (new TourModel())->TourDetailItineraryModel($tour_id);

        $dataOneTour = (new TourModel())->getOne($tour_id);

        $dataTourSupplier = (new TourModel())->TourSuppliersModel($tour_id);

        $dataTourImages = (new TourModel())->TourImagesModel($tour_id);
        // echo "<pre>";
        // var_dump($dataTourImages);
        // echo "<pre>";
        // die;
        require_once "./views/Admin/admin_tours.php";
    }


    public function showFromAddTour()
    {
        // echo "<pre>";
        // var_dump($dataOneTour);
        // echo "<pre>";
        // die;
        require_once "./views/Admin/admin_addTour.php";
    }
}
