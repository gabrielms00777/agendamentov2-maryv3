<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappMessage extends Model
{
    /** @use HasFactory<\Database\Factories\WhatsappMessageFactory> */
    use HasFactory;

    protected $fillable = [
        'from_number', 'to_number', 'direction', 'content', 
        'message_id', 'type', 'timestamp'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
