<?php

namespace App\Http\Respone;

trait UserRespone
{
        function responeResultWithMessage($result,$messageSuccess,$messageFail){
            if ($result) {
                return redirect()->back()
                    ->with(["message_admin_user" => $messageSuccess,"status_massage"=>"alert alert-success"]);
            }
            return redirect()->back()
                ->with(["message_admin_user" => $messageFail,"status_massage"=>"alert alert-danger"]);
        }
}