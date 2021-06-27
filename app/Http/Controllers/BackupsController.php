<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Param;
use App\Models\Player;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupsController extends Controller
{
    public function create(Request $request) {
        $tables = [];

        $tables['backup_info'] = [];
        $tables['backup_info']['ip'] = $request->ip();
        $tables['backup_info']['date'] = date("c");
        $tables['backup_info']['filename'] = "backup_" . str_replace( ':', '-', date("c") ) . ".json";
        $tables['players'] = Player::all()->toArray();
        $tables['games'] = Game::all()->toArray();
        $tables['users'] = User::all()->toArray();
        $tables['params'] = Param::all()->toArray();
        $tables['tables'] = Table::all()->toArray();
        # TODO: add other tables!

        Storage::put( "backups/" . $tables['backup_info']['filename'] , json_encode( $tables ) );

        return "OK";
    }
}