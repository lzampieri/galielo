<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Param;

class ParamController extends Controller
{
    public function all() {
        return Param::all();
    }
}