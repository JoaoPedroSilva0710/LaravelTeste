<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    /** @use HasFactory<\Database\Factories\PhoneFactory> */
    use HasFactory;
    
    protected $fillable = [
        'number',
        'intern_id'
    ];
    
    protected $hidden =
    [
        'created_at',
        'updated_at'
    ];
}
