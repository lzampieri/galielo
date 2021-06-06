<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value'
    ];
    
    /**
     * In this table, the primary key is 'key' and
     * it is not numeric and incrementing, but it is
     * a string
     */
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
}
