<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Game;

class Ccup extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
    ];

    public function pl1() {
        return $this->belongsTo( User::class, 'pl1_id' );
    }

    public function pl2() {
        return $this->belongsTo( User::class, 'pl2_id' );
    }
    
    public function game1() {
        return $this->belongsTo( Game::class, 'game1_id' );
    }
    
    public function game2() {
        return $this->belongsTo( Game::class, 'game2_id' );
    }
    
}
