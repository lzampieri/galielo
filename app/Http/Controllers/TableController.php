<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Table;

class TableController extends Controller
{
    public function all() {
        return Table::all();
    }
}