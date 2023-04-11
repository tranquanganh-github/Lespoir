<?php

namespace App\Models;


use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use Illuminate\Http\Request;

class Cloundinary
{
    private $cloudinary = null;
    private $admin = null;

    public function __construct()
    {
        if (is_null($this->cloudinary)) {
            $this->cloudinary = new Cloudinary(
                ['cloud' => ['cloud_name' => 'daffydrva',
                    'api_key' => '547646138315111',
                    'api_secret' => 'Lbmdk5l_chG6f7QqgSzoRdbH1o4',],]
            );
        }
        if (is_null($this->admin)) {
            $this->admin = new AdminApi(['cloud' => ['cloud_name' => 'daffydrva',
                'api_key' => '547646138315111',
                'api_secret' => 'Lbmdk5l_chG6f7QqgSzoRdbH1o4',],]);
        }
    }

    function uploadImage(Request $request, $key, $publicId)
    {
        $this->cloudinary->uploadApi()->upload(
            $request->file($key)->getRealPath(),
            [
                'public_id' => $publicId,
                'use_filename' => TRUE,
                'overwrite' => TRUE,
                'transformation' => [
                    'width' => 340,
                    'height' => 340
                ],
            ]
        );
            $url = $this->admin->asset($publicId, ['colors' => TRUE])->getArrayCopy()["url"];
            return $url;

    }
    function uploadImageByLink($link,$publicId){
        $this->cloudinary->uploadApi()->upload(
            $link,
            [
                'public_id' => $publicId,
                'use_filename' => TRUE,
                'overwrite' => TRUE,
                'transformation' => [
                    'width' => 340,
                    'height' => 340
                ],
            ]
        );
        $url = $this->admin->asset($publicId, ['colors' => TRUE])->getArrayCopy()["url"];
        return $url;
    }

}