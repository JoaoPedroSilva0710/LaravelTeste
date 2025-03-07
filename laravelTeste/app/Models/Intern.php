<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Intern extends Model
{
    /** @use HasFactory<\Database\Factories\InternFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'birth',
        'cpf'
    ];


    protected $hidden =
    [
        'created_at',
        'updated_at',
        'ts_vector_search_name',
        'deleted_at'
    ];

    public function phones(): HasMany
{
	return $this->hasMany(Phone::class);
}
}
