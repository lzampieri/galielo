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
    
}
