<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Schools extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'address',
        'founder'
    ];

    /**
     * Get the user that owns the class.
     */
    public function user()
    {
        return $this->hasOne(Users::class);
    }

}