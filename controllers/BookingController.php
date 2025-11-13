<?php
class BookingController
{
    public function ShowBooking()
    {
        require_once "./views/Admin/Booking.php";
    }

    public function ShowFromNewBooking()
    {
        require_once "./views/Admin/newBooking.php";
    }
}
