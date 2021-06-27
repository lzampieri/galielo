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
        return $this->hasOne( User::class, 'pl1' );
    }

    public function pl2() {
        return $this->hasOne( User::class, 'pl2' );
    }
    
    public function game1() {
        return $this->hasOne( Game::class, 'game1' );
    }
    
    public function game2() {
        return $this->hasOne( Game::class, 'game2' );
    }
    
}
