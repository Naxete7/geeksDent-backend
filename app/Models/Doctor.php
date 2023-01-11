<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Doctor extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [

        'name',
        'especialidad',
        'active'
    ];



    public function appointments()
    {
        return $this->belongsTo(Appointment::class);
    }

}
