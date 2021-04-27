<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Log extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action'
    ];

    public function user() {
        return $this->hasOne( User::class );
    }
    
}
