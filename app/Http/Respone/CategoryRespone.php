<?php

namespace App\Http\Respone;

trait CategoryRespone
{
    function responeResultWithMessage($result,$messageSuccess,$messageFail){
        if ($result) {
            return redirect()->back()
                ->with(["message_admin_category" => $messageSuccess,"status_massage"=>"alert alert-success"]);
        }
        return redirect()->back()
            ->with(["message_admin_category" => $messageFail,"status_massage"=>"alert alert-danger"]);
    }
}