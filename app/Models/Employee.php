<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'matricule',
        'tagid',
        'route_id',
        'Presence'
    ];
    public $timestamps = false;

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

}
