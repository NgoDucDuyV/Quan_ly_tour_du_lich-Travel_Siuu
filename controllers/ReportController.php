<?php
class ReportController
{
    private $model;

    public function __construct()
    {
        require_once "./models/ReportModel.php";
        $this->model = new ReportModel();
    }

    public function index()
    {
        $completedBookings = $this->model->getCompletedBookings();
        $totalRevenue      = $this->model->getTotalRevenueCompleted();
        $totalBookings     = $this->model->countCompletedBookings();

        require_once "./views/Admin/report.php";
    }
}