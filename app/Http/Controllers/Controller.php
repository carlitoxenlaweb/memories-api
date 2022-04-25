<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function unset ($model)
    {
        unset($model->created_at);
        unset($model->updated_at);
        unset($model->deleted_at);
        return $model;
    }

    protected function hashFile ($string, $length = 12)
    {
        $rand = md5(rand()).substr(base_convert(md5($string), 16,32), 0, $length);
        $imageName = pathinfo($string, PATHINFO_EXTENSION);
        return "$rand.$imageName";
    }
}
