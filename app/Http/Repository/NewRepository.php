<?php

namespace App\Http\Repository;

use App\Models\News;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class NewRepository
{
    /**
     * Create new.
     */
    function createNew($data){
        return News::insert($data);
    }

    /**
     * Update new by id.
     */
    function updateNewById($id,$data){
        return News::whereId($id)->update($data);
    }

    function getNewById($id){
        return News::whereId($id);
    }
}