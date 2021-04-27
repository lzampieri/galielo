<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Game extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deltaa1',
        'deltad1',
        'deltaa2',
        'deltad2',
        'pt1',
        'pt2',
        'hidden'
    ];

    public function att1() {
        return $this->hasOne( User::class, 'att1' );
    }

    public function dif1() {
        return $this->hasOne( User::class, 'dif1' );
    }
    
    public function att2() {
        return $this->hasOne( User::class, 'att2' );
    }
    
    public function dif2() {
        return $this->hasOne( User::class, 'dif2' );
    }
    
}
