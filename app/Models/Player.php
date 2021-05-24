<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Player extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'apoints',
        'dpoints'
    ];

    public function user() {
        return $this->belongsTo( User::class );
    }

    public function asAtt1() {
        return $this->hasMany( Game::class, 'att1_id' );
    }

    public function asDif1() {
        return $this->hasMany( Game::class, 'dif1_id' );
    }
    
    public function asAtt2() {
        return $this->hasMany( Game::class, 'att2_id' );
    }
    
    public function asDif2() {
        return $this->hasMany( Game::class, 'dif2_id' );
    }
    
}
