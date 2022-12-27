<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Appointment extends Model
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [

        'date',
        'duration',
        'description'
      
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    //public function treatments()
    //{
    //    return $this->hasMany(Treatment::class);
    //}
}
