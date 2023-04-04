<?php

namespace App\Models;


use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;

class Cloundinary
{
    private $cloudinary = null;

    public function __construct()
    {
        if (is_null($this->cloudinary)){
            $this->cloudinary = new Cloudinary(
                ['cloud' => ['cloud_name' => 'daffydrva',
                    'api_key' => '547646138315111',
                    'api_secret' => 'Lbmdk5l_chG6f7QqgSzoRdbH1o4',],]
            );
        }
    }

    function uploadImage(){
    $this->cloudinary->uploadApi()->upload(
        'https://upload.wikimedia.org/wikipedia/commons/a/ae/Olympic_flag.jpg',
        ['public_id' => 'olympic_flag']
    );

    $url = $this->cloudinary->image('olympic_flag')->resize(Resize::fill(100, 150))->toUrl();
        return $url;
    }

}