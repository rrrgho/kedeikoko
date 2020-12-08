<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseUrl extends Model
{
    public function get(){
        return "https://kedeikoko-backend.rrrgho.com/api/";
    }
}
