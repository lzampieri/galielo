<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Table;

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
        return $this->belongsTo( Player::class, 'att1_id' );
    }

    public function dif1() {
        return $this->belongsTo( Player::class, 'dif1_id' );
    }
    
    public function att2() {
        return $this->belongsTo( Player::class, 'att2_id' );
    }
    
    public function dif2() {
        return $this->belongsTo( Player::class, 'dif2_id' );
    }
    
    public function author() {
        return $this->belongsTo( User::class, 'inserted_by' );
    }
    
    public function table() {
        return $this->belongsTo( Table::class );
    }
}
