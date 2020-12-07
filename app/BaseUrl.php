<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseUrl extends Model
{
    public function get(){
        return "http://localhost/project/captainbras-be/public/api/";
    }
}
