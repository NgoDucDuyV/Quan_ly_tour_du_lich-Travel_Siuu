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
        // Lấy dữ liệu từ model
        $completed = $this->model->getCompletedTours();

        // Gửi qua view
        require_once "./views/Admin/report.php";
    }
}
