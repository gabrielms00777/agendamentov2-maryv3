<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    /** @use HasFactory<\Database\Factories\ProfessionalFactory> */
    use HasFactory;

    protected $fillable = ['company_id','name', 'active'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'professional_service');
    }

    public function businessHours()
    {
        return $this->hasMany(BusinessHour::class);
    }

    public function blockedSlots()
    {
        return $this->hasMany(BlockedSlot::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
