<?php
class AdminController
{
    public function signin($requestData)
    {
        $dataAllUser = (new AdminModel())->getAllUser();
        // echo "<pre>";
        // print_r($dataAllUser);
        // echo "</pre>";
        // foreach ($dataAllUser as $value) {
        //     echo $value['username'];
        // }
        // die;
    }
}
