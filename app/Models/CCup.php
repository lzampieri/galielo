<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Game;

class CCup extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hidden'
    ];

    public function att() {
        return $this->hasOne( User::class, 'att' );
    }

    public function dif() {
        return $this->hasOne( User::class, 'dif' );
    }
    
    public function game1() {
        return $this->hasOne( Game::class, 'game1' );
    }
    
    public function game2() {
        return $this->hasOne( Game::class, 'game2' );
    }
    
}
