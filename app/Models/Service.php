<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['company_id','name', 'description', 'duration_minutes', 'price', 'is_active'];

    public function casts()
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function professionals()
    {
        return $this->belongsToMany(Professional::class, 'professional_service');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
