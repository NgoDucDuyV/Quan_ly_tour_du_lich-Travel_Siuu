<?php
class BookingController
{
    public function ShowBooking()
    {
        $datatour = (new TourModel())->getall();
        // echo '<pre>';
        // var_dump($datatour);
        // echo '<pre>';
        // die;
        require_once "./views/Admin/Booking.php";
    }

    public function ShowFromNewBooking()
    {
        require_once "./views/Admin/newBooking.php";
    }
}
