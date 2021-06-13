<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function games() {
        return $this->hasMany( Game::class );
    }
    
}
