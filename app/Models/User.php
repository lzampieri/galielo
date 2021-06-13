<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'slogan',
        'bio',
        'isadmin'
    ];

    public function player() {
        return $this->hasOne( Player::class );
    }

    public function logs() {
        return $this->hasMany( Log::class );
    }
    
    public function inserted_games() {
        return $this->hasMany( Game::class, 'inserted_by' );
    }
}
