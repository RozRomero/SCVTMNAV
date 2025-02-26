<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'priority',
        'description',
        'status',
    ];

    // Definir valores predeterminados
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ticket) {
            $ticket->status = 'Abierto'; // Estado inicial
        });
    }
}

