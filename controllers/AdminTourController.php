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

        $dataTourPolicies = (new TourModel())->TourPoliciesModel($tour_id);
        // echo "<pre>";
        // var_dump($dataTourPolicies);
        // echo "<pre>";
        // die;
        require_once "./views/Admin/admin_detail_tour.php";
    }

    public function CreateTour() {}

    public function showFromCreateTour()
    {
        // category
        $categories = (new CategoryModel())->getAllCategories();
        // echo "<pre>";
        // var_dump($categories);
        // echo "<pre>";
        // die;
        require_once "./views/Admin/admin_createTour.php";
    }
}
