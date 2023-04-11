<?php

namespace App\Http\Respone;

trait OrderRespone
{
    function responeResultWithMessage($result,$messageSuccess,$messageFail){
        if ($result) {
            return redirect()->back()
                ->with(["message_admin_order" => $messageSuccess,"status_massage"=>"alert alert-success"]);
        }
        return redirect()->back()
            ->with(["message_admin_order" => $messageFail,"status_massage"=>"alert alert-danger"]);
    }
}