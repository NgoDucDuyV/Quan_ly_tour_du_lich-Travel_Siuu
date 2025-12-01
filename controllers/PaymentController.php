<?php
class PaymentController
{

    public function PaymentController()
    {
        $paymentModel = new PaymentModel();
        $payments = $paymentModel->getPaymentModel();
        require_once "./views/Admin/payment .php";
    }
}
