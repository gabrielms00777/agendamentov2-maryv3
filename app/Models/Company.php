<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'document', 'email', 'phone', 'appointment_interval', 'onboarding_completed'
    ];

    public function whatsappNumbers() {
        return $this->hasMany(WhatsappNumber::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function services() {
        return $this->hasMany(Service::class);
    }

    public function professionals() {
        return $this->hasMany(Professional::class);
    }

    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
}
