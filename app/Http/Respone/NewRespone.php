<?php
namespace App\Http\Respone;

trait NewRespone
{
    function responeResultWithMessage($result, $messageSuccess, $messageFail): \Illuminate\Http\RedirectResponse
    {
        if ($result) {
            return redirect()->back()
                ->with(["message_admin_product" => $messageSuccess, "status_massage" => "alert alert-success"]);
        }
        return redirect()->back()
            ->with(["message_admin_product" => $messageFail, "status_massage" => "alert alert-danger"]);
    }
}