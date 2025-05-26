<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappNumber extends Model
{
    /** @use HasFactory<\Database\Factories\WhatsappNumberFactory> */
    use HasFactory;

    protected $fillable = ['number', 'provider', 'api_token', 'status'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
