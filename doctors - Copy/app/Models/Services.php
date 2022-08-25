<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'services'];


    public function users()
    {
        return $this->belongsToMany('App\User');
    }
        


}