<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chauffeur extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'cin',
        'address',
    ];
    public $timestamps = false;

}
