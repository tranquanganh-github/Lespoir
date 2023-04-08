<?php
namespace App\Http\Enum;
enum Status : int
{
    case ACTIVE = 1;
    case STATUS_MISS_DATA = 300;
    case STATUS_SUCCESS = 200;
    case STATUS_FAIL = 400;
    case WAITING = 4;
    case CONFORM = 120;
}
