<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Password extends Model
{
    /** @use HasFactory<\Database\Factories\PasswordFactory> */
    use HasFactory;

    public static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    protected $fillable = [
        'uuid',
        'password',
        'expires_at',
        'visit_limit',
        'visit_count',
    ];

    protected $casts = [
        'expires_at'  => 'datetime',
        'visit_limit' => 'integer',
        'visit_count' => 'integer',
        'password'    => 'encrypted',
    ];
}
